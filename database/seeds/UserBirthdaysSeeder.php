<?php

use Illuminate\Database\Seeder;

class UserBirthdaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get all users
        /**@var \App\User[] $users*/
        $users = \App\User::all();
        $i=0;
        foreach ($users as $user) {
            if(is_null($user->birthday)){
                $user->birthday = '2010-01-01';
                $user->save();
            }
            $i++;
        }
    }
}
