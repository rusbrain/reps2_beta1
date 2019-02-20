<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIgnoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ignore_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('ignored_user_id');
            $table->timestamps();

            $table->index('user_id');
            $table->index('ignored_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ignore_users');
    }
}
