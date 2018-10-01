<?php

use Illuminate\Database\Seeder;

class ReplayTypesSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [ 'name' => 'uduel',],
            [ 'name' => 'duel',],
            [ 'name' => 'pack',],
            [ 'name' => 'rotw',],
            [ 'name' => 'team',],
            [ 'name' => 'upack',],
            [ 'name' => 'uteam',],
            [ 'name' => 'wrotw',],
        ];

        \App\ReplayType::insert($countries);
    }
}
