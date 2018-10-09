<?php

namespace App\Http\Controllers;

use App\UserGallery;
use App\UserReputation;

class UserGalleryRatingController extends RatingController
{
    /**
     * Object relation
     *
     * @var string
     */
    protected static $relation = UserReputation::RELATION_USER_GALLERY;

    /**
     * Model name
     *
     * @var string
     */
    protected static $model = UserGallery::class;
}
