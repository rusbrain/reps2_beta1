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
            [ 'name' => 'duel', 'title' => '1x1'],
            [ 'name' => 'pack', 'title' => 'Park / Archive'],
            [ 'name' => 'rotw', 'title' => 'Game of the Week'],
            [ 'name' => 'team', 'title' => '2x2, 3x3, 4x4'],
        ];

        \App\ReplayType::insert($replay_type);
    }
}
