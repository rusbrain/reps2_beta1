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
            $table->boolean('type_id');
            $table->string('title');
            $table->text('content');
            $table->integer('map_id')->default(0);
            $table->integer('file_id');
            $table->string('game_version');
            $table->string('championship');
            $table->integer('first_country_id');
            $table->integer('second_country_id');
            $table->string('first_matchup');
            $table->string('second_matchup');
            $table->integer('rating')->default(0);
            $table->integer('user_rating')->default(0);
            $table->integer('evaluation');
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
