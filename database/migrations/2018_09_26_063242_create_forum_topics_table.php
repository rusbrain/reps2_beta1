<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reps_id')->nullable();
            $table->string('reps_section')->nullable();
            $table->integer('section_id');
            $table->string('title');
            $table->text('preview_content')->charset('cp1251')->nullable();
            $table->text('preview_file_id')->nullable();
            $table->longText('content')->charset('cp1251');
            $table->integer('user_id');
            $table->integer('reviews')->default(0);
            $table->dateTime('start_on')->nullable();
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
        Schema::dropIfExists('forum_topics');
    }
}
