<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Division;
use App\Category;
use App\User;
use App\Type;
use App\Object;
use Illuminate\Database\QueryException;
use App\Http\Controllers\PeriodController;

/**
 * Create User
 * @param Request $user
 * @return Status $status
 */

class ObjectController extends Controller
{
    public function __construct(){
        if (!Auth::user())
        {
            Redirect::to('auth/login')->send();
        }
    }

    public function home()
    {
        $user=Auth::user();
        if (isset($user) && in_array($user['language'], ['de', 'fr', 'en']))
            {
                return $this->categories();
            }
        else{
            return view('wait');
        }


    }

    public function divisions()
    {
        try {
            $divisions = Division::all();
        } catch (QueryException $e) {
            abort(400, $e);
        }

        $user=Auth::user();
        $language=$user['language'];


        if (in_array($user['language'], ['de', 'fr', 'en']) && in_array($user['type'], ['admin', 'supervisor', 'user']))
        {
            if ($user['type']=='admin')
            {
                //return objectlist not working/incomplete
                $objects=Object::where('complete', 0)->orWhere('working', 0)->with('type')->with('type.category')->with('type.category.division')->orderBy('color', 'asc')->get();
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
            else {
                return view('browser')->with([
                    'divisions' => $divisions,
                    'division' => array('name' => 'none', 'name_de' => 'keiner', 'name_fr' => 'rien', 'en' => 'none'),
                    'categories' => [], 'types' => [], 'type' => [], 'objects' => [],
                    'current' => 'browser',
                    'subcurrent' => 'divisions',
                    'language' => $language,
                    'user_type' => $user['type'],
                ]);
            }
        }
        else {
            return view('auth/wait');
        }

    }



    public function categories($id=0)
    {
        if ($id > 0) {
            try {
                if (!$division = Division::find($id)) {
                    abort(400, 'Abteilung nicht gefunden');
                }
            } catch (QueryException $e) {
                abort(400, $e);
            }
            try {
                $categories = $division->categories;
            } catch (QueryException $e) {
                abort(400, $e);
            }
        }
        else{
            try {
                $categories = Category::all();
            } catch (QueryException $e) {
                abort(400, $e);
            }

    }



        $user=Auth::user();
        $language=$user['language'];


        if ($user['type']=='supervisor' || $user['user']=='user')
        {
            return view('browser')->with([
                'divisions' => Division::all(),
                'division' => $division,
                'categories' => $categories->toArray(),
                'types' => [], 'type' => [], 'objects' => [],
                'current' => 'browser',
                'subcurrent' => 'categories',
                'language' => $language,
                'user_type' => $user['type'],
            ]);
        }
        elseif ($user['type']=='admin'){
            $allobjects=Object::where('complete', 0)->orWhere('working', 0)->with('type')->with('type.category')->with('type.category.division')->get();
            $objects=[];

            foreach ($allobjects as $object){
                echo '<br/>';
                if ($object->type->category->division->id ==$division['id']){
                    $objects[]=$object;
                }
            }
            //var_dump($objects);

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
    }

    public function types($id){
        $pc = new PeriodController;
        $pc->refresh();

        $category=Category::findOrFail($id);
        $division=$category->division;
        $categories=$division->categories;
        $types=$category->types;
        $user=Auth::user();
        $language=$user['language'];

        return view('browser')->with([
            'divisions'=>Division::all(),
            'division'=>$division,
            'categories'=>$categories->toArray(),
            'types'=>$types->toArray(),
            'objects'=>[],
            'category'=>$category->toArray(),
            'current'=>'browser',
            'subcurrent'=>'types',
            'language'=>$language,
            'user_type'=>$user['type'],
        ]);
    }

    public function objects($id){
        //$types=Type::all();
        $type=Type::findOrFail($id);
        $objects=$type->objects;
        $category=$type->category;
        $division=$category->division;
        $categories=$division->categories;
        $types=$category->types;
        $user=Auth::user();
        $language=$user['language'];

        return view('browser')->with([
            'divisions'=>Division::all()->toArray(),
            'division'=>$division->toArray(),
            'categories'=>$categories->toArray(),
            'types'=>$types->toArray(),
            'objects'=>$objects->toArray(),
            'category'=>$category->toArray(),
            'type'=>$type->toArray(),
            'current'=>'browser',
            'subcurrent'=>'objects',
            'language'=>$language,
            'user_type'=>$user['type'],
        ]);
    }

    public function details($id)
    {
        $objects=Object::all();
        $object=Object::findOrFail($id);
        $type=$object->type;
        $category=$type->category;
        $division=$category->division;
        $categories=$division->categories;
        $types=$category->types;

        $soll=$object->type->accessoryset->accessories->toArray();
        $ist=$object->accessories->toArray();
        $object=$object->toArray();
        $object['accessories']=[];
        foreach ($soll as $accessory)
        {

            $accessory['included'] = false;
            foreach($ist as $key=>$check)
            {
                if ($check['id'] == $accessory['id']) {
                    $accessory['included'] = true;
                    unset($ist[$key]);
                    break;
                }

            }
            $object['accessories'][]=$accessory;
        }

        foreach ($ist as $accessory){
            $accessory['included']=true;
            $object['accessories'][]=$accessory;
        }

        //var_dump($object['accessories']);



        $user=Auth::user();
        $language=$user['language'];
        if ($lender=User::where('id', $object['lender_id'])->first())
        {
            $lender=$lender['email'];
        }
        else{
            $lender='-';
        }

        if ($locker=User::where('id', $object['locked'])->first())
        {
            $locker=$locker['email'];
        }
        else{
            $lender='-';
        }

        if ($object['locked']>0)
        {
            $locked=1;
        }
        else
        {
            $locked=0;
        }

        return view('object')->with([
            'categories'=>$categories->toArray(),
            'types'=>$types->toArray(),
            'objects'=>$objects->toArray(),
            'category'=>$category->toArray(),
            'type'=>$type->toArray(),
            'object'=>$object,
            'language'=>$language,
            'user'=>$user,
            'user_type'=>$user['type'],
            'lender'=>$lender,
            'locker'=>$locker,
            'locked'=>$locked,
        ]);
    }
}