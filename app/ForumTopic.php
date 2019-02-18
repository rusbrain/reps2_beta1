<?php

namespace App;

use App\Http\Requests\SearchForumTopicRequest;
use App\Observers\ForumTopicPointsObserver;
use App\Traits\ModelRelations\ForumTopicRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Input;
use Illuminate\Notifications\Notifiable;

class ForumTopic extends Model
{
    use Notifiable, ForumTopicRelation;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created'   => ForumTopicPointsObserver::class,
        'deleted'   => ForumTopicPointsObserver::class,
        'restored'  => ForumTopicPointsObserver::class,
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
    protected $fillable = ['icon', 'reps_id', 'reps_section', 'section_id', 'title', 'preview_content',
        'content', 'user_id', 'reviews', 'start_on', 'preview_file_id', 'news','negative_count',
        'positive_count', 'comments_count'];

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
        return ForumTopic::where('news',1)
            ->where(function ($q){
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-M-d'));
            })
            ->whereHas('section', function($q){
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
            ->withCount( 'positive', 'negative', 'comments')
            ->with(['user'=> function($q){
                $q->withTrashed();
            }]);
    }

    /**
     * Generate query with search request
     *
     * @param array $data
     * @param Builder $query
     * @return Builder
     */
    public static function search(array $data, $query = false )
    {
        if (!$query){
            $query = ForumTopic::where('id', '>', 0);
        }

        if (isset($data['user_id']) && null !== $data['user_id']){
            $query->where('user_id', $data['user_id']);
        }

        if (isset($data['min_rating']) && null !== $data['min_rating']){
            $query->where('rating','>=', $data['min_rating']);
        }

        if (isset($data['min_date']) && null !== $data['min_date']){
            $query->where('created_at','>=', $data['min_date']);
        }

        if (isset($data['max_date']) && null !== $data['max_date']){
            $query->where('created_at','<=', $data['max_date']);
        }

        if (isset($data['news']) && null !== $data['news']){
            $query->where('news',$data['news']);
        }

        if (isset($data['approved']) && null !== $data['approved']){
            $query->where('approved',$data['approved']);
        }

        if (isset($data['text']) && null !== $data['text']){
            $query->where(function ($q) use ($data){
                $q->where('title', 'like', "%{$data['text']}%")
                    ->orWhere('preview_content', 'like', "%{$data['text']}%")
                    ->orWhere('content', 'like', "%{$data['text']}%");
            });
        }

        if (isset($data['section_id']) && null !== $data['section_id']){
            $query->whereHas('section', function ($q) use ($data){
                $q->where('id', $data['section_id']);
            });
        }

        if(Input::has('sort') && Input::get('sort')){
            $query->orderBy(Input::get('sort'), 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
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
            ->with('section', 'user.avatar','preview_image', 'icon')
            ->withCount( 'positive', 'negative', 'comments')
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
        return $data->topics()->with(['user'=> function($q){
            $q->with('avatar')->withTrashed();
        }])
            ->withCount( 'positive', 'negative', 'comments')
            ->where(function ($q){
                $q->whereNull('start_on')
                    ->orWhere('start_on','<=', Carbon::now()->format('Y-M-d'));
            })
            ->with(['comments' => function($query){
                $query->withCount('positive', 'negative')->orderBy('created_at', 'desc')->get();
            }])
            ->with('comments', 'icon')
            ->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getTopicWithRelations($id)
    {
        return ForumTopic::where('id', $id)
            ->where(function ($q){
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-M-d'));
            })
            ->with(User::getUserWithReputationQuery())
            ->withCount( 'positive', 'negative', 'comments')
            ->with('icon')->first();
    }

    /**
     * @return mixed
     */
    public static function popularForumTopics()
    {
        return ForumTopic::where('approved',1)
            ->where(function ($q){
                $q->whereNull('start_on')
                    ->orWhere('start_on','<=', Carbon::now()->format('Y-M-d'));
            })
            ->withCount( 'positive', 'negative', 'comments')
            ->whereHas('section', function ($query){
                $query->where('is_active',1)->where('is_general',1);
            })
            ->with('preview_image')
            ->limit(5)
            ->orderBy('created_at', 'desc')
            ->orderBy('rating', 'desc')->get();
    }

    /**
     * @return mixed
     */
    public static function lastNews()
    {
        return ForumTopic::news()->where('approved',1)->with(['user'=> function($q){
            $q->withTrashed()->with('avatar');
        }])
            ->withCount( 'positive', 'negative', 'comments')
            ->with('preview_image', 'icon')->limit(5)->get();
    }

    /**
     * @param $search
     * @return mixed
     */
    public static function getSearchTitleNews($search)
    {
        return ForumTopic::news()->where('approved',1)->with(['user'=> function($q){
            $q->withTrashed()->with('avatar');
        }])
            ->withCount( 'positive', 'negative', 'comments')
            ->where('title', 'like', "%$search%")
            ->with('preview_image', 'icon')->paginate(20);
    }

    /**
     * @param $search
     * @return mixed
     */
    public static function getSearchTitle($search)
    {
        return ForumTopic::with(['user'=> function($q){
            $q->withTrashed();
        }])
            ->withCount( 'positive', 'negative', 'comments')
            ->with('icon')
            ->where(function ($q){
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-M-d'));
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
        return self::search($request->validated(), self::with('user', 'section', 'icon'))
            ->withCount( 'positive', 'negative', 'comments')->paginate(50);
    }

    /**
     * @param $topic_id
     */
    public static function removeTopic($topic_id)
    {
        $topic = ForumTopic::find($topic_id);

        $topic->comments()->delete();
        $topic->positive()->delete();
        $topic->negative()->delete();

        ForumTopic::where('id', $topic_id)->delete();
    }
}
