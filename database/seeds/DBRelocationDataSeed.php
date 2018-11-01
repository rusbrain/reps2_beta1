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
//        // Old users seeding
//        echo "1. Users and Avatars seed start \n";
//        $this->seedUser(self::$country);
//        echo "Users and Avatars seed finished \n\n";
//
//        //Update users avatars file
//        echo "2. Update users avatars file start \n";
//        $this->updateAvatarFile();
//        echo "Update users avatars file finished \n\n";
//
//        //User Gallery seeding
//        echo "3. User Gallery seed start \n";
//        $this->seedUserGallery();
//        echo "User Gallery seed finished \n\n";
//
//        //User Gallery Comments seeding
//        echo "4. User Gallery Comments seed start \n";
//        $this->seedUserGalleryComments();
//        echo "User Gallery Comments seed finished \n\n";
//
//        //User Friends seeding
//        echo "5. User Friends seed start \n";
//        $this->seedUserFriends();
//        echo "User Friends seed finished \n\n";

        //new
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
        $this->seedTopicComments('rusforumreply');
        echo "Forum Topic Comment Eng seed finished \n\n";
    }

    /**
     * Old users seeding
     *
     * @param $user_roles
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
                        $path_from = "http://reps.ru/avatars/{$old_user->user_avatar}";
                        $path_to   = "./public/storage/avatars/{$old_user->user_avatar}";

                        if(@fopen($path_from, 'r')){
                            if(copy($path_from, $path_to)){
                                $file_data = [
                                    'user_id' => 0,
                                    'title' => "Аватар {$old_user->user_name}",
                                    'link' => "/storage/avatars/{$old_user->user_avatar}",
                                    'type' => 'image/*',
                                    'size' => filesize($path_to),
                                ];

                                $file = File::create($file_data);
                                $avatar_id = $file->id;
                            }
                        }
                    }

                    $new_users[] = [
                        'reps_id' => $old_user->user_id,
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

        for ($i = 0; $i < $cycles; $i++) {
            $old_galleries = DB::table(env('DB_DATABASE_OLD') . '.usergallery')->orderBy('photo_id')->offset(1000 * $i)->limit(1000)->get();

            $new_gallery = [];
            foreach ($old_galleries as $old_gallery) {
                $path_from = "http://reps.ru/usergallery/{$old_gallery->photo_id}.jpg";
                $path_to = "./public/storage/gallery/{$old_gallery->photo_id}.jpg";

                if (@fopen($path_from, 'r')) {
                    if (copy($path_from, $path_to)) {
                        $user = \App\User::where('reps_id', $old_gallery->user_id)->first();
                        $user_name = $user->name ?? '';

                        $file_data = [
                            'user_id' => $user->id ?? 0,
                            'title' => "Картинка галлереи пользователя {$user_name}",
                            'link' => "/storage/gallery/{$old_gallery->photo_id}.jpg",
                            'type' => 'image/jpeg',
                            'size' => filesize($path_to),
                        ];

                        $file = File::create($file_data);
                        $file_id = $file->id;

                        $new_gallery[] = [
                            'reps_id' => $old_gallery->photo_id,
                            'user_id' => $user->id ?? 1,
                            'file_id' => $file_id,
                            'comment' => $old_gallery->title,
                            'created_at' => $old_gallery->date != 0 ? self::correctDate(Carbon::createFromTimestamp($old_gallery->date)) : Carbon::now(),
                            'for_adults' => $old_gallery->adult == 'yes',
                        ];
                    }
                }
            }

            UserGallery::insert($new_gallery);

            $j = $i +1;
            echo "User Gallery seeded ($j/$cycles)\n";
        }
    }

    /**
     * seed User Gallery Comments
     */
    protected function seedUserGalleryComments()
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') . '.rusnewscomments')->where('type', 'userphoto')->count());

        for ($i = 0; $i < $cycles; $i++) {
            $old_gallery_comments = DB::table(env('DB_DATABASE_OLD') . '.rusnewscomments')->where('type', 'userphoto')->orderBy('comment_id')->offset(1000 * $i)->limit(1000)->get();

            $new_gallery_comment = [];
            foreach ($old_gallery_comments as $old_gallery_comment) {
                $user = User::where('reps_id', $old_gallery_comment->user_id)->first();
                $user_gallery = UserGallery::where('reps_id', $old_gallery_comment->news_id)->first();

                $new_gallery_comment[] = [
                    'user_id' => $user->id ?? 1,
                    'object_id' => $user_gallery->id ?? 0,
                    'relation' => Comment::RELATION_USER_GALLERY,
                    'title' => $old_gallery_comment->comment_title,
                    'content' => mb_convert_encoding(substr($old_gallery_comment->comment_text,0,10000), "UTF-8"),
                    'created_at' =>  self::correctDate(Carbon::parse($old_gallery_comment->comment_date.' '. $old_gallery_comment->comment_time)),
                ];
            }

            Comment::insert($new_gallery_comment);

            $j = $i +1;
            echo "Gallery comments seeded ($j/$cycles)\n";
        }
    }

    /**
     * seed Topic Comments
     */
    protected function seedTopicComments($table)
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') .'.'.  $table)->count());

        for ($i = 0; $i < $cycles; $i++) {
            $old_topic_comments = DB::table(env('DB_DATABASE_OLD') .'.'.  $table)->orderBy('reply_id')->offset(1000 * $i)->limit(1000)->get();

            $new_topic_comment = [];
            foreach ($old_topic_comments as $old_topic_comment) {
                $user = User::where('reps_id', $old_topic_comment->user_id)->first();
                $forum_topic = ForumTopic::where('reps_id', $old_topic_comment->forum_id)->first();

                $new_topic_comment[] = [
                    'user_id' => $user->id ?? 1,
                    'object_id' => $forum_topic->id ?? 0,
                    'relation' => Comment::RELATION_FORUM_TOPIC,
                    'title' => $old_topic_comment->reply_title,
                    'content' => mb_convert_encoding(substr($old_topic_comment->reply_text,0,10000), "UTF-8"),
                    'created_at' =>  self::correctDate(Carbon::parse($old_topic_comment->reply_date.' '. $old_topic_comment->reply_time)),
                ];
            }

            Comment::insert($new_topic_comment);

            $j = $i +1;
            echo "Forum Topic comments seeded ($j/$cycles)\n";
        }
    }

    /**
     * seed User Friends
     */
    protected function seedUserFriends()
    {
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') . '.friends')->count());

        for ($i = 0; $i < $cycles; $i++) {
            $users_friends = DB::table(env('DB_DATABASE_OLD') . '.friends')->orderBy('user_id')->offset(1000 * $i)->limit(1000)->get();

            $new_users_friends = [];
            $time = Carbon::now();
            foreach ($users_friends as $users_friend) {
                $user = User::where('reps_id', $users_friend->user_id)->first();
                $friend = User::where('reps_id', $users_friend->friend_id)->first();

                $new_users_friends[] = [
                    'user_id' => $user->id ?? 0,
                    'friend_user_id' => $friend->id ?? 0,
                    'created_at' => $time,
                ];
            }

            UserFriend::insert($new_users_friends);

            $j = $i +1;
            echo "User Friends seeded ($j/$cycles)\n";
        }
    }

    /**
     * Seed Forum Topic
     */
    protected function seedForumTopic($table)
    {
        $forum_section = ForumSection::all();
        $forum_icons = ForumIcon::all();
        $cycles = self::getCycles(DB::table(env('DB_DATABASE_OLD') . '.'. $table)->count());

        for ($i = 0; $i < $cycles; $i++) {
            $rusforums = DB::table(env('DB_DATABASE_OLD') . '.'. $table)->orderBy('forum_id')->offset(1000 * $i)->limit(1000)->get();
            $new_forum_topics = [];

            foreach ($rusforums as $rusforum) {
                $section_id = $forum_section->where('reps_id', $rusforum->rub_id)->first()->id ?? 1;
                $user = User::where('reps_id', $rusforum->user_id)->first();

                $new_forum_topics[] = [
                    'reps_id' => $rusforum->forum_id,
                    'section_id' => $section_id,
                    'title' => $rusforum->forum_title,
                    'content' => mb_convert_encoding(substr($rusforum->forum_text, 0, 10000), "UTF-8"),
                    'user_id' => $user->id ?? 1,
                    'reviews' => $rusforum->forum_view,
                    'created_at' => self::correctDate($rusforum->forum_date && $rusforum->forum_time ? Carbon::parse($rusforum->forum_date . ' ' . $rusforum->forum_time) : Carbon::now()),
                    'approved' => $rusforum->forum_open,
                    'news' => 0,
                    'forum_icon_id' => $forum_icons->where('id', $rusforum->forum_icon)->first()->id ?? $forum_icons->first()->id,
                ];
            }

            \App\ForumTopic::insert($new_forum_topics);

            $j = $i +1;
            echo "Forum Topic seeded ($j/$cycles)\n";
        }
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
