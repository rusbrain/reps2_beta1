<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('position');
            $table->integer('reps_id')->nullable();
            $table->string('name');
            $table->string('title');
            $table->string('description');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_general')->default(false);
            $table->boolean('user_can_add_topics')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_sections');
    }
}
