<?php

namespace App;

use App\Traits\ModelRelations\SectionIconRelation;
use Illuminate\Database\Eloquent\Model;

class SectionIcon extends Model
{
    use SectionIconRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='section_icons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icon'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
