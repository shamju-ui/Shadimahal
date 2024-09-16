<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('grade');
            $table->decimal('fee_amount', 8, 2);
            $table->integer('term');
            $table->date('date');
            $table->string('receipt_number');
            $table->foreignId('created_by')->constrained('users'); // Assuming there's a users table
            $table->foreignId('deleted_by')->nullable()->constrained('users'); // Nullable, as not all entries will be soft deleted
            $table->timestamps();
            $table->softDeletes(); // Adds deleted_at column for soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('fee_payments');
    }
}
