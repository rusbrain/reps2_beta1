<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\DB;
use App\User;

class DBManagementController extends Controller
{

    public $dir_path = 'reps.ru';

    /**
     * Display a listing of the backup files.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $allFiles = Storage::allFiles($this->dir_path);
        $files = array();
        rsort($allFiles);
        foreach ($allFiles as $file) {
            $files[] = $this->fileInfo(pathinfo(storage_path() . '/app/' . $file));
        }
        return view('admin.dbbackup.list')->with('files', $files);
    }

    /**
     * Get file info.
     * @param $filePath
     * @return $file
     */

    public function fileInfo($filePath)
    {
        $file = array();
        $file['dbname'] = "Reps DB";
        $file['name'] = $filePath['filename'];
        $file['extension'] = $filePath['extension'];
        $file['size'] = number_format(round(filesize($filePath['dirname'] . '/' . $filePath['basename'])/1024, 0)) ." KB";
        $file['basename'] = $filePath['basename'];
        return $file;
    }

    /**
     * Download dump file from server
     * @param $file
     * @return \Illuminate\Http\Response
     */
    public function filedownload($file)
    {
        return response()->download(storage_path("app/{$this->dir_path}/{$file}"));
    }

    /**
     * Delete dump file
     * @param $file
     * @return \Illuminate\Http\Redirect
     */
    public function filedelete($file)
    {
        Storage::delete("{$this->dir_path}/{$file}");
        return redirect()->route('admin.dbbackup');
    }  
}
