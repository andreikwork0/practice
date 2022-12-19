<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('pers_kod');
            $table->integer('kod_agr');

            $table->string('family');
            $table->string('name1');
            $table->string('name2')->nullable();
            $table->string('name_ar');

            $table->foreignId('education_type_id')->constrained()->onUpdate('cascade');

            $table->integer('kurs');
            $table->tinyInteger('is_active');

            $table->string('kod_osn');
            $table->string('name_osn');

            $table->timestamps();
        });

        Schema::create('students_tmp', function (Blueprint $table) {
            $table->id();
            $table->integer('pers_kod');
            $table->integer('kod_agr');

            $table->string('family');
            $table->string('name1');
            $table->string('name2')->nullable();
            $table->string('name_ar');

            $table->bigInteger('education_type_id');

            $table->integer('kurs');
            $table->tinyInteger('is_active');

            $table->string('kod_osn');
            $table->string('name_osn');

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
        Schema::dropIfExists('students');
        Schema::dropIfExists('students_tmp');
    }
}
