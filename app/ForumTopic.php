<?php

namespace App;

use App\Observers\ForumTopicPointsObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Input;
use Illuminate\Notifications\Notifiable;

class ForumTopic extends Model
{
    use Notifiable;

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
     * Relations. Topics section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo('App\ForumSection','section_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sectionActive()
    {
        return $this->belongsTo('App\ForumSection','section_id')->where('is_active', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function icon()
    {
        return $this->belongsTo('App\ForumIcon');
    }

    /**
     * Relations. Topic comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'object_id')->where('relation', Comment::RELATION_FORUM_TOPIC);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positive()
    {
       return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_FORUM_TOPIC)->where('rating',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function negative()
    {
       return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_FORUM_TOPIC)->where('rating','-1');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preview_image()
    {
        return $this->belongsTo('App\File', 'preview_file_id');
    }

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
     * Generate query with search request
     *
     * @param Builder $query
     * @param array $data
     * @return Builder
     */
    public static function search(Builder $query, array $data)
    {
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
            ->with(['comments' => function($q) {
                $q->with('user.avatar')->orderBy('created_at', 'desc')->paginate(20);
            }])
            ->withCount( 'positive', 'negative', 'comments')
            ->first();
    }
}
