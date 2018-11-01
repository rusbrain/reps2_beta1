<?php

use Illuminate\Database\Seeder;

class ForumIconSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forum_icone = [
            ["icon"=>'<i class="fa fa-file-text-o"></i>'],
            ["icon"=>'<i class="fa fa-long-arrow-right"></i>'],
            ["icon"=>'<i class="fa fa-lightbulb-o"></i>'],
            ["icon"=>'<i class="fa fa-exclamation-triangle"></i>'],
            ["icon"=>'<i class="fa fa-question-circle"></i>'],
            ["icon"=>'<i class="fa fa-hand-peace-o"></i>'],
            ["icon"=>'<i class="fa fa-smile-o"></i>'],
            ["icon"=>'<i class="fa fa-thumbs-o-down"></i>'],
            ["icon"=>'<i class="fa fa-volume-up"></i>'],
            ["icon"=>'<i class="fa fa-unlock-alt"></i>'],
            ];

        \App\ForumIcon::insert($forum_icone);
    }
}
