<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('streams')) {
            Schema::create('streams', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->longText('content');
                $table->integer('user_id');
                $table->string('race');
                $table->integer('country_id');
                $table->longText('stream_url');
                $table->boolean('active')        ->default(1);
                $table->boolean('approved')      ->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('streams');
    }
}
