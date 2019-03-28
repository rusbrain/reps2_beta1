<?php

namespace App\Providers;

use App\Comment;
use App\ForumTopic;
use App\Observers\CommentObserver;
use App\Observers\ForumTopicPointsObserver;
use App\Observers\ReplayPointsObserver;
use App\Observers\UserGalleryPointsObserver;
use App\Observers\UserReputationObserver;
use App\Replay;
use App\UserGallery;
use App\UserReputation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Comment::observe(CommentObserver::class);
        UserReputation::observe(UserReputationObserver::class);
        ForumTopic::observe(ForumTopicPointsObserver::class);
        UserGallery::observe(UserGalleryPointsObserver::class);
        Replay::observe(ReplayPointsObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * ide-helper - only for dev
         */
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        // ...
    }
}
