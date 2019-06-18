<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('replays', function (Blueprint $table) {

            $table->dropForeign('replays_file_id_foreign');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('replays', function (Blueprint $table) {

            $table->dropForeign('replays_file_id_foreign');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('restrict');
        });

    }
}
