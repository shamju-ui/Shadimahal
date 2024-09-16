<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('student_name');
            $table->string('student_id');
            $table->string('student_mobile');
            $table->string('guardian_name');
            $table->string('guardian_id');
            $table->string('guardian_mobile');
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->string('educational_institution');
            $table->string('institution_mobile');
            $table->string('course_id'); // Foreign key for course
            $table->string('stream_id')->nullable(); // Foreign key for stream, optional
            $table->string('current_grade');
            $table->integer('total_fees');
            $table->integer('allocated_fees');
            $table->softDeletes();
            $table->timestamps();
        
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('stream_id')->references('id')->on('streams')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
