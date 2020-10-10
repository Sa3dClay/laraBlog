<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_admin', function (Blueprint $table) {
          $table->string('type')->nullable(false);
          $table->integer('admin_id')->nullable(false)->references('id')->on('admins')
            ->onDelete('cascade');
          $table->integer('post_id')->default(0)->references('id')->on('posts')
          ->onDelete('cascade');
          $table->integer('feedback_id')->default(0)->references('id')->on('feedbacks')
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
        Schema::dropIfExists('notifications_admin');
    }
}
