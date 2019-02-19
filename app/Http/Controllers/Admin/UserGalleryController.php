<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Requests\UserGalleryStoreRequest;
use App\Services\Base\BaseDataService;
use App\Services\Base\AdminViewService;
use App\Services\Comment\CommentService;
use App\Services\User\UserGalleryService;
use App\UserGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserGalleryController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(Request $request)
    {
        if ($request->has('user_id')){
            $data = UserGallery::where('user_id', $request->get('user_id'))->count();
        } else{
            $data = UserGallery::count();
        }

        return view('admin.user.gallery.list')->with(['gallery_count' => $data, 'request_data' => $request->all()]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function pagination(Request $request)
    {
        $galleries = UserGalleryService::getGalleries($request);
        return BaseDataService::getPaginationData(AdminViewService::getGallery($galleries), AdminViewService::getPagination($galleries), AdminViewService::getGalleryPopUp($galleries));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        return view('admin.user.gallery.view')->with('gallery', UserGallery::getGalleryById($id));
    }

    /**
     * @param CommentUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendComment(CommentUpdateRequest $request, $id)
    {
        CommentService::create($request->validated(),Comment::RELATION_USER_GALLERY,$id);
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
     * @throws \Exception
     */
    public function remove($id)
    {
        UserGalleryService::destroy(UserGallery::find($id));
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
        }
        return back();
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
        return redirect()->route('admin.users.gallery.view', ['id' => UserGalleryService::store($request)]);
    }
}
