<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamSetting extends Model
{
   /**
     * Using table name
     *
     * @var string
     */
    protected $table='stream_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'headline',
        'main_section'
    ];
}
