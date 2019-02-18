<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Requests\FileSearchAdminRequest;
use App\Http\Requests\FileUpdateAdminRequest;
use App\Services\Base\BaseDataService;
use App\Services\Base\FileService;
use App\Services\Base\ViewService;
use App\Http\Controllers\Controller;
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
        return BaseDataService::getPaginationData(ViewService::getFiles($files), ViewService::getPagination($files), ViewService::getFilesPopUp($files));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\StreamedResponse
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
            FileService::update($request, $file);
            return back();
        }

        return abort(404);
    }
}
