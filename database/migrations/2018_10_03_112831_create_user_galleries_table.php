<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('file_id');
            $table->integer('reps_id')          ->nullable();
            $table->integer('rating')           ->default(0);
            $table->longText('comment')         ->charset('cp1251')->nullable();
            $table->boolean('for_adults')       ->default(false);
            $table->integer('negative_count')   ->default(0);
            $table->integer('positive_count')   ->default(0);
            $table->integer('comments_count')   ->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_galleries');
    }
}
