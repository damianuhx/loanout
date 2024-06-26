<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Document extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'path', 'document_id'];

    public function lent()
    {
        return $this->belongsTo('App\Lent');
    }

}

?>