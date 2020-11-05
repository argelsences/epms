<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('synopsis');
            $table->string('excerpt')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('pre_booking_display_message')->nullable();
            $table->text('post_booking_display_message')->nullable();
            $table->boolean('social_show_facebook');
            $table->boolean('social_show_linkedin');
            $table->boolean('social_show_twitter');
            $table->boolean('social_show_whatsapp');
            $table->boolean('social_show_email');
            $table->boolean('is_public');
            $table->boolean('is_approved');
            $table->boolean('for_approval');
            $table->string('barcode_type');
            $table->integer('checkout_timeout');
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('edited_by')->unsigned();
            $table->bigInteger('venue_id')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('edited_by')->references('id')->on('users');
            $table->foreign('venue_id')->references('id')->on('venues');
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
        Schema::dropIfExists('events');
    }
}
