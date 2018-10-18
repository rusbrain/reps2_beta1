<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ForumTopic extends Model
{
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
    protected $fillable = ['reps_id', 'reps_section', 'section_id', 'title', 'preview_content', 'content', 'user_id', 'reviews', 'start_on', 'preview_file_id'];

    /**
     * Relations. Topics section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo('App\ForumSection');
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
       return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_FORUM_TOPIC)->where('rating',-1);
    }

    public function preview_image()
    {
        return $this->belongsTo('App\File', 'preview_file_id');
    }

    /**
     * @param $rating
     * @param $topic_id
     */
    public static function updateRating($rating, $topic_id)
    {
        \DB::update('update forum_topics set rating = rating + (?) where id = ?', [$rating, $topic_id]);
    }

    /**
     * @return mixed
     */
    public static function news()
    {
        return ForumTopic::where('news',1)->whereHas('section', function($q){
            $q->where('is_active', 1)->where('is_general', 1);
        })->orderBy('created_at', 'desc');
    }

    /**
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

        return $query;
    }
}
