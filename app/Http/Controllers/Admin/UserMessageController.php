<?php

namespace App\Http\Controllers\Admin;

use App\Dialogue;
use App\Http\Requests\SendUserMessageRequest;
use App\User;
use App\UserMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserMessageController extends Controller
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
        UserMessage::createMessage($request, $dialog_id);

        return redirect()->route('admin.user.message_load', ['id'=>$dialog_id]);
    }

    /**
     * Get data for message view
     *
     * @param $id
     * @return array
     */
    private static function getMessageData($id)
    {
        $contacts = Dialogue::getUserDialogues();

        if(!$id){
            foreach ($contacts->first()->senders as $sender){
                if ($sender->id != Auth::id()){
                    $id = $sender->id;
                }
            }
        }

        $dialog_id = Dialogue::getDialogUser($id)->id;

        return ['dialog_id' => $dialog_id,'messages'=> Dialogue::getUserDialogueContent($dialog_id), 'contacts' => $contacts, 'user' => User::find($id), 'page' => Input::has('page')?Input::get('page')+1:2];
    }

    /**
     * Load messages of user
     *
     * @param $dialog_id
     * @return array
     */
    public function load($dialog_id)
    {
        $user = Dialogue::find($dialog_id)->users()->where('id','<>', Auth::id())->first();

        return view('admin.user.message_parse')->with(self::getMessageData($user->id));
    }


}
