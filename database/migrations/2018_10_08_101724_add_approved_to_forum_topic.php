<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedToForumTopic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_topics', function($table)
        {
            $table->integer('approved')->default(0);
        });
        Schema::table('replays', function($table)
        {
            $table->integer('approved')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_topics', function($table)
        {
            $table->dropColumn('approved');
        });
        Schema::table('replays', function($table)
        {
            $table->dropColumn('approved');
        });
    }
}
