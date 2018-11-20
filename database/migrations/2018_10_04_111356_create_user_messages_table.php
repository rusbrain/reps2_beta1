<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_sender_id');
            $table->integer('user_recipient_id');
            $table->longText('message')->charset('cp1251');
            $table->boolean('is_read')->default(0);
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
        Schema::dropIfExists('user_messages');
    }
}
