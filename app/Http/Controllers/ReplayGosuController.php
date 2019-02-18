<?php

namespace App\Http\Controllers;

class ReplayGosuController extends ReplayController
{
    /**
     *  Replay group name
     *
     * @var string
     */
    public  $replay_group = 'Госу реплаи';

    /**
     * Replay query function name
     *
     * @var string
     */
    public  $method_get = "gosuReplay";
}
