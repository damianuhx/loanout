<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'company', 'title', 'first_name', 'last_name', 'addition',
        'street', 'number', 'zip', 'city', 'country', 'email', 'phone', 'language', 'reseller'];

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