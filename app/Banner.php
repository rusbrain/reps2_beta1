<?php

namespace App;

use App\Traits\ModelRelations\BannerRelation;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use BannerRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'banners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_id',
        'title',
        'url_redirect',
        'is_active',
    ];
}
