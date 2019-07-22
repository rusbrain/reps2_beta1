<?php

namespace App\Services\Chat;

use App\{File, User, ChatSmile};
use App\Http\Requests\{SmileStoreRequest, SmileUpdateRequest};
use App\Services\Base\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatSmileService
{
    /**
     * @param $smile
     * @return mixed
     */
    public static function getList($smile)
    {
        return $smile->with('file', 'user')->orderBy('created_at')->paginate(50);
    }

    /**
     * @param SmileStoreRequest $request
     * @return mixed
     */
    public static function store(SmileStoreRequest $request)
    {
        $data = $request->validated();
        $data = self::saveImage($data);
        $data['user_id'] = Auth::id();       
        $smile = ChatSmile::create($data);

        return $smile->id;
    }
  
    /**
     * @param SmileUpdateRequest $request
     * @param ChatSmile $smile
     */
    public static function update(SmileUpdateRequest $request, ChatSmile $smile)
    {
        $data = $request->validated();

        if($request->has('image')){
            FileService::removeFile($smile->file_id);
            $data = self::saveImage($data);
        }

        ChatSmile::where('id', $smile->id)->update($data);
    }

    /**
     * @param ChatSmile $smile
     * @throws \Exception
     */
    public static function destroy(ChatSmile $smile)
    {

        $file = $smile->file()->first();
        if($file) {
            FileService::removeFile($file->id);
            if(file_exists(base_path('public/images/emoticons/smiles/'.pathinfo($file->link)["basename"])))
                unlink(base_path('public/images/emoticons/smiles/'.pathinfo($file->link)["basename"]));
        }
        $smile->delete();
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

        $file = File::storeFile($data['image'], 'chat/smiles', $title, 'smile', $data['charactor']);
        $success = \File::copy(base_path('public/'.$file->link),base_path('public/images/emoticons/smiles/'.pathinfo($file->link)["basename"]));
      
        $data['file_id'] = $file->id;
        unset($data['image']);
        return $data;
    }
}