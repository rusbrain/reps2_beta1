<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 10:38
 */

namespace App\Services\Rating;


use App\Http\Requests\SetReplayUserRatingRequest;
use App\Replay;
use App\ReplayUserRating;
use Illuminate\Support\Facades\Auth;

class ReplayUserRatingService
{
    /**
     * @param SetReplayUserRatingRequest $request
     * @param $id
     */
    public static function setEvaluation(SetReplayUserRatingRequest $request, $id)
    {
        $comment = RatingService::getComment($request);

        ReplayUserRating::updateOrCreate(
            ['user_id' => Auth::id(), 'replay_id' => $id],
            ['comment' => $comment, 'rating'=> $request->get('rating')]
        );

        Replay::updateUserRating($id);
    }
}