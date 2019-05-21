<?php

namespace App\Http\Controllers\Admin;

use App\Footer;
use App\Http\Requests\AdminFooterStoreRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FooterManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.footer.list')->with('footer_widgets', Footer::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.footer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminFooterStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminFooterStoreRequest $request)
    {
        $data = $request->validated();
        $footer_widget = Footer::create($data);
        return redirect()->route('admin.footer.view', ['id' => $footer_widget->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Footer  $footer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.footer.view')->with('footer_widget', Footer::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.footer.edit')->with('footer_widget', Footer::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminFooterStoreRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function update(AdminFooterStoreRequest $request, $id)
    {
        $footer = Footer::find($id);
        if($footer){
            $data = $request->validated();
            if($footer->update($data)){
                return back();
            }
        }
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
        $footer = Footer::find($id);
        $footer->delete();
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approved($id)
    {
        Footer::where('id', $id)->update(['approved' => 1]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notApproved($id)
    {
        Footer::where('id', $id)->update(['approved' => 0]);
        return back();
    }
}
