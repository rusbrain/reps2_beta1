<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $position
 * @property integer $approved
 * @property string $title
 * @property string $email
 * @property string $icq
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Footer extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='footer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'position',
        'text',
        'email',
        'icq',
        'approved'
    ];
}
