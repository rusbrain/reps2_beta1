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
            $table->integer('user_id');
            $table->longText('message') ->charset('cp1251');
            $table->boolean('is_read')  ->default(0);
            $table->integer('dialogue_id');
            $table->timestamps();

            $table->index('user_id');
            $table->index('is_read');
            $table->index('dialogue_id');
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
