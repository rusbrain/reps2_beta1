<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SendUserMessageRequest;
use App\User;
use App\UserMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserMessageController extends Controller
{
    /**
     * Get message list for user
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUser($id)
    {
        return view('admin.user.messages')->with(self::getMessageData($id));
    }

    /**
     * Seva new message to user
     *
     * @param SendUserMessageRequest $request
     * @param $id
     * @return array
     */
    public function send(SendUserMessageRequest $request, $id)
    {
        UserMessage::createMessage($request, $id);

        return redirect()->route('admin.user.message.load', ['id'=>$id]);
    }

    /**
     * Get data for message view
     *
     * @param $id
     * @return array
     */
    private static function getMessageData($id)
    {
        return ['messages'=> UserMessage::loadMessages($id), 'user' => User::find($id), 'page' => Input::has('page')?Input::get('page')+1:2];
    }

    /**
     * Load messages of user
     *
     * @param $id
     * @return array
     */
    public function load($id)
    {
        return view('admin.user.message_parse')->with(self::getMessageData($id));
    }
}
