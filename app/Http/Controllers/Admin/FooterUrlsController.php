<?php

namespace App\Http\Controllers\Admin;

use App\Footerurl;
use App\Http\Requests\AdminFooterUrlStoreRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FooterUrlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.footer.customurl.list')->with('footer_urls', Footerurl::all());
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.footer.customurl.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminFooterUrlStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminFooterUrlStoreRequest $request)
    {
        $data = $request->validated();
        $footer_url = Footerurl::create($data);
        return redirect()->route('admin.footer.customurl');
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.footer.customurl.edit')->with('footer_url', Footerurl::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminFooterUrlStoreRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminFooterUrlStoreRequest $request, $id)
    {
        $footerurl = Footerurl::find($id);
        if($footerurl){
            $data = $request->validated();
            if($footerurl->update($data)){
                return redirect()->route('admin.footer.customurl');
            }
        }
        return back();
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $footerurl = Footerurl::find($id);
        $footerurl->delete();
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approved($id)
    {
        Footerurl::where('id', $id)->update(['approved' => 1]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notApproved($id)
    {
        Footerurl::where('id', $id)->update(['approved' => 0]);
        return back();
    }
    
}
