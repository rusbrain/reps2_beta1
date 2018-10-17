<?php

use Illuminate\Database\Seeder;

class UserTestDataSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = [];
        for ($i = 1; $i < 37; $i++){
            $files[]  = [
                'title'         => 'User Avatar',
                'link'          => '/test_img/'.$i.'.jpg',
                'created_at'    => Carbon\Carbon::now(),
                'updated_at'    => Carbon\Carbon::now(),
                ];
        }

        for ($i = 1; $i < 19; $i++){
            $files[]  = [
                'title'         => 'Topic IMG',
                'link'          => '/test_img/for_topic/'.$i.'.jpg',
                'created_at'    => Carbon\Carbon::now(),
                'updated_at'    => Carbon\Carbon::now(),
                ];
        }

        // Seed Files
        \App\File::insert($files);

        $names = ['user_game', 'test_user', 'vasia', 'semen', 'zina','Protey', 'mastaren', 'oTiGeRo', 'Evil_Lord', 'sashaka'];

        $roles = \App\UserRole::get(['id']);
        $role_ids = self::getIds($roles, [0]);
        $countrys = \App\Country::get(['id']);
        $country_ids = self::getIds($countrys, []);
        $files = \App\File::where('title', 'User Avatar')->get(['id']);
        $file_ids = self::getIds($files, []);

        $users = [];
        $questions = [];

        for ($i = 0; $i < 10; $i++){
            $name = $names[$i];
            $users[] = [
                'name'              => $name,
                'email'             => $name.$i.'@gmail.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password'          => \Illuminate\Support\Facades\Hash::make('123456789'),
                'user_role_id'      => $role_ids[array_rand($role_ids)],
                'country_id'        => $country_ids[array_rand($country_ids)],
                'file_id'           => $file_ids[array_rand($file_ids)],
                'is_ban'            => array_rand([0,1]),
                'rep_allow'         => 1,
                'rep_buy'           => 0,
                'rep_sell'          => 0,
                'view_signs'        => array_rand([0,1]),
                'view_avatars'      => array_rand([0,1]),
                'updated_password'  => array_rand([0,1]),
                'created_at'        => Carbon\Carbon::now(),
                'updated_at'        => Carbon\Carbon::now(),
            ];

            $questions[] = [
                'question'      => 'Вопрос № '. $i,
                'is_favorite'   => array_rand([0,1]),
                'for_login'     => array_rand([0,1]),
                'created_at'    => Carbon\Carbon::now(),
                'updated_at'    => Carbon\Carbon::now(),
            ];
        }

        //seed users
        \App\User::insert($users);

        //Seed Questions
        \App\InterviewQuestion::insert($questions);

        $users = \App\User::get(['id']);
        $user_ids = self::getIds($users, []);

        //seed gallery
        $gellery_data = [];
        for($i = 0; $i < 50; $i++){
            $gellery_data[] = [
                'user_id'       => $user_ids[array_rand($user_ids)],
                'file_id'       => $file_ids[array_rand($file_ids)],
                'comment'       => 'Comment to Image '.$i,
                'for_adults'    => rand(0,1),
                'created_at'    => Carbon\Carbon::now(),
                'updated_at'    => Carbon\Carbon::now(),
            ];
        }
        \App\UserGallery::insert($gellery_data);

        $user_friends   = [];
        $user_message   = [];
        $dialogues      = [];
        $ignore_users   = [];
        $dialogue_user  = [];

        for($i = 0; $i < 10; $i++){
            $dialogues[] = ['name' => 'Диалог '.$i];
        }
        
        \App\Dialogue::insert($dialogues);
        
        $dialogues = \App\Dialogue::all();

        foreach ($dialogues as $key=>$dialogue) {
            $user_1 = $user_ids[array_rand($user_ids)];
            do{
                $user_2 = $user_ids[array_rand($user_ids)];
            }while ($user_1 == $user_2);

            $dialogue->users()->attach(['user_id' =>$user_1], ['user_id' =>$user_2]);

            for ($j = 0; $j<rand(2,15); $j++){
                $user_message[] = [
                    'user_id'               => $j%2?$user_1:$user_2,
                    'dialogue_id'           => $dialogue->id,
                    'message'               => "Тестовое сообщение $key - $j",
                    'created_at'            => Carbon\Carbon::now(),
                    'updated_at'            => Carbon\Carbon::now(),
                ];
            }
        }

        //seed user messages
        \App\UserMessage::insert($user_message);

        for($i = 0; $i < 10; $i++)
        {
            for($j = $i+1; $j < 10; $j++)
            {
                $user_friends[] = [
                    'user_id'           => $user_ids[$j],
                    'friend_user_id'    => $user_ids[$i],
                    'created_at'        => Carbon\Carbon::now(),
                    'updated_at'        => Carbon\Carbon::now(),
                ];
            }

            $ignore_users[] = [
                'user_id'           => $user_ids[$i],
                'ignored_user_id'   => $user_ids[array_rand($user_ids)],
                'created_at'        => Carbon\Carbon::now(),
                'updated_at'        => Carbon\Carbon::now(),
            ];
        }

        //seed user friends
        \App\UserFriend::insert($user_friends);
        //seed ignore users
        \App\IgnoreUser::insert($ignore_users);

        $questions = \App\InterviewQuestion::get(['id']);
        $question_ids = self::getIds($questions, []);

        $v_ansver = [];

        foreach ($question_ids as $question_id){
            for($i=1; $i <=5; $i++){
                $v_ansver[] = [
                    'answer'        => "вариант ответа $question_id - $i",
                    'question_id'   => $question_id,
                    'created_at'    => Carbon\Carbon::now(),
                    'updated_at'    => Carbon\Carbon::now(),
                ];
            }
        }

        //seed variant of answers
        \App\InterviewVariantsAnswers::insert($v_ansver);

        $question_w_answers = \App\InterviewQuestion::with('answers')->get();

        $user_answer = [];
        foreach ($question_w_answers as $question_w_answer){
            foreach ($user_ids as $user_id){
                if(!rand(0,1)){
                    $user_answer[] = [
                        'user_id'       => $user_id,
                        'question_id'   => $question_w_answer->id,
                        'answer_id'     => $question_w_answer->answers[array_rand($question_w_answer->answers->toArray())]->id,
                        'created_at'    => Carbon\Carbon::now(),
                        'updated_at'    => Carbon\Carbon::now(),
                    ];
                }
            }
        }

        //seed users answer
        \App\InterviewUserAnswers::insert($user_answer);

        $topic_imgs = \App\File::where('title', 'Topic IMG')->get(['id']);
        $topic_img_ids = self::getIds($topic_imgs, []);
        $forum_sections = \App\ForumSection::get(['id']);
        $forum_sections_ids = self::getIds($forum_sections, []);
        $replay_types = \App\ReplayType::get(['id']);
        $replay_types_ids = self::getIds($replay_types, []);
        $replay_maps = \App\ReplayMap::get(['id']);
        $replay_maps_ids = self::getIds($replay_maps, []);
        $race = ['All', 'Z', 'T','P'];

        $forum_topic = [];
        $perlays = [];

        foreach ($topic_img_ids as $topic_img_id){
            $forum_topic[] = [
                'section_id'        => $forum_sections_ids[array_rand($forum_sections_ids)],
                'title'             => "Тема форума $topic_img_id",
                'user_id'           => $user_ids[array_rand($user_ids)],
                'reviews'           => rand(0,50),
                'approved'          => rand(0,1),
                'preview_file_id'   => $topic_img_id,
                'preview_content'   => "Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.",
                'content'           => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                'created_at'        => Carbon\Carbon::now(),
                'updated_at'        => Carbon\Carbon::now(),
            ];

            $perlays[] = [
                'user_id'           => $user_ids[array_rand($user_ids)],
                'user_replay'       => rand(0,1),
                'type_id'           => $replay_types_ids[array_rand($replay_types_ids)],
                'title'             => "Replay $topic_img_id",
                'content'           => "Replay контент$topic_img_id",
                'map_id'            => $replay_maps_ids[array_rand($replay_maps_ids)],
                'file_id'           => $topic_img_id,
                'game_version'      => rand(1,5),
                'first_country_id'  => $country_ids[array_rand($country_ids)],
                'second_country_id' => $country_ids[array_rand($country_ids)],
                'first_race'        => $race[array_rand($race)],
                'second_race'       => $race[array_rand($race)],
                'evaluation'        => rand(1,10),
                'downloaded'        => rand(0,50),
                'approved'          => rand(0,1),
                'created_at'        => Carbon\Carbon::now(),
                'updated_at'        => Carbon\Carbon::now(),
            ];
        }

        //seed forum topic
        \App\ForumTopic::insert($forum_topic);
        //seed replay
        \App\Replay::insert($perlays);

        $replays = \App\Replay::get(['id']);
        $replay_ids = self::getIds($replays, []);

        $replays_user_rating = [];

        foreach ( $replay_ids as $replay_id){
            for($i = 1; $i <= rand(0,count($user_ids)); $i++){
                $replays_user_rating[] = [
                    'user_id' => $user_ids[$i],
                    'replay_id' => $replay_id,
                    'comment' => "Комментарий к оценке Replay $replay_id",
                    'rating' => rand(1,5),
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now(),
                ];
            }
        }

        //seed replay user rating
        \App\ReplayUserRating::insert($replays_user_rating);

        $comments = [];
        $ratings = [];

        $rating_value = ['-1','1'];

        foreach ($replay_ids as $replay_id){
            $recipient_id  = \App\Replay::find($replay_id)->user_id;

            for ($i = 0; $i < 100; $i++) {
                if(!rand(0,1)){
                    $user_rand_id = $user_ids[array_rand($user_ids)];
                    $comments[] = [
                        'user_id'       => $user_rand_id,
                        'object_id'     => $replay_id,
                        'relation'      => 2,
                        'title'         => "Комментарий пользователя $user_rand_id",
                        'content'       => "Комментарий пользователя $user_rand_id к Replay $replay_id",
                        'created_at'    => Carbon\Carbon::now(),
                        'updated_at'    => Carbon\Carbon::now(),
                    ];
                }
            }

            for($i = 1; $i <= rand(0,count($user_ids)); $i++){
                if(!rand(0,1)){
                    $ratings[] = [
                        'sender_id'     => $user_ids[$i],
                        'recipient_id'  => $recipient_id,
                        'comment'       => "Лайк пользователя $user_ids[$i] за реплей $replay_id",
                        'rating'        => $rating_value[array_rand($rating_value)],
                        'object_id'     => $replay_id,
                        'relation'      => 2,
                        'created_at'    => Carbon\Carbon::now(),
                        'updated_at'    => Carbon\Carbon::now(),
                    ];
                }
            }
        }

        $forum_topics = \App\ForumTopic::all();

        foreach ($forum_topics as $forum_topic){
            for ($i = 0; $i < 100; $i++) {
                if(!rand(0,1)){
                    $user_rand_id = $user_ids[array_rand($user_ids)];
                    $comments[] = [
                        'user_id'       => $user_rand_id,
                        'object_id'     => $forum_topic->id,
                        'relation'      => 1,
                        'title'         => "Комментарий пользователя $user_rand_id",
                        'content'       => "Комментарий пользователя $user_rand_id к теме форума $forum_topic->id",
                        'created_at'    => Carbon\Carbon::now(),
                        'updated_at'    => Carbon\Carbon::now(),
                    ];
                }
            }

            for($i = 1; $i <= rand(0,count($user_ids)); $i++){
                if(!rand(0,1)){
                    $ratings[] = [
                        'sender_id'     => $user_ids[$i],
                        'recipient_id'  => $forum_topic->user_id,
                        'comment'       => "Лайк пользователя $user_ids[$i] за тему форума $forum_topic->id",
                        'rating'        => $rating_value[array_rand($rating_value)],
                        'object_id'     => $forum_topic->id,
                        'relation'      => 1,
                        'created_at'    => Carbon\Carbon::now(),
                        'updated_at'    => Carbon\Carbon::now(),
                    ];
                }
            }
        }

        $user_galleries = \App\UserGallery::all();

        foreach ($user_galleries as $user_gallery){
            for ($i = 0; $i < 100; $i++) {
                if(!rand(0,1)){
                    $user_rand_id = $user_ids[array_rand($user_ids)];
                    $comments[] = [
                        'user_id'       => $user_rand_id,
                        'object_id'     => $user_gallery->id,
                        'relation'      => 3,
                        'title'         => "Комментарий пользователя $user_rand_id",
                        'content'       => "Комментарий пользователя $user_rand_id к фотограции $user_gallery->id",
                        'created_at'    => Carbon\Carbon::now(),
                        'updated_at'    => Carbon\Carbon::now(),
                    ];
                }
            }

            for($i = 1; $i <= rand(0,count($user_ids)); $i++){
                if(!rand(0,1)){
                    $ratings[] = [
                        'sender_id'     => $user_ids[$i],
                        'recipient_id'  => $user_gallery->user_id,
                        'comment'       => "Лайк пользователя $user_ids[$i] за фотографию $user_gallery->id",
                        'rating'        => $rating_value[array_rand($rating_value)],
                        'object_id'     => $user_gallery->id,
                        'relation'      => 3,
                        'created_at'    => Carbon\Carbon::now(),
                        'updated_at'    => Carbon\Carbon::now(),
                    ];
                }
            }
        }

        //seed rating
        \App\UserReputation::insert($ratings);

        //seed rating
        \App\Comment::insert($comments);

        $reputations = \App\UserReputation::all();

        foreach ($reputations as $reputation){
            \App\User::updateRating($reputation->rating, $reputation->recipient_id);

            switch ($reputation->relation){
                case \App\UserReputation::RELATION_USER_GALLERY:
                    \App\UserGallery::updateRating($reputation->rating, $reputation->object_id);
                    break;
                case \App\UserReputation::RELATION_REPLAY:
                    \App\Replay::updateRating($reputation->rating, $reputation->object_id);
                    break;
                case \App\UserReputation::RELATION_FORUM_TOPIC:
                    \App\ForumTopic::updateRating($reputation->rating, $reputation->object_id);
                    break;
            }
        }

        foreach ($replay_ids as $replay_id){
            \App\Replay::updateUserRating($replay_id);
        }
    }

    private static function getIds($objects, $inp_array)
    {
        foreach ($objects as $object){
            $inp_array[] = $object->id;
        }

        return $inp_array;
    }
}
