<?php

namespace App;

use App\Observers\UserGalleryPointsObserver;
use App\Traits\ModelRelations\UserGalleryRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserGallery extends Model
{
    use SoftDeletes, Notifiable, UserGalleryRelation;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created'   => UserGalleryPointsObserver::class,
        'deleted'   => UserGalleryPointsObserver::class,
        'restored'  => UserGalleryPointsObserver::class,
    ];

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

    const USER_GALLERY_FOR_ADULTS  = 1;
    const USER_GALLERY_FOR_ALL  = 0;

    /**
     * @param $rating
     * @param $user_gallery_id
     */
    public static function updateRating($rating, $user_gallery_id)
    {
        \DB::update('update user_galleries set rating = rating + (?) where id = ?', [$rating, $user_gallery_id]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getGalleryById($id)
    {
        return UserGallery::where('id', $id)
            ->with('user.avatar', 'file')
            ->withCount( 'positive', 'negative', 'comments')
            ->first();
    }
}
