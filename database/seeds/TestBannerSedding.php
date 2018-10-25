<?php

use Illuminate\Database\Seeder;

class TestBannerSedding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = \App\File::where(function ($q){
            $q ->where('title', 'User Avatar')->orWhere('title', 'Topic IMG');
        })->get(['id']);
        $file_ids = UserTestDataSeeding::getIds($files, []);

        $banners = [];
        for($i=0; $i<10; $i++){
        $banners[] = [
            'title'         => 'Банер '.$i,
            'file_id'       => $file_ids[array_rand($file_ids)],
            'url_redirect'  => route('home'),
            'is_active'     => rand(0,1),
            ];
        }

        \App\Banner::insert($banners);
    }
}
