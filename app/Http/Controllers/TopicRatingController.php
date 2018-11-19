<?php

namespace App\Http\Controllers;

use App\ForumTopic;
use App\Http\Requests\SetRatingRequest;
use App\UserReputation;

class TopicRatingController extends RatingController
{
    /**
     * Object relation
     *
     * @var string
     */
    protected $relation = UserReputation::RELATION_FORUM_TOPIC;

    /**
     * Model name
     *
     * @var string
     */
    protected $model = ForumTopic::class;
}
