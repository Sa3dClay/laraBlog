<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) { //weak entity
            $table->string('type')->nullable(false);
            $table->integer('user_id')->nullable(false)->references('id')->on('users')
              ->onDelete('cascade');
            $table->integer('post_id')->nullable(false)->references('id')->on('posts')
            ->onDelete('cascade');
            $table->string('message')->nullable(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
