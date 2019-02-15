<?php

namespace App;

use App\Traits\ModelRelations\ReplayTypeRelation;
use Illuminate\Database\Eloquent\Model;

class ReplayType extends Model
{
    use ReplayTypeRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'replay_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'title'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
