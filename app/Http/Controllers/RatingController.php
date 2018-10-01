<?php

namespace App\Http\Controllers;

use App\ForumTopic;
use App\ForumTopicComment;
use App\Http\Requests\SetRatingRequest;
use App\User;
use App\UserReputation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Set rating to topic
     *
     * @param SetRatingRequest $request
     * @param $topic_id
     * @return array
     */
    public function setRating(SetRatingRequest $request, $topic_id)
    {
        $topic = ForumTopic::find($topic_id);

        $comment = null;

        if($request->hes('comment')){
            $comment = $request->get('comment');
        }

        if($topic){
            UserReputation::updateOrCreate(
                ['sender_id' => Auth::id(), 'recipient_id' => $topic->user_id, 'topic_id' => $topic->id],
                ['comment' => $comment, 'rating'=> $request->get('rating')]
            );

            User::updateRating($request->get('rating'), $topic->user_id);
            ForumTopic::updateRating($request->get('rating'), $topic->id);

            return ['topic_id' => $topic->id, 'rating' => ($topic->positive()->count()-$topic->negative()->count())];
        }

        return abort(404);
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
     * Get reputation of Topic
     *
     * @param $id
     * @return mixed
     */
    public function getRatingTopic($id)
    {
        return UserReputation::where('topic_id', $id)->with('sender')->paginate(10);

    }
}
