<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourneyPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourney_players', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tourney_id');
            $table->integer('user_id');
            $table->integer('check_in') ->default(0); // 0: no, 1: yes
            $table->string('description');
            $table->string('place_result');
            $table->timestamps();

            $table->index('tourney_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourney_players');
    }
}
