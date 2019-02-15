<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Requests\FileSearchAdminRequest;
use App\Http\Requests\FileUpdateAdminRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileManagementController extends Controller
{
    /**
     * Get list of file
     *
     * @param FileSearchAdminRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(FileSearchAdminRequest $request)
    {
        $data = File::search($request)->count();
        return view('admin.file.list')->with(['file_count' => $data, 'request_data' => $request->validated()]);
    }

    public function pagination(FileSearchAdminRequest $request)
    {
        $files = File::search($request)->paginate(20);

        $table      = (string) view('admin.file.list_table') ->with(['data' => $files]);
        $pagination = (string) view('admin.user.pagination')    ->with(['data' => $files]);
        $pop_up     = (string) view('admin.file.list_pop_up')->with(['data' => $files]);

        return ['table' => $table, 'pagination' => $pagination, 'pop_up' => $pop_up];
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
                $path = str_replace('public', '/storage',$date['file']->storeAs('public/files', substr(md5(time()), 0, 5).$date['file']->getClientOriginalName()));

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
