<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourneyMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourney_matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tourney_id');
            $table->integer('match_id');
            $table->string('round');
            $table->integer('round_id');
            $table->integer('player1_id');
            $table->integer('player2_id');
            $table->integer('player1_score');
            $table->integer('player2_score');
            $table->integer('win_score');
            $table->integer('winner_action');
            $table->integer('winner_value');
            $table->integer('looser_action');
            $table->integer('looser_value');
            $table->integer('played');
            $table->string('rep1');
            $table->string('rep2');
            $table->string('rep3');
            $table->string('rep4');
            $table->string('rep5');
            $table->string('rep6');
            $table->string('rep7');
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
        Schema::dropIfExists('tourney_matches');
    }
}
