<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PublicChat;

class ChatController extends Controller
{
    //
    public function get_messages() {
       return PublicChat::select('user_id', 'user_name', 'message', 'file_path', 'imo', 'created_at')
                        ->orderBy('created_at', 'desc')
                        ->limit(100)
                        ->get();
    }

    public function insert_message(Request $request) {
       
        $message_data = $request->all();
        if(isset($request->created_at)) {
            unset($message_data['created_at']);
        }
        $insert = PublicChat::create($message_data);
        if($insert) {
             return response()->json([
                'status' => 'ok',
            ], 200);
        }       
    }
}
