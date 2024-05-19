<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoleBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('hole_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('time_slot');
            $table->string('name');
            $table->string('mobile_1');
            $table->string('mobile_2')->nullable();
            $table->longText('address_line_1')->nullable();
            $table->longText('address_line_2')->nullable();
            $table->float('total_amount', 15, 2)->nullable();
            $table->string('elactric_charges')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('am')->default(0)->nullable();
            $table->boolean('pm')->default(0)->nullable();
            $table->boolean('ad')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
