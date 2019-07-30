<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PublicChat;
use Illuminate\Support\Facades\Auth;
use App\{User, Country, Replay};
use App\Services\GeneralViewHelper;
use App\ChatSmile;
use App\ChatPicture;


class ChatController extends Controller
{
    private $font_colors = array(
         'c1' => '#FFFF77',
         'c2' => '#FF77FF',
         'c3' => '#77FFFF',
         'c4' => '#FFAAAA',
         'c5' => '#AAFFAA',
         'c6' => '#AAAAFF'
    );
    private $font_sizes = array(
        'f1' => '14px',
        'f2' => '16px',
        'f3' => '18px',
    );

    private $allChatImages = array();
   
    public function __construct(){
        $this->general_helper = new GeneralViewHelper;
        $this->allChatImages = $this->general_helper->getAllChatImages();
    }

    /**
     * Get 100 messages
     */
    public function get_messages() {
        $messages = PublicChat::select('user_id', 'user_name', 'message', 'file_path', 'imo', 'created_at')->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(100)
                ->get();
        $result = array();
        foreach ($messages as $msg) {
            $result[] = $this->setFullMessage($msg);
        }

        return $result;
    }

    /**
     * Insert new messages from chat
     */
    public function insert_message(Request $request) {
       
        $message_data = $request->all();
        if (Auth::id() == $request->user_id) {
            $message_data['user_name'] = Auth::user()->name;
            $message_data['message'] = $this->rewrapperText($message_data['message']);
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

    private function rewrapperText($text) {
        $text = preg_replace("/:smile([0-9]{1,}):/", '<img src="/images/emoticons/smiles/smile$1.gif" border="0">', $text);
        $text = preg_replace("/:s([0-9]{1,}):/", '<img src="/images/emoticons/smiles/s$1.gif" border="0">', $text);

        $text = preg_replace("#\[(b)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);
        $text = preg_replace("#\[(i)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);
        $text = preg_replace("#\[(u)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);

        $text = preg_replace_callback("#\[(c[0-9]{1,})\](.+?)\[/\\1\]#is", function ($matches) {          
            return "<span style='color: ".$this->font_colors[$matches[1]]."'>$matches[2]</span>";
        }, $text);

        $text = preg_replace_callback("#\[(f[0-9]{1,})\](.+?)\[/\\1\]#is", function ($matches) {          
            return "<span style='font-size: ".$this->font_sizes[$matches[1]]."'>$matches[2]</span>";
        }, $text);
      
        
        $text = preg_replace_callback("#(:{1,})(.+?)\\1#is", function ($matches) {          
            return '<img src="'.$this->allChatImages[$matches[2]].'" border="0">';
        }, $text);

        $text = preg_replace("/\[img\](\r\n|\r|\n)*((http|https):\/\/([^;<>\*\"]+)|[a-z0-9\/\\\._\- ]+)\[\/img\]/siU",
            "<img src=\"\\2\" class=\"imgl\" border=\"0\" alt=\"\"> ", $text);

        $text = preg_replace_callback("#\[url\](.*?)\[/url\]#is", function ($matches) {
            return $this->general_helper->_regex_build_url_tags($matches);
        }, $text);


        $text = preg_replace_callback("#\[(d)\](.+?)\[/\\1\]#is", function ($matches) { 
            $url = isset($matches[2]) ? $matches[2] : $matches[1];         
            return '<center><a title="'.$url.'" target="_blank" href="'.$url.'" class="id_link">
                    <img class="smile_inchat" src="'.$url.'"></a><center>';
        }, $text);    
        
        $text =  preg_replace('/@([[:alnum:]\-_) ]+),/', '<span class="username">@$1,</span>', $text);
        
        return $text;
    }

    /**
     * Get just updated message
     */
    public function get_message(Request $request) {
        $id = $request->id;
        $user_id = $request->user_id;
        $message = PublicChat::where('id', $id)->where('user_id', $user_id)->with('user')->first();
        return response()->json([
            'status' => "ok",
            'message' => $this->setFullMessage($message)
        ], 200);      
    }

    public function setFullMessage($msg) {
        $countries =$this->general_helper->getCountries();
        $country_code = ($msg->user->country_id) ? mb_strtolower($countries[$msg->user->country_id]->code) : '';
        $race = ($msg->user->race) ? Replay::$race_icons[$msg->user->race] : Replay::$race_icons['All'];
        return  array(
            'user_id'=>$msg->user_id, 
            'user_name'=>$msg->user_name, 
            'message'=>$msg->message, 
            'file_path'=>$msg->file_path, 
            'imo'=>$msg->imo, 
            'created_at'=>$msg->created_at,
            'country_code'=>$country_code,
            'race'=>$race
        );
        return $msg;
    }

    /**
     * Get Chat Smiles
     */
    public function get_externalsmiles() {
        $smiles = array();
        $extraSmiles = ChatSmile::with('file')->orderBy('updated_at', 'Desc')->get();
        foreach ($extraSmiles as $smile ) {
            $smiles[] = array(
                'charactor' => $smile->charactor,
                'filename' => pathinfo($smile->file->link)["basename"]
            );
        }
      
        return response()->json([
            'status' => "ok",
            'smiles' =>  $smiles
        ], 200); 
        
    }

    /**
     * Get Chat Images
     */
    public function get_externalimages() {
        $images = array();
        $extraImages = ChatPicture::with('file')->orderBy('updated_at', 'Desc')->get();
        foreach ($extraImages as $image ) { 
            if(!isset($images[$image->category])) {
                $images[$image->category] = array();   
            }       
            array_push($images[$image->category], array(
                'charactor' => $image->charactor,
                'filepath' => $image->file->link
            ));  
        }
      
        return response()->json([
            'status' => "ok",
            'images' =>  $images
        ], 200); 
        
    }

    /**
     * Ge Chat users
     */
    public function get_chatusers() {
        $users = array();
        $chatusers = User::orderBy('name', 'ASC')->get();
        foreach ($chatusers as $user) {
            $users[] = $user->name;
        }

        return response()->json([
            'status' => "ok",
            'users' =>  $users
        ], 200); 
    }

}
