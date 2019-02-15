<?php

namespace App;

use App\Traits\ModelRelations\ForumSectionRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ForumSection extends Model
{
    use ForumSectionRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'forum_sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['position', 'reps_id', 'name', 'title', 'description', 'is_active', 'is_general', 'user_can_add_topics'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return mixed
     */
    public static function active()
    {
        return $general_forum = ForumSection::where('is_active',1)->orderBy('position');
    }

    /**
     * @return mixed
     */
    public static function general_active()
    {
        return $general_forum = ForumSection::where('is_active',1)->where('is_general', 1)->orderBy('position');
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function getSectionByName($name)
    {
       return ForumSection::active()->where('name', $name)->first();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function getUserTopics($user_id)
    {
        return ForumSection::whereHas('topics', function ($query) use ($user_id){
                    $query->where('user_id', $user_id);
                })->with(['topics' => function($query1) use ($user_id){
                    $query1->where('user_id',$user_id)
                        ->withCount( 'positive', 'negative', 'comments')
                        ->with('icon')
                        ->has('sectionActive')
                        ->with(['user'=> function($q){
                            $q->with('avatar')->withTrashed();
                        }])
                        ->where(function ($q){
                            $q->whereNull('start_on')
                                ->orWhere('start_on','<=', Carbon::now()->format('Y-M-d'));
                        })
                        ->with(['comments' => function($query){
                            $query->withCount('positive', 'negative')->orderBy('created_at', 'desc')->first();
                        }])
                        ->orderBy('created_at', 'desc');
                }])->get();
    }
}
