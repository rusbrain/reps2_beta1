<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 12:16
 */

namespace App\Services\Base;

use App\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FileUpdateAdminRequest;

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
}