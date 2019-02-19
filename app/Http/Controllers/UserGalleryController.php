<?php

namespace App\Http\Controllers;

use App\Http\Requests\{UserGalleryStoreRequest, UserGalleryUpdateRequest};
use App\{IgnoreUser, UserGallery};
use App\Services\User\UserGalleryService;
use Illuminate\Support\Facades\Auth;

class UserGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gallery.list')->with('photos', UserGalleryService::getList(new UserGallery()));
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexUser($id = 0)
    {
        if ($id == 0){
            $id = Auth::id();
        }

        if (IgnoreUser::me_ignore($id)){
            return abort(403);
        }

        return view('gallery.list')->with('photos', UserGalleryService::getList(UserGallery::where('user_id',$id)));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserGalleryStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserGalleryStoreRequest $request)
    {
        return redirect()->route('gallery.view', ['id' => UserGalleryService::store($request)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photo = UserGallery::find($id);

        if (IgnoreUser::me_ignore($photo->user_id)){
            return abort(403);
        }
        if (!$photo)
        {
            return abort(404);
        }

        return view('gallery.photo')->with('photo', UserGalleryService::getPhotoData($photo));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $photo = UserGallery::where('id', $id)->with('file')->first();

        if ($photo->user_id != Auth::id()){
            return abort(403);
        }

        return view('gallery.edit')->with('photo', $photo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserGalleryUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserGalleryUpdateRequest $request, $id)
    {
        $gallery = UserGallery::find($id);

        if($gallery){
            UserGalleryService::update($request, $gallery);
            return redirect()->route('gallery.view', ['id' => $id]);
        }

        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = UserGallery::find($id);

        if (!$gallery){
            return abort(404);
        }
        if ($gallery->user_id != Auth::id()){
            return abort(403);
        }

        UserGalleryService::destroy($gallery);
        return redirect()->route('gallery.list_my');
    }
}