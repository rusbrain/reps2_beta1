<?php

namespace App\Http\Controllers;

use App\Stream;
use App\Http\Requests\{ StreamStoreRequest, StreamUpdateRequest};
use App\Services\Base\{BaseDataService, UserViewService};
use App\Services\Stream\StreamService;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    /**
     * Route name for view edit stream page
     *
     * @var string
     */
    public $edit_route_name;
    /**
     * Get my streams
     */
    public function index()
    {
        return view('stream.index')->with('request', '');
    }

    /**
     * Get Paination data
     */
    public function pagination()
    { 
        $streams = Stream::with('user')->paginate(20);
        return [
            'streams'   => UserViewService::getStreams($streams),
            'pagination' => UserViewService::getPagination($streams)
        ];
    }

    /**
     * Create Stream
     */
    public function create()
    {
        return view('stream.create');
    }

    /**
     * Strore Stream
     * @param Request $request
     * @return
     */
    public function store(Request $request)
    {

    }

    /**
     * View stream
     */
    public function view($stream_id)
    {

    }
}
