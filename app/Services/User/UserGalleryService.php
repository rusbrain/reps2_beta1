<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 11:01
 */

namespace App\Services\User;

use App\{Comment, File, User, UserGallery};
use App\Http\Requests\{UserGalleryStoreRequest, UserGalleryUpdateRequest};
use App\Services\Base\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $data = self::saveImage($data);
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
            FileService::removeFile($gallery->file_id);
            $gallery_data = self::saveImage($gallery_data);
        }

        if ($request->has('content') && $request->get('content') === null){
            $gallery_data['content'] = '';
        }

        UserGallery::where('id', $gallery->id)->update($gallery_data);
    }

    /**
     * @param UserGallery $gallery
     * @throws \Exception
     */
    public static function destroy(UserGallery $gallery)
    {
//        $user_id = $gallery->user_id;
        $file = $gallery->file()->first();
        FileService::removeFile($file->id);

        $gallery->comments()->delete();
        $gallery->positive()->delete();
        $gallery->negative()->delete();
        $gallery->delete();
//        User::recountRating($user_id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getGalleries(Request $request)
    {
        $galleries = UserGallery::with('user', 'file')->withCount( 'positive', 'negative', 'comments')->orderBy('id', 'desc');

        if ($request->has('user_id')){
            $galleries->where('user_id', $request->get('user_id'));
        }

        return $galleries->paginate(20);
    }

    /**
     * Store image file
     *
     * @param $gallery_data
     * @return mixed
     */
    public static function saveImage($gallery_data)
    {
        $title = 'Картинка галереи пользователя '.Auth::user()->name;

        $file = File::storeFile($gallery_data['image'], 'gallery', $title);
        $gallery_data['file_id'] = $file->id;
        unset($gallery_data['image']);
        return $gallery_data;
    }

    /**
     * @param UserGallery $photo
     */
    public static function updateReview(UserGallery $photo)
    {
        UserGallery::where('id', $photo->id)->update(['reviews' => $photo->reviews+1]);
    }
}