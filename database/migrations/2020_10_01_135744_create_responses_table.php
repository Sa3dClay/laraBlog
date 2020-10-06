<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->integer('user_id')->nullable(false)->references('id')->on('users')
              ->onDelete('cascade');
            $table->integer('admin_id')->nullable(false)->references('id')->on('admins')
              ->onDelete('cascade');
            $table->integer('feedback_id')->nullable(false)->references('id')->on('feedbacks')
              ->onDelete('cascade');
            $table->mediumText('response')->nullable(false);
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
        Schema::dropIfExists('responses');
    }
}
