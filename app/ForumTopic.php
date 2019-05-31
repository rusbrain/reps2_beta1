<?php

namespace App;

use App\Http\Requests\SearchForumTopicRequest;
use App\Observers\ForumTopicPointsObserver;
use App\Services\Forum\TopicService;
use App\Traits\ModelRelations\ForumTopicRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\{
    Model, Builder
};
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property integer $section_id
 * @property integer $user_id
 * @property integer $reviews
 * @property integer $negative_count
 * @property integer $positive_count
 * @property integer $comments_count
 * @property integer $news
 * @property integer $approved
 * @property string $title
 * @property integer $preview_file_id
 * @property string $preview_content
 * @property string $content
 * @property string $updated_by_user
 *
 * @property Carbon $start_on
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * 'preview_file_id', 'news',
 */
class ForumTopic extends Model
{
    use Notifiable, ForumTopicRelation;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ForumTopicPointsObserver::class,
        'deleted' => ForumTopicPointsObserver::class,
        'restored' => ForumTopicPointsObserver::class,
    ];

    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'forum_topics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icon',
        'reps_id',
        'reps_section',
        'section_id',
        'title',
        'preview_content',
        'content',
        'user_id',
        'reviews',
        'start_on',
        'preview_file_id',
        'news',
        'negative_count',
        'positive_count',
        'comments_count',
        'approved'
    ];

    /**
     * Update forum topic rating
     *
     * @param $rating
     * @param $topic_id
     */
    public static function updateRating($rating, $topic_id)
    {
        \DB::update('update forum_topics set rating = rating + (?) where id = ?', [$rating, $topic_id]);
    }

    /**
     * Get forum topics for news
     *
     * @return mixed
     */
    public static function news()
    {
        return ForumTopic::where('news', 1)
            ->where(function ($q) {
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-m-d'));
            })
            ->whereHas('section', function ($q) {
                $q->where('is_active', 1)->where('is_general', 1);
            })->orderBy('created_at', 'desc');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public static function newsWithQuery(Builder $query)
    {
        return $query->with('section', 'preview_image', 'icon')
            ->withCount('positive', 'negative', 'comments')
            ->with([
                'user' => function ($q) {
                    $q->withTrashed();
                }
            ]);
    }

    /**
     * Get Forum Topic with all data by id
     *
     * @param $topic_id
     * @return mixed
     */
    public static function getTopicById($topic_id)
    {
        return ForumTopic::where('id', $topic_id)
            ->with('section', 'user.avatar', 'preview_image', 'icon')
            ->withCount('positive', 'negative', 'comments')
            ->first();
    }

    /**
     * Get topics of section with pagination
     *
     * @param ForumSection $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getTopicsForSection(ForumSection $data)
    {
        return $data->topics()->with([
            'user' => function ($q) {
                $q->with('avatar')->withTrashed();
            }
        ])
            ->withCount('positive', 'negative', 'comments')
            ->where(function ($q) {
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-m-d'));
            })
            ->where('approved', 1)
            ->with([
                'comments' => function ($query
                ) {                                                             //TODO:remove "with comments"
                    $query->withCount('positive', 'negative')->orderBy('created_at', 'desc')->get();
                }
            ])
            ->with('comments', 'icon')//TODO:remove "with comments"
            ->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getTopicWithRelations($id)
    {
        return ForumTopic::where('id', $id)
            ->where(function ($q) {
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-m-d'));
            })
            ->with(User::getUserWithReputationQuery())
            ->withCount('positive', 'negative', 'comments')
            ->with('icon')->first();
    }

    /**
     * @return mixed
     */
    public static function popularForumTopics()
    {
        return ForumTopic::where('approved', 1)
            ->where(function ($q) {
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-m-d'));
            })
            ->withCount('positive', 'negative', 'comments')
            ->whereHas('section', function ($query) {
                $query->where('is_active', 1)->where('is_general', 1);
            })
            ->with('preview_image')
            ->limit(5)
            ->orderBy('created_at', 'desc')
            ->orderBy('rating', 'desc')->get();
    }

    /**
     * Get five populates forum topics/news
     *
     * @param $limit
     * @return $this
     */
    public static function getTopForumTopics($limit)
    {
        return DB::table((new self())->getTable())
            ->select(DB::raw("id, rating, 'forum' AS 'type'"))
            ->where('approved', 1)
            ->where(function ($q) {
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-m-d'));
            })
            ->orderBy('rating','DESC')
            ->limit($limit);
    }

    /**
     * @return mixed
     */
    public static function lastNews()
    {
        return ForumTopic::news()->where('approved', 1)->with([
            'user' => function ($q) {
                $q->withTrashed()->with('avatar');
            }
        ])
            ->withCount('positive', 'negative', 'comments')
            ->with('preview_image', 'icon')->limit(4)->get();
    }

    /**
     * @param $search
     * @return mixed
     */
    public static function getSearchTitleNews($search)
    {
        return ForumTopic::news()->where('approved', 1)->with([
            'user' => function ($q) {
                $q->withTrashed()->with('avatar');
            }
        ])
            ->withCount('positive', 'negative', 'comments')
            ->where('title', 'like', "%$search%")
            ->with('preview_image', 'icon')->paginate(20);
    }

    /**
     * @param $search
     * @return mixed
     */
    public static function getSearchTitle($search)
    {
        return ForumTopic::with([
            'user' => function ($q) {
                $q->withTrashed();
            }
        ])
            ->withCount('positive', 'negative', 'comments')
            ->with('icon')
            ->where(function ($q) {
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-m-d'));
            })
            ->where('title', 'like', "%$search%")
            ->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * @param SearchForumTopicRequest $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getTopicPagination(SearchForumTopicRequest $request)
    {
        return TopicService::search($request->validated(), self::with('user', 'section', 'icon'))
            ->withCount('positive', 'negative', 'comments')->paginate(50);
    }

    /**
     * @param $text
     * @return mixed
     */
    public static function searchTopic($text)
    {
        return ForumTopic::where('preview_content', 'like', "%$text%")->orWhere('content', 'like',
            "%$text%")->orWhere('title', 'like', "%$text%");
    }

    /**
     * get last five forums
     *
     * @param int $limit
     * @return $this
     */
    public static function getLastForumTopic($limit = 5)
    {
        return DB::table((new self())->getTable())
            ->select(DB::raw("id, created_at, 'forum' AS 'type'"))
            ->where('approved', 1)
            ->where('news', 0)
            ->where(function ($q) {
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-m-d'));
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit);
    }

    /**
     * Get forum topics by ids
     *
     * @param array $ids
     * @return mixed
     */
    public static function getForumTopicsByIds(array $ids)
    {
        return ForumTopic::whereIn('id', $ids)
            ->with('preview_image')
            ->withCount('positive', 'negative', 'comments')
            ->get();
    }

    /**
     * Get last 10 forums and news for home page
     * @return mixed
     */
    public static function getLastForums ()
    {
        return ForumTopic::forums()->where('approved', 1)->with([
            'user' => function ($q) {
                $q->withTrashed()->with('avatar');
            }
        ])
            ->withCount('positive', 'negative', 'comments')
            ->with('preview_image', 'icon')->limit(10)->get();
    }

    /**
     * get all forums
     * @return mixed
     */
    public static function forums()
    {
        return ForumTopic::where(function ($q) {
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-m-d'));
            })
            ->whereHas('section', function ($q) {
                $q->where('is_active', 1);//->where('is_general', 1)
            })->orderBy('created_at', 'desc');
    }

}