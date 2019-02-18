<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 11:01
 */

namespace App\Services\User;


use App\Comment;
use App\File;
use App\Http\Requests\UserGalleryStoreRequest;
use App\Http\Requests\UserGalleryUpdateRequest;
use App\UserGallery;
use Illuminate\Support\Facades\Auth;

class UserGalleryService
{
    /**
     * @param $gallery
     * @return mixed
     */
    public static function getList($gallery)
    {
        return $gallery->with('file', 'user')->withCount( 'positive', 'negative', 'comments')->orderBy('created_at')->paginate(50);
    }

    /**
     * @param UserGalleryStoreRequest $request
     * @return mixed
     */
    public static function store(UserGalleryStoreRequest $request)
    {
        $data = $request->validated();
        $data = UserGallery::saveImage($data);
        $data['user_id'] = Auth::id();

        $gallery = UserGallery::create($data);

        return $gallery->id;
    }

    /**
     * @param UserGallery $photo
     * @return UserGallery
     */
    public static function getPhotoData(UserGallery $photo)
    {
        $photo = $photo->load('file', 'user');
        $photo->comments = Comment::where('relation', Comment::RELATION_USER_GALLERY)->where('object_id',$photo->id)->withCount('positive', 'negative')->paginate(20);
        $photo->photo_next = UserGallery::where('user_id', $photo->user_id)->where('id', '>', $photo->id)->orderBy('id', 'asc')->first();
        $photo->photo_before = UserGallery::where('user_id', $photo->user_id)->where('id', '<', $photo->id)->orderBy('id', 'desc')->first();

        return $photo;
    }

    /**
     * @param UserGalleryUpdateRequest $request
     * @param UserGallery $gallery
     */
    public static function update(UserGalleryUpdateRequest $request, UserGallery $gallery)
    {
        $gallery_data = $request->validated();

        if($request->has('image')){
            File::removeFile($gallery->file_id);
            $gallery_data = self::saveImage($gallery_data);
        }

        if ($request->has('content') && $request->get('content') === null){
            $gallery_data['content'] = '';
        }

        UserGallery::where('id', $gallery->id)->update($gallery_data);
    }

    public static function destroy(UserGallery $gallery)
    {
        $file = $gallery->file()->first();
        File::removeFile($file->id);

        $gallery->comments()->delete();
        $gallery->positive()->delete();
        $gallery->negative()->delete();
        $gallery->delete();
    }
}