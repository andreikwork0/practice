<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PracticeTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::dropIfExists('practice_teachers');

        Schema::create('practice_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_id');
            $table->foreignId('teacher_id');
            $table->integer('contingent');
            $table->unique('practice_id', 'teacher_id');
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
        Schema::dropIfExists('practice_teacher');
        Schema::create('practice_teachers', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('mname');
            $table->string('post');
            $table->float('hours');
            $table->foreignId('practice_id')->constrained()->onUpdate('cascade');
            $table->timestamps();
        });
    }
}
