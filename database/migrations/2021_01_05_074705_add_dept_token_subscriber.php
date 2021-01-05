<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeptTokenSubscriber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            //
            $table->dropUnique(['email']);
            $table->text('token');
            $table->foreignId('department_id')->onDelete('cascade')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            //
        });
    }
}
