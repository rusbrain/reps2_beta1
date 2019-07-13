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

    /**
     * Import database from defiler db
     * @return \Illuminate\Http\Redirect
     */
    public function import() 
    {
        
        $defiler_users = DB::connection('mysql2')
                    ->table("user_info as ui")
                    ->join('user as u', 'u.id', '=', 'ui.id')
                    ->where('ui.mail', 'NOT LIKE', '')
                    ->select('u.login', 'ui.mail')
                    ->get();
      
        foreach ($defiler_users as $user) {
            try {
            $check = DB::table('users')->where('email',  trim($user->mail))->exists();
            $index = 16700;
            $insert_user = array();
          
            if($check) {
                
            } else {
               
                    $insert_user = array( 
                        'name' => $user->login,
                        'email' => trim($user->mail),
                        'password' => '',
                        'user_role_id' => 0
                    );
                    User::create($insert_user);
                    $index++;
              
               
            }
        } catch (\Exception $e) {
            dd($e, $check, $insert_user );
        }
        }
       
    }
}
