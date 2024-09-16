<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_lists', function (Blueprint $table) {
            $table->id();
            $table->string('class_name'); // Class name, e.g., "Class 4"
            $table->integer('term'); // Term number, e.g., "1"
            $table->string('grade'); // Grade, e.g., "A"
            $table->date('date'); // Date of the mark list
            $table->text('comments')->nullable(); // Comments or additional notes
            $table->string('marklist_file')->nullable(); // The file path of the uploaded mark list image
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mark_lists');
    }
}
