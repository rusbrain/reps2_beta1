<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendUserMessageRequest;
use App\Services\User\MessageService;
use App\UserMessage;

class BaseUserMessageController extends Controller
{
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
        return back();
    }

    /**
     * Load messages of user
     *
     * @param $dialog_id
     * @return array
     */
    public function load($dialog_id)
    {
        $user = MessageService::getContactUser($dialog_id);
        return MessageService::getMessageData($user->id);
    }
}
