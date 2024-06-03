<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Source extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sources';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'name_de', 'name_fr', 'name_en'];

    public function object()
    {
        return $this->belongsTo('App\Object');
    }

}

?>