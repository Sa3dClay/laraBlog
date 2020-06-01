<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToLikesAndCommentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->change();
            $table->integer('post_id')->unsigned()->change();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('commentable_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('likes', function($table) {
            $table->dropForeign(['user_id', 'post_id']);
        });

        Schema::table('comments', function($table) {
            $table->dropForeign(['user_id', 'commentable_id']);
        });
    }
}
