<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewReplayFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replays', function(Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->unsignedInteger('first_apm')->nullable();
            $table->unsignedInteger('second_apm')->nullable();
            $table->date('start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('replays', function(Blueprint $table) {
            $table->dropColumn([
                'first_name', 'second_name',
                'first_apm', 'second_apm',
                'start_time'
            ]);
        });
    }
}
