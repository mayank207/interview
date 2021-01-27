<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTechnologyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_technology', function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->unsignedBigInteger('technology_id');
            $table->unsignedBigInteger('student_id');
            $table->foreign('technology_id')->references('id')->on('technology')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('student')->onUpdate('cascade')->onDelete('cascade');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_technology');
    }
}
