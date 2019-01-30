<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_icons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon');
        });

        Schema::table('forum_sections', function (Blueprint $table) {
            $table->integer('section_icon_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_icons');
        Schema::table('forum_sections', function (Blueprint $table) {
            $table->dropColumn('section_icon_id');
        });
    }
}
