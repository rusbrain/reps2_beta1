<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgeToUserGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_galleries', function($table)
        {
            $table->boolean('for_adults')->default(false);
        });

        Schema::table('replays', function($table)
        {
            $table->integer('first_location')->nullable();
            $table->integer('second_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('replays', function($table)
        {
            $table->dropColumn('for_adults');
        });

        Schema::table('replays', function($table)
        {
            $table->dropColumn('first_location');
            $table->dropColumn('second_location');
        });
    }
}
