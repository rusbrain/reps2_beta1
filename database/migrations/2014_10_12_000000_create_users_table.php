<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reps_id')->nullable();
            $table->string('name');
            $table->string('email')                 ->unique();
            $table->timestamp('email_verified_at')  ->nullable();
            $table->string('password');
            $table->integer('user_role_id');
            $table->integer('country_id')           ->nullable();
            $table->integer('score')                ->nullable();
            $table->string('homepage')              ->nullable();
            $table->string('isq')                   ->nullable();
            $table->string('skype')                 ->nullable();
            $table->string('vk_link')               ->nullable();
            $table->string('fb_link')               ->nullable();
            $table->string('signature')             ->nullable();
            $table->integer('file_id')              ->nullable();
            $table->string('mouse')                 ->nullable();
            $table->string('keyboard')              ->nullable();
            $table->string('headphone')             ->nullable();
            $table->string('mousepad')              ->nullable();
            $table->date('birthday')                ->nullable();
            $table->ipAddress('last_ip')            ->nullable();
            $table->boolean('is_ban')               ->default(0);
            $table->boolean('rep_allow')            ->default(1);
            $table->integer('rep_buy')              ->default(0);
            $table->integer('rep_sell')             ->default(0);
            $table->boolean('view_signs')           ->default(1);
            $table->boolean('view_avatars')         ->default(1);
            $table->boolean('updated_password')     ->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
