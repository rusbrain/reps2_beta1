<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:11
 */

namespace App\Services\Rating;

use App\Http\Requests\SetRatingRequest;
use App\IgnoreUser;
use App\User;
use App\UserReputation;
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
}