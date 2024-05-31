<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

use App\State;
use Illuminate\Database\Eloquent\Model;


class Purpose extends Model
{


}

class DebugController extends Controller
{


   public function test(){
       $test=new Purpose;
   }
}