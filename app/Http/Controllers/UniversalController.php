<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
//use App\Http\Controllers\Auth;

use Auth;
use App\Accessoryset;
use App\Accessory;
use App\Category;
use App\Location;
use App\Source;
use App\Purpose;
use App\State;
use App\Type;
use App\Object;
use App\Customer;
use App\User;
use App\Document;
use App\Lent;
use App\Division;
use App\Language;
use App\Http\Controllers\PeriodController;

function __construct(){
    if (!Auth::user())
    {
        return redirect('auth/login');
    }
}

class UniversalController extends Controller
{


    private static function get_model($model){
        if (!$user=Auth::user()){
            abort(400, 'Kein Benutzer angmeldet');
        }
        $rights=config('app.rights');
        $rights=$rights[$user['type']];

        if (in_array($model, $rights))
        {
            if ($model == 'accessoryset') {
                $model = new Accessoryset;
            } else if ($model == 'accessory') {
                $model = new Accessory;
            } else if ($model == 'category') {
                $model = new Category;
            } else if ($model == 'location') {
                $model = new Location;
            } else if ($model == 'source') {
                $model = new Source;
            } else if ($model == 'purpose') {
                $model = new Purpose;
            } else if ($model == 'state') {
                $model = new State;
            } else if ($model == 'type') {
                $model = new Type;
            } else if ($model == 'object') {
                $model = new Object;
            } else if ($model == 'user') {
                $model = new User;
            } else if ($model == 'customer') {
                $model = new Customer;
            } else if ($model == 'document') {
                $model = new Document;
            } else if ($model == 'lent') {
                $model = new Lent;
            }else if ($model == 'division') {
                $model = new Division;
            }else if ($model == 'language') {
                $model = new Language;
            } else {
                abort(400, 'Modell existiert nicht.');
            }

        return $model;
        }
        else{
            abort(400, 'Sie haben nicht die Berechtigung auf diese Resource zuzugreifen.');
        }

    }


    public static function test()
    {
        $user=Auth::user();
        var_dump($user);
    }

    private static function get_all($model)
    {
        $title=$model;
        $model=self::get_model($model);
        if ($title=='customer'){
            $model=$model->where('reseller',1)->orderBy('name', 'asc')->get()->toArray();
        }
        else{
            $model=$model->orderBy('name', 'asc')->get()->toArray();
        }

        return $model;
    }

    public function all($model)
    {
        if (!$user=Auth::user()){
            abort(400, 'Kein Benutzer angmeldet');
        }

        $title=$model;
        $model = self::get_all($model);
        $user_type=$user['type'];
        return view('select')->with(['list'=>$model, 'title'=>$title, 'current'=>'admin', 'subcurrent'=>$title, 'user_type'=>$user_type, 'language'=>$user['language']]);
    }

    public function cat()
    {
        if (!$user=Auth::user()){
            abort(400, 'Kein Benutzer angmeldet');
        }

        $divisions=[];
        $id=Input::get('division');
        if ($id>0){
            $divisions[]=Division::find($id);
        }
        else{
            $divisions=Division::orderBy('name', 'asc')->get();
        }

        $divisions=$divisions->toArray();
        foreach($divisions as $key=>$division)
        {
            $divisions[$key]['categories']=[];
            $category_id=Input::get('category');

            if ($id>0){
                $divisions[$key]['categories'][]=Category::find($category_id)->toArray();
            }
            else{
                $divisions[$key]['categories']=Category::where('division_id', $division['id'])->orderBy('name', 'asc')->get()->toArray();
            }

            $type_id=Input::get('type');
            foreach ($divisions[$key]['categories'] as $key2=>$category){
                $divisions[$key]['categories'][$key2]['types']=[];
                if ($type_id>0){
                    $divisions[$key]['categories'][$key2]['types'][]=Type::find($type_id)->toArray();
                }
                else{
                    $divisions[$key]['categories'][$key2]['types']=Type::where('category_id', $category['id'])->orderBy('name', 'asc')->get()->toArray();
                }

                $object_id=Input::get('object');
                foreach ($divisions[$key]['categories'][$key2]['types'] as $key3=>$type){
                    $divisions[$key]['categories'][$key2]['types'][$key3]['objects']=[];
                    if ($object_id>0){
                        $divisions[$key]['categories'][$key2]['types'][$key3]['objects'][]=Object::find($object_id)->toArray();
                    }
                    else{
                        $divisions[$key]['categories'][$key2]['types'][$key3]['objects']=Object::where('type_id', $type['id'])->orderBy('name', 'asc')->get()->toArray();
                    }
                }

            }
        }

        $user_type=$user['type'];
        return view('selectcat')->with(['list'=>$divisions, 'title'=>'objects', 'current'=>'admin', 'subcurrent'=>'none', 'user_type'=>$user_type, 'language'=>$user['language']]);
    }


