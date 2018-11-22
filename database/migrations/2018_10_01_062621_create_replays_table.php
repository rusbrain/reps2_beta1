<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->boolean('user_replay')->default(true);
            $table->integer('type_id');
            $table->string('title');
            $table->longText('content')->charset('cp1251');
            $table->integer('map_id')->default(0);
            $table->integer('file_id');
            $table->string('game_version');
            $table->string('championship')->nullable();
            $table->integer('first_country_id');
            $table->integer('second_country_id');
            $table->string('first_race');
            $table->string('second_race');
            $table->integer('rating')->default(0);
            $table->double('user_rating',10,2)->default(0);
            $table->integer('evaluation');
            $table->integer('downloaded')->default(0);
            $table->time('length')->default('00:00:00');
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
        Schema::dropIfExists('replays');
    }
}
