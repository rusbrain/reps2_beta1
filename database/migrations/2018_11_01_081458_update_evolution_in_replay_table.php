<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEvolutionInReplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replays', function (Blueprint $table) {
            $table->dropColumn('evaluation');
            $table->dropColumn('game_version');
            $table->enum('creating_rate', ['7','8','9','10','Cool','Best'])->default('10');
            $table->integer('game_version_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('replays', function (Blueprint $table) {
            $table->integer('evaluation')->default(8);
            $table->string('game_version')->default('1.17');
            $table->dropColumn('creating_rate');
            $table->dropColumn('game_version_id');

        });
    }
}
