<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Base\{BaseDataService, AdminViewService};
use App\Http\Controllers\Controller;
use App\PublicChat;

class ChatController extends Controller
{
    /**
     * get chat messages
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    // public $limit = 10000;

    public function index() 
    {      
        return view('admin.chat.list');
    }

    /**
     * Get message list paginate
     *
     * @return array
     */
    public function pagination()
    {
        $messages = PublicChat::with('user')->orderBy('created_at', 'Desc')->paginate(50);
        return BaseDataService::getPaginationData(
            AdminViewService::getChatMessages($messages), 
            AdminViewService::getPagination($messages)
        );    
    }

    /**
     * @param $stream_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        $message = PublicChat::find($id);
        $message->delete();
        return back();
    }
    
}
