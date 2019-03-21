<?php

namespace App;

use App\Observers\UserGalleryPointsObserver;
use App\Traits\ModelRelations\UserGalleryRelation;
use Illuminate\Database\Eloquent\{
    Model, SoftDeletes
};
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class UserGallery extends Model
{
    use SoftDeletes, Notifiable, UserGalleryRelation;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserGalleryPointsObserver::class,
        'deleted' => UserGalleryPointsObserver::class,
        'restored' => UserGalleryPointsObserver::class,
    ];

    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'user_galleries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'file_id',
        'reps_id',
        'rating',
        'comment',
        'for_adults',
        'negative_count',
        'positive_count',
        'comments_count'
    ];

    const USER_GALLERY_FOR_ADULTS = 1;
    const USER_GALLERY_FOR_ALL = 0;

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
            ->withCount('positive', 'negative', 'comments')
            ->first();
    }

    /**
     * get last five galleries
     *
     * @param int $limit
     * @return mixed
     */
    public static function getLastGallery($limit = 5)
    {
        return DB::table((new self)->getTable())
            ->select(DB::raw("id, created_at, 'gallery' AS 'type'"))
            ->orderBy('created_at', 'desc')
            ->limit($limit);
    }

    /**
     * Get user galleries by ids
     *
     * @param array $ids
     * @return mixed
     */
    public static function getGalleriesByIds(array $ids)
    {
        return UserGallery::whereIn('id', $ids)
            ->with('file', 'user')
            ->withCount('positive', 'negative', 'comments')
            ->get();
    }
}
