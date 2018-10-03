<?php

namespace App\Http\Controllers;

use App\CensorshipWord;
use App\ForumTopic;
use App\Http\Requests\SetRatingRequest;
use App\User;
use App\UserReputation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Replay;


class RatingController extends Controller
{
    /**
     * Object name with 'id'
     *
     * @var string
     */
    protected static $object;

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
        return $this->getRatingView(UserReputation::where(self::$object, $id));
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
            ['sender_id' => Auth::id(), 'recipient_id' => $user_id, self::$object => $object_id],
            ['comment' => $comment, 'rating'=>  $rating]
        );

        User::updateRating($rating, $user_id);

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
            $comment = CensorshipWord::check($request->get('comment'));
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
