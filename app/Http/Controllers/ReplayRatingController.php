<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetRatingRequest;
use App\Http\Requests\SetReplayUserRatingRequest;
use App\Replay;
use App\ReplayUserRating;
use App\User;
use App\UserReputation;
use Illuminate\Support\Facades\Auth;

class ReplayRatingController extends RatingController
{
    /**
     * Object relation
     *
     * @var string
     */
    protected $relation = UserReputation::RELATION_REPLAY;

    /**
     * Model name
     *
     * @var string
     */
    protected $model = Replay::class;

    /**
     * Get list of replay evaluation
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEvaluation($id)
    {
        $replay = Replay::where('id', $id)
            ->with(User::getUserWithReputationQuery())
            ->withCount('comments', 'positive','negative')
            ->with(['user'=> function($q){
                $q->withTrashed();
            }])
            ->with('type','user', 'map','first_country','second_country')
            ->first();


        return view('replay.evaluation')->with(['replay' => $replay, 'list' => $replay->user_rating()->with(['user'=> function($q){
            $q->withTrashed();
        }])->paginate(20)]);
    }

    /**
     * Save Replay Evaluation
     *
     * @param SetReplayUserRatingRequest $request
     * @param $id
     * @return array
     */
    public function setEvaluation(SetReplayUserRatingRequest $request, $id)
    {
        if (Replay::find($id)){
            $comment = self::getComment($request);

            ReplayUserRating::updateOrCreate(
<<<<<<< HEAD
                ['user_id' => Auth::id(), 'object_id' => $id, 'relation' => $this->relation],
=======
                ['user_id' => Auth::id(), 'replay_id' => $id],
>>>>>>> feature/front_home_page3
                ['comment' => $comment, 'rating'=> $request->get('rating')]
            );

            Replay::updateUserRating($id);

            return back();
        }

        return abort(404);
    }
}
