<?php

namespace App;

use App\Traits\ModelRelations\UserRoleRelation;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $title
 *
 */
class UserRole extends Model
{
    use UserRoleRelation;

    /**
     * Using table name
     *
     * @var string
     */
    protected $table='user_roles';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
    ];
}
