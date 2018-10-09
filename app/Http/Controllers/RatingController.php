<?php

namespace App\Http\Controllers;

use App\ForumTopic;
use App\Http\Requests\SetRatingRequest;
use App\IgnoreUser;
use App\User;
use App\UserReputation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Replay;


class RatingController extends Controller
{
    /**
     * Object relation
     *
     * @var string
     */
    protected static $relation;

    /**
     * Model name
     *
     * @var string
     */
    protected static $model;

    /**
     * Get rating
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRating($id)
    {
        return $this->getRatingView(UserReputation::where('object_id', $id)->where('relation', self::$relation));
    }

    /**
     * Set rating
     *
     * @param SetRatingRequest $request
     * @param $id
     * @return array
     */
    public function setRating(SetRatingRequest $request, $id)
    {
        $object = self::$model::find($id);

        if (IgnoreUser::me_ignore($object->user_id)){
            return abort(403);
        }

        $comment = self::getComment($request);

        if($object){
            self::saveUserReputation($object->user_id, $object->id, $request->get('rating'), $comment);

            return ['rating' => self::getRatingValue($object)];
        }

        return abort(404);
    }

    /**
     * Save updated rating values
     *
     * @param $user_id
     * @param $object_id
     * @param $rating
     * @param string $comment
     */
    protected static function saveUserReputation($user_id, $object_id, $rating, $comment = '')
    {
        UserReputation::updateOrCreate(
            ['sender_id' => Auth::id(), 'recipient_id' => $user_id, 'object_id' => $object_id, 'relation' => self::$relation],
            ['comment' => $comment, 'rating'=>  $rating]
        );

        UserReputation::refreshUserRating($user_id);
        UserReputation::refreshObjectRating(self::$model, $object_id, self::$relation);

        self::$model::updateRating($rating, $object_id);
    }

    /**
     * Get comment value
     *
     * @param Request $request
     * @return mixed|null
     */
    protected static function getComment(Request $request)
    {
        $comment = null;

        if($request->has('comment')){
            $comment = $request->get('comment');
        }

        return $comment;
    }

    /**
     * Get calculation of rating value
     *
     * @param $object
     * @return mixed
     */
    protected static function getRatingValue($object)
    {
        return $object->positive()->count()-$object->negative()->count();
    }
    /**
     * Get reputation of User
     *
     * @param $id
     * @return mixed
     */
    public function getRatingUser($id)
    {
        return UserReputation::where('recipient_id', $id)->with('topic', 'sender')->paginate(10);
    }

    /**
     * Get view with rating list
     *
     * @param UserReputation $user_reputation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getRatingView(UserReputation $user_reputation)
    {
        return view('reputation_list')->with('list', $user_reputation->with('sender')->paginate(20));
    }
}
