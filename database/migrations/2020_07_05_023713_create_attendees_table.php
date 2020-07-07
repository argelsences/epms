<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('private_reference_number');
            $table->boolean('is_cancelled');
            $table->boolean('has_arrived');
            $table->dateTime('arrival_time');
            $table->string('reference_index');
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('book_id')->unsigned();
            $table->bigInteger('ticket_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('ticket_id')->references('id')->on('tickets');
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
        Schema::dropIfExists('attendees');
    }
}
