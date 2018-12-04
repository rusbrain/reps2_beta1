<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.10.18
 * Time: 12:50
 */

namespace App\Services;

use App\Banner;
use App\Country;
use App\File;
use App\ForumSection;
use App\ForumTopic;
use App\GameVersion;
use App\InterviewQuestion;
use App\Replay;
use App\ReplayMap;
use App\ReplayType;
use App\User;
use App\UserGallery;
use App\UserMessage;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GeneralViewHelper
{
    protected $last_forum;
    protected $last_forum_home;
    protected $last_gosu_replay;
    protected $last_user_replay;
    protected $countries;
    protected $user_roles;
    protected $bd_users;
    protected $all_sections;
    protected $replay_type;
    protected $general_sections;
    protected $replay_maps;
    protected $banner;
    protected $question;
    protected $new_users;
    protected $game_version;
    protected $user_gallery;
    protected static $instance;

    public function __construct()
    {
        if (!self::$instance) {
            self::$instance = $this;
        }
    }

    /**
     * Get random user gallery images
     *
     * @return array
     */
    public function getRandomImg()
    {
        $data_img = UserGallery::orderBy('created_at', 'desc')->limit(5000)->get(['id'])->toArray();
        $random_img_ids = $data_img ? array_rand($data_img, (count($data_img) > 4 ? 4 : count($data_img))) : [];
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
        self::$instance->question = self::$instance->question ?? InterviewQuestion::getRandomQuestion();
        return self::$instance->question;
    }

    /**
     * @return mixed
     */
    public function getLastForum()
    {
        if (!self::$instance->last_forum) {
            if (!self::$instance->all_sections) {
                self::$instance->getAllForumSections();
            }

            self::$instance->last_forum = self::$instance->all_sections->where('is_general', 1);
        }

        return self::$instance->last_forum;
    }

    /**
     * @return mixed
     */
    public function getLastGosuReplay()
    {
        if (!self::$instance->last_gosu_replay) {
            self::$instance->last_gosu_replay = Replay::gosuReplay()->where('approved', 1)->orderBy('created_at',
                'desc')->limit(5)->get();
            self::$instance->last_gosu_replay->load('map');
        }

        return self::$instance->last_gosu_replay;
    }

    /**
     * @return mixed
     */
    public function getLastUserReplay()
    {
        self::$instance->last_user_replay = self::$instance->last_user_replay ?? Replay::userReplay()->where('approved',
                1)->orderBy('created_at', 'desc')->limit(5)->get();
        return self::$instance->last_user_replay;
    }

    /**
     * @return int
     */
    public function getNewUserMessage()
    {
        $new_user_message = 0;

        if (Auth::user()) {
            $new_user_message = UserMessage::whereHas('dialogue.users', function ($query) {
                $query->where('users.id', Auth::id());
            })->where('user_id', '<>', Auth::id())->where('is_read', 0)->count();
        }

        return $new_user_message;
    }

    /**
     * @return mixed
     */
    public function getNewUsers()
    {
        $new_users = $new_users ?? User::where('is_ban', 0)->orderBy('created_at', 'desc')->limit(10)->get();
        return $new_users;
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

    /**
     * @return UserRole[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUsersRole()
    {
        self::$instance->user_roles = self::$instance->user_roles ?? UserRole::all();
        return self::$instance->user_roles;
    }

    /**
     * @return mixed
     */
    public function getBirthdayUsers()
    {
        self::$instance->bd_users = self::$instance->bd_users ?? User::where('birthday', 'like',
                "%" . Carbon::now()->format('m-d'))->get();
        return self::$instance->bd_users;
    }

    /**
     * @return ForumSection[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllForumSections()
    {
        if (!$this->all_sections) {
            $all_sections = ForumSection::active()->get();
            $time = Carbon::now()->format('Y-M-d');
            $sql = [];
            foreach ($all_sections as $section) {
                $sql[] = "(
        select * from `forum_topics` where `approved` = 1 and (`start_on` is null or `start_on` <= '$time') and `section_id` = $section->id ORDER BY `commented_at` DESC limit 5
        )";
            }

            $sql = implode(" UNION ALL ", $sql);
            $topics = collect(\DB::select($sql))->groupBy('section_id');

            foreach ($all_sections as $key => $section) {
                $all_sections[$key]->topics = $topics[$section->id];
            }

            $this->all_sections = $all_sections;
        }

        return self::$instance->all_sections;
    }

    /**
     * @return ReplayType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReplayTypes()
    {
        if (!self::$instance->replay_type) {
            $types = ReplayType::all();

            foreach ($types as $type) {
                self::$instance->replay_type[$type->id] = $type;
            }
        }

        return self::$instance->replay_type;
    }

    /**
     * @return mixed
     */
    public function getGeneralSectionsForum()
    {
        if (!self::$instance->general_sections) {
            if (!self::$instance->all_sections) {
                self::$instance->getAllForumSections();
            }

            self::$instance->general_sections = self::$instance->all_sections->where('is_general', 1);
        }

        return self::$instance->general_sections;
    }

    /**
     * @return mixed
     */
    public function getRandomBanner()
    {
        self::$instance->banner = self::$instance->banner ?? Banner::getRandomBanner();
        return self::$instance->banner;
    }

    public function getTopReplayAll()
    {

    }

    public function getTopReplayWeek()
    {

    }

    public function getTopReplayMonth()
    {

    }

    /**
     * @return mixed
     */
    public function getLastForumHome()
    {
        self::$instance->last_forum_home = self::$instance->last_forum_home ?? ForumTopic::whereHas('section',
                function ($query) {
                    $query->where('is_active', 1)->where('is_general', 1);
                })
                ->where('approved', 1)
                ->with('preview_image')
                ->withCount('positive', 'negative', 'comments')
                ->limit(5)->get();

        return self::$instance->last_forum_home;
    }

    /**
     * Get Replay Maps
     *
     * @return ReplayMap[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReplayMaps()
    {
        if (!self::$instance->replay_maps) {
            $types = ReplayMap::all();

            foreach ($types as $type) {
                self::$instance->replay_maps[$type->id] = $type;
            }
        }

        return self::$instance->replay_maps;
    }

    /**
     * Get Replay Maps
     *
     * @return ReplayMap[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getGameVersion()
    {
        if (!self::$instance->game_version) {
            $types = GameVersion::all();

            foreach ($types as $type) {
                self::$instance->game_version[$type->id] = $type;
            }
        }

        return self::$instance->game_version;
    }

    /**
     * @param $user
     * @return bool
     */
    public function isOnline($user)
    {
        $time = (Carbon::now()->getTimestamp() - Carbon::parse($user->activity_at)->getTimestamp()) / 60;

        return $time <= 15;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getUserGallery($user_id)
    {
        self::$instance->user_gallery = self::$instance->user_gallery ?? UserGallery::where('user_id',
                $user_id)->with('file')->get();
        return self::$instance->user_gallery;
    }

    public function oldContentFilter($text)
    {
        $text = str_replace("%20", " ", $text);

        $text = preg_replace("#\[(b)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);
        $text = preg_replace("#\[(i)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);
        $text = preg_replace("#\[(u)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);
        $text = preg_replace("#\[(s)\](.+?)\[/\\1\]#is", "<\\1>\\2</\\1>", $text);
        $text = preg_replace("#\[spoiler\](.+?)\[/spoiler\]#is", '</p><div style="width: 99%;margin: 0 auto;">
    <div class="quotetop" style="cursor:pointer;font-size:10px;"><u>Скрытый текст <i>(кликните чтобы развернуть/свернуть)</i></u></div><div class="spoilmain" style="display:none;"><font color="#555599" size="1">\\1</font></div></div><p class="page_content_text" align="justify">',
            $text);
        $text = preg_replace("#\[(quote)\](.+?)\[/\\1\]#is",
            "</p><p class=\"page_content_info2\" align=\"left\" align=\"justify\"><font color=\"#555599\">\\2</font></p><p align=\"justify\">",
            $text);
        $text = preg_replace("#\[(left|right|center)\](.+?)\[/\\1\]#is",
            "</p><div align=\"\\1\">\\2</div><p align=\"justify\">", $text);
        $text = preg_replace("/\[img\](\r\n|\r|\n)*((http|https):\/\/([^;<>\*\"]+)|[a-z0-9\/\\\._\- ]+)\[\/img\]/siU",
            "<img src=\"\\2\" class=\"imgl\" border=\"0\" alt=\"\"> ", $text);

        $text = preg_replace_callback("#(^|\s|>)((http|https|news|ftp)://\w+[^\s\[\]\<]+)#i", function ($matches) {
            return $this->_regex_build_url_manual($matches);
        }, $text);
        $text = preg_replace_callback("#\[url\](.*?)\[/url\]#is", function ($matches) {
            return $this->_regex_build_url_tags($matches);
        }, $text);

        $text = preg_replace_callback("#\[url\s*=\s*(?:\&quot\;|\")\s*(.*?)\s*(?:\&quot\;|\")\s*\](.*?)\[\/url\]#is",
            function ($matches) {
                return $this->_regex_build_url_tags($matches);
            }, $text);
        $text = preg_replace_callback("#\[url\s*=\s*(.*?)\s*\](.*?)\[\/url\]#is", function ($matches) {
            return $this->_regex_build_url_tags($matches);
        }, $text);

        $text = preg_replace("/([\w\.]+)(@)([\w\.]+)/i", "<a rel=\"nofollow\" href=\"mailto:$0\"><b>Mail»</b></a>",
            $text);

        $text = preg_replace("/:s([0-9]{1,}):/", '<img src="/images/smiles/s$1.gif" border="0">', $text);

        /***additional smiles*/
        $text = preg_replace_callback("/:([a-z]{1,2}):/", function ($matches) {
            $this->getEditorSmile($matches);
        }, $text);

        return $text;
    }

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
     * @param    array    Input vars
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
     * @param    array    Input vars
     * @return    string    Converted text
     */
    public function _regex_build_url_tags($matches = array())
    {
        /**Send off to the correct function...*/
        return $this->regex_build_url(array(
            'st' => '',
            'html' => $matches[1],
            'show' => $matches[2] ? $matches[2] : $matches[1],
            'end' => ''
        ));

    }

    /**
     * Convert URLs
     *
     * regex_build_url: Checks, and builds the a href
     *
     * @param    array    Input vars
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

            $show = $uri_type . '://' . substr($stripped, 0, 25) . '...' . substr($stripped, -10);
        }
        $result = (isset($url['st']) ? $url['st'] : '') . "<a rel=\"nofollow\" href=\"" . $url['html'] . "\" target=\"_blank\">" . $show . "</a>" . $url['end'];

        return $result;
    }
}