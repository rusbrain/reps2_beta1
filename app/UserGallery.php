<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class UserGallery extends Model
{
    use SoftDeletes;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='user_galleries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'file_id', 'reps_id', 'rating', 'comment', 'for_adults',
        'negative_count', 'positive_count', 'comments_count'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positive()
    {
        return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_USER_GALLERY)->where('rating',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function negative()
    {
        return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_USER_GALLERY)->where('rating','-1');
    }

    /**
     * Relations. User gallery comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'object_id')->where('relation', Comment::RELATION_USER_GALLERY);
    }

    /**
     * @param $rating
     * @param $user_gallery_id
     */
    public static function updateRating($rating, $user_gallery_id)
    {
        \DB::update('update user_galleries set rating = rating + (?) where id = ?', [$rating, $user_gallery_id]);
    }

    /**
     * Store image file
     *
     * @param $gallery_data
     * @return mixed
     */
    public static function saveImage($gallery_data)
    {
        $title = 'Картинка галлереи пользователя '.Auth::user()->name;

        $file = File::storeFile($gallery_data['image'], 'gallery', $title);

        $gallery_data['file_id'] = $file->id;

        unset($gallery_data['image']);

        return $gallery_data;
    }
}
