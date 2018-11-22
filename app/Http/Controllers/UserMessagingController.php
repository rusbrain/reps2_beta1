<?php

namespace App\Http\Controllers;

use App\Dialogue;
use App\Http\Requests\SendUserMessageRequest;
use App\UserMessage;
use Illuminate\Support\Facades\Auth;

class UserMessagingController extends BaseUserMessageController
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
            return redirect()->route('user.message.get_list');
        }

        return view('admin.user.messages')->with(self::getMessageData($id));
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












    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCorrespList()
    {
        return view('user.message_list')->with('messages_list', Dialogue::getUserDialogues());
    }

    /**
     * Get view with user messages
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMessages($user_id)
    {
        $dialog_id = Dialogue::getDialogUser($user_id)->id;

        return view('user.messages')->with(['messages'=>Dialogue::getUserDialogueContent($user_id), 'dialog_id'=>$dialog_id]);
    }

    /**
     * Get message content
     *
     * @param $message_id
     * @return mixed
     */
    public function getMessage($message_id)
    {
        return UserMessage::find($message_id);
    }

    /**
     * Save updates of message content
     *
     * @param SendUserMessageRequest $request
     * @param $message_id
     * @return mixed
     */
    public function updateMessage(SendUserMessageRequest $request, $message_id)
    {
        $message = UserMessage::find($message_id);

        if ($message->user_sender_id != Auth::id()){
            return abort(403);
        }

        UserMessage::where('id', $message_id)->update(['message' => $request->get('message')]);

        return UserMessage::find($message_id);
    }

    /**
     * Remove user message
     *
     * @param $message_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeMessage($message_id)
    {
        $message = UserMessage::find($message_id);

        if ($message->user_id != Auth::id()){
            return abort(403);
        }

        $user_id = $message->user_recipient_id;

        UserMessage::where('id', $message_id)->delete();

        return redirect()->route('',['id'=>$user_id]);
    }
}
