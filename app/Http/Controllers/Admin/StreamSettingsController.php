<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StreamSetting;
use App\Http\Requests\StreamSettingRequest;

class StreamSettingsController extends Controller
{
     /**
     * 
     */
    public function index() {
        return view('admin.stream.settings.index')->with('settings', StreamSetting::first());
    }

    /** Save the display setting  */
    public function save(StreamSettingRequest $request) {

        $settings = $request->validated();
        if (!$request->has('headline')) {
            $settings['headline'] = "0";
        } 

        if (!$request->has('main_section')) {
            $settings['main_section'] = "0";
        } 

        $streamsetting = StreamSetting::first();

        if (isset($streamsetting) && !empty($streamsetting)) {
            StreamSetting::where('id', $streamsetting->id)->update($settings);
        } else {
            StreamSetting::create($settings);            
        }
        return back();
    }
}