    public function attach($model1, $id1, $model2){
        $id2=Input::only('id');
        self::tach($model1, $model2, $id1, $id2, 1);
        return $this->form($model1, $id1);
    }

    public function detach($model1, $id1, $model2, $id2){
        self::tach($model1, $model2, $id1, $id2, 2);
        return $this->form($model1, $id1);
    }

    private static function tach($model1, $model2, $id1=0, $id2=0, $attach=1)
    {

        $model1=self::get_model($model1);

        if ($id1)
        {
            $model1=$model1->find($id1);
        }

        if ($model2=='accessoryset')
        {
            $return=$model1->accessoryset();
        }
        elseif ($model2=='accessory')
        {
            $return=$model1->accessory();
        }
        elseif ($model2=='category')
        {
            $return=$model1->category();
        }
        elseif ($model2=='type_id')
        {
            $return=$model1->type();
        }
        elseif ($model2=='source_id')
        {
            $return=$model1->source();
        }
        elseif ($model2=='location_id')
        {
            $return=$model1->location();
        }
        elseif ($model2=='customer_id')
        {
            $return=$model1->customer();
        }
        elseif ($model2=='state_id')
        {
            $return=$model1->state();
        }
        elseif ($model2=='purpose_id')
        {
            $return=$model1->purpose();
        }
        elseif ($model2=='user_id')
        {
            $return=$model1->user();
        }
        elseif ($model2=='lent')
        {
            $return=$model1->lent();
        }
        elseif ($model2=='object')
        {
            $return=$model1->object();
        }
        elseif ($model2=='division')
        {
            $return=$model1->division();
        }
        else
        {
            abort(400, 'Modell existiert nicht.');
        }

        if ($attach==0){
            return $return;
        }
        else if ($attach==1){
            $return->attach($id2);
        }
        else if ($attach==2){
            $return->detach($id2);
        }
        else if ($attach==3){
            $return->detach();
        }
    }

    public function admin()
    {
        if (!$user=Auth::user()){
            abort(400, 'Kein Benutzer angmeldet');
        }
        $user_type=$user['type'];

        return view('main')->with(['title'=>'Admin Panel (main)', 'current'=>'admin', 'subcurrent'=>'none', 'user_type'=>$user_type, 'language'=>$user['language']]);
    }

