<?php

use Illuminate\Database\Seeder;

class ForumSectionIconsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $icons = [
            'all'=>'icon_general.png',
            'columns' =>'icon_columns.png',
            'event' =>'icon_championship.png',
            'interview' =>'icon_interview.png',
            'article' =>'icon_posts.png',
            'strategy' =>'icon_strategy.png',
            'coverage' =>'icon_reports.png',
            'clans' =>'icon_klan.png',
            'vod' =>'icon_vod.png',
            'humor' =>'icon_humor.png',
            'music_and_video' =>'icon_music.png',
            'help' =>'icon_help.png',
            'star_craft_2' =>'icon_craft.png',
            'poker' =>'icon_poker.png',
            'politics' =>'icon_politic.png',
            'business' =>'icon_business.png',
            'games' =>'icon_game.png',
        ];

        foreach ($icons as $key=>$icon) {
            $ic = new \App\SectionIcon();
            $ic->icon = '/images/icons/'.$icon;
            $ic->save();

            \App\ForumSection::where('name', $key)->update(['section_icon_id' => $ic->id]);
        }
    }
}
