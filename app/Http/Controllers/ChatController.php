<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PublicChat;
use Illuminate\Support\Facades\Auth;
use App\User;

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
        if (Auth::id() == $request->user_id) {
            $message_data['user_name'] = Auth::user()->name;
            $insert = PublicChat::create($message_data);           
            if($insert) {               
                return response()->json([
                    'status' => 'ok',
                    'id' => $insert->id, 'user' => Auth::id()
                ], 200);
            }   
        } else {
            return response()->json([
                'status' => 'fail'
            ], 200);
        }
      
            
    }

    public function get_message(Request $request) {
        $id = $request->id;
        $user_id = $request->user_id;
        $message = PublicChat::where('id', $id)->where('user_id', $user_id)->first();
        return response()->json([
            'status' => "ok",
            'message' => $message
        ], 200);
        // $user = User::find($request->user_id);

    }
}
