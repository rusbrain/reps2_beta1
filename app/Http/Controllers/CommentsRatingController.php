<?php

namespace App\Http\Controllers;

use App\{Comment, UserReputation};

class CommentsRatingController extends RatingController
{
    /**
     * Object relation
     *
     * @var string
     */
    protected $relation = UserReputation::RELATION_COMMENT;

    /**
     * Model name
     *
     * @var string
     */
    protected $model = Comment::class;
}
