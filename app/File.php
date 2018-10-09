<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'link'
    ];

    /**
     * Relations. Files user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Storage new file
     *
     * @param $file
     * @param $dir_name
     * @param string $file_title
     * @return mixed
     */
    public static function storeFile($file,$dir_name, $file_title = '')
    {
        $path = str_replace('public', '/storage',$file->store('public/'.$dir_name));

        $file = File::create([
            'user_id' => Auth::id(),
            'title' => $file_title,
            'link' => $path
        ]);

        return $file;
    }

    /**
     * Remove old file
     *
     * @param $file_id
     */
    public static function removeFile($file_id)
    {
        $file = File::find($file_id);

        if ($file){
            Storage::delete(str_replace('/storage','public', $file->link));

            File::where('id', $file_id)->delete();
        }
    }
}
