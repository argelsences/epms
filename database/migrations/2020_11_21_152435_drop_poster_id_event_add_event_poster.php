<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPosterIdEventAddEventPoster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['poster_id']);
            $table->dropColumn('poster_id');
        });

        Schema::table('posters', function (Blueprint $table) {
            $table->foreignId('event_id')->unique()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posters', function (Blueprint $table) {
            //
        });
    }
}
