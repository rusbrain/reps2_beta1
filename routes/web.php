<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test', function (){
    dd(\App\Dialogue::getUserDialogue(2));

});
Route::group(['middleware' => ['auth', 'admin_panel']], function () {
//    Route::get('test', function () {
//        if (!Auth::user()->role) {
//            return redirect('/');
//        }
//        dd(Auth::user()->role);
//    });
});
Route::get('/', 'HomeController@index')                                             ->name('home');
Route::get('/email/verified/{token}', 'Auth\RegisterController@emailVerified')      ->name('email_verified');

Route::middleware(['guest'])->group(function () {
    Route::post('/login', 'Auth\LoginController@userLogin')                         ->name('login');

    Route::group(['prefix' => 'password'], function () {
        Route::get('/update', 'Auth\ResetPasswordController@updateOldPassword')     ->name('get_update_password');
        Route::get('/new/{token}', 'Auth\ResetPasswordController@viewNewPassword')  ->name('update_old_password');
        Route::post('/new', 'Auth\ResetPasswordController@saveNewPassword')         ->name('save_new_password');
        Route::get('/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')   ->name('password.request');
        Route::post('/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')   ->name('password.email');
        Route::get('/reset/{token}', 'Auth\ResetPasswordController@showResetForm')  ->name('password.reset');
        Route::post('/reset', 'Auth\ResetPasswordController@reset')                 ->name('password.update');
    });
});

Route::post('question/{id}/set_answer', 'InterviewQuestionController@setAnswer')    ->name('question.set_answer');
Route::post('question/{id}/view_answer', 'InterviewQuestionController@getResult')   ->name('question.view_answer');

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', 'Auth\LoginController@logout')                             ->name('logout');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')         ->name('registration_form');
    Route::post('/register', 'Auth\RegisterController@register')                    ->name('registration');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('{id}/ignore', 'IgnoreController@setIgnore')                     ->name('user.set_ignore');
        Route::get('{id}/not_ignore', 'IgnoreController@setNotIgnore')              ->name('user.set_not_ignore');
        Route::get('/ignore_list', 'IgnoreController@getIgnoreList')                ->name('user.ignore_list');
        Route::get('{id}/add_friend', 'UserFriendController@addFriend')             ->name('user.add_friend');
        Route::get('{id}/remove_friend', 'UserFriendController@removeFriend')       ->name('user.remove_friend');
        Route::get('/friends_list', 'UserFriendController@getFriendsList')          ->name('user.friends_list');
        Route::get('/edit', 'UserController@edit')                                  ->name('edit_profile');
        Route::post('/save', 'UserController@update')                               ->name('save_profile');

        Route::post('{id}/send_message', 'UserMessagingController@sendMessage')     ->name('user.message.send');
        Route::get('messages', 'UserMessagingController@getCorrespList')            ->name('user.message.get_list');
        Route::get('{id}/messages', 'UserMessagingController@getMessages')          ->name('user.message.get_user_list');
        Route::post('{id}/messages', 'UserMessagingController@loadMessages')        ->name('user.message.load_user_list');
        Route::post('messages/{id}', 'UserMessagingController@getMessage')          ->name('user.message.get');
        Route::post('messages/{id}/update', 'UserMessagingController@updateMessage')->name('user.message.update');
        Route::post('messages/{id}/delete', 'UserMessagingController@removeMessage')->name('user.message.delete');
    });

    Route::get('/{id}', 'UserController@show')                                      ->name('user_profile');

    Route::get('{id}/get_rating', 'RatingController@getRatingUser')                 ->name('user.get_rating');
    Route::get('{id}/replay', 'ReplayUsersController@getUserReplay')                ->name('user.user_replay');
    Route::get('{id}/gosu_replay', 'ReplayGosuController@getUserReplay')            ->name('user.gosu_replay');
});

