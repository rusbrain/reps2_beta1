<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.10.18
 * Time: 12:50
 */

namespace App\Services;

use App\Comment;
use App\Country;
use App\Footer;
use App\Footerurl;
use App\ForumTopic;
use App\Services\Base\{BaseDataService, InterviewQuestionsService, UserbarService};
use App\Services\Comment\CommentService;
use App\Services\Forum\TopicService;
use App\Traits\ViewHelper\{
    ForumData, ReplayData, UserData, TournamentData
};
use App\User;
use App\UserGallery;
use Illuminate\Http\Request;

use BBCode;


class GeneralViewHelper
{
    use UserData, ReplayData, ForumData, TournamentData;

    protected $last_forum;
    protected $last_forum_home;
    protected $last_gosu_replay;
    protected $last_rotw_replay;
    protected $last_user_replay;
    protected $last_news_footer;
    protected $countries;
    protected $user_roles;
    protected $bd_users;
    protected $all_sections;
    protected $replay_type;
    protected $general_sections;
    protected $recent_forums;
    protected $replay_maps;
    protected $banner;
    protected $active_banners;
    protected $question;
    protected $answers;
    protected $new_users;
    protected $game_version;
    protected $user_gallery;
    protected $section_icons;
    protected static $instance;
    protected $footer_widgets;
    protected $footer_urls;
    protected $getextraSmiles;
    protected $getChatPictures;
    protected $upcomingtournaments;

    public function __construct()
    {
        if (!self::$instance) {
            self::$instance = $this;
        }

    }

    /**
     * Get footer's widgets
     *
     * @return mixed
     */
    public function getFooterWidgets()
    {
        if (!self::$instance->footer_widgets) {
            $footer_widgets = Footer::where('approved', 1)->get();

            foreach ($footer_widgets as $footer_widget) {
                self::$instance->footer_widgets[$footer_widget->position] = $footer_widget;
            }
        }
        return self::$instance->footer_widgets;
    }

    /**
     * Get footer's custom urls
     */
    public function getFooterUrls()
    {
        if (!self::$instance->footer_urls) {
            $footer_urls = Footerurl::where('approved', 1)->orderBy('updated_at', 'desc')->limit(10)->get();
            self::$instance->footer_urls = $footer_urls;

        }
        return self::$instance->footer_urls;
    }

    /**
     * @param ForumTopic $topic
     * @return bool
     */
    public function checkForumEdit(ForumTopic $topic)
    {
        return TopicService::checkForumEdit($topic);
    }

    /**
     * @param Comment $comment
     * @return bool
     */
    public function checkCommentEdit(Comment $comment)
    {
        return CommentService::checkCommentEdit($comment);
    }

    /**
     * Get random user gallery images
     *
     * @return array
     */
    public function getRandomImg()
    {
        $data_img = UserGallery::orderBy('created_at', 'desc')->limit(5000)->get(['id'])->toArray();
        $random_img_ids = $data_img ? array_rand($data_img, (count($data_img) > 2 ? 2 : count($data_img))) : [];
        if (!is_array($random_img_ids)) {
            $random_img_ids = [$random_img_ids];
        }
        $random_img = [];

        foreach ($random_img_ids as $item) {
            $data = $data_img[$item]['id'];
            $random_img[] = $data;
        }
        $random_img = UserGallery::whereIn('id', $random_img)->with('file')->get()->toArray();

        return $random_img;
    }

    /**
     * Get pandom question for user
     *
     * @return mixed
     */
    public function getRandomQuestion()
    {
        self::$instance->question = self::$instance->question ?? InterviewQuestionsService::getRandomQuestion();
        return self::$instance->question;
    }

    /**
     * Get user questions
     *
     * @return mixed
     */
    public function getUserQuestions()
    {
        self::$instance->answers = self::$instance->answers ?? InterviewQuestionsService::getUserQuestion();
        return self::$instance->answers;
    }

