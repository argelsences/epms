<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('max_per_person');
            $table->integer('min_per_person');
            $table->integer('quantity_available');
            $table->integer('quantity_booked');
            $table->dateTime('start_book_date');
            $table->dateTime('end_book_date');
            $table->boolean('is_paused');
            $table->boolean('is_hidden');
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('edited_by')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('edited_by')->references('id')->on('users');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
