<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBookingPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id', 'booking_fk_9684710')->references('id')->on('hole_bookings');
        });
    }
}
