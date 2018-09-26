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
            $table->string('name')->nullable();
            $table->string('title');
            $table->string('description');
            $table->boolean('is_active')->default(true);
            $table->boolean('in_menu')->default(false);
            $table->string('url')->nullable();

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
