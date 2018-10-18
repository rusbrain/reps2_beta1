<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->softDeletes();
        });

        Schema::table('dialogues', function($table)
        {
            $table->softDeletes();
        });

        Schema::table('user_friends', function($table)
        {
            $table->softDeletes();
        });

        Schema::table('user_galleries', function($table)
        {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropSoftDeletes();
        });

        Schema::table('dialogues', function($table)
        {
            $table->dropSoftDeletes();
        });

        Schema::table('user_friends', function($table)
        {
            $table->dropSoftDeletes();
        });

        Schema::table('user_galleries', function($table)
        {
            $table->dropSoftDeletes();
        });
    }
}
