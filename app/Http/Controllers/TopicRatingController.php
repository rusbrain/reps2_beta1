<?php

namespace App\Http\Controllers;

use App\ForumTopic;
use App\Http\Requests\SetRatingRequest;
use App\UserReputation;

class TopicRatingController extends RatingController
{
    /**
     * Object name
     *
     * @var string
     */
    protected static $object = 'topic_id';

    /**
     * Model name
     *
     * @var string
     */
    protected static $model = ForumTopic::class;
}
