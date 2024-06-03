<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Accessoryset extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accessorysets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'name_de', 'name_fr', 'name_en'];

    public function types()
    {
        return $this->hasMany('App\Type');
    }

    public function type()
    {
        return $this->hasMany('App\Type');
    }


    public function accessories()
    {
        return $this->belongsToMany('App\Accessory');
    }

    public function accessory()
    {
        return $this->belongsToMany('App\Accessory');
    }
}

?>