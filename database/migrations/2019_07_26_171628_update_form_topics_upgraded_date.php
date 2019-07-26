<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFormTopicsUpgradedDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_topics', function(Blueprint $table) {
            $table->dateTime('upgraded_date')->default(\Carbon\Carbon::now())->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_topics', function(Blueprint $table) {
            $table->dateTime('upgraded_date')->nullable()->change();
        });
    }
}
