<?php

namespace App\Providers;

use App\ForumSection;
use App\InterviewQuestion;
use App\Replay;
use App\User;
use App\UserGallery;
use App\UserMessage;
use Illuminate\Support\Facades\Auth;
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
        $data_img = UserGallery::with('file')->orderBy('created_at', 'desc')->limit(5000)->get()->toArray();
        $random_img = $data_img?array_rand($data_img,(count($data_img)>4?4:count($data_img))):[];

        $random_question = InterviewQuestion::getRandomQuestion();

        $last_forum = ForumSection::general_active()->with(['topics' =>function($query){
            $query->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);
        }])->get();

        $last_gosu_replay = Replay::gosuReplay()->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);
        $last_user_replay = Replay::userReplay()->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);

        $new_users = User::where('is_ban',0)->orderBy('created_at')->limit(10)->get();
        $new_user_message = 0;

        if (Auth::user()){
            $new_user_message = UserMessage::where('user_recipient_id', Auth::id())->where('is_read',0)->count();
        }

        View::share([
            'random_img'        => $random_img,
            'random_question'   => $random_question,
            'last_forum'        => $last_forum,
            'last_gosu_replay'  => $last_gosu_replay,
            'last_user_replay'  => $last_user_replay,
            'new_user_message'  => $new_user_message,
            'new_users'         => $new_users
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
