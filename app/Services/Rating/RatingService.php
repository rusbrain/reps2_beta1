<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:11
 */

namespace App\Services\Rating;

use App\{Comment, ForumTopic, IgnoreUser, Replay, User, UserGallery, UserReputation};
use App\Http\Requests\SetRatingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    /**
     * Get view with rating list
     *
     * @param UserReputation $user_reputation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function getRatingView($user_reputation, $id)
    {
        $query_list = clone $user_reputation;
        $query_topic = clone $user_reputation;
        $query_replay = clone $user_reputation;
        $query_base = clone $user_reputation;

        $list = $query_list->orderBy('created_at', 'desc')->paginate(20);

        $ids = [];
        foreach ($list as $item) {
            $ids[] = $item->id;
        }

        $list_topic     =  $query_topic->where('relation', UserReputation::RELATION_FORUM_TOPIC)        ->whereIn('id',$ids)->with('sender', 'topic')   ->get();
        $list_replay    =  $query_replay->where('relation', UserReputation::RELATION_REPLAY)            ->whereIn('id',$ids)->with('sender', 'replay')  ->get();
        $list_gallery   =  $user_reputation->where('relation', UserReputation::RELATION_USER_GALLERY)   ->whereIn('id',$ids)->with('sender', 'gallery') ->get();
        $list_base      =  $query_base->where('relation', 0)                                            ->whereIn('id',$ids)->with('sender')            ->get();

        $list_with_data = $list_topic->merge($list_replay)->merge($list_topic)->merge($list_gallery)->merge($list_base)->sortByDesc('created_at');

        return view('user.reputation')->with(['list'=>$list_with_data, 'pagination_data' =>$list, 'user' => User::find($id)] );
    }

    /**
     * Set rating
     *
     * @param SetRatingRequest $request
     * @param $id
     * @param $relation
     * @return array
     */
    public static function set(SetRatingRequest $request, $id, $relation, $model)
    {
        $object = ($model)::find($id);

        if (IgnoreUser::me_ignore($object->user_id)){
            return abort(403);
        }

        $comment = self::getComment($request);

        if($object){
            UserReputation::updateOrCreate(
                ['sender_id' => Auth::id(), 'recipient_id' => $object->user_id, 'object_id' => $object->id, 'relation' => $relation],
                ['comment' => $comment, 'rating'=>  $request->get('rating')]
            );

            return ['rating' => self::getRatingValue($object)];
        }

        return abort(404);
    }

    /**
     * Get calculation of rating value
     *
     * @param $object
     * @return mixed
     */
    protected static function getRatingValue($object)
    {
        return $object->positive()->count() - $object->negative()->count();
    }

    /**
     * Get comment value
     *
     * @param Request $request
     * @return mixed|null
     */
    public static function getComment(Request $request)
    {
        $comment = null;

        if($request->has('comment')){
            $comment = $request->get('comment');
        }
        return $comment;
    }

    /**
     * @param $user_id
     */
    public static function recountRating($user_id)
    {
        $ratings = UserReputation::where('recipient_id', $user_id)->get();
        $sum = 0;
        foreach ($ratings as $rating){
            $sum += $rating->rating;
        }

        User::where('id', $user_id)->update(['rating' => $sum]);
    }

    /**
     * @param $relation_id
     * @return null|string
     */
    public static function getModel($relation_id)
    {
        $model = null;
        switch ($relation_id){
            case UserReputation::RELATION_FORUM_TOPIC:
                $model = ForumTopic::class;
                break;
            case UserReputation::RELATION_REPLAY:
                $model = Replay::class;
                break;
            case UserReputation::RELATION_USER_GALLERY:
                $model = UserGallery::class;
                break;
            case UserReputation::RELATION_COMMENT:
                $model = Comment::class;
                break;
        }

        return $model;
    }

    /**
     * Refresh user Rating
     *
     * @param $user_id
     */
    public static function refreshUserRating($user_id)
    {
        $positive = UserReputation::where('recipient_id', $user_id)->where('rating', '1')->count();
        $negative = UserReputation::where('recipient_id', $user_id)->where('rating', '-1')->count();
        $val = $positive - $negative;

        User::where('id', $user_id)->update(['rating'=>$val, 'negative_count' => $negative, 'positive_count' => $positive]);
    }

    /**
     * Refresh object Rating
     *
     * @param $object_id
     * @param $relation_id
     */
    public static function refreshObjectRating($object_id, $relation_id)
    {
        $class_name = RatingService::getModel($relation_id);
        $positive = UserReputation::where('object_id', $object_id)->where('relation',$relation_id)->where('rating', '1')->count();
        $negative = UserReputation::where('object_id', $object_id)->where('relation',$relation_id)->where('rating', '-1')->count();
        $val = $positive - $negative;

        $class_name::where('id', $object_id)->update(['rating'=>$val, 'negative_count' => $negative, 'positive_count' => $positive]);
    }
}