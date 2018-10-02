<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReplayUsersController extends ReplayController
{
    /**
     *  Replay group name
     *
     * @var string
     */
    protected $replay_group = 'Users Replay';

    /**
     * Replay query function name
     *
     * @var string
     */
    protected $method_get = 'userReplay';
}
