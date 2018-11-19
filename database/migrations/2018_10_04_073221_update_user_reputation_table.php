<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserReputationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_reputations', function($table)
        {
            $table->dropColumn('replay_id');
            $table->dropColumn('topic_id');

            $table->integer('object_id');
            $table->integer('relation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_reputations', function($table)
        {
            $table->integer('replay_id')->nullale();
            $table->integer('topic_id')->nullable();
            $table->integer('gallery_id')->nullable();

            $table->dropColumn('object_id');
            $table->dropColumn('relation');
        });
    }
}
