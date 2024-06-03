<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\QueryException;

use Mail;
use Carbon\Carbon;
use App\Division;
use App\Object;
use App\State;
use App\User;
use App\Customer;
use App\Http\Controllers\PeriodController;
use Auth;
use App\Lent;

/**
 * Create User
 * @param Request $user
 * @return Status $status
 */



class LendingController extends Controller
{
    function __construct(){
        if (!Auth::user())
        {
            return redirect('auth/login');
        }
        $pc = new PeriodController;
        $pc->refresh();
    }

    public function search_list()
    {
        $users = User::all();
        $customers = Customer::all();
        $states = State::all();

        foreach (['user' => $users, 'customer' => $customers, 'state' => $states] as $key => $array) {
            $selection=array('none'=>'egal');
            foreach ($array as $entry) {
                $selection[] = [$entry['id'] => $entry['name']];
            }
            $return[$key]=$selection;
        }
        $return['current']='lending';
        $return['subcurrent']='search';
        return view('search')->with($return);
    }



    public function display_list(){

        if (!$user=Auth::user())
        {
            return view('errors/400')->with(['message'=>'Kein Benutzer angemeldet']);
        }

        if ($user['type']=='user')
        {
            $_GET['user_id']=$user['id'];
        }

        $lents=Lent::with('objects')->with('objects.type')->with('user')->with('customer')->with('state');
        foreach($_GET as $key=>$value)
        {
            if ($value!=='none')
            {
                $key=explode('_', $key);
                if (in_array($key[0], ['user, company, state']))
                {
                    $lents=$lents->where($key[0].'_id', $value);
                }
                elseif(isset($key[1]) && $key[1]=='sign')
                {

                    if (in_array($key[0], ['updated', 'reserved', 'granted', 'handed', 'returned', 'return'])  )
                    {
                        $lents = $lents->whereDate($key[0] . '_at', $key[1], $value);
                    }
                }
            }
        }
        $lents=$lents->get();
        return view ('lendings')->with(['lents'=>$lents->toArray(), 'action'=>'restock', 'current'=>'lending', 'subcurrent'=>'search']);
    }



    public function confirmation($id){
        if (!$user=Auth::user())
        {
            return view('errors/400')->with(['message'=>'Kein Benutzer angemeldet']);
        }

        $language=$user['language'];

        $lent=Lent::with('objects')->with('objects.type')->with('user')->with('customer')->with('state')->find($id);
        if ($lent['state_id']==1)
        {
            $subcurrent='requested';
        }
        elseif ($lent['state_id']==2)
        {
            $subcurrent='granted';
        }
        elseif($lent['state_id']==3)
        {
            $subcurrent='handed';
        }
        else{
            $subcurrent='restocked';
        }

        Mail::send('emails.password', ['user' => $user], function ($m) use ($user) {
            $m->from('contact@synesthesia.com', 'Synesthesia.com');

            $m->to('damian.h82@gmail.com', $user->name)->subject('Welcome to synesthesia.com');
        });

        return view('details')->with(['lent'=>$lent->toArray(), 'purpose'=>'confirmation', 'language'=>$language, 'current'=>'lending', 'subcurrent'=>$subcurrent]);
    }



    public function add_object($id){
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }

        try {
            //$user->objects()->attach($id);
            $object=Object::findOrFail($id);
            if (!$object['user_id']>0 || $object['user_id']==$user['id'])
            {
                $object->update(['user_id'=>$user['id']]);
            }
            else{
                abort(400, 'Das Objekt befindet sich bereits in einem Warenkorb.');
            }
        }
        catch (QueryException $e){
            abort(400, $e->getMessage());
        }

