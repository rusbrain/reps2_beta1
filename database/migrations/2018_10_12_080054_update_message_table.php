<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_messages', function($table)
        {
            $table->integer('dialogue_id');
            $table->renameColumn('user_sender_id', 'user_id');
            $table->dropColumn('user_recipient_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_messages', function($table)
        {
            $table->dropColumn('dialogue_id');
            $table->renameColumn('user_id', 'user_sender_id');
            $table->integer('user_recipient_id');
        });
    }
}
