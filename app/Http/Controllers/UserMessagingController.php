<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendUserMessageRequest;
use App\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMessagingController extends Controller
{
    public function sendMessage(SendUserMessageRequest $request, $user_id){
        $message = UserMessage::create([
            'user_sender_id'    => Auth::id(),
            'user_recipient_id' => $user_id,
            'message'           => $request->get('message'),
        ]);

        return $message->load('recipient', 'sender');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCorrespList()
    {
        $send_message = UserMessage::where('user_sender_id', Auth::id())->orderBy('created_at')->with('recipient')->get()->groupBy(function ($item) {
            return 'user_'.$item['user_recipient_id'];
        });
        $recipient_message = UserMessage::where('user_recipient_id', Auth::id())->orderBy('created_at')->with('sender')->get()->groupBy(function ($item) {
            return 'user_'.$item['user_sender_id'];
        });

        $recipient_message->transform(function ($item){
            return $item->last();
        });
        $send_message->transform(function ($item){
            return $item->last();
        });

        foreach ($send_message as $key=>$item){
            if (isset($recipient_message[$key])){
                if ($item->created_at > $recipient_message[$key]->created_at){
                    unset($recipient_message[$key]);
                } else{
                    unset($send_message[$key]);
                }
            }
        }

        $message_list = array_merge($send_message->toArray(), $recipient_message->toArray());

        return view('user.message_list')->with('messages_list', $message_list);
    }

    /**
     * Get view with user messages
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMessages($user_id)
    {
        return view('user.messages')->with('messages', $this->loadMessages($user_id));
    }

    /**
     * Loaded user messages with pagination/Get user messages
     *
     * @param $user_id
     * @return mixed
     */
    public function loadMessages($user_id)
    {
        $messages = UserMessage::where(function ($query) use ($user_id){
            $query->where('user_sender_id', Auth::id())->where('user_recipient_id', $user_id);
        })
            ->orWhere(function ($query) use ($user_id){
                $query->where('user_sender_id', $user_id)->where('user_recipient_id', Auth::id());
            })
            ->with('sender.avatar', 'recipient.avatar')->paginate(20);

        return $messages;
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

        if ($message->user_sender_id != Auth::id()){
            return abort(403);
        }

        $user_id = $message->user_recipient_id;

        UserMessage::where('id', $message_id)->delete();

        return redirect()->route('',['id'=>$user_id]);
    }
}
