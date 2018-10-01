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
            [ 'name' => 'duel',],
            [ 'name' => 'pack',],
            [ 'name' => 'rotw',],
            [ 'name' => 'team',],
        ];

        \App\ReplayType::insert($countries);
    }
}
