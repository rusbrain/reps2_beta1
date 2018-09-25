<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='files';

    protected $fillable = [
        'user_id',
        'title',
        'link'
    ];
    /**
     * Relations. Files user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
