<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVisibilityDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('visibility');
            $table->boolean('hidden')->default(0);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('visibility');
            $table->boolean('hidden')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('hidden');
            $table->boolean('visible')->default(1);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('hidden');
            $table->boolean('visible')->default(1);
        });
    }
}
