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

Route::get('/', 'HomeController@index');
Route::get('/email/verified/{token}', 'Auth\RegisterController@emailVerified')->name('email_verified');

Route::middleware(['guest'])->group(function () {
    Route::post('/login', 'Auth\LoginController@userLogin')->name('login');

    Route::group(['prefix' => 'password'], function () {
        Route::get('/update', 'Auth\ResetPasswordController@updateOldPassword')->name('get_update_password');
        Route::get('/new/{token}', 'Auth\ResetPasswordController@viewNewPassword')->name('update_old_password');
        Route::post('/new', 'Auth\ResetPasswordController@saveNewPassword')->name('save_new_password');
    });

});

Route::group(['prefix' => 'user'], function () {
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('registration_form');
    Route::post('/register', 'Auth\RegisterController@register')->name('registration');

    Route::get('/{id}', 'UserController@show')->name('user_profile');
    Route::get('/edit', 'UserController@edit')->name('edit_profile');
    Route::post('/save', 'UserController@update')->name('save_profile');

});

Route::group(['prefix' => 'forum'], function () {
    Route::get('/', 'ForumController@index')->name('forum.index');

    Route::group(['prefix' => 'section'], function () {
        Route::get('/{name}', 'ForumController@section')->name('forum.section.index');
    });

    Route::group(['prefix' => 'topic'], function () {
        Route::get('/{id}', 'ForumTopicController@index')->name('forum.topic.index');

        Route::group(['middleware' => 'auth'], function () {
            Route::get('/create', 'ForumTopicController@create')->name('forum.topic.create');
            Route::post('/store', 'ForumTopicController@store')->name('forum.topic.store');
        });
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
Route::get('registration.php', 'RedirectOldURL@registration');

//Auth::routes();