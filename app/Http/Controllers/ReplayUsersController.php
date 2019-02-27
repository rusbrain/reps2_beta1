<?php

namespace App\Http\Controllers;

class ReplayUsersController extends ReplayController
{
    /**
     *  Replay group name
     *
     * @var string
     */
    public  $replay_group = 'Пользовательские реплаи';

    /**
     * Replay type
     *
     * @var string
    */
    public $replay_type = "users";

    /**
     * Replay query function name
     *
     * @var string
     */
    public  $method_get = "userReplay";

}