Route::group(['prefix' => 'forum'], function () {
    Route::get('/', 'ForumController@index')                                        ->name('forum.index');

    Route::group(['prefix' => 'section'], function () {
        Route::get('/{name}', 'ForumController@section')                            ->name('forum.section.index');
    });

    Route::group(['prefix' => 'topic'], function () {
        Route::post('{id}/get_rating', 'TopicRatingController@getRating')           ->name('forum.topic.get_rating');

        Route::group(['middleware' => 'auth'], function () {
            Route::get('/create', 'ForumTopicController@create')                    ->name('forum.topic.create');
            Route::post('/store', 'ForumTopicController@store')                     ->name('forum.topic.store');
            Route::get('{id}/delete', 'ForumTopicController@destroy')               ->name('forum.topic.delete');
            Route::get('{id}/edit', 'ForumTopicController@edit')                    ->name('forum.topic.edit');
            Route::post('{id}/update', 'ForumTopicController@update')               ->name('forum.topic.update');
            Route::post('{id}/rebase', 'ForumTopicController@rebase')               ->name('forum.topic.rebase');
            Route::post('{id}/set_rating', 'TopicRatingController@setRating')       ->name('forum.topic.set_rating');

            Route::group(['prefix' => 'comment'], function () {
                Route::post('/store', 'TopicCommentController@store')               ->name('forum.topic.comment.store');
                Route::get('{id}/delete', 'TopicCommentController@destroy')         ->name('forum.topic.comment.delete');
                Route::post('{id}/update', 'TopicCommentController@update')         ->name('forum.topic.comment.update');
            });
        });

        Route::get('/{id}', 'ForumTopicController@index')                           ->name('forum.topic.index');
    });

});

Route::group(['prefix' => 'replay'], function (){
    Route::get('/users', 'ReplayUsersController@list')                              ->name('replay.users');
    Route::get('/gosus', 'ReplayGosuController@list')                               ->name('replay.gosus');
    Route::get('/user/{type}', 'ReplayUsersController@getReplayByType')             ->name('replay.user_type');
    Route::get('/gosu/{type}', 'ReplayGosuController@getReplayByType')              ->name('replay.gosu_type');
    Route::get('/{id}/get_rating', 'ReplayRatingController@getRating')              ->name('replay.ger_rating');
    Route::get('/{id}/get_evaluation', 'ReplayRatingController@getEvaluation')      ->name('replay.get_evaluation');
    Route::get('/{id}/download', 'ReplayController@download')                       ->name('replay.download');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/create', 'ReplayController@create')                            ->name('replay.create');
        Route::post('/store', 'ReplayController@store')                             ->name('replay.store');
        Route::get('/{id}/edit', 'ReplayController@edit')                           ->name('replay.edit');
        Route::post('/{id}/update', 'ReplayController@update')                      ->name('replay.update');
        Route::get('{id}/delete', 'ReplayController@destroy')                       ->name('replay.delete');
        Route::get('/my', 'ReplayUsersController@getUserReplay')                    ->name('replay.my_user');
        Route::get('/my_gosu', 'ReplayGosuController@getUserReplay')                ->name('replay.my_gosu');


        Route::get('{id}/set_rating', 'ReplayRatingController@setRating')           ->name('replay.set_rating');
        Route::post('{id}/set_evaluation', 'ReplayRatingController@setEvaluation')  ->name('replay.set_evaluation');

        Route::group(['prefix' => 'comment'], function () {
            Route::post('/store', 'ReplayCommentController@store')                  ->name('replay.comment.store');
            Route::get('{id}/delete', 'ReplayCommentController@destroy')            ->name('replay.comment.delete');
            Route::post('{id}/update', 'ReplayCommentController@update')            ->name('replay.comment.update');
        });
    });
    Route::get('/{id}', 'ReplayController@show')                                    ->name('replay.get');
});

