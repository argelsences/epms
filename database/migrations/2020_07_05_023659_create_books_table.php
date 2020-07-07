<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('business_name');
            $table->string('business_address_line_1');
            $table->string('business_address_line_2');
            $table->string('business_address_state_province');
            $table->string('business_address_city');
            $table->string('ticket_pdf_path');
            $table->string('booking_reference');
            $table->string('transaction_id');
            $table->string('notes');
            $table->boolean('is_deleted');
            $table->boolean('is_cancelled');
            $table->bigInteger('reserve_status_id')->unsigned();
            $table->foreign('reserve_status_id')->references('id')->on('reserve_statuses');
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
        Schema::dropIfExists('books');
    }
}
