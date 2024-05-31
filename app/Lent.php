<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Lent extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id', 'reserved_at', 'granted_at', 'handed_at', 'return_at',
    'returned_at', 'stored_at', 'state_id', 'comment', 'purpose', 'user_id', 'shipping', 'granter_id'];

    public function objects()
    {
        return $this->belongsToMany('App\Object');
    }

    public function object()
    {
        return $this->belongsToMany('App\Object');
    }


    public function purpose()
    {
        return $this->belongsTo('App\Purpose');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function document()
    {
        return $this->hasMany('App\Document');
    }

}

?>