Route::group(['prefix' => 'gallery'], function (){
    Route::get('/', 'UserGalleryController@index')                                  ->name('gallery.list');
    Route::get('/my', 'UserGalleryController@indexUser')                            ->name('gallery.list_my');
    Route::get('/user/{id}', 'UserGalleryController@indexUser')                     ->name('gallery.list_user');


    Route::get('/{id}/get_rating', 'UserGalleryRatingController@getRating')         ->name('gallery.ger_rating');

    Route::group(['middleware' => 'auth', 'prefix' => 'photo'], function () {
        Route::get('/create', 'UserGalleryController@create')                       ->name('gallery.create');
        Route::get('/{id}/edit', 'UserGalleryController@edit')                      ->name('gallery.edit');
        Route::post('/store', 'UserGalleryController@store')                        ->name('gallery.store');
        Route::post('/{id}/update', 'UserGalleryController@update')                 ->name('gallery.update');
        Route::get('{id}/set_rating', 'UserGalleryRatingController@setRating')      ->name('gallery.set_rating');

        Route::group(['prefix' => 'comment'], function () {
            Route::post('/store', 'UserGalleryCommentController@store')             ->name('gallery.comment.store');
            Route::get('{id}/delete', 'UserGalleryCommentController@destroy')       ->name('gallery.comment.delete');
            Route::post('{id}/update', 'UserGalleryCommentController@update')       ->name('gallery.comment.update');
        });
    });

    Route::get('/photo/{id}', 'UserGalleryController@show')                         ->name('gallery.view');
});

Route::group(['middleware' => ['auth', 'admin_panel'], 'prefix' => 'admin_panel', 'namespace' => 'Admin'], function () {
    Route::get('/', 'BaseController@index')                                         ->name('admin.home');
    Route::post('send_quick_email', 'BaseController@sendQuickEmail')                ->name('admin.send_quick_email');
    Route::group(['prefix' => 'user'], function (){
        Route::get('{id}/email', 'UserEmailController@index')                       ->name('admin.user.email');
        Route::get('{id}/replay', 'ReplayController@getReplayByUser')               ->name('admin.user.replay');
        Route::get('{id}/topic', 'ForumController@getUsersTopics')                  ->name('admin.user.topic');
        Route::get('{id}/profile', 'UserController@getUserProfile')                 ->name('admin.user.profile');
        Route::get('{id}/ban', 'UserController@banUser')                            ->name('admin.user.ban');
        Route::get('{id}/remove', 'UserController@removeUser')                      ->name('admin.user.remove');
        Route::get('{id}/not_ban', 'UserController@notBanUser')                     ->name('admin.user.not_ban');
        Route::get('{id}/profile/edit', 'UserController@getEditUserProfile')        ->name('admin.user.profile.edit');
        Route::post('{id}/profile/save', 'UserController@saveUserProfile')          ->name('admin.user.profile.save');
        Route::get('/', 'UserController@index')                                     ->name('admin.users');
        Route::get('{id}/message', 'UserMessageController@getUser')                 ->name('admin.user.messages');
        Route::get('/message/{dialog_id}/load', 'UserMessageController@load')       ->name('admin.user.message_load');
        Route::post('/message/{dialog_id}/send', 'UserMessageController@send')      ->name('admin.user.message.send');
        Route::get('/role', 'UserRoleController@index')                             ->name('admin.users.role');
    });
    Route::group(['prefix' => 'forum'], function (){
        Route::get('/', 'ForumController@index')                                    ->name('admin.forum_sections');
    });
    Route::group(['prefix' => 'replay'], function (){
        Route::get('/users', 'ReplayController@indexUsers')                         ->name('admin.replay.users');
        Route::get('/gosu', 'ReplayController@indexGosu')                           ->name('admin.replay.gosu');
    });
});

//
//Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
//
//});









//Redirect old URI
Route::get('news.php', 'RedirectOldURL@news');
Route::get('user.php', 'RedirectOldURL@user');
Route::get('columns.php', 'RedirectOldURL@columns');
Route::get('forum.php', 'RedirectOldURL@forum');
Route::get('info.php', 'RedirectOldURL@index');
Route::get('replays.php', 'RedirectOldURL@replays');
Route::get('freereplays.php', 'RedirectOldURL@freeReplays');
Route::get('files.php', 'RedirectOldURL@files');
Route::get('sc2.php', 'RedirectOldURL@sc2');
Route::get('rating.php', 'RedirectOldURL@rating');
Route::get('donate.php', 'RedirectOldURL@donate');
Route::get('userbars.php', 'RedirectOldURL@userBars');
Route::get('registration.php', 'RedirectOldURL@registration'); //TODO:: redirect for gallery

//Auth::routes();