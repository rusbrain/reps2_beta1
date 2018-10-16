<?php

namespace App\Http\Controllers;

use App\Dialogue;
use App\Http\Requests\SendUserMessageRequest;
use App\IgnoreUser;
use App\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMessagingController extends Controller
{
    public function sendMessage(SendUserMessageRequest $request, $user_id){

        if (IgnoreUser::me_ignore($user_id)){
            return abort(403);
        }

        $dialogue = Dialogue::getDialogUser($user_id);

        $message = UserMessage::createMessage($request, $dialogue->id);

        return $message->load('recipient', 'sender');
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
