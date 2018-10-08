<?php

namespace App\Providers;

use App\ForumSection;
use App\InterviewQuestion;
use App\Replay;
use App\UserGallery;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $random_img = array_rand(UserGallery::with('file')->orderBy('created_at', 'desc')->limit(5000)->get()->toArray(),4);

        $random_question = InterviewQuestion::getRandomQuestion();

        $last_forum = ForumSection::where('is_active', 1)->where('is_general',1)->with(['topics' =>function($query){
            $query->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);
        }]);

        $last_gosu_replay = Replay::gosuReplay()->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);
        $last_user_replay = Replay::userReplay()->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);

        View::share([
            'random_img'        => $random_img,
            'random_question'   => $random_question,
            'last_forum'        => $last_forum,
            'last_gosu_replay'  => $last_gosu_replay,
            'last_user_replay'  => $last_user_replay
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
