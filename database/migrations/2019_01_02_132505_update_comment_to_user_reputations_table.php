<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCommentToUserReputationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_reputations', function (Blueprint $table) {
            $table->dropColumn('rating');
            $table->dropIndex('rating');
        });
        Schema::table('user_reputations', function (Blueprint $table) {
            $table->text('comment')->charset('cp1251')->nullable()->change();
            $table->enum('rating',[1,-1])->default(1);
            $table->index('rating');
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
            $table->dropColumn('rating');
            $table->dropIndex('rating');
        });
        Schema::table('user_reputations', function (Blueprint $table) {
            $table->string('comment')->nullable()->change();
            $table->enum('rating',[1,-1])->default(1);
            $table->index('rating');
        });
    }
}
