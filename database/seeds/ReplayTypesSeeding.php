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
            [ 'name' => 'duel', 'title' => '1 на 1 игра'],
            [ 'name' => 'pack', 'title' => 'Replay паки'],
            [ 'name' => 'rotw', 'title' => 'Replay недели'],
            [ 'name' => 'team', 'title' => 'Коммандная игра'],
        ];

        \App\ReplayType::insert($replay_type);
    }
}
