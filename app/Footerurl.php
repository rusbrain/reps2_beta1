<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $approved
 * @property string $title
 * @property string $url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Footerurl extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='footer_urls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'url',
        'approved'
    ];
}
