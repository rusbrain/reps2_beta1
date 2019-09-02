<?php

namespace App\Http\Controllers;

use App\Stream;
use App\Http\Requests\{ StreamStoreRequest, StreamUpdateRequest};
use App\Services\Base\{BaseDataService, UserViewService};
use App\Services\Stream\StreamService;
use App\Services\GeneralViewHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    /**
     * Route name for view edit stream page
     *
     * @var string
     */
    public $edit_route_name;
    public $general_helper;

    public function __construct() {
        $this->general_helper = new GeneralViewHelper;
    }
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
        $streams = Stream::with('user')->where('user_id', Auth::user()->id)->orderBy('updated_at', 'Desc')->paginate(20);
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
    public function store(StreamStoreRequest $request)
    {
        StreamService::store($request);
        return redirect()->route('stream.my_stream');
    }

     /**
     * @param $stream_id
     * @return mixed
     */
    private function getStreamObject($stream_id)
    {
        return Stream::where('id', $stream_id)->where('user_id', Auth::user()->id)->with('user.avatar')->first();
    }

    /**
     * @param Request $request->id // selected stream Id
     * @return mixed
     */
    public function getStreamById(Request $request)
    {
       return ['stream' =>(string)view('stream-section.stream')->with(['stream'=> Stream::where('id', $request->id)->with('country')->first()])];
    }

    /**
     * @return mixed
     */
    public function getLiveStreamsList()
    {
        return [
            'streams_list' =>(string)view('stream-section.stream-list')
                        ->with(
                            [
                                'streams_list'=> $this->getLists(),
                                'countries'=>$this->general_helper->getCountries(),
                            ])

        ];
    }

    private function getLists()
    {
        return BaseDataService::streams_list();
    }

    /**
     * @param $stream_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($stream_id)
    {
        return view('stream.edit')->with(['stream'=> $this->getStreamObject($stream_id)]);
    }

    /**
     * @param StreamUpdateRequest $request
     * @param $stream_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(StreamUpdateRequest $request, $stream_id)
    {

        $stream = Stream::where('id', $stream_id)->where('user_id', Auth::user()->id)->first();

        if($stream){
            StreamService::updateStream($request, $stream);
            return redirect()->route('stream.my_stream');
        }
        return abort(404);
    }

}
