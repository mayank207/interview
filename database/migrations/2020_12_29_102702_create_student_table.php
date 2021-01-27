<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id');
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->bigInteger('phone');
            $table->string('attachment');
            $table->dateTime('date');
            $table->integer('fresher')->nullable();
            $table->integer('expereince_year')->nullable();
            $table->integer('expereince_month')->nullable();
            $table->foreign('state_id')->references('id')->on('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
