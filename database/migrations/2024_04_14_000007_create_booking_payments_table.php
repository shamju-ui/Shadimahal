<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('amount', 15, 2);
            $table->string('amount_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
