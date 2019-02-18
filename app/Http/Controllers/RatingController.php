<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetRatingRequest;
use App\Services\Rating\RatingService;
use App\UserReputation;

class RatingController extends Controller
{
    /**
     * Object relation
     *
     * @var string
     */
    protected $relation;

    /**
     * Model name
     *
     * @var string
     */
    protected $model;

    /**
     * Get rating
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRating($id)
    {
        return RatingService::getRatingView(UserReputation::where('object_id', $id)->where('relation', $this->relation), $id);
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
        return RatingService::set($request, $id, $this->relation, $this->model);
    }
    /**
     * Get reputation of User
     *
     * @param $id
     * @return mixed
     */
    public function getRatingUser($id)
    {
        return RatingService::getRatingView(UserReputation::where('recipient_id', $id), $id);
    }
}