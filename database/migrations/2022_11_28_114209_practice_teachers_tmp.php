<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PracticeTeachersTmp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_teachers_tmp', function (Blueprint $table) {

            $table->id();
            $table->string('name');

            $table->integer('id_year_learning');
            $table->string('gname');
            $table->integer('contingent');
            $table->integer('semester');
            $table->integer('course');
            $table->bigInteger('id_teacher');

            $table->integer('l_id_plan');

            $table->string('firstname');
            $table->string('lastname');
            $table->string('surname');
            $table->string('type');
            $table->string('post');

//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practice_teachers_tmp');
    }
}
