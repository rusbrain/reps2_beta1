<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Requests\FileUpdateAdminRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileManagementController extends Controller
{
    /**
     * Get list of file
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = File::withCount('banner', 'country', 'forum_topic', 'replay', 'avatar', 'user_gallery')->with('user')->paginate(20);
        return view('admin.file.list')->with(['data' => $data]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function download($id)
    {
        $file = File::find($id);

        if(!$file){
            return abort(404);
        }

        if (stristr($file->type, 'image')){
            return redirect(route('home').'/'.$file->link);
        }

        return Storage::download(str_replace('/storage','public', $file->link));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        File::removeFile($id);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.file.edit')->with('file', File::find($id));
    }

    /**
     * @param FileUpdateAdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FileUpdateAdminRequest $request, $id)
    {
        if ($file = File::find($id)){
            $date = $request->validated();

            if ($request->hasFile('file')){
                Storage::delete(str_replace('/storage','public', $file->link));
                $path = str_replace('public', '/storage',$date['file']->store('public/files'));

                $date['link']       = $path;
                $date['user_id']    = Auth::id();
                $date['size']       = $date['file']->getSize();
                $date['type']       = $date['file']->getMimeType();
            }

            unset($date['file']);
            File::where('id', $id)->update($date);

            return back();
        }

        return abort(404);
    }
}
