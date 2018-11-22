<?php

use Illuminate\Database\Seeder;
use App\UserRole;
use \App\Country;
use \App\User;
use \Carbon\Carbon;
use \App\File;
use \App\UserGallery;
use \App\Comment;
use \App\UserFriend;
use \App\ForumSection;
use \App\ForumTopic;
use \App\ForumIcon;
use App\ReplayMap;
use App\ReplayType;
use App\GameVersion;
use App\Replay;
use \App\IgnoreUser;
use \App\Dialogue;
use \App\UserMessage;

class DBRelocationDataSeed extends Seeder
{
    /**
     * @var UserRole[]|\Illuminate\Database\Eloquent\Collection
     */
    protected static $user_roles;

    /**
     * @var Country[]|\Illuminate\Database\Eloquent\Collection
     */
    protected static $country;

    /**
     * @var array
     */
    protected static $revert_dates;

    /**
     * DBRelocationDataSeed constructor.
     */
    public function __construct()
    {
        self::$user_roles = UserRole::all();
        self::$country = Country::all();
        self::$revert_dates = [
            [
                'start' => Carbon::parse('2000-03-26 03:00:00'),
                'end'   => Carbon::parse('2000-03-26 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2001-03-25 03:00:00'),
                'end'   => Carbon::parse('2001-03-25 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2002-03-31 03:00:00'),
                'end'   => Carbon::parse('2002-03-31 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2003-03-30 03:00:00'),
                'end'   => Carbon::parse('2003-03-30 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2004-03-28 03:00:00'),
                'end'   => Carbon::parse('2004-03-28 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2005-03-27 03:00:00'),
                'end'   => Carbon::parse('2005-03-27 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2006-03-26 03:00:00'),
                'end'   => Carbon::parse('2006-03-26 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2007-03-25 03:00:00'),
                'end'   => Carbon::parse('2007-03-25 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2008-03-30 03:00:00'),
                'end'   => Carbon::parse('2008-03-30 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2009-03-29 03:00:00'),
                'end'   => Carbon::parse('2009-03-29 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2010-03-28 03:00:00'),
                'end'   => Carbon::parse('2010-03-28 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2011-03-27 03:00:00'),
                'end'   => Carbon::parse('2011-03-27 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2012-03-25 03:00:00'),
                'end'   => Carbon::parse('2012-03-25 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2013-03-31 03:00:00'),
                'end'   => Carbon::parse('2013-03-31 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2014-03-30 03:00:00'),
                'end'   => Carbon::parse('2014-03-30 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2015-03-29 03:00:00'),
                'end'   => Carbon::parse('2015-03-29 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2016-03-27 03:00:00'),
                'end'   => Carbon::parse('2016-03-27 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2017-03-26 03:00:00'),
                'end'   => Carbon::parse('2017-03-26 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2018-03-25 03:00:00'),
                'end'   => Carbon::parse('2018-03-25 04:00:00'),
            ],
            [
                'start' => Carbon::parse('2019-03-31 03:00:00'),
                'end'   => Carbon::parse('2019-03-31 04:00:00'),
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Old users seeding
        echo "1. Users and Avatars seed start \n";
        $this->seedUser(self::$country);
        echo "Users and Avatars seed finished \n\n";

        //Update users avatars file
        echo "2. Update users avatars file start \n";
        $this->updateAvatarFile();
        echo "Update users avatars file finished \n\n";

        //User Gallery seeding
        echo "3. User Gallery seed start \n";
        $this->seedUserGallery();
        echo "User Gallery seed finished \n\n";

        //User Gallery Comments seeding
        echo "4. User Gallery Comments seed start \n";
        $this->seedUserGalleryComments();
        echo "User Gallery Comments seed finished \n\n";

        //User Friends seeding
        echo "5. User Friends seed start \n";
        $this->seedUserFriends();
        echo "User Friends seed finished \n\n";

        //Forum Topic seeding
        echo "6. Forum Topic seed start \n";
        $this->seedForumTopic('rusforum');
        echo "Forum Topic seed finished \n\n";

        //Forum Topic Eng seeding
        echo "7. Forum Topic Eng seed start \n";
        $this->seedForumTopic('engforum');
        echo "Forum Topic Eng seed finished \n\n";

        //Forum Topic Comment seeding
        echo "8. Forum Topic Comment seed start \n";
        $this->seedTopicComments('rusforumreply');
        echo "Forum Topic Comment seed finished \n\n";

        //Forum Topic Comment Eng seeding
        echo "9. Forum Topic Comment Eng seed start \n";
        $this->seedTopicComments('engforumreply');
        echo "Forum Topic Comment Eng seed finished \n\n";

        //News seeding
        echo "10. News seed start \n";
        $this->seedNews('rusnews');
        echo "News seed finished \n\n";

        //News Eng seeding
        echo "11. News Eng seed start \n";
        $this->seedNews('engnews');
        echo "News Eng seed finished \n\n";

        //News Comments seeding
        echo "12. News Comments seed start \n";
        $this->seedNewsComments('rusnewscomments');
        echo "News Comments seed finished \n\n";

        //News Comments Eng seeding
        echo "13. News Comments Eng seed start \n";
        $this->seedNewsComments('engnewscomments');
        echo "News Comments Eng seed finished \n\n";

        //Replay seeding
        echo "14. Replay seed start \n";
        $this->seedReplay();
        echo "Replay seed finished \n\n";

        //Replay Comments seeding
        echo "15. Replay Comments seed start \n";
        $this->seedReplayComments();
        echo "Replay Comments seed finished \n\n";

        //Columns rus seeding
        echo "16. Columns rus seed start \n";
        $this->seedColumns('ruscolumns');
        echo "Columns rus seed finished \n\n";

        //Columns rus Comments seeding
        echo "17. Columns rus Comments seed start \n";
        $this->seedColumnComments('ruscolumnscomments');
        echo "Columns rus Comments seed finished \n\n";

        //Columns eng seeding
        echo "18. Columns eng seed start \n";
        $this->seedColumns('engcolumns');
        echo "Columns eng seed finished \n\n";

        //Columns eng Comments seeding
        echo "19. Columns eng Comments seed start \n";
        $this->seedColumnComments('engcolumnscomments');
        echo "Columns eng Comments seed finished \n\n";

        //Ignore List seeding
        echo "20. Ignore List seed start \n";
        $this->seedIgnoreList();
        echo "Ignore List seed finished \n\n";

        //Dialogs seeding
        echo "21. Dialogs seed start \n";
        $this->seedMessages();
        echo "Dialogs seed finished \n\n";

        //Dialogs seeding
        echo "22. Start Update Interview \n";
        $this->updateInterview();
        echo "Update Interview finished \n\n";

        //Dialogs seeding
        echo "23. Start Update Coverage \n";
        $this->updateCoverage();
        echo "Update Coverage finished \n\n";
    }

    /**
     * Old users seeding
     *
     * @param $country
     */
    protected function seedUser($country)
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD').'.users')->count());

        $emails = [];
        for ($i = 0; $i<$cycles; $i++){
            $old_users = DB::table(env('DB_DATABASE_OLD').'.users')->orderBy('user_id')->offset(1000*$i)->limit(1000)->get();

            $new_users = [];
            foreach ($old_users as $old_user){
                if (!in_array(strtolower($old_user->user_email), $emails)){
                    $emails[] = strtolower($old_user->user_email);
                    $role = self::getUserRole($old_user);

                    $avatar_id = 0;
                    if ($old_user->user_avatar){
                        $path_to   = "./public/storage/avatars/{$old_user->user_avatar}";

                        if(@fopen($path_to, 'r')){
                            $file_data = [
                                'user_id' => 0,
                                'title' => "Аватар {$old_user->user_name}",
                                'link' => "/storage/avatars/{$old_user->user_avatar}",
                                'type' => filetype($path_to),
                                'size' => filesize($path_to),
                            ];

                            $file = File::create($file_data);
                            $avatar_id = $file->id;
                        }
                    }

                    $new_users[] = [
                        'reps_id' => (int)$old_user->user_id,
                        'name' => $old_user->user_name,
                        'email' => $old_user->user_email,
                        'password' => '',
                        'user_role_id' => $role,
                        'country_id' => $country->where('name', $old_user->user_country)->first()->id??0,
                        'score' => $old_user->user_score,
                        'homepage' => $old_user->user_homepage,
                        'isq' => $old_user->user_icq,
                        'signature' => $old_user->user_signature,
                        'file_id' => $avatar_id,
                        'mouse' => $old_user->user_mouse,
                        'keyboard' => $old_user->user_keyboard,
                        'headphone' => $old_user->user_headphone,
                        'mousepad' => $old_user->user_mousepad,
                        'birthday' => ($old_user->user_year && $old_user->user_month && $old_user->user_day)?Carbon::now()->year($old_user->user_year)->month($old_user->user_month)->day($old_user->user_day):null,
                        'is_ban' => $old_user->user_ban,
                        'rep_allow' => ((int)$old_user->user_rep_allow)?1:0,
                        'rep_buy' => $old_user->user_rep_buy,
                        'rep_sell' => $old_user->user_rep_sell,
                        'view_signs' => ($old_user->view_signs == 'yes'?1:0),
                        'view_avatars' => ($old_user->view_avatars == 'yes'?1:0),
                        'skype' => $old_user->user_skype,
                        'created_at' =>  self::correctDate($old_user->reg_date!=0?Carbon::createFromTimestamp($old_user->reg_date):($old_user->nick_date!=0?Carbon::createFromTimestamp($old_user->nick_date):Carbon::now()))
                    ];
                }
            }

            User::insert($new_users);
            $j = $i +1;
            echo "Users and Avatars seeded ($j/$cycles)\n";
        }
    }

    /**
     * Update avatar users
     */
    protected function updateAvatarFile()
    {
        $cycles = self::getCycles(User::where('file_id', '>', 0)->count());

        for ($i = 0; $i<$cycles; $i++){
            $avatar_users = User::where('file_id', '>', 0)->orderBy('id')->offset(1000*$i)->limit(1000)->get();

            foreach ($avatar_users as $avatar_user) {
                File::where('id', $avatar_user->file_id)->update(['user_id' => $avatar_user->id]);
            }

            $j = $i +1;
            echo "Updated users avatars file ($j/$cycles)\n";
        }
    }

    /**
     * Seeding user gallery
     */
    protected function seedUserGallery()
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') . '.usergallery')->count());

        $users = [];
        $users_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $old_galleries = DB::table(env('DB_DATABASE_OLD') . '.usergallery')->orderBy('photo_id')->offset(1000 * $i)->limit(1000)->get();
            $new_gallery = [];

            foreach ($old_galleries as $old_gallery) {
                $path_to = "./public/storage/gallery/{$old_gallery->photo_id}.jpg";

                if (@fopen($path_to, 'r')) {
                    if(in_array($old_gallery->user_id, $users_id)){
                        $user = $users[$old_gallery->user_id];
                    } else{
                        $user = User::where('reps_id', $old_gallery->user_id)->first();
                        $users[$old_gallery->user_id] = $user;
                        $users_id[] = $old_gallery->user_id;
                    }

                    $user_name = $user->name ?? '';

                    $file_data = [
                        'user_id' => $user->id ?? 0,
                        'title' => "Картинка галлереи пользователя {$user_name}",
                        'link' => "/storage/gallery/{$old_gallery->photo_id}.jpg",
                        'type' => filetype($path_to),
                        'size' => filesize($path_to),
                    ];

                    $file = File::create($file_data);
                    $file_id = $file->id;

                    $new_gallery[] = [
                        'reps_id' => (int)$old_gallery->photo_id,
                        'user_id' => $user->id ?? 1,
                        'file_id' => $file_id,
                        'comment' => $old_gallery->title,
                        'created_at' => $old_gallery->date != 0 ? self::correctDate(Carbon::createFromTimestamp($old_gallery->date)) : Carbon::now(),
                        'for_adults' => $old_gallery->adult == 'yes',
                    ];
                }
            }

            UserGallery::insert($new_gallery);

            $j = $i +1;
            echo "User Gallery seeded ($j/$cycles)\n";
        }

