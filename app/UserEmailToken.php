<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmailToken extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='user_email_tokens';

    /**
     * Relations. Tokens user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('app\User');
    }
}
