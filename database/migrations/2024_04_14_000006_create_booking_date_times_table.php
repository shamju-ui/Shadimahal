<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingDateTimesTable extends Migration
{
    public function up()
    {
        Schema::create('booking_date_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('booked_date')->nullable();
            $table->string('time_slot')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('hall_booking_id')->nullable();
            $table->foreign('hall_booking_id', 'hall_booking_fk_9708243')->references('id')->on('hole_bookings');
        
        });
        
    }
}
