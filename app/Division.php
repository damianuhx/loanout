<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Division extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'divisions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'name_de', 'name_fr', 'name_en'];

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function category()
    {
        return $this->hasMany('App\Category');
    }
}

?>