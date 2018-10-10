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
        // Seed Files
        $files = [];
        for ($i = 1; $i < 37; $i++){
            $files[]  = ['title' => 'User Avatar', 'link' => '/test_img/'.$i.'.jpg'];
        }
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
            ];

            $questions[] = [
                'question'      => 'Вопрос № '. $i,
                'is_favorite'   => array_rand([0,1]),
                'for_login'     => array_rand([0,1]),
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
                'user_id' => $user_ids[array_rand($user_ids)],
                'file_id' => $file_ids[array_rand($file_ids)],
                'comment' => 'Comment to Image '.$i,
            ];
        }
        \App\UserGallery::insert($gellery_data);

        $user_friends = [];
        $user_message = [];
        $ignore_users = [];

        for($i = 0; $i < 10; $i++)
        {
            for($j = $i+1; $j < 10; $j++)
            {
                $user_friends[] = [
                    'user_id'           => $user_ids[$j],
                    'friend_user_id'    => $user_ids[$i],
                ];

                $user_message[] = [
                    'user_sender_id' => $user_ids[$i],
                    'user_recipient_id' => $user_ids[array_rand($user_ids)],
                    'message' => "Тестовое сообщение $i - $j",
                ];
            }

            $ignore_users[] = [
                'user_id' => $user_ids[$i],
                'ignored_user_id' => $user_ids[array_rand($user_ids)],
            ];

        }

        //seed user friends
        \App\UserFriend::insert($user_friends);

        //seed user messages
        \App\UserMessage::insert($user_message);

        //seed ignore users
        \App\IgnoreUser::insert($ignore_users);


    }

    private static function getIds($objects, $inp_array)
    {
        foreach ($objects as $object){
            $inp_array[] = $object->id;
        }

        return $inp_array;
    }
}
