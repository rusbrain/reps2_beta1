<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FileOwnerType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function(Blueprint $table) {
            $table->string('resource_type');
        });

        \Illuminate\Support\Facades\DB::update("
            UPDATE files
            JOIN replays r on files.id = r.file_id
            SET files.resource_type = 'replay'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function(Blueprint $table) {
            $table->dropColumn('resource_type');
        });
    }
}
