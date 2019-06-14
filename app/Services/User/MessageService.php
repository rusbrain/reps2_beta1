<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 13:42
 */

namespace App\Services\User;

use App\{Dialogue, User};
use Illuminate\Support\Facades\{Auth, Input};

class MessageService
{
    /**
     * Get data for message view
     *
     * @param $id
     * @return array
     */
    public static function getMessageData($id)
    {
        $contacts = UserDialogService::getUserDialogues();  
        $data =    self::formMessageData($id, $contacts);
       
        return $data;
       
    }

    /**
     * @param $id
     * @param $contacts
     * @return array
     */
    protected static function formMessageData($id, $contacts)
    {       

        if(!$id){
            foreach ($contacts->first()->senders as $sender){
                if ($sender->id != Auth::id()){
                    $id = $sender->id;
                }
            }
        }

        $dialog_id = UserDialogService::getDialogUser($id)->id;

        return [
            'dialog_id' => $dialog_id,
            'messages' => Dialogue::getUserDialogueContent($dialog_id),
            'contacts' => $contacts,
            'user' => User::find($id),
            'page' => Input::has('page') ? Input::get('page') + 1 : 2
        ];
    }

    /**
     * @param $dialog_id
     * @return mixed
     */
    public static function getContactUser($dialog_id)
    {
       return Dialogue::find($dialog_id)->users()->where('id','<>', Auth::id())->first();
    }
}