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
        $replay_type = [
            [ 'name' => 'duel',],
            [ 'name' => 'pack',],
            [ 'name' => 'rotw',],
            [ 'name' => 'team',],
        ];

        \App\ReplayType::insert($replay_type);
    }
}
