<?php

namespace App;

use App\Http\Requests\FileSearchAdminRequest;
use Illuminate\Database\Eloquent\Model;
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
        'link',
        'size',
        'type'
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

        $file_boj = File::create([
            'user_id' => Auth::id(),
            'title' => $file_title,
            'link' => $path,
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
        ]);

        return $file_boj;
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
        $file->replay()->delete();
        $file->avatar()->update(['file_id' => null]);
        if ($file){
            Storage::delete(str_replace('/storage','public', $file->link));

            File::where('id', $file_id)->delete();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_gallery()
    {
        return $this->hasOne('App\UserGallery', 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function banner()
    {
        return $this->hasOne('App\Banner', 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne('App\Country', 'flag_file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function forum_topic()
    {
        return $this->hasOne('App\ForumTopic', 'preview_file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function replay()
    {
        return $this->hasOne('App\Replay', 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function avatar()
    {
        return $this->hasOne('App\User', 'file_id');
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