        $users = null;
        $users_id = null;
    }

    /**
     * seed User Gallery Comments
     */
    protected function seedUserGalleryComments()
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') . '.rusnewscomments')->where('type', 'userphoto')->count());

        $users = [];
        $users_id = [];
        $galleries = [];
        $galleries_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $old_gallery_comments = DB::table(env('DB_DATABASE_OLD') . '.rusnewscomments')->where('type', 'userphoto')->orderBy('comment_id')->offset(1000 * $i)->limit(1000)->get();

            $new_gallery_comment = [];
            foreach ($old_gallery_comments as $old_gallery_comment) {
                if(in_array($old_gallery_comment->user_id, $users_id)){
                    $user = $users[$old_gallery_comment->user_id];
                } else{
                    $user = User::where('reps_id', $old_gallery_comment->user_id)->first();
                    $users[$old_gallery_comment->user_id] = $user;
                    $users_id[] = $old_gallery_comment->user_id;
                }

                if(in_array($old_gallery_comment->news_id, $galleries_id)){
                    $user_gallery = $galleries[$old_gallery_comment->news_id];
                } else{
                    $user_gallery = UserGallery::where('reps_id', $old_gallery_comment->news_id)->first();
                    $galleries[$old_gallery_comment->news_id] = $user_gallery;
                    $galleries_id[] = $old_gallery_comment->news_id;
                }

                $new_gallery_comment[] = [
                    'user_id' => (int)$user->id ?? 1,
                    'object_id' => (int)$user_gallery->id ?? 0,
                    'relation' => Comment::RELATION_USER_GALLERY,
                    'title' => $old_gallery_comment->comment_title,
                    'content' => (string)$old_gallery_comment->comment_text,
                    'created_at' =>  self::correctDate(Carbon::parse($old_gallery_comment->comment_date.' '. $old_gallery_comment->comment_time)),
                ];
            }

            Comment::insert($new_gallery_comment);

            $j = $i +1;
            echo "Gallery comments seeded ($j/$cycles)\n";
        }

        $users = null;
        $users_id = null;
        $galleries = null;
        $galleries_id = null;
    }

    /**
     * seed Topic Comments
     */
    protected function seedTopicComments($table)
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') .'.'.  $table)->count());

        $users = [];
        $users_id = [];
        $topics = [];
        $topics_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $old_topic_comments = DB::table(env('DB_DATABASE_OLD') .'.'.  $table)->orderBy('reply_id')->offset(1000 * $i)->limit(1000)->get();

            $new_topic_comment = [];
            foreach ($old_topic_comments as $old_topic_comment) {
                if(in_array($old_topic_comment->user_id, $users_id)){
                    $user = $users[$old_topic_comment->user_id];
                } else{
                    $user = User::where('reps_id', $old_topic_comment->user_id)->first();
                    $users[$old_topic_comment->user_id] = $user;
                    $users_id[] = $old_topic_comment->user_id;
                }

                if(in_array($old_topic_comment->forum_id, $topics_id)){
                    $forum_topic = $topics[$old_topic_comment->forum_id];
                } else {
                    $forum_topic = ForumTopic::where('reps_id', $old_topic_comment->forum_id)->first();
                    $topics[$old_topic_comment->forum_id] = $forum_topic;
                    $topics_id[] = $old_topic_comment->forum_id;
                }

                $new_topic_comment[] = [
                    'user_id' => $user->id ?? 1,
                    'object_id' => (int)$forum_topic->id ?? 0,
                    'relation' => Comment::RELATION_FORUM_TOPIC,
                    'title' => $old_topic_comment->reply_title,
                    'content' => $old_topic_comment->reply_text,
                    'created_at' =>  self::correctDate(Carbon::parse($old_topic_comment->reply_date.' '. $old_topic_comment->reply_time)),
                ];
            }

            Comment::insert($new_topic_comment);

            $j = $i +1;
            echo "Forum Topic comments seeded ($j/$cycles)\n";
        }

        $users = null;
        $users_id = null;
        $topics = null;
        $topics_id = null;
    }

    /**
     * Seed News
     *
     * @param $table
     */
    protected function seedNews($table)
    {
        $forum_icons = ForumIcon::first();
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') . '.'.$table)->count());

        $users = [];
        $users_id = [];
        $section_ids = [];
        $section_id_key = [];

        for ($i = 0; $i < $cycles; $i++) {
            $rusforums = DB::table(env('DB_DATABASE_OLD') . '.'.$table)
//                ->select(DB::raw('news_stext COLLATE utf8mb4_unicode_ci AS news_stext1, news_title COLLATE utf8mb4_unicode_ci AS news_title1, news_date, news_time'))
//                ->select(DB::raw('news_text COLLATE utf8mb4_unicode_ci AS news_text1, user_id, news_type, news_id, news_long, news_show, news_start, denyview'))
                ->orderBy('news_id')->offset(1000 * $i)->limit(1000)->get();

            $new_forum_topics = [];
            foreach ($rusforums as $rusforum) {
                if(in_array($rusforum->user_id, $users_id)){
                    $user = $users[$rusforum->user_id];
                } else{
                    $user = User::where('reps_id', $rusforum->user_id)->first();
                    $users[$rusforum->user_id] = $user;
                    $users_id[] = $rusforum->user_id;
                }

                if(in_array($rusforum->news_type, $section_id_key)){
                    $section_id = $section_ids[$rusforum->news_type];
                } else{
                    $section_id = ForumSection::where('name', 'like', "%".$rusforum->news_type."%")->first()->id??\App\ForumSection::where('name', 'article')->first()->id;
                    $section_ids[$rusforum->news_type] = $section_id;
                    $section_id_key[] = $rusforum->news_type;
                }

                $s_text = $rusforum->news_stext;

                $new_forum_topics[] = [
                    'reps_id'           => (int)$rusforum->news_id,
                    'reps_section'      => $rusforum->news_type,
                    'section_id'        => (int)$section_id,
                    'title'             => $rusforum->news_title,
                    'preview_content'   => $s_text,
                    'content'           => (string)($rusforum->news_long?$rusforum->news_text:$s_text),
                    'user_id'           => (int)$user->id??1,
                    'reviews'           => $rusforum->news_show,
                    'start_on'          => $rusforum->news_start?(Carbon::parse($rusforum->news_start) > Carbon::now()?Carbon::parse($rusforum->news_start):null) :null,
                    'created_at'        => $rusforum->news_date&&$rusforum->news_time?Carbon::parse($rusforum->news_date.' '.$rusforum->news_time):Carbon::now(),
                    'approved'          => $table == 'rusnews'?$rusforum->denyview:1,
                    'news'              => 1,
                    'forum_icon_id'     => (int)$forum_icons->id,
                ];
            }

            \App\ForumTopic::insert($new_forum_topics);

            $j = $i +1;
            echo "News seeded ($j/$cycles) \n";
        }

        $users = null;
        $users_id = null;
        $section_id = null;
        $section_id_key = null;
    }

    /**
     * Seed Columns
     *
     * @param $table
     */
    protected function seedColumns($table)
    {
        $forum_icons = ForumIcon::first();
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') . '.'.$table)->count());
        $section_id = ForumSection::where('name', 'columns')->first()->id;
        $users = [];
        $users_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $rusforums = DB::table(env('DB_DATABASE_OLD') . '.'.$table)->orderBy('columns_id')->offset(1000 * $i)->limit(1000)->get();

            $new_forum_topics = [];
            foreach ($rusforums as $rusforum) {
                if(in_array($rusforum->user_id, $users_id)){
                    $user = $users[$rusforum->user_id];
                } else{
                    $user = User::where('reps_id', $rusforum->user_id)->first();
                    $users[$rusforum->user_id] = $user;
                    $users_id[] = $rusforum->user_id;
                }

                $s_text = $rusforum->columns_stext;

                $new_forum_topics[] = [
                    'reps_id' => (int)$rusforum->columns_id,
                    'reps_section' => "columns",
                    'section_id' => (int)$section_id,
                    'title' => $rusforum->columns_title,
                    'preview_content' => $s_text,
                    'content' => 	$rusforum->columns_long?($rusforum->columns_text):$s_text,
                    'user_id' => (int)$user->id??1,
                    'reviews' => $rusforum->columns_show,
                    'start_on' => $rusforum->columns_start?(Carbon::parse($rusforum->columns_start) > Carbon::now()?Carbon::parse($rusforum->columns_start):null) :null,
                    'created_at' => $rusforum->columns_date&&$rusforum->columns_time?Carbon::parse($rusforum->columns_date.' '.$rusforum->columns_time):Carbon::now(),
                    'approved' => 1,
                    'news' => 0,
                    'forum_icon_id' => (int)$forum_icons->id,
                ];
            }

            \App\ForumTopic::insert($new_forum_topics);

            $j = $i +1;
            echo "News seeded ($j/$cycles) \n";
        }

        $users = null;
        $users_id = null;
    }

    /**
     * seed User Friends
     */
    protected function seedUserFriends()
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') . '.friends')->count());

        $users = [];
        $users_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $users_friends = DB::table(env('DB_DATABASE_OLD') . '.friends')->orderBy('user_id')->offset(1000 * $i)->limit(1000)->get();

            $new_users_friends = [];
            $time = Carbon::now();
            foreach ($users_friends as $users_friend) {
                if(in_array($users_friend->user_id, $users_id)){
                    $user = $users[$users_friend->user_id];
                } else{
                    $user = User::where('reps_id', $users_friend->user_id)->first();
                    $users[$users_friend->user_id] = $user;
                    $users_id[] = $users_friend->user_id;
                }

                if(in_array($users_friend->friend_id, $users_id)){
                    $friend = $users[$users_friend->friend_id];
                } else{
                    $friend = User::where('reps_id', $users_friend->friend_id)->first();
                    $users[$users_friend->friend_id] = $friend;
                    $users_id[] = $users_friend->friend_id;
                }

                $new_users_friends[] = [
                    'user_id' => (int)$user->id ?? 0,
                    'friend_user_id' => (int)$friend->id ?? 0,
                    'created_at' => $time,
                ];
            }

            UserFriend::insert($new_users_friends);

            $j = $i +1;
            echo "User Friends seeded ($j/$cycles)\n";
        }

        $users = null;
        $users_id = null;
    }

    /**
     * Seed Forum Topic
     * 
     * @param $table
     */
    protected function seedForumTopic($table)
    {
        $forum_section = ForumSection::all();
        $forum_icons = ForumIcon::all();
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') . '.'. $table)->count());
        $users = [];
        $users_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $rusforums = DB::table(env('DB_DATABASE_OLD') . '.'. $table)->orderBy('forum_id')->offset(1000 * $i)->limit(1000)->get();
            $new_forum_topics = [];

            foreach ($rusforums as $rusforum) {
                $section_id = $forum_section->where('reps_id', $rusforum->rub_id)->first()->id ?? 1;

                if(in_array($rusforum->user_id, $users_id)){
                    $user = $users[$rusforum->user_id];
                } else{
                    $user = User::where('reps_id', $rusforum->user_id)->first();
                    $users[$rusforum->user_id] = $user;
                    $users_id[] = $rusforum->user_id;
                }

                $new_forum_topics[] = [
                    'reps_id' => (int)$rusforum->forum_id,
                    'section_id' => (int)$section_id,
                    'title' => $rusforum->forum_title,
                    'content' => $rusforum->forum_text,
                    'user_id' => (int)$user->id ?? 1,
                    'reviews' => $rusforum->forum_view,
                    'created_at' => self::correctDate($rusforum->forum_date && $rusforum->forum_time ? Carbon::parse($rusforum->forum_date . ' ' . $rusforum->forum_time) : Carbon::now()),
                    'approved' => $rusforum->forum_open,
                    'news' => 0,
                    'forum_icon_id' => (int)$forum_icons->where('id', $rusforum->forum_icon)->first()->id ?? $forum_icons->first()->id,
                ];
            }

            \App\ForumTopic::insert($new_forum_topics);

            $j = $i +1;
            echo "Forum Topic seeded ($j/$cycles)\n";
        }
        $users = null;
        $users_id = null;
    }

    /**
     * Seed News Comments
     *
     * @param $table
     */
    protected function seedNewsComments($table)
    {
        $data = DB::table(env('DB_DATABASE_OLD') .'.'.$table);

        if ($table != 'engnewscomments'){
            $data->where('type', 'news');
        }

        $cycles = self::getCycles($data->count());

        $users = [];
        $users_id = [];
        $topics = [];
        $topics_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $old_topic_comments = DB::table(env('DB_DATABASE_OLD') .'.'.$table);

            if ($table != 'engnewscomments'){
                $old_topic_comments->where('type', 'news');
            }

            $old_topic_comments = $old_topic_comments->orderBy('comment_id')->offset(1000 * $i)->limit(1000)->get();

            $new_topic_comment = [];
            foreach ($old_topic_comments as $old_topic_comment) {
                if(in_array($old_topic_comment->user_id, $users_id)){
                    $user = $users[$old_topic_comment->user_id];
                } else{
                    $user = User::where('reps_id', $old_topic_comment->user_id)->first();
                    $users[$old_topic_comment->user_id] = $user;
                    $users_id[] = $old_topic_comment->user_id;
                }

                if(in_array($old_topic_comment->news_id, $topics_id)){
                    $forum_topic = $topics[$old_topic_comment->news_id];
                } else {
                    $forum_topic = ForumTopic::where('reps_id', $old_topic_comment->news_id)->where('news', 1)->first();
                    $topics[$old_topic_comment->news_id] = $forum_topic;
                    $topics_id[] = $old_topic_comment->news_id;
                }

                $new_topic_comment[] = [
                    'user_id' => (int)$user->id ?? 1,
                    'object_id' => (int)$forum_topic->id ?? 0,
                    'relation' => Comment::RELATION_FORUM_TOPIC,
                    'title' => $old_topic_comment->comment_title,
                    'content' => $old_topic_comment->comment_text,
                'created_at' =>  self::correctDate(Carbon::parse($old_topic_comment->comment_date.' '. $old_topic_comment->comment_time)),
                ];
            }

            Comment::insert($new_topic_comment);

            $j = $i +1;
            echo "News comments seeded ($j/$cycles)\n";
        }

        $users = null;
        $users_id = null;
        $topics = null;
        $topics_id = null;
    }

    /**
     * Seed Column Comments
     *
     * @param $table
     */
    protected function seedColumnComments($table)
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') .'.'.$table)->count());

        $users = [];
        $users_id = [];
        $topics = [];
        $topics_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $old_topic_comments = DB::table(env('DB_DATABASE_OLD') .'.'.$table)->orderBy('comment_id')->offset(1000 * $i)->limit(1000)->get();

            $new_topic_comment = [];
            foreach ($old_topic_comments as $old_topic_comment) {
                if(in_array($old_topic_comment->user_id, $users_id)){
                    $user = $users[$old_topic_comment->user_id];
                } else{
                    $user = User::where('reps_id', $old_topic_comment->user_id)->first();
                    $users[$old_topic_comment->user_id] = $user;
                    $users_id[] = $old_topic_comment->user_id;
                }

                if(in_array($old_topic_comment->columns_id, $topics_id)){
                    $forum_topic = $topics[$old_topic_comment->columns_id];
                } else {
                    $forum_topic = ForumTopic::where('reps_id', $old_topic_comment->columns_id)->where('reps_section', "columns")->first();
                    $topics[$old_topic_comment->columns_id] = $forum_topic;
                    $topics_id[] = $old_topic_comment->columns_id;
                }

                $new_topic_comment[] = [
                    'user_id' => (int)$user->id ?? 1,
                    'object_id' => (int)$forum_topic->id ?? 0,
                    'relation' => Comment::RELATION_FORUM_TOPIC,
                    'title' => $old_topic_comment->comment_title,
                    'content' => $old_topic_comment->comment_text,
                    'created_at' =>  self::correctDate(Carbon::parse($old_topic_comment->comment_date.' '. $old_topic_comment->comment_time)),
                ];
            }

            Comment::insert($new_topic_comment);

            $j = $i +1;
            echo "News comments seeded ($j/$cycles)\n";
        }

        $users = null;
        $users_id = null;
        $topics = null;
        $topics_id = null;
    }

    /**
     * Seed Replays Comments
     *
     */
    protected function seedReplayComments()
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') .'.rusreplaycomments')->count());

        $users = [];
        $users_id = [];
        $replays = [];
        $replays_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $old_replay_comments = DB::table(env('DB_DATABASE_OLD') .'.rusreplaycomments')->orderBy('comment_id')->offset(1000 * $i)->limit(1000)->get();

            $new_replay_comment = [];
            foreach ($old_replay_comments as $old_replay_comment) {
                if(in_array($old_replay_comment->user_id, $users_id)){
                    $user = $users[$old_replay_comment->user_id];
                } else{
                    $user = User::where('reps_id', $old_replay_comment->user_id)->first();
                    $users[$old_replay_comment->user_id] = $user;
                    $users_id[] = $old_replay_comment->user_id;
                }

                if(in_array($old_replay_comment->replay_id, $replays_id)){
                    $replay = $replays[$old_replay_comment->replay_id];
                } else {
                    $replay = Replay::where('reps_id', $old_replay_comment->replay_id)->first();
                    $replays[$old_replay_comment->replay_id] = $replay;
                    $replays_id[] = $old_replay_comment->replay_id;
                }

                $new_replay_comment[] = [
                    'user_id' => (int)$user->id ?? 1,
                    'object_id' => (int)$replay->id ?? 0,
                    'relation' => Comment::RELATION_REPLAY,
                    'title' => $old_replay_comment->comment_title,
                    'content' => $old_replay_comment->comment_text,
                    'created_at' =>  self::correctDate(Carbon::parse($old_replay_comment->comment_date.' '. $old_replay_comment->comment_time)),
                ];
            }

            Comment::insert($new_replay_comment);

            $j = $i +1;
            echo "Replay comments seeded ($j/$cycles)\n";
        }

        $users = null;
        $users_id = null;
        $replays = null;
        $replays_id = null;
    }

    /**
     * Seed replays
     */
    protected function seedReplay()
    {
        $cycles = self::getCycles(\DB::table(env('DB_DATABASE_OLD') . '.replays')->count());

        $countries = Country::all();
        $maps = ReplayMap::all();
        $game_versions = GameVersion::all();
        $types = ReplayType::all();
        $replay_n = 0;
        $users = [];
        $users_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $old_replays = DB::table(env('DB_DATABASE_OLD') . '.replays')->orderBy('replay_id')->offset(1000 * $i)->limit(1000)->get();

            $new_replays = [];
            foreach ($old_replays as $old_replay) {
                if ($old_replay->replay_file) {
                    if(in_array($old_replay->user_id, $users_id)){
                        $user = $users[$old_replay->user_id];
                    } else{
                        $user = User::where('reps_id', $old_replay->user_id)->first();
                        $users[$old_replay->user_id] = $user;
                        $users_id[] = $old_replay->user_id;
                    }

                    $file_id = 0;
                    $path_to = "./public/storage/replays/{$old_replay->replay_file}";

                    if (@fopen($path_to, 'r')) {
                        $file_data = [
                            'user_id' => (int)$user->id ?? 1,
                            'title' => "Replay {$old_replay->replay_name}",
                            'link' => "/storage/replays/{$old_replay->replay_file}",
                            'type' => filetype($path_to),
                            'size' => filesize($path_to),
                        ];

                        $replay_n++;
                        $file = App\File::create($file_data);
                        $file_id = $file->id;
                    }

                    $new_replays[] = [
                        'user_id'           => (int)$user->id ?? 1,
                        'user_replay'       => in_array($old_replay->replay_type, ['uduel', 'upack', 'uteam']),
                        'type_id'           => (int)$types->where('name', substr($old_replay->replay_type, 1))->first()->id ?? $types->first()->id,
                        'title'             => $old_replay->replay_name,
                        'content'           => $old_replay->replay_rustext,
                        'map_id'            => (int)$old_replay->replay_map ? $maps->where('name', $old_replay->replay_map)->first()->id ?? 0 : 0,
                        'file_id'           => (int)$file_id,
                        'championship'      => $old_replay->replay_event,
                        'first_country_id'  => (int)$countries->where('name', $old_replay->replay_countryv)->first()->id ?? 0,
                        'second_country_id' => (int)$countries->where('name', $old_replay->replay_countryd)->first()->id ?? 0,
                        'first_race'        => $old_replay->replay_racev??'0',
                        'second_race'       => $old_replay->replay_raced??'0',
                        'downloaded'        => $old_replay->replay_dl,
                        'length'            => '00:00:00',
                        'created_at'        => self::correctDate(Carbon::parse($old_replay->replay_date . ' ' . $old_replay->replay_time)),
                        'reps_id'           => (int)$old_replay->replay_id,
                        'first_location'    => (int)$old_replay->replay_expv??0,
                        'second_location'   => (int)$old_replay->replay_expd??0,
                        'creating_rate'     => in_array((string)$old_replay->replay_rating,['7','8','9','10','Cool','Best'])?(string)$old_replay->replay_rating:'10',
                        'game_version_id'   => (int)$game_versions->where('version', $old_replay->replay_version)->first()->id,
                        'approved'          => 1,
                    ];
                }
            }
            Replay::insert($new_replays);

            $j = $i + 1;
            echo "Replay seeded ($j/$cycles)\n";
        }
        $users = null;
        $users_id = null;
    }

    /**
     * Seed ignore list
     */
    protected function seedIgnoreList()
    {
        $cycles = self::getCycles(\DB::table(env('DB_DATABASE_OLD') . '.ignore_list')->count());

        $users = [];
        $users_id = [];

        for ($i = 0; $i < $cycles; $i++) {
            $old_ignores = DB::table(env('DB_DATABASE_OLD') . '.ignore_list')->orderBy('user_id')->offset(1000 * $i)->limit(1000)->get();

            $new_ignores = [];
            foreach ($old_ignores as $old_ignore) {
                if (in_array($old_ignore->user_id, $users_id)) {
                    $user = $users[$old_ignore->user_id];
                } else {
                    $user = User::where('reps_id', $old_ignore->user_id)->first();
                    $users[$old_ignore->user_id] = $user;
                    $users_id[] = $old_ignore->user_id;
                }

                if (in_array($old_ignore->ignore_id, $users_id)) {
                    $ignored = $users[$old_ignore->ignore_id];
                } else {
                    $ignored = User::where('reps_id', $old_ignore->ignore_id)->first();
                    $users[$old_ignore->ignore_id] = $ignored;
                    $users_id[] = $old_ignore->ignore_id;
                }

                $new_ignores[] = [
                    'user_id' => (int)$user->id ?? 0,
                    'ignored_user_id' => (int)$ignored->id ?? 0,
                ];
            }
            IgnoreUser::insert($new_ignores);

            $j = $i + 1;
            echo "Ignore list seeded ($j/$cycles)\n";
        }
        $users = null;
        $users_id = null;
    }

    /**
     * Seed ignore list
     */
    protected function seedMessages()
    {
        $cycles = self::getCycles(\DB::table(env('DB_DATABASE_OLD') . '.messages')->count());

        $users = [];
        $users_id = [];
        $users_dialogs = [];

        for ($i = 0; $i < $cycles; $i++) {
            $old_messages = DB::table(env('DB_DATABASE_OLD') . '.messages')->orderBy('id')->offset(1000 * $i)->limit(1000)->get();

            $new_messages = [];
            foreach ($old_messages as $old_message) {
                if (!(in_array([$old_message->from_id, $old_message->to_id], $users_dialogs)||
                    in_array([$old_message->to_id, $old_message->from_id], $users_dialogs))) {
                    $users_dialogs[] = [$old_message->from_id, $old_message->to_id];
                    if (in_array([$old_message->from_id], $users_id)) {
                        $from = $users[$old_message->from_id];
                    } else {
                        $from = User::where('reps_id', $old_message->from_id)->first();
                        $users[$old_message->from_id] = $from;
                        $users_id[] = $old_message->from_id;
                    }

                    if (in_array([$old_message->to_id], $users_id)) {
                        $to = $users[$old_message->to_id];
                    } else {
                        $to = User::where('reps_id', $old_message->to_id)->first();
                        $users[$old_message->to_id] = $to;
                        $users_id[] = $old_message->to_id;
                    }

                    $old_dialogs = DB::table(env('DB_DATABASE_OLD') . '.messages')->where(
                        function ($q) use ($old_message){
                            $q->where(function ($q1) use ($old_message){
                                $q1->where('from_id', $old_message->from_id)
                                    ->where('to_id', $old_message->to_id);
                            })->orWhere(function ($q2) use ($old_message){
                                $q2->where('to_id', $old_message->from_id)
                                    ->where('from_id', $old_message->to_id);
                            });
                        }
                    )->orderBy('id')->get();

                    $new_dialog = new Dialogue();
                    $new_dialog->name = $old_message->title;
                    $new_dialog->save();

                    $new_dialog->users()->attach([$from->id??0, $to->id??0]);

                    foreach ($old_dialogs as $dialog){
                        $from = $users[$dialog->from_id];

                        $new_messages[] = [
                            'user_id'       => (int)$from->id??0,
                            'message'       => $dialog->text,
                            'is_read'       => $dialog->read,
                            'dialogue_id'   => (int)$new_dialog->id,
                            'created_at'   => self::correctDate(Carbon::createFromTimestamp($dialog->date)),
                        ];
                    }
                }
            }

            UserMessage::insert($new_messages);

            $j = $i + 1;
            echo "Dialog seeded ($j/$cycles)\n";
        }

        $users = null;
        $users_id = null;
    }

    /**
     * Update section for Interview
     */
    protected function updateInterview(){
        $section_id = ForumSection::where('name', 'interview')->first()->id??3;
        ForumTopic::where('reps_section', 'like', '%interview%')->update(['section_id' => $section_id]);
    }

    /**
     * Update section for Coverage
     */
    protected function updateCoverage(){
        $section_id = ForumSection::where('name', 'coverage')->first()->id??7;
        ForumTopic::where('reps_section', 'like', '%coverage%')->update(['section_id' => $section_id]);
    }

    /**
     * @param $count
     * @return int
     */
    public static function getCycles($count)
    {
        return ((int)($count / 1000)) + (($count % 1000 > 0) ? 1 : 0);
    }

    /**
     * @param $user
     * @return int
     */
    public static function getUserRole($user)
    {
        $user_roles = self::$user_roles;

        $role = 0;
        switch ($user->user_admin){
            case 1:
                $role = $user_roles->where('name', 'admin')->first()->id;
                break;
            case 2:
                $role = $user_roles->where('name', 'moderator')->first()->id;
                break;
        }

        return $role;
    }

    /**
     * @param Carbon $date
     * @return Carbon
     */
    public static function correctDate(Carbon $date)
    {
        foreach (self::$revert_dates as $revert_date) {
            if ($revert_date['start'] <= $date && $date < $revert_date['end']){
                $date->addHour(1);
            }
        }

        return $date;
    }
}
