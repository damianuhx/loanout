<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Type extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'manufacturer', 'category_id', 'accessoryset_id', 'full', 'partial', 'missing', 'color', 'fee'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }


    public function objects()
    {
        return $this->hasMany('App\Object');
    }

    public function object()
    {
        return $this->hasMany('App\Object');
    }


    public function accessoryset()
    {
        return $this->belongsTo('App\Accessoryset');
    }
}

?>