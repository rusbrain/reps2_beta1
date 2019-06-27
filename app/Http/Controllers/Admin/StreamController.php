<?php

namespace App\Http\Controllers\Admin;


use App\Stream;
use App\Http\Requests\{ StreamStoreRequest, StreamUpdateRequest};
use App\Services\Base\{BaseDataService, AdminViewService};
use App\Services\Stream\StreamService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class StreamController extends Controller
{
   
     /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.stream.list')->with(['stream_count'=> Stream::count(), 'request_data' => []]);
    }

    /**
     * Get stream list paginate
     *
     * @return array
     */
    public function pagination()
    {
        $streams = Stream::withCount('user')->paginate(50);
        return BaseDataService::getPaginationData(
            AdminViewService::getStreams($streams), 
            AdminViewService::getPagination($streams)
        );
    
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.stream.create');
    }

    /**
     * @param StreamStoreRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StreamStoreRequest $request)
    {
        return redirect()->route('admin.stream.view', ['id' => StreamService::store($request)]);
    }

    public function getStream($stream_id) 
    {
        return view('admin.stream.view')->with('stream', $this->getStreamObject($stream_id));
    }

     /**
     * @param $stream_id
     * @return mixed
     */
    private function getStreamObject($stream_id)
    {
        return Stream::getstreamById($stream_id);
    }


    
    /**
     * @param $stream_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($stream_id)
    {
        return view('admin.stream.edit')->with(['stream'=> $this->getStreamObject($stream_id)]);
    }

    /**
     * @param StreamUpdateRequest $request
     * @param $replay_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(StreamUpdateRequest $request, $stream_id)
    {
        $stream = Stream::find($stream_id);

        if($stream){
            StreamService::updateStream($request, $stream);
            return back();
        }
        return abort(404);
    }


     /**
     * @param $stream_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($stream_id)
    {
        Stream::where('id', $stream_id)->update(['approved' => 1]);
        return back();
    }

    /**
     * @param $stream_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notApprove($stream_id)
    {
        Stream::where('id', $stream_id)->update(['approved' => 0]);
        return back();
    }

    /**
     * @param $stream_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($stream_id)
    {
        $stream = Stream::find($stream_id);
        $stream->delete();
        return back();
    }
}
