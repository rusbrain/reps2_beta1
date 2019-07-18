<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Services\Base\{BaseDataService, UserViewService};
use Illuminate\Support\Facades\Auth;
use App\PublicChat;


class ChatClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChatMessageClean:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $general_helper;

    public function __construct()
    {
        parent::__construct();	
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */    
    public function handle()
    {       
       /**
        * Remove messages older than a month
        */
        $checkDate = date("Y-m-d H:i:s",strtotime("-1 month"));
        $olderMeassges = PublicChat::where('created_at', '<', $checkDate)->delete();
    }
}
