<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_icons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon');
        });

        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->integer('forum_icon_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_icons');

        Schema::table('forum_topics', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->dropColumn('forum_icon_id');

        });
    }
}
