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
     * Replay type
     *
     * @var string
     */
    public $replay_type = "gosus";

    /**
     * Replay query function name
     *
     * @var string
     */
    public  $method_get = "gosuReplay";
}
