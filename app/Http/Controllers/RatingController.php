<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetRatingRequest;
use App\Services\Rating\RatingService;
use App\UserReputation;
use Illuminate\Http\Request;


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
        return RatingService::getRatingView(UserReputation::where('recipient_id', $id), $id);
    }
}