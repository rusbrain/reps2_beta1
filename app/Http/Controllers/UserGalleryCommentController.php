<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\UserGalleryStoreCommentRequest;
use App\IgnoreUser;
use App\UserGallery;
use Illuminate\Http\Request;

class UserGalleryCommentController extends CommentController
{
    /**
     * Relation id
     *
     * @var string
     */
    protected $relation = Comment::RELATION_USER_GALLERY;

    /**
     * View name
     *
     * @var string
     */
    protected $view_name = 'gallery.view';

    /**
     * Route name
     *
     * @var string
     */
    protected $route_name = 'gallery.view';

    /**
     * object name with 'id'
     *
     * @var string
     */
    protected $name_id = 'gallery_id';

    /**
     * Model class
     *
     * @var string
     */
    protected $model = UserGallery::class;
    /**
     * Store a newly created resource in storage.
     *
     * @param UserGalleryStoreCommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserGalleryStoreCommentRequest $request)
    {
        $user_gallery = UserGallery::find($request->get($this->name_id));

        if (IgnoreUser::me_ignore($user_gallery->user_id)){
            return abort(403);
        }

        return $this->storeComment($request);
    }
}
