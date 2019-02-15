<?php

namespace App;

use App\Traits\ModelRelations\CountryRelation;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use CountryRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


}
