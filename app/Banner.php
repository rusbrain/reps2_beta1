<?php

namespace App;

use App\Services\Base\FileService;
use App\Traits\ModelRelations\BannerRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $file_id
 * @property string $title
 * @property string $url_redirect
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
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

    public static function saveImage($banner_data, $title)
    {
        $file = File::storeFile($banner_data['image'], 'banners', $title);
        $banner_data['file_id'] = $file->id;
        unset($banner_data['image']);
        return $banner_data;
    }

    public static function updateBanner($request, $banner)
    {
        $banner_data = $request->validated();
        if ($request->has('image')) {
            FileService::removeFile($banner->file_id);

            $title = 'Banner ' . $request->has('title') ? $request->get('title') : '';

            $file = File::storeFile($banner_data['image'], 'banners', $title);
            $banner_data['file_id'] = $file->id;
            unset($banner_data['image']);
        }

        Banner::where('id', $banner->id)->update($banner_data);
    }
}
