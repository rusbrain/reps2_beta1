<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmailToken extends Model
{

    const TOK_FUNC_UPDATE_EMAIL = 'update_email';

    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'user_email_tokens';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id' ,
        'function',
        'token',
    ];

    /**
     * Relations. Tokens user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