    /**
     * Get user answer
     *
     * @return mixed
     */
    public function getUserAnswers($question_id)
    {
        return InterviewQuestionsService::getUserAnswer($question_id);
    }

    /**
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCountries()
    {
        if (!self::$instance->countries) {
            $countries = Country::all();

            foreach ($countries as $country) {
                self::$instance->countries[$country->id] = $country;
            }
        }
        return self::$instance->countries;
    }

    public function getUserbarForFilter($selectedItem)
    {
        return collect(UserbarService::getItems())->prepend('Не выбрано', 0)->map(function ($item, $key) use ($selectedItem) {
            return [
                'id' => $key,
                'text' => $key ? '/images/userbars/' . $item : $item,
                'selected' => $selectedItem && $selectedItem == $key
            ];
        })->values()->toJson();
    }

    public function getUserbarForUser(User $user)
    {
        if (!isset(UserbarService::getItems()[$user->userbar_id])) {
            return null;
        }

        return '/images/userbars/' . UserbarService::getItems()[$user->userbar_id];
    }


    /**
     * @param $comments
     * @return array|bool
     */
    public function parseCommentsData($comments)
    {
        $types = [
            'topic' =>
                [
                    'title' => 'Форумы',
                    'relation' => 'topic',
                    'route' => 'forum.topic.index',
                    'comments' => []
                ],
            'gallery' =>
                [
                    'title' => 'Галереи',
                    'relation' => 'gallery',
                    'route' => 'gallery.view',
                    'comments' => []
                ],
            'replay' =>
                [
                    'title' => 'Реплеи',
                    'relation' => 'replay',
                    'route' => 'replay.get',
                    'comments' => []
                ]
        ];

        if (!$comments) {
            return false;
        }
        foreach ($comments as $item => $comment) {
            foreach ($types as $key => $type) {
                if ($comment->$key) {
                    $types[$key]['comments'][] = $comment;
                }
            }
        }
        return $types;
    }

    /**
     * @return mixed
     */
    public function getRandomBanner()
    {
        self::$instance->banner = self::$instance->banner ?? BaseDataService::getRandomBanner();
        return self::$instance->banner;
    }

    public function getActiveBanners()
    {
        self::$instance->active_banners = self::$instance->active_banners ?? BaseDataService::getActiveBanners();
        return self::$instance->active_banners;
    }

    public function getStreamSettings()
    {
        self::$instance->stream_settings = self::$instance->stream_settings ?? BaseDataService::getStreamSettings();
        return self::$instance->stream_settings;
    }

    /**
     * @return mixed
     */
    public function getStreamHeader()
    {
        self::$instance->streamheader = self::$instance->streamheader ?? BaseDataService::getStreamHeader();
        return self::$instance->streamheader;
    }

    /**
     * @return mixed
     */
    public function getextraSmiles()
    {
        self::$instance->getextraSmiles = self::$instance->getextraSmiles ?? BaseDataService::getextraSmiles();
        return self::$instance->getextraSmiles;
    }

    /**
     *
     */
    public function getAllChatImages()
    {
        self::$instance->getChatPictures = self::$instance->getChatPictures ?? BaseDataService::getChatPictures();
        return self::$instance->getChatPictures;
    }

    public function parse_stream_url($url)
    {
        return parse_url(htmlspecialchars_decode($url));
    }

    /**
     * Check Streaming live status
     */
    public function liveStreamCheck($stream_url)
    {
        $parts = $this->parse_stream_url($stream_url);
        $host = $parts['host'];

        if ($host == 'play.afreecatv.com') {
            $channel = explode("/", $parts['path'])[1];
            return $this->afreecaTvStream($channel);
        }

        if ($host == 'player.twitch.tv') {
            parse_str($parts['query'], $query);
            $channel = $query['channel'];
            return $this->twitchTvStream($channel);
        }

        if ($host == 'goodgame.ru') {
            $channel_id = $parts['query'];
            return $this->goodgameTvStream($channel_id);
        }
    }

