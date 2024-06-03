<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Object extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'objects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type_id',  'name', 'location_id', 'source_id',  'comment', 'lender_id',
        'return_date', 'available', 'working', 'complete', 'state_id', 'color', 'user_id', 'locked'];

    public function accessories()
    {
        return $this->belongsToMany('App\Accessory');
    }

    public function accessory()
    {
        return $this->belongsToMany('App\Accessory');
    }


    public function lents()
    {
        return $this->belongsToMany('App\Lent');
    }
    public function lent()
    {
        return $this->belongsToMany('App\Lent');
    }


    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function source()
    {
        return $this->belongsTo('App\Source');
    }

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

?>