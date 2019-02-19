<?php

namespace App\Http\Controllers;

use App\{ForumTopic, UserReputation};

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
