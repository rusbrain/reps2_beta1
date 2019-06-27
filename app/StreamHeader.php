<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamHeader extends Model
{
   /**
     * Using table name
     *
     * @var string
     */
    protected $table='stream_headers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'url'
    ];
}
