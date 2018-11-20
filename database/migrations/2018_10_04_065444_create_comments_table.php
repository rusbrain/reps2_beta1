<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('object_id');
            $table->integer('relation');
            $table->string('title')->nullable();
            $table->longText('content')->charset('cp1251');
            $table->timestamps();
        });

        Schema::dropIfExists('forum_topic_comments');
        Schema::dropIfExists('replay_comments');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
