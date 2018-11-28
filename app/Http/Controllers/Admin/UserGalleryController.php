<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\File;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Requests\UserGalleryStoreRequest;
use App\User;
use App\UserGallery;
use App\UserMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserGalleryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = UserGallery::with('user', 'file')->withCount( 'positive', 'negative', 'comments')->orderBy('id', 'desc')->paginate(50);
        return view('admin.user.gallery.list')->with(['data' => $data, 'request_data' =>[]]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        $data = UserGallery::where('id', $id)
            ->with('user.avatar', 'file')
            ->withCount( 'positive', 'negative', 'comments')
            ->with(['comments' =>function($q){
            $q->with('user')->paginate(20);
        }])->first();

        return view('admin.user.gallery.view')->with('gallery', $data);
    }

    /**
     * @param CommentUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendComment(CommentUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['relation'] = Comment::RELATION_USER_GALLERY;
        $data['object_id'] = $id;

        Comment::create($data);

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notForAdults($id)
    {
        UserGallery::where('id', $id)->update(['for_adults' => 0]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forAdults($id)
    {
        UserGallery::where('id', $id)->update(['for_adults' => 1]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        $gallery = UserGallery::find($id);
        $user_id = $gallery->user_id;

        File::removeFile($gallery->file_id);
        $gallery->positive()->delete();
        $gallery->negative()->delete();
        $gallery->comments()->delete();

        UserGallery::where('id', $id)->delete();
        User::recountRating($user_id);

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.user.gallery.edit')->with('gallery', UserGallery::find($id));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if($request->has('comment')){
            UserGallery::where('id', $id)->update(['comment' => $request->get('comment')]);

            return back();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.user.gallery.add');
    }

    /**
     * @param UserGalleryStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(UserGalleryStoreRequest $request)
    {
        $data = $request->validated();

        $data = UserGallery::saveImage($data);
        $data['user_id'] = Auth::id();

        $gallery = UserGallery::create($data);

        return redirect()->route('admin.users.gallery.view', ['id' => $gallery->id]);
    }
}
