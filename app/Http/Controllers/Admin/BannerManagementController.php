<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Requests\AdminBannerStoreRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminBannerUpdateRequest;

class BannerManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::with('file')->orderBy('id', 'desc')->get();
        return view('admin.banner.list')->with('banners', $banners);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminBannerStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminBannerStoreRequest $request)
    {
        $data = $request->validated();
        $title = 'Banner ' . $request->has('title') ? $request->get('title') : '';
        $data = Banner::saveImage($data, $title);
        if($data){
            $banner = Banner::create($data);
            return redirect()->route('admin.banner.view', ['id' => $banner->id]);
        }
        return redirect()->route('error',['error' => 'Ошибка сохранения']);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = Banner::where('id', $id)->with('file')->first();
        return view('admin.banner.view')->with('banner', $banner);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::where('id', $id)->with('file')->first();
        return view('admin.banner.edit')->with('banner', $banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminBannerUpdateRequest $request, $id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            Banner::updateBanner($request, $banner);
            return redirect()->route('admin.banner.view', ['id' => $banner->id]);
        }
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        //
    }


}
