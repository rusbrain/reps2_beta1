<?php

use Illuminate\Database\Seeder;

class UserRoleSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [ 'name' => 'admin', 'title' => 'Администратор'],
            [ 'name' => 'moderator', 'title' => 'Модератор'],
        ];

        \App\UserRole::insert($countries);
    }
}
