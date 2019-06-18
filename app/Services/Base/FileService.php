<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 12:16
 */

namespace App\Services\Base;

use App\File;
use App\Http\Requests\{FileSearchAdminRequest, FileUpdateAdminRequest};
use Illuminate\Support\Facades\{Auth, Storage};

class FileService
{
    /**
     * @param FileUpdateAdminRequest $request
     * @param File $file
     */
    public static function update(FileUpdateAdminRequest $request, File $file)
    {
        $date = $request->validated();

        if ($request->hasFile('file')){
            Storage::delete(str_replace('/storage','public', $file->link));
            $path = str_replace('public', '/storage',$date['file']->storeAs('public/files', substr(md5(time()), 0, 5).$date['file']->getClientOriginalName()));

            $date['link']       = $path;
            $date['user_id']    = Auth::id();
            $date['size']       = $date['file']->getSize();
            $date['type']       = $date['file']->getMimeType();
        }

        unset($date['file']);
        File::where('id', $file->id)->update($date);
    }

    /**
     * Remove old file
     *
     * @param $file_id
     */
    public static function removeFile($file_id)
    {
        $file = File::find($file_id);

        $file->user_gallery()->delete();
        $file->banner()->delete();
        $file->country()->update(['flag_file_id' => null]);
        $file->forum_topic()->update(['preview_file_id' => null]);
        //$file->replay()->delete();
        $file->avatar()->update(['file_id' => null]);
        if ($file){
            Storage::delete(str_replace('/storage','public', $file->link));

            File::where('id', $file_id)->delete();
        }
    }

    /**
     * @param FileSearchAdminRequest $request
     * @return mixed
     */
    public static function search(FileSearchAdminRequest $request)
    {
        $data = File::withCount('banner', 'country', 'forum_topic', 'replay', 'avatar', 'user_gallery')->with('user');
        $data_req = $request->validated();

        if (isset($data_req['size_to'])){
            $data->where('size', ($data_req['size_to']?'>=':'<='), ($data_req['size']*1000));
        } elseif (isset($data_req['size'])){
            $data->where('size', '>=', ($data_req['size']*1000));
        }

        if (isset($data_req['text'])){
            $data->where(function ($q) use ($data_req){
                $q->where('title', 'like', "%{$data_req['text']}%")
                    ->orWhere('type', 'like', "%{$data_req['text']}%")
                    ->orWhere('id', 'like', "%{$data_req['text']}%");
            });
        }

        if(isset($data_req['sort'])){
            $data->orderBy($data_req['sort']);
        } else {
            $data->orderBy('created_at', 'desc');
        }

        if(isset($data_req['user_id'])){
            $data->where('user_id',$data_req['user_id']);
        }

        return $data;
    }
}