    public function form($model, $id)
    {
        if (!$user=Auth::user()){
            abort(400, 'Kein Benutzer angmeldet');
        }

        $title=$model;
        $types=config('app.types');
        $tomany=config('app.tomany');
        $model=self::get_model($model);
        $fields=array();
        $link=env('HREF_MAIN');

        if ($id=='new')
        {
            foreach ($model['fillable'] as $name)
            {
                $fields[$name]['label']=$name;
                $fields[$name]['name']=$name;
                $fields[$name]['content']='';
                if (in_array($name, $types['one']))
                {
                $fields[$name]['content']='1';
                }
                if (in_array($name, $types['two']))
                {
                    $fields[$name]['content']='2';
                }
            }
            $link=env('HREF_MAIN').$title.'/all';
        }
        else if ($id>0) {
            $model = $model->find($id);
            $fields = $model->toArray();
            foreach ($fields as $key => $value) {
                $fields[$key] = ['content' => $value, 'label' => $key, 'name' => $key, 'selection' => []];
            }
            $link=env('HREF_MAIN').$title.'/'.$id;
        }

        //-------------
        foreach ($fields as $key=>$value)
        {
            foreach ($types as $type=>$variables)
            {

                if ( in_array($key, $variables))
                {
                    $fields[$key]['type']=$type;

                    if ($type=='dropdown')
                    {
                        $selection=[];
                        $model=explode('_', $key);
                        $model=$model[0];

                        $all=self::get_all($model);
                        foreach($all as $entry)
                        {
                            $selection[]=[$entry['id']=>$entry['name']];
                        }
                        $fields[$key]['selection'] = $selection;
                    }
                    break;
                }
                else{
                    $fields[$key]['type']='none';
                }
            }
        }

        //-----------------
        if(isset($tomany[$title]))
        {
            $tomany=$tomany[$title];

            foreach ($tomany as $entry)
            {
                $model=self::get_model($entry);
                $fields[$entry]['name']=$entry;
                $fields[$entry]['label']='';
                $fields[$entry]['type']='tomany';
                $fields[$entry]['selection']=[];
                $fields[$entry]['fentries']=[];

                $all=$model->all()->toArray();
                $selection=[];
                foreach($all as $fentry)
                {
                    $selection[$fentry['id']]=$fentry['name'];
                }
                $fields[$entry]['selection']=$selection;

                if ($id!=='new') {
                    $fentries = self::tach($title, $entry, $id, 0, $attach = 0)->get()->toArray();
                    $fields[$entry]['fentries'] = $fentries;
                }
            }
        }
        $user_type=$user['type'];



        return view('edit')->with(['fields'=>$fields, 'title'=>$title, 'id'=>$id, 'link'=>$link, 'current'=>'admin', 'subcurrent'=>$title, 'user_type'=>$user_type, 'language'=>$user['language']]);
    }

    public function save($model, $id)
    {
        if (!$user=Auth::user()){
            abort(400, 'Kein Benutzer angmeldet');
        }

        $save=self::get_model($model);
        $input=array();
        foreach ($save['fillable'] as $field)
        {
            if (Input::get($field)){
                $input[$field]=Input::get($field);
            }
        }


        if ($id>0)
        {
            if (!$save=$save->find($id)){
                return view('errors/400')->with(['message'=>'ID nicht gefunden']);
            }
            try {
                $save->update($input);
            }
            catch (QueryException $e){
                return view('errors/400')->with(['message'=>$e->getMessage()]);
            }
            return $this->form($model, $id);
        }
        else
        {
            $save->create($input);
            return $this->all($model);
        }

        $pc = new PeriodController;
        $pc->refresh();

    }

    public function delete($model, $id)
    {
        if (!$user=Auth::user()){
            abort(400, 'Kein Benutzer angmeldet');
        }

        if (!$delete=self::get_model($model)->find($id)){
            return view('errors/400')->with(['message'=>'ID nicht gefunden']);
        }


        //try to remove all many-to-many relations
        $tomany=config('app.tomany');
        if (isset($tomany[$model])) {
            $relations = $tomany[$model];

            foreach ($relations as $relation) {
                try {
                    self::tach($model, $relation, $id, 0, 3);
                } catch (QueryException $e) {
                    return view('errors/400')->with(['message' => $e->getMessage()]);
                }
            }
        }
        try {
            $delete->delete();
        }
        catch (QueryException $e){
            return view('errors/400')->with(['message'=>$e->getMessage()]);
        }
        return $this->all($model);
    }

}