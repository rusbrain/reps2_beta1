<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplayController extends Controller
{
    public function indexUsers()
    {
        return view('admin.user.user_list');
    }

    public function indexGosu()
    {
        return view('admin.user.user_list');
    }
}
