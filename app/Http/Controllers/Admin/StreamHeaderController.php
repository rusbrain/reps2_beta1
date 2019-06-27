<?php

namespace App\Http\Controllers\Admin;

use App\StreamHeader;
use App\Http\Requests\AdminStreamHeaderRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StreamHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.stream.header.list')->with('data', StreamHeader::all());
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.stream.header.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminStreamHeaderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminStreamHeaderRequest $request)
    {
        $data = $request->validated();
        $streamheader = StreamHeader::create($data);
        return redirect()->route('admin.stream.header');
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.stream.header.edit')->with('data', StreamHeader::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminStreamHeaderRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminStreamHeaderRequest $request, $id)
    {
        $streamheader = StreamHeader::find($id);
        if($streamheader){
            $data = $request->validated();
            if($streamheader->update($data)){
                return redirect()->route('admin.stream.header');
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
        $streamheader = StreamHeader::find($id);
        $streamheader->delete();
        return back();
    }


}
