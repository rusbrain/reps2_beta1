<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetReplayUserRatingRequest;
use App\Replay;
use App\ReplayUserRating;
use App\Services\Rating\ReplayUserRatingService;
use App\Services\Replay\ReplayService;
use App\UserReputation;

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
        $replay = ReplayService::getReplay($id);
        return view('replay.evaluation')->with(['replay' => $replay, 'list' => ReplayUserRating::getUserRatingPagination($replay)]);
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
            ReplayUserRatingService::setEvaluation($request, $id);
            return back();
        }
        return abort(404);
    }
}
