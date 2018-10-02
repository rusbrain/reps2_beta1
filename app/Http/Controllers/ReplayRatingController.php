<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetRatingRequest;
use App\Replay;
use App\UserReputation;

class ReplayRatingController extends RatingController
{
    /**
     * Object name
     *
     * @var string
     */
    protected static $object = 'replay_id';

    /**
     * Model name
     *
     * @var string
     */
    protected static $model = 'Replay';


}
