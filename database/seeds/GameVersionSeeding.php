<?php

use Illuminate\Database\Seeder;

class GameVersionSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $game_versions = [
            ["version"=>'1.09'],
            ["version"=>'1.10'],
            ["version"=>'1.11'],
            ["version"=>'1.12'],
            ["version"=>'1.13'],
            ["version"=>'1.14'],
            ["version"=>'1.15'],
            ["version"=>'1.16'],
            ["version"=>'1.16'],
            ["version"=>'1.17'],
            ["version"=>'All']];

        \App\GameVersion::insert($game_versions);
    }
}
