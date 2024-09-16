<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentIdToMarkListsTable extends Migration
{
    public function up()
    {
        Schema::table('mark_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->after('id'); // Add the student_id column
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade'); // Add foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('mark_lists', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
        });
    }
}
