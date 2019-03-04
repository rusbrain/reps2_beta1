<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseUserMessageController;
use App\Http\Requests\SendUserMessageRequest;
use App\Services\User\MessageService;
use Illuminate\Support\Facades\Auth;

class UserMessageController extends BaseUserMessageController
{
    /**
     * Get message list for user
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUser($id = false)
    {
        if($id == Auth::id()){
            return redirect()->route('admin.user.messages_all');
        }

        return view('admin.user.messages')->with(MessageService::getMessageData($id));
    }

    /**
     * Seva new message to user
     *
     * @param SendUserMessageRequest $request
     * @param $dialog_id
     * @return array
     */
    public function send(SendUserMessageRequest $request, $dialog_id)
    {
        parent::send($request, $dialog_id);

        return redirect()->route('admin.user.message_load', ['id'=>$dialog_id]);
    }

    /**
     * Load messages of user
     *
     * @param $dialog_id
     * @return array
     */
    public function load($dialog_id)
    {
        return view('admin.user.message_parse')->with(parent::load($dialog_id));
    }


}
