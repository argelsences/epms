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
            $table->string('business_name')->nullable();
            $table->string('business_address_line_1')->nullable();
            $table->string('business_address_line_2')->nullable();
            $table->string('business_address_state_province')->nullable();
            $table->string('business_address_city')->nullable();
            $table->string('ticket_pdf_path')->nullable();
            $table->string('booking_reference');
            $table->string('transaction_id')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->boolean('is_cancelled')->default(0);
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
