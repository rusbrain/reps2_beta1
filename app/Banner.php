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

    /**
     * @return mixed
     */
    public static function getRandomBanner()
    {
        $banners_id = Banner::where('is_active',1)->has('file')->get(['id']);

        $ids = [];
        foreach ($banners_id as $banner){
            $ids[] = $banner->id;
        }
        $id = array_rand($ids);

        return Banner::where('id', $ids[$id])->with('file')->first();
    }
}
