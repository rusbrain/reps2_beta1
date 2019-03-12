<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Show error page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($error)
    {
        return view('error')->with('error', $error);
    }
}
