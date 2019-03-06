<?php

namespace App;

use App\Traits\ModelRelations\UserEmailTokenRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string function
 * @property integer $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property User $user
 * */
class UserEmailToken extends Model
{
    use UserEmailTokenRelation;

    const TOK_FUNC_UPDATE_PASSWORD = 'update_password';
    const TOK_FUNC_VERIFIED_EMAIL = 'verified_email';

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
        'user_id',
        'function',
        'token',
    ];
}
