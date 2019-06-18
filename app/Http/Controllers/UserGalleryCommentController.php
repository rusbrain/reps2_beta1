<?php

namespace App\Http\Controllers;

use App\{Comment, IgnoreUser, UserGallery};
use App\Http\Requests\UserGalleryStoreCommentRequest;

class UserGalleryCommentController extends CommentController
{
    /**
     * Relation id
     *
     * @var string
     */
    public $relation = Comment::RELATION_USER_GALLERY;

    public $edit_route_name = 'gallery.comment.edit';

    public $update_route_name = 'gallery.comment.update';

    public $relation_name = 'gallery';

    /**
     * View name
     *
     * @var string
     */
    public $view_name = 'gallery.view';

    /**
     * Route name
     *
     * @var string
     */
    public $route_name = 'gallery.view';

    /**
     * object name with 'id'
     *
     * @var string
     */
    public $name_id = 'gallery_id';

    /**
     * Model class
     *
     * @var string
     */
    public $model = UserGallery::class;
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
