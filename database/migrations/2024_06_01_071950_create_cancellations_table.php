<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cancellations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hall_id');
            $table->decimal('amount', 8, 2);
            $table->timestamp('canceled_at')->useCurrent();
            $table->timestamps();

            // Foreign key constraints (assuming you have halls and users tables)
            $table->foreign('hall_id')->references('id')->on('halls')->onDelete('cascade');

    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancellations');
    }
};
