<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicChat extends Model
{
   /**
     * Using table name
     *
     * @var string
     */
    protected $table='public_messages';

    protected $fillable = [
      'user_id',
      'user_name',
      'file_path',
      'message',
      'imo'
    ];

    public $timestamps = true;
}
