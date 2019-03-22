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
            $table->boolean('user_replay')                  ->default(true);
            $table->integer('type_id');
            $table->string('title');
            $table->longText('content')                     ->charset('cp1251');
            $table->integer('map_id')                       ->default(0);
            $table->integer('file_id')                      ->nullable();
            $table->longText('video_iframe')                ->nullable();
            $table->enum('creating_rate', ['7','8','9','10','Cool','Best'])->default('10');
            $table->integer('game_version_id')              ->default(0);
            $table->string('championship')                  ->nullable();
            $table->integer('first_country_id');
            $table->integer('second_country_id');
            $table->string('first_race');
            $table->string('second_race');
            $table->integer('rating')                       ->default(0);
            $table->double('user_rating',10,2)  ->default(0);
            $table->integer('downloaded')                   ->default(0);
            $table->time('length')                          ->default('00:00:00');
            $table->integer('reps_id')                      ->nullable();
            $table->integer('approved')                     ->default(0);
            $table->integer('first_location')               ->nullable();
            $table->integer('second_location')              ->nullable();
            $table->integer('negative_count')               ->default(0);
            $table->integer('positive_count')               ->default(0);
            $table->integer('comments_count')               ->default(0);
            $table->timestamps();

            $table->index('user_id');
            $table->index('user_replay');
            $table->index('map_id');
            $table->index('first_country_id');
            $table->index('second_country_id');
            $table->index('first_race');
            $table->index('second_race');
            $table->index('approved');
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
