<?php

namespace App;

use App\Contracts\CommentContainerInterface;
use App\Observers\UserGalleryPointsObserver;
use App\Traits\ModelRelations\UserGalleryRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\{
    Model, SoftDeletes
};
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $file_id
 * @property integer $reps_id
 * @property integer $rating
 * @property integer $for_adults
 * @property integer $reviews
 * @property integer $negative_count
 * @property integer $positive_count
 * @property integer $comments_count
 * @property string $comment
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class UserGallery extends Model implements CommentContainerInterface
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
        'comments_count',
        'reviews'
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

    /**
     * Get five populates replays
     *
     * @param $limit
     * @return mixed
     */
    public static function getTopGalleries($limit)
    {
        return DB::table((new self())->getTable())
            ->select(DB::raw("id, rating, 'gallery' AS 'type'"))
            ->orderBy('rating','DESC')
            ->limit($limit);
    }

    public function getRouteConfig()
    {
        return ['gallery.view', ['id' => $this->id]];
    }

    public function getTitle()
    {
        return $this->comment ? : null;
    }
}
