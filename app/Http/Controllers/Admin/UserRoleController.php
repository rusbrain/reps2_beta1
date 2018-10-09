<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRoleController extends Controller
{
    public function index()
    {
        return view('admin.user.user_list');
    }
}