    private function afreecaTvStream($channel)
    {
        if (!empty($channel)) {
            $url = "https://live.afreecatv.com/afreeca/player_live_api.php";
            $data = 'bid=' . $channel . '&bno=&pwd=&type=&player_type=html5&stream_type=common&quality=&mode=embed';
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Accept:application/json",
            ));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            $response = json_decode($response, true);
            if ($response['CHANNEL']['RESULT']) {
                return true;
            }
        }
        return false;
    }

    private function twitchTvStream($channel)
    {
        if (!empty($channel)) {
            $url = 'https://api.twitch.tv/kraken/streams/' . $channel;
            $curlHeader = array(
                'Client-ID: jzkbprff40iqj646a697cyrvl0zt2m6', /* SET CLIENT ID HERE */
                'Accept: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeader);
            $data = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($data, true);
            if ($response['stream'] != null) {
                return true;
            }
        }
        return false;
    }

    private function goodgameTvStream($channel_id)
    {
        if (!empty($channel_id)) {
            $url = 'https://goodgame.ru/api/player?src=' . $channel_id;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($data, true);
            if ($response['channel_status'] == 'online') {
                return true;
            }
        }
        return false;
    }

    public function getActivePath()
    {
        $this->path = $this->path ?? str_ireplace('admin_panel/', '', Request::capture()->path());
        return $this->path;
    }

    public function UrlFilter($text)
    {
        if (preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $match)) {
            return $match[0][0];
        }
        return '';
    }

    /**
     * @param $text
     * @return mixed|null|string|string[]
     */
    public function oldContentFilter($text)
    {
        $text = str_replace("%20", " ", $text);
        $text = str_replace("&nbsp;", " ", $text);

        $text = preg_replace("#\[spoiler\](.+?)\[/spoiler\]#is",
            '</p><div style="width: 99%;margin: 0 auto;">
                <div class="quotetop" style="cursor:pointer;font-size:12px;">
                    <u>Скрытый текст <i>(кликните чтобы развернуть/свернуть)</i></u>
                </div>
                <div class="spoilmain" style="display:none;">
                    <font color="#555599" size="2">\\1</font></div>
                </div
                <p class="page_content_text" align="justify">', $text
            );

        $text = preg_replace_callback("#\[font\s*=\s*(.*?)\s*\](.*?)\[\/font\]#is",
            function ($matches) {
                return "<span style='font-family: ".$matches[1]."'>".$matches[2]."</span>";
        }, $text);
        $text = preg_replace_callback("#\[size\s*=\s*(.*?)\s*\](.*?)\[\/size\]#is",
            function ($matches) {
                $size = $this->getFontsize($matches[1]);
                return "<span style='font-size: ".$size."'>".$matches[2]."</span>";
            }, $text);
        $text = preg_replace_callback("#\[color\s*=\s*(.*?)\s*\](.*?)\[\/color\]#is",
            function ($matches) {
                return "<span style='color: ".$matches[1]."'>".$matches[2]."</span>";
            }, $text);

        /***additional smiles*/
        $text = preg_replace_callback("/:([a-z]{1,2}):/", function ($matches) {
            $this->getEditorSmile($matches);
        }, $text);

        $text = BBCode::parse($text);

        return $text;
    }

    public function getFontsize($size) {
        switch($size) {
            case 1:
                return '10px';
                break;
            case 2:
                return '13px';
                break;
            case 3:
                return '16px';
                break;
            case 4:
                return '18px';
                break;
            case 5:
                return '24px';
                break;
            case 6:
                return '32px';
                break;
            case 7:
                return '48px';
                break;
            default:
                break;
        }
    }

    /**
     * @param $text, $tags, invert
     * return $string
     */
    public function strip_tags_content($text, $tags = '', $invert = FALSE) {

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if(is_array($tags) AND count($tags) > 0) {
            if($invert == FALSE) {
                return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            }
            else {
                return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
            }
        }
        elseif($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }

    /**
     *  remove <!-- -->
     */
    public function removeExtraTag($text) {

        $text =   preg_replace("/<!--.*?-->/mss", "", $text);
        $text =  str_replace('&nbsp;', ' ', $text);
        return $text;
    }

    /**
     * @param $string
     * @return string
     */
    public function getEditorSmile($string)
    {
        $smile_map = array(
            'g' => 'gold.png',
            's' => 'silver.png',
            'tr' => 'trollface.png',
            'f' => 'facepalm.png',
            'z' => 'zerg.gif',
            't' => 'terran.gif',
            'p' => 'protoss.gif'
        );


        if (array_key_exists($string[1], $smile_map)) {
            return '<img src="editor/' . $smile_map[$string[1]] . '" border="0">';
        } else {
            return $string[0];
        }
    }

    /**
     * Convert manual URLs
     * _regex_build_url_manual: Checks, and builds the a href
     *
     * @param array    Input vars
     * @return    string    Converted text
     */
    public function _regex_build_url_manual($matches = array())
    {
        /**Send off to the correct function...*/
        return $this->regex_build_url(array(
            'st' => $matches[1],
            'html' => $matches[2],
            'show' => $matches[2],
            'end' => ''
        ));
    }

    /**
     * Convert tagged URLs
     * _regex_build_url_tags: Checks, and builds the a href
     *
     * @param array    Input vars
     * @return    string    Converted text
     */
    public function _regex_build_url_tags($matches = array())
    {
        /**Send off to the correct function...*/
        return $this->regex_build_url(array(
            'st' => '',
            'html' => $matches[1],
            'show' => isset($matches[2]) && $matches[2] ? $matches[2] : $matches[1],
            'end' => ''
        ));
    }

    /**
     * Convert URLs
     *
     * regex_build_url: Checks, and builds the a href
     *
     * @param array    Input vars
     * @return    string    Converted text
     */
    public function regex_build_url($url = array())
    {
        //-----------------------------------------
        // INIT
        //-----------------------------------------

        $skip_it = 0;
        $url['end'] = isset($url['end']) ? $url['end'] : '';

        //-----------------------------------------
        // Is there another bbcode + js?
        // Block XSS attempt
        //-----------------------------------------

        $bbcodes = array('b', 'i', 'u', 's', 'center', 'left', 'right', 'url', 'email', 'quote', 'img');

        if (preg_match("#\[(" . implode('|', $bbcodes) . ")(.*?)\]#is", $url['html'])) {
            $error = 'domain_not_allowed';
            return $url['html'];
        }

        //-----------------------------------------
        // Make sure the last character isn't punctuation..
        // if it is, remove it and add it to the
        // end array
        //-----------------------------------------

        if (preg_match("/([\.,\?]|&#33;)$/", $url['html'], $match)) {
            $url['end'] .= $match[1];
            $url['html'] = preg_replace("/([\.,\?]|&#33;)$/", "", $url['html']);
            $url['show'] = preg_replace("/([\.,\?]|&#33;)$/", "", $url['show']);
        }

        //-----------------------------------------
        // Make sure it's not being used in a
        // closing code/quote/html or sql block
        //-----------------------------------------

        if (preg_match("/\[\/(html|quote|code|sql)/i", $url['html'])) {
            return $url['html'];
        }

        //-----------------------------------------
        // Make sure it's fixed if used in an
        // opening quote block
        //-----------------------------------------

        if (preg_match("/(\+\-\-\>)$/", $url['html'], $match)) {
            $url['end'] .= $match[1];
            $url['html'] = preg_replace("/(\+\-\-\>)$/", "", $url['html']);
            $url['show'] = preg_replace("/(\+\-\-\>)$/", "", $url['show']);
        }

        //-----------------------------------------
        // clean up the ampersands / brackets
        //-----------------------------------------

        $url['html'] = htmlspecialchars($url['html']);
        $url['html'] = str_replace("&amp;amp;", "&amp;", $url['html']);
        $url['html'] = str_replace("[", "%5b", $url['html']);
        $url['html'] = str_replace("]", "%5d", $url['html']);
        $url['html'] = str_replace(" ", "%20", $url['html']);

        //-----------------------------------------
        // Make sure we don't have a JS link
        //-----------------------------------------

        if (preg_match('#javascript\:#is', preg_replace('#\s{1,}#s', '', $url['html']))) {
            $url['html'] = preg_replace("/javascript:/i", "java script&#58; ", $url['html']);
        }

        if (preg_match('#javascript\:#is', preg_replace('#\s{1,}#s', '', $url['show']))) {
            $url['show'] = preg_replace("/javascript:/i", "java script&#58; ", $url['show']);
        }

        //-----------------------------------------
        // Do we have http:// at the front?
        //-----------------------------------------

        if (!preg_match("#^(http|news|https|ftp|aim)://#", $url['html'])) {
            $url['html'] = 'http://' . $url['html'];
        }

        //-----------------------------------------
        // Tidy up the viewable URL
        //-----------------------------------------

        if (preg_match("/^<img src/i", $url['show'])) {
            $skip_it = 1;
            $url['show'] = stripslashes($url['show']);
        }

        $url['show'] = str_replace("&amp;amp;", "&amp;", $url['show']);
        $url['show'] = preg_replace("/javascript:/i", "javascript&#58; ", $url['show']);

        if ((strlen($url['show']) - 38) < 3) {
            $skip_it = 1;
        }

        //-----------------------------------------
        // Make sure it's a "proper" url
        //-----------------------------------------

        if (!preg_match("/^(http|ftp|https|news):\/\//i", $url['show'])) {
            $skip_it = 1;
        }

        $show = $url['show'];

        if ($skip_it != 1) {
            $stripped = preg_replace("#^(http|ftp|https|news)://(\S+)$#i", "\\2", $url['show']);
            $uri_type = preg_replace("#^(http|ftp|https|news)://(\S+)$#i", "\\1", $url['show']);

            $show = $uri_type . '://' . mb_substr($stripped, 0, 25) . '...' . mb_substr($stripped, -10);
        }
        $result = (isset($url['st']) ? $url['st'] : '') . "<a rel=\"nofollow\" href=\"" . $url['html'] . "\" target=\"_blank\">" . $show . "</a>" . $url['end'];

        return $result;
    }

    public function closeAllTags($content)
    {
        $position = 0;
        $open_tags = array();
        //ignored tags
        $ignored_tags = array('br', 'hr', 'img');

        while (($position = mb_strpos($content, '<', $position)) !== false) {
            //get all tags in content
            if (preg_match("|^<(/?)([a-z\d]+)\b[^>]*>|i", mb_substr($content, $position), $match)) {
                $tag = mb_strtolower($match[2]);
                //ignore all single tags
                if (in_array($tag, $ignored_tags) == false) {
                    //tag is opened
                    if (isset($match[1]) AND $match[1] == '') {
                        if (isset($open_tags[$tag])) {
                            $open_tags[$tag]++;
                        } else {
                            $open_tags[$tag] = 1;
                        }
                    }
                    //tag is closed
                    if (isset($match[1]) AND $match[1] == '/') {
                        if (isset($open_tags[$tag])) {
                            $open_tags[$tag]--;
                        }
                    }
                }
                $position += mb_strlen($match[0]);
            } else {
                $position++;
            }
        }
        //close all tags
        foreach ($open_tags as $tag => $count_not_closed) {
            $content .= str_repeat("</{$tag}>", $count_not_closed);
        }

        return $content;
    }

    public function checkUserLink($str)
    {
        if (preg_match('/^(http|https):\/\//i', $str)) {
            $url = $str;
        } else {
            $url = 'http://' . $str;
        }
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }
        return false;
    }
}
