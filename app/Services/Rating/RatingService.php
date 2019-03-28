<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:11
 */

namespace App\Services\Rating;

use App\{
    Comment, ForumTopic, IgnoreUser, Replay, Services\Base\UserViewService, User, UserGallery, UserReputation
};
use App\Http\Requests\SetRatingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    /**
     * Get user reputation view
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function getRatingView($id)
    {
        return view('user.reputation')->with([
            'user' => User::find($id)
        ]);
    }

    /**
     * @param $user_reputation
     * @return $this
     */
    public static function getUserRatingList($user_reputation)
    {
        return $user_reputation->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * Get view with rating list for current object
     *
     * @param $id
     * @param $relation
     * @param $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function getObjectRating($id, $model, $relation)
    {
        $route = '';
        $pagination_path = '';
        $object = $model::find($id);
        switch ($relation) {
            case UserReputation::RELATION_FORUM_TOPIC:
                $route = 'forum.topic.index';
                $pagination_path = 'forum.topic.paginate';
                break;
            case UserReputation::RELATION_REPLAY:
                $route = 'replay.get';
                $pagination_path = 'replay.paginate';
                break;
            case UserReputation::RELATION_USER_GALLERY:
                $route = 'gallery.view';
                $pagination_path = 'gallery.paginate';
                break;
        }
        return view('user.object-reputation')->with([
            'object' => $object,
            'route' => $route,
            'pagination_path' => $pagination_path
        ]);
    }

    /**
     * @param $user_reputation
     * @param $relation
     * @param $id
     * @return array
     */
    public static function getList($relation = false, $id, $user_reputation = false)
    {
        if(!$relation && $user_reputation){
            $data = self::getUserRatingList($user_reputation, $id);
        }
        if($relation && !$user_reputation){
            $data = self::reputationWithPagination($relation, $id);
        }

        return [
            'list' => UserViewService::getReputationList($data),
            'pagination' => UserViewService::getPagination($data)
        ];
    }

    /**
     * @param $relation
     * @param $id
     * @return mixed
     */
    public static function reputationWithPagination($relation, $id)
    {
        return UserReputation::where('object_id', $id)->where('relation', $relation)->with('sender')->paginate(20);
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
        if (IgnoreUser::me_ignore($object->user_id)) {
            return ['message' => 'Вы не можете проголосовать. Автор добавил Вас в игнор лист'];
        }

        $comment = self::getComment($request);
        if ($object) {
            if (!self::checkUserVoteExist($object, $request, $relation)) {
                UserReputation::updateOrCreate(
                    [
                        'sender_id' => Auth::id(),
                        'recipient_id' => $object->user_id,
                        'object_id' => $object->id,
                        'relation' => $relation
                    ],
                    ['comment' => $comment, 'rating' => $request->get('rating')]
                );
                return ['rating' => self::getRatingValue($object)];
            }
            return ['message' => 'Вы уже проголосовали, Ваш голос:', 'user_rating' => $request->get('rating')];
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

        if ($request->has('comment')) {
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
        foreach ($ratings as $rating) {
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
        switch ($relation_id) {
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

        User::where('id', $user_id)->update([
            'rating' => $val,
            'negative_count' => $negative,
            'positive_count' => $positive
        ]);
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
        $positive = UserReputation::where('object_id', $object_id)->where('relation', $relation_id)->where('rating',
            '1')->count();
        $negative = UserReputation::where('object_id', $object_id)->where('relation', $relation_id)->where('rating',
            '-1')->count();
        $val = $positive - $negative;

        $class_name::where('id', $object_id)->update([
            'rating' => $val,
            'negative_count' => $negative,
            'positive_count' => $positive
        ]);
    }

    /**
     * @param $object
     * @param $request
     * @param $relation
     * @return bool
     */
    public static function checkUserVoteExist($object, $request, $relation)
    {
        $vote = UserReputation::where('sender_id', Auth::id())
            ->where('recipient_id', $object->user_id)
            ->where('object_id', $object->id)
            ->where('relation', $relation)
            ->where('rating', $request->get('rating'))
            ->first();

        return $vote ? $vote : false;
    }
}