        return $this->basket();
    }

    public function remove_object($id){
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }

        try
        {
            $object=Object::findOrFail($id);
            $object->update(['user_id'=>'NULL']);
        }
        catch (QueryException $e){
            abort(400, $e->getMessage());
        }

        return $this->basket();
    }


    public function basket(){
        $lent=[];


        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $lent['id']=$user['id'];
        $objects=$user->objects;
        $lent['objects']=$objects;
        $lent['user']=$user;
        $lent['return_at']=Carbon::now();

        $raw=Customer::where('reseller', 1)->orderBy('name', 'asc')->get()->toArray();
        $customers=[];
        foreach ($raw as $customer)
        {
            $customers[$customer['id']]=$customer['name'];
        }



        /*$raw=Purpose::all()->toArray();
        $purposes=[];
        foreach ($raw as $purpose)
        {
            $purposes[$purpose['id']]=$purpose['name'];
        }*/

        return view('details')->with([
            'divisions'=>Division::all()->toArray(),
            'division'=>array('name'=>'none', 'name_de'=>'keiner', 'name_fr'=>'rien', 'en'=>'none'),
            'lent'=>$lent,
            'customers'=>$customers,
            'purpose'=>'request',
            'language'=>$user['language'],
            'current'=>'browser',
            'subcurrent'=>'basket',
            'user_type'=>$user['type']]
        );
    }

    public function reset_basket($view=true){
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $objects=$user->objects;

        foreach ($objects as $object){
            if(!$object['locked'])
            {
                try {
                    $object->update(['user_id' => 'NULL']);
                } catch (QueryException $e) {
                    abort(400, $e->getMessage());
                }
            }
        }
        if ($view){
            return $this->basket();
        }
        else
        {
            return true;
        }
    }


    public function send_request()
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $objects=$user->objects;
        $object_ids=[];

        foreach($objects as $object){
            $object_ids[]=$object->id;
        }
        $values=Input::only(['shipping', 'purpose_id', 'customer_id', 'comment', 'return_at', 'purpose']);

        if(strtotime( $values['return_at'])-time()<0){
            abort(400, 'Das Rückgabedatum liegt in der Vergangenheit.');
        }
        if(count($object_ids)==0){
            abort(400, 'Es wurden keine Objekte ausgewählt.');
        }

        if ($values['customer_id']==0){
            $customer=Input::only(['name', 'company', 'title', 'first_name', 'last_name', 'addition', 'street', 'number', 'zip', 'city', 'country', 'language', 'email', 'phone']);
            $customer['name']=uniqid();
            $customer['reseller']=0;
            $values['customer_id']=Customer::create($customer)->id;
        }

        $values['user_id']=$user->id;
        $values['reserved_at']=Carbon::now();

        if ($user['type']=='supervisor')
        {
            $values['state_id']=2;
        }
        else if ($user['type']=='user')
        {
            $values['state_id']=1;
        }
        else if ($user['type']=='admin')
        {
            $values['state_id']=3;
        }
        else
        {
            abort(400, 'User hat keine Berechtigung');
        }

        $lent=Lent::create($values);
        $lent->objects()->attach($object_ids);
        $lent=$lent->id;
        $lent=Lent::with('user')->with('customer')->with('objects')->with('objects.type')->with('state')->find($lent);

        foreach($lent['objects'] as $object){
            try {
                $this->update_object($object['id'], ['locked'=>0, 'state_id' => $values['state_id'], 'purpose' => $values['purpose'], 'return_date' => $values['return_at'], 'available' => 0, 'lender_id'=>$user['id']]);
            }
            catch (QueryException $e){
                abort(400, $e->getMessage());
            }
        }

        $objects=$user->objects;
        foreach ($objects as $object){
            try{
                $object->update(['user_id'=>'NULL']);
            }
            catch (QueryException $e){
                abort(400, $e->getMessage());
            }
        }

        if ($user['type']=='user'){
            $subcurrent='requested';
        }
        elseif ($user['type']=='supervisor'){
            $subcurrent='granted';
        }
        elseif ($user['type']=='admin'){
            $subcurrent='handed';
        }
        else {
            $subcurrent='none';
        }

        $this->reset_basket(false);

        return view('details')->with([
            'divisions'=>Division::all(),
            'division'=>array('name'=>'none', 'name_de'=>'keiner', 'name_fr'=>'rien', 'en'=>'none'),
            'title'=>'Reservation',
            'lent'=>$lent->toArray(),
            'purpose'=>'confirmation',
            'user'=>$user,
            'language'=>$user['language'],
            'current'=>'lending',
            'subcurrent'=>$subcurrent,
            'user_type'=>$user['type']
        ]);
    }


    public function send_unlock($id)
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        if (!$user['type']=='supervisor'){
            abort(400, 'Sie haben nicht die benötigten Berechtigungen.');
        }

        if ($object=Object::findOrFail($id))
        {
            try {
                $this->update_object($object['id'], ['locked'=>'NULL']);
            }
            catch (QueryException $e){
                abort(400, $e->getMessage());
            }
        }

        return $this->lock_list();
    }


    public function send_lock($id)
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        if (!$user['type']=='supervisor'){
            abort(400, 'Sie haben nicht die benötigten Berechtigungen.');
        }

        if ($object=Object::findOrFail($id))
        {
            try {
                $this->update_object($object['id'], ['user_id'=>'NULL', 'locked'=>$user['id']]);
            }
            catch (QueryException $e){
                abort(400, $e->getMessage());
            }
        }

        return $this->lock_list();
    }

    public function lock_list(){
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        if (!$user['type']=='supervisor'){
            abort(400, 'Sie haben nicht die benötigten Berechtigungen.');
        }

        $objects=Object::where('locked', $user['id'])->with('type')->with('type.category')->with('type.category.division')->get();
        $objects=$objects->toArray();

        return view('objectlist')->with([
            'divisions'=>Division::all(),
            'division'=>array('name'=>'none', 'name_de'=>'keiner', 'name_fr'=>'rien', 'en'=>'none'),
            'objects'=>$objects,
            'user'=>$user,
            'language'=>$user['language'],
            'current'=>'browser',
            'subcurrent'=>'locked',
            'user_type'=>$user['type']
        ]);
    }



    public function grant_list()
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $language=$user['language'];
        $lents=Lent::where('state_id', '1')->with('objects')->with('objects.type')->with('user')->with('customer')->with('state');
        if ($user['type']=='user'){
            $lents=$lents->where('user_id', $user['id']);
        }
        $lents=$lents->get();
        return view ('lendings')->with(['lents'=>$lents->toArray(), 'language'=>$language, 'action'=>'grant', 'current'=>'lending', 'subcurrent'=>'requested']);
    }

    public function grant($id) //supervisor
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $language=$user['language'];
        $lent=Lent::with('objects')->with('objects.type')->with('user')->with('customer')->with('state')->find($id);
        if ($user['type']=='supervisor')
        {
            $purpose='grant';
        }
        else
        {
            $purpose='confirmation';
        }
        return view('details')->with(['lent'=>$lent->toArray(), 'purpose'=>$purpose, 'language'=>$language, 'current'=>'lending', 'subcurrent'=>'requested']);
    }

    public function send_grant($id)
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }

        $language=$user['language'];

        $values=Input::only(['return_at', 'state_id', 'shipping']);
        $values['granted_at']=Carbon::now();
        $values['state_id']=2;
        $values ['granter_id']=Auth::id();
        $lent=Lent::find($id);

        if ($lent['state_id']==1 && $user['type']=='supervisor')
        {
            $lent->update($values);

            foreach($lent['objects'] as $object){
                $this->update_object($object['id'],['state_id'=>2, 'return_date'=>$values['return_at'], 'available'=>0]);
            }
        }
        else{
            abort(400, 'Sie haben nicht die Berechtigung');
        }


        return $this->confirmation($id);

    }


    public function send_reject($id)
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $language=$user['language'];

        $values=Input::only(['return_at', 'state_id']);
        $values['granted_at']=Carbon::now();
        $values['state_id']=5;
        $values ['granter_id']=Auth::id();
        $lent=Lent::find($id);
        if ($lent['state_id']==1 && $user['type']=='supervisor') {
            $lent->update($values);

            foreach ($lent['objects'] as $object) {
                $this->update_object($object['id'], ['state_id' => 4, 'return_date' => $values['return_at'], 'available' => 1]);
            }
            return $this->confirmation($id);
        }
        else{
            abort(400, 'Sie haben nicht die Berechtigung');
        }
        //$lent=Lent::with('objects')->with('objects.type')->with('user')->with('customer')->with('state')->find($id);
        //return view('details')->with(['lent'=>$lent->toArray(), 'purpose'=>'confirmation', 'language'=>$language, 'current'=>'lending', 'subcurrent'=>'granted']);
    }




    public function handout_list()
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $language=$user['language'];

        $lents=Lent::where('state_id', '2')->with('objects')->with('objects.type')->with('user')->with('state')->with('customer')->get();
        return view ('lendings')->with(['lents'=>$lents->toArray(), 'language'=>$language, 'action'=>'handout', 'current'=>'lending', 'subcurrent'=>'granted']);
    }

    public function handout($id) //admin
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $language=$user['language'];

        if ($user['type']=='admin' || $user['type']=='supervisor')
        {
            $purpose='handout';
        }
        else
        {
            $purpose='confirmation';
        }

        $lent=Lent::with('objects')->with('objects.type')->with('user')->with('customer')->with('state')->with('objects.location')->find($id);
        return view('details')->with(['lent'=>$lent->toArray(), 'purpose'=>$purpose, 'language'=>$language, 'current'=>'lending', 'subcurrent'=>'granted']);
    }

    public function send_handout($id)
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $language=$user['language'];

        $lent=Lent::with('objects')->with('objects.type')->with('user')->with('customer')->with('state')->find($id);

        if ($lent['state_id']==2 && ($user['type']=='admin' || $user['type'] == 'supervisor'))
        {

            $lent->update(['state_id'=>'3','handed_at'=>Carbon::now()]);

            foreach($lent['objects'] as $object){
                $this->update_object($object['id'],['state_id'=>3, 'available'=>0]);
            }

            return $this->confirmation($id);
        }
        else{
            abort(400, 'Sie haben nicht die Berechtigung');
        }
        //return view('details')->with(['lent'=>$lent->toArray(), 'purpose'=>'confirmation', 'language'=>$language, 'current'=>'lending', 'subcurrent'=>'handed']);
    }




    public function restock_list()
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $language=$user['language'];

        $lents=Lent::where('state_id', '3')->with('objects')->with('objects.type')->with('user')->with('customer')->with('objects.accessories')->with('state')->get();
        return view ('lendings')->with(['lents'=>$lents->toArray(), 'action'=>'restock', 'language'=>$language, 'current'=>'lending', 'subcurrent'=>'handed']);
    }

    public function restock($id) //admin
    {
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $language=$user['language'];

        if ($user['type']=='admin' || $user['type']=='supervisor')
        {
            $purpose='restock';
        }
        else
        {
            $purpose='confirmation';
        }

        $lent=Lent::with('objects')->with('objects.location')->with('objects.accessories')->with('objects.type.accessoryset.accessories')->with('objects.type')->with('user')->with('customer')->with('state')->find($id)->toArray();

        foreach ($lent['objects'] as $lentkey=>$object)
        {
            $soll = $object['type']['accessoryset']['accessories'];
            $ist = $object['accessories'];

            $lent['objects'][$lentkey]['accessories']=[];

            foreach ($soll as $sollkey=>$accessory)
            {

                $accessory['included'] = false;
                $accessory['required'] = true;
                foreach($ist as $key=>$check)
                {
                    if ($check['id'] == $accessory['id']) {
                        $accessory['included'] = true;
                        unset($ist[$key]);
                        break;
                    }

                }
                $lent['objects'][$lentkey]['accessories'][]=$accessory;
            }

            foreach ($ist as $accessory){
                $accessory['required'] = false;
                $accessory['included']=true;
                $lent['objects'][$lentkey]['accessories'][]=$accessory;
            }

        }



        return view('details')->with(['lent'=>$lent, 'language'=>$language, 'purpose'=>$purpose, 'current'=>'lending', 'subcurrent'=>'restock']);
    }



    public function send_restock($id)
    {
        if (!$user = Auth::user()) {
            abort(400, 'Kein Benutzer angemeldet');
        }
        $values = Input::all();
        $language = $user['language'];

        $lent = Lent::findOrFail($id);

        if ($lent['state_id'] == 3 && ($user['type'] == 'admin' || $user['type'] == 'supervisor'))
        {

            $objects = $lent->objects;

            foreach ($objects as $object) {
                $object->accessories()->detach();
            }

            foreach ($values as $key => $value) {
                $buffer = explode('_', $key);
                if (isset($buffer[1]) && intval($buffer[1]) > 0) {
                    $object = Object::find($buffer[1]);
                    $object->update(['return_date' => '']);
                    if ($buffer[0] == 'object') {
                        if ($value) {
                            $object->update(['state_id' => 4, 'available' => 1]);
                        } else {
                            $object->update(['state_id' => 7, 'available' => 0]);
                        }
                    }
                    if ($buffer[0] == 'working') {
                        $object->update(['working' => $value]);
                    }
                    if ($buffer[0] == 'accessory') {
                        if ($value == 1) {
                            $object->accessories()->attach($buffer[2]);
                        }

                    }
                }
            }

            $lent = Lent::with('objects')->with('objects.type')->with('user')->with('customer')->with('state')->find($id);
            try {
                $lent->update(['state_id' => '4', 'returned_at' => Carbon::now()]);
            } catch (QueryException $e) {
                return view('errors/400')->with(['message' => $e->getMessage()]);
            }

            foreach ($lent['objects'] as $object) {
                PeriodController::refresh_object($object['id']);
                PeriodController::refresh_type($object->type->id);

            }
        }
        else
        {
            abort(400, 'Sie haben nicht die Berechtigung');
        }


        return $this->confirmation($id);
    }

    private function update_object($id, $array)
    {
        $object=Object::find($id);
        try {
            $object->update($array);
        }
        catch (QueryException $e){
            abort(400, $e);
        }
    }


    public function pdf($id){
        if (!$user=Auth::user())
        {
            abort(400, 'Kein Benutzer angemeldet');
        }
        if (!$lent=Lent::with('objects')->with('objects.accessories')->with('objects.type')->with('user')->with('customer')->with('state')->with('objects.accessories')->find($id)){
                return view('errors/400')->with(['message'=>'Ausleihe nicht gefunden']);
        }

        $ndays=strtotime ( $lent['return_at'])-time();
        $ndays=ceil($ndays);
        $ndays/=(60*60*24);
        $fee=0;
        foreach ($lent['objects'] as $object)
        {
            $fee+=$object->type['fee'];
        }
        $totalfee=$ndays*$fee;


        return view('delivery')->with([
            'lent'=>$lent->toArray(),
            'language'=>$lent['customer']['language'], 'current'=>'lending', 'subcurrent'=>'granted', 'fee'=>number_format($fee, 2), 'totalfee'=>number_format($totalfee, 2)]);

    }

}