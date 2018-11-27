<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedComentAtToTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dateTime('commented_at')->default(\Carbon\Carbon::now());
        });

        $topics = \App\ForumTopic::all();
        $i = 0;
        foreach ($topics as $topic) {
            $comment = $topic->comments()->orderBy('created_at', 'desc')->first();
            $topic->commented_at = ($comment?$comment->created_at:$topic->created_at);
            $topic->save();

            $i++;
            if ($i%1000 == 0){
                echo $i."\n";
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropColumn('commented_at');
        });
    }
}
