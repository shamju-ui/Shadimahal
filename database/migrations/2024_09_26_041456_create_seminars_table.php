<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->string('seminar_name');
            $table->date('seminar_date');
            $table->string('runner');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seminars');
    }
    /**
     * Reverse the migrations.
     */
    
};
