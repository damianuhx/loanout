<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

use Auth;
use App\User;
use App\Object;
use App\Type;
use App\Lent;
use Illuminate\Database\QueryException;

/**
 * Create User
 * @param Request $user
 * @return Status $status
 */

class PeriodController extends Controller
{
    public function refresh(){
        $objects=Object::all();
        foreach($objects as $object)
        {
            self::refresh_object($object['id']);
        }

        $types=Type::all();
        foreach($types as $type)
        {
            self::refresh_type($type['id']);
        }

        $users=User::all();
        foreach($users as $user)
        {
            self::empty_basket($user);
            self::send_reminder($user);
        }

        return 'refresh successful';
    }


    public static function empty_basket($user)
    {
        $objects=$user->objects;
        $t=config('app.basket_duration');

        foreach($objects as $object){
            if (time()-strtotime($object['updated_at'])>(60*$t)){
                $object->update(['user_id'=>'NULL']);
            }
        }

        return true;
    }

    public static function send_reminder($user){
        return true;
    }

    public static function refresh_object($id){
        //recalculates the objects and types temporal variables

        if (!$object=Object::find($id)) {
            return false;
        }
        else{
            $ist=$object->accessories->toArray();
            $soll=$object->type->accessoryset->accessories->toArray();

            $complete=1;
            foreach($soll as $a1)
            {
                $complete=0;
                foreach($ist as $a2)
                {
                    if ($a1['id']==$a2['id'])
                    {
                        $complete=1;
                        break;
                    }
                    else
                    {
                        $complete=0;
                    }
                }
                if (!$complete){
                    break;
                }
            }

            $object->update(['complete'=>$complete]);

            if ($object['available']==1 && $object['working']==1 && !$object['locked']){
                if ($object['complete']==1){
                    $color=2;
                }
                elseif ($object['complete']==0){
                    $color=1;
                }
            }
            else
            {
                $color=0;
            }

            $object->update(['color'=>$color]);
            return true;
        }

    }

    public static function refresh_type($id){
        //recalculates the objects and types temporal variables

        $type=Type::findOrFail($id);
        if (count($type->objects->where('color', '2')->toArray())){
            $color=2;
        }
        elseif (count($type->objects->where('color', '1')->toArray())){
            $color=1;
        }
        else{
            $color=0;
        }

        $type->update(['color'=>$color]);
        return true;
    }

    public static function send_mail($id){

        /*
         * lender, granter, shipper || actor, task,
        -sie haben reserviert (actor/lender) | bitte bewilligen sie (task/granter)
        -ihre anfrage wurde bewilligt (lender) | bitte liefern sie (task/shipper)
        -ihre anfrage wurde ausgeliefert |(lender) sie haben ausgeliefert (actor/shipper)
        -ihre ausleihe wurde zurückgeschickt (lender)| sie haben zurückgestellt (actor/shipper)
        */
        $lent=Lent::findOrFail($id);
        $taskmail= self::task_mail($lent);
        $confirmationmail= self::task_mail($lent);

        if ($lent['state_id']==1){
            //supervisor.
            mail("daaamian.spam@gmail.com","My subject", $taskmail);
        }
        else if ($lent['state_id']==1){

        }
        if ($lent['state_id']==1){

        }
        if ($lent['state_id']==1){

        }
        $mail= self::task_mail($lent);
        mail("daaamian.spam@gmail.com","My subject", $mail);
    }

    private static function confirmation_mail($lent){
        $mail='Der Status der Ausleihe von ';
        $mail.=$lent->user['name'];
        $mail.='für ';
        $mail.=$lent->customer['name'].' bis am '.$lent['return_date'].' für folgende Objekte: \n';
        foreach ($lent->objects as $object){
            $mail.='    -'.$object->type['name'].' ('.$object['name'].') \n\n';
        }
        $mail.='ist ';
        $mail.=$lent->state['name'];
        return $mail;
    }

    private static function task_mail($lent){
        $mail='Sie haben eine Anfrage:\n';
        $mail.=$lent->user['name'].' möchte für '.$lent->customer['name'].' bis am '.$lent['return_date'].' folgende Objekte ausleihen: \n';
        foreach ($lent->objects as $object){
            $mail.='    -'.$object->type['name'].' ('.$object['name'].') \n\n';
        }
        $mail.='Bitte gehen Sie auf diesen <a href="'.env('HREF_MAIN').'node/'.$lent['id'].'">Link</a> um die Anfrage zu bearbeiten.';
        return $mail;
    }
}