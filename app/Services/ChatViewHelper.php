<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.10.18
 * Time: 12:50
 */

namespace App\Services;

use App\Services\Base\BaseDataService;
use App\User;
use Illuminate\Http\Request;
use App\Services\GeneralViewHelper;

class ChatViewHelper
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

    public function __construct()
    {
        $this->host = request()->getSchemeAndHttpHost();
        $this->general_helper = new GeneralViewHelper;
        $this->allChatImages = $this->general_helper->getAllChatImages();
    }
    public function UrlFilter($text)
    {
        if(preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $match)) {
            return $match[0][0];
        }
        return '';
    }

    public function html_encode($str)
    {
        return htmlspecialchars($str);
    }

    public function rewrapperText($text) {
        $text = $this->html_encode($text);
        $text = preg_replace("/:smile([0-9]{1,}):/", '<img src="'.$this->host.'/images/emoticons/smiles/smile$1.gif" border="0">', $text);
        $text = preg_replace("/:s([0-9]{1,}):/", '<img src="'.$this->host.'/images/emoticons/smiles/s$1.gif" border="0">', $text);
        $text = preg_replace_callback("#\[(d)\](.+?)\[/\\1\]#is", function ($matches) {

            $content = trim(isset($matches[2]) ? $matches[2] : $matches[1]);

            $url = '';
            if(preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match)) {
                $url = $match[0][0];
            }

            $image_content = '<a title="'.$url.'" target="_blank" href="'.$url.'" class="id_link"> <img class="smile_inchat" src="'.$url.'" onerror="this.onerror=null;this.src=\'/images/incorrect_img.png\';"></a>';

            $string = substr($content , strlen($url), strlen($content));
            return '<center><div class="demotivator">'.$image_content.'<p>'.trim($string).'</p></div><center>';
        }, $text);
        $text = preg_replace("#\[(b)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);
        $text = preg_replace("#\[(i)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);
        $text = preg_replace("#\[(u)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);

        $text = preg_replace_callback("#\[(c[0-9]{1,})\](.+?)\[/\\1\]#is", function ($matches) {
            return "<span style='color: ".$this->font_colors[$matches[1]]."'>$matches[2]</span>";
        }, $text);@

        $text = preg_replace_callback("#\[(f[0-9]{1,})\](.+?)\[/\\1\]#is", function ($matches) {
            return "<span style='font-size: ".$this->font_sizes[$matches[1]]."'>$matches[2]</span>";
        }, $text);

        $text = preg_replace_callback('/:([a-zA-Z0-9]{1,}):/', function ($matches) {
            return '<img src="'.$this->host.$this->allChatImages[$matches[1]].'" border="0">';
        }, $text);

        $text = preg_replace("/\[img\](\r\n|\r|\n)*((http|https):\/\/([^;<>\*\"]+)|[a-z0-9\/\\\._\- ]+)\[\/img\]/siU",
            "<img src=\"\\2\" class=\"imgl\" border=\"0\" alt=\"\" > ", $text);

        $text = preg_replace_callback("#\[url\](.*?)\[/url\]#is", function ($matches) {
            return $this->general_helper->_regex_build_url_tags($matches);
        }, $text);

        $text = preg_replace_callback('/@([0-9]+),/', function ($matches) {
            $this->selected_user = $matches[1];
            $chatusers = User::find($this->selected_user);
            return '<span class="username '.$this->selected_user.'">@'.$chatusers->name.',</span>';
        }, $text);

        return $text;
    }



    /**
     * file check
     */
    /**public function does_url_exists($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }*/

}
