<?php

namespace App\Services\Chat;

use App\{File, User, ChatPicture};
use App\Http\Requests\{PictureStoreRequest, PictureUpdateRequest};
use App\Services\Base\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatPicturesService
{
    /**
     * @param $picture
     * @return mixed
     */
    public static function getList($picture)
    {
        return $picture->with('file', 'user')->orderBy('created_at')->paginate(50);
    }

    /**
     * @param PictureStoreRequest $request
     * @return mixed
     */
    public static function store(PictureStoreRequest $request)
    {
        $data = $request->validated();
        $data = self::saveImage($data);
        $data['user_id'] = Auth::id();       
        $picture = ChatPicture::create($data);

        return $picture->id;
    }
  
    /**
     * @param PictureUpdateRequest $request
     * @param ChatPicture $picture
     */
    public static function update(PictureUpdateRequest $request, ChatPicture $picture)
    {
        $data = $request->validated();

        if($request->has('image')){
            FileService::removeFile($picture->file_id);
            $data = self::saveImage($data);
        }

        ChatPicture::where('id', $picture->id)->update($data);
    }

    /**
     * @param ChatPicture $picture
     * @throws \Exception
     */
    public static function destroy(ChatPicture $picture)
    {

        $file = $picture->file()->first();
        if($file) {
            FileService::removeFile($file->id);
        }
        $picture->delete();
    }

   
    /**
     * Store image file
     *
     * @param $data
     * @return mixed
     */
    public static function saveImage($data)
    {
        $title = 'Изображение чата '.Auth::user()->name;

        $file = File::storeFile($data['image'], 'chat/pictures', $title);
        $data['file_id'] = $file->id;
        unset($data['image']);
        return $data;
    }
}