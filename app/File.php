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

    /**
     * Relations. Files user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('app\User');
    }
}
