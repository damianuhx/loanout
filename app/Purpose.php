<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Purpose extends Model
{

    protected $table = 'purposes';

    protected $fillable = ['name', 'name_de', 'name_fr', 'name_en'];

    public function lents()
    {
        return $this->hasMany('App\Lent');
    }

    public function lent()
    {
        return $this->hasMany('App\Lent');
    }

}



