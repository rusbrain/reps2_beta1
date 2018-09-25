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

Route::middleware([/*'guest'*/])->group(function () {
    Route::post('/login', 'Auth\LoginController@userLogin')->name('login');
    Route::get('/password/update', 'Auth\ResetPasswordController@updateOldPassword')->name('post_update_password');
    Route::get('/password/new/{token}', 'Auth\ResetPasswordController@viewNewPassword')->name('update_old_password');
    Route::post('/password/new/', 'Auth\ResetPasswordController@saveNewPassword')->name('save_new_password');
    Route::get('/registration.php', 'Auth\RegisterController@showRegistrationForm')->name('registration_form');
    Route::post('/registration.php', 'Auth\RegisterController@register')->name('registration');
});

Route::get('/info.php', 'UserController@show')->name('user_profile');
Route::get('/user.php', 'UserController@edit')->name('edit_profile');
Route::post('/user', 'UserController@update')->name('save_profile');

//Auth::routes();