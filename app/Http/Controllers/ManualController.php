<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

use App\State;
use Illuminate\Database\Eloquent\Model;


class Purpose extends Model
{


}

class ManualController extends Controller
{


   public function manual($user='all')
   {
        return view('manual/manual')->with(['user'=>$user]);
   }


}