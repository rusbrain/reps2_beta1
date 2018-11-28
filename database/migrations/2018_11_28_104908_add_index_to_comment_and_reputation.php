<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToCommentAndReputation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_reputations', function (Blueprint $table) {
            $table->index(['object_id', 'relation']);
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->index(['object_id', 'relation']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_reputations', function (Blueprint $table) {
            $table->dropIndex(['object_id', 'relation']);
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['object_id', 'relation']);
        });
    }
}
