<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Show notification page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($notification)
    {
        return view('notification')->with('notification', $notification);
    }
}
