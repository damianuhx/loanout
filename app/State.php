<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class State extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

?>