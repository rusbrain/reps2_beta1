<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Stream;
use App\Http\Requests\{ StreamStoreRequest, StreamUpdateRequest};
use App\Services\Base\{BaseDataService, UserViewService};
use App\Services\Stream\StreamService;
use App\Services\GeneralViewHelper;
use Illuminate\Support\Facades\Auth;



class ServiceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'streamActiveCheck:start';

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
        $this->general_helper = new GeneralViewHelper;	
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */    
    public function handle()
    {       
        $streams = BaseDataService::streams_list();      
        foreach($streams as $stream) {
           
            $live_check = $this->general_helper->liveStreamCheck($this->general_helper->UrlFilter($stream->stream_url));
            $activeStream = Stream::find($stream->id);
            if($live_check) {                
                $activeStream->active = 1;
            } else {
                $activeStream->active = 0;
            }
            $activeStream->save();           
        }
    }
}
