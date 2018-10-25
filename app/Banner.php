<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File', 'file_id');
    }

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
