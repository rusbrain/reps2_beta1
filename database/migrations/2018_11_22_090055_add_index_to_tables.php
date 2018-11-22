<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->index('user_id');
        });
        Schema::table('user_reputations', function (Blueprint $table) {
            $table->index('sender_id');
            $table->index('recipient_id');
            $table->index('object_id');
            $table->index('relation');
        });
        Schema::table('forum_sections', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('is_general');
        });
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->index('section_id');
            $table->index('user_id');
            $table->index('approved');
            $table->index('news');
        });
        Schema::table('replays', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('user_replay');
            $table->index('map_id');
            $table->index('first_country_id');
            $table->index('second_country_id');
            $table->index('first_race');
            $table->index('second_race');
            $table->index('approved');
        });
        Schema::table('replay_user_ratings', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('replay_id');
        });
        Schema::table('interview_variants_answers', function (Blueprint $table) {
            $table->index('question_id');
        });
        Schema::table('interview_user_answers', function (Blueprint $table) {
            $table->index('question_id');
            $table->index('answer_id');
            $table->index('user_id');
        });
        Schema::table('user_galleries', function (Blueprint $table) {
            $table->index('user_id');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('object_id');
            $table->index('relation');
        });
        Schema::table('ignore_users', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('ignored_user_id');
        });
        Schema::table('user_friends', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('friend_user_id');
        });
        Schema::table('user_messages', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('is_read');
            $table->index('dialogue_id');
        });
        Schema::table('dialogue_user', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('dialogue_id');
        });
        Schema::table('banners', function (Blueprint $table) {
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropIndex('user_id');
        });
        Schema::table('user_reputations', function (Blueprint $table) {
            $table->dropIndex('sender_id');
            $table->dropIndex('recipient_id');
            $table->dropIndex('object_id');
            $table->dropIndex('relation');
        });
        Schema::table('forum_sections', function (Blueprint $table) {
            $table->dropIndex('is_active');
            $table->dropIndex('is_general');
        });
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropIndex('section_id');
            $table->dropIndex('user_id');
            $table->dropIndex('approved');
            $table->dropIndex('news');
        });
        Schema::table('replays', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('user_replay');
            $table->dropIndex('map_id');
            $table->dropIndex('first_country_id');
            $table->dropIndex('second_country_id');
            $table->dropIndex('first_race');
            $table->dropIndex('second_race');
            $table->dropIndex('approved');
        });
        Schema::table('replay_user_ratings', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('replay_id');
        });
        Schema::table('interview_variants_answers', function (Blueprint $table) {
            $table->dropIndex('question_id');
        });
        Schema::table('interview_user_answers', function (Blueprint $table) {
            $table->dropIndex('question_id');
            $table->dropIndex('answer_id');
            $table->dropIndex('user_id');
        });
        Schema::table('user_galleries', function (Blueprint $table) {
            $table->dropIndex('user_id');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('object_id');
            $table->dropIndex('relation');
        });
        Schema::table('ignore_users', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('ignored_user_id');
        });
        Schema::table('user_friends', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('friend_user_id');
        });
        Schema::table('user_messages', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('is_read');
            $table->dropIndex('dialogue_id');
        });
        Schema::table('user_messages', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('is_read');
            $table->dropIndex('dialogue_id');
        });
        Schema::table('dialogue_user', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('dialogue_id');
        });
        Schema::table('banners', function (Blueprint $table) {
            $table->dropIndex('is_active');
        });
    }
}
