<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replays', function (Blueprint $table) {

            $table->integer('negative_count')->default(0);
            $table->integer('positive_count')->default(0);
            $table->integer('comments_count')->default(0);
        });
        Schema::table('forum_topics', function (Blueprint $table) {

            $table->integer('negative_count')->default(0);
            $table->integer('positive_count')->default(0);
            $table->integer('comments_count')->default(0);
        });
        Schema::table('user_galleries', function (Blueprint $table) {

            $table->integer('negative_count')->default(0);
            $table->integer('positive_count')->default(0);
            $table->integer('comments_count')->default(0);
        });
        Schema::table('users', function (Blueprint $table) {

            $table->integer('negative_count')->default(0);
            $table->integer('positive_count')->default(0);
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
            $table->dropColumn('negative_count');
            $table->dropColumn('positive_count');
            $table->dropColumn('comments_count');

        });
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropColumn('negative_count');
            $table->dropColumn('positive_count');
            $table->dropColumn('comments_count');

        });
        Schema::table('user_galleries', function (Blueprint $table) {
            $table->dropColumn('negative_count');
            $table->dropColumn('positive_count');
            $table->dropColumn('comments_count');

        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('negative_count');
            $table->dropColumn('positive_count');

        });
    }
}
