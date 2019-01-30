<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReplayGosuController extends ReplayController
{
    /**
     *  Replay group name
     *
     * @var string
     */
    protected  $replay_group = 'Госу реплаи';

    /**
     * Replay query function name
     *
     * @var string
     */
    protected  $method_get = "gosuReplay";
}
