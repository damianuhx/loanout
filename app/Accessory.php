<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Accessory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accessories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'name_de', 'name_fr', 'name_en'];

    public function objects()
    {
        return $this->belongsToMany('App\Object');
    }

    public function object()
    {
        return $this->belongsToMany('App\Object');
    }


    public function lents()
    {
        return $this->belongsToMany('App\Lent');
    }

    public function lent()
    {
        return $this->belongsToMany('App\Lent');
    }


    public function accessoryset()
    {
        return $this->belongsToMany('App\Accessoryset');
    }

    public function accessorysets()
    {
        return $this->belongsToMany('App\Accessoryset');
    }
}

?>