<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourneyListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourney_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tourney_id');
            $table->integer('admin_id')->default(0);
            $table->string('name');
            $table->string('place');
            $table->string('prize_pool');
            $table->integer('status')->default(0); // 0: ANNOUNCE, 1: REGISTRATION, 2: CHECK-IN, 3: GENERATION, 4: STARTED, 5: FINISHED
            $table->boolean('visible')->default(1); // 0: hidden, 1: visible
            $table->string('maps');
            $table->string('rules_link');
            $table->string('vod_link');
            $table->string('logo_link');
            $table->string('map_selecttype')->default(1); // 0: NONE, 1: FIRSTBYREMOVING, 2: FIRSTBYROUND
            $table->integer('importance') ->default(0);
            $table->boolean('is_ranking') ->default(1);  // 0: NO, 1: YES
            $table->string('password');
            $table->dateTime('checkin_time');
            $table->dateTime('start_time');
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
        Schema::dropIfExists('tourney_lists');
    }
}
