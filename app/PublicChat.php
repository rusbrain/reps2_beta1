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
      'to',
      'imo'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    } 

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }
}
