<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practices', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->string('name', 300);
            $table->string('plan_title');

            $table->float('course');
            $table->integer('semester');

            $table->float('hours')->nullable();
            $table->float('day');
            $table->float('week');

            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();

            /*
             * Группа
             */
            $table->string('spec');
            $table->string('agroup');
            $table->integer('contingent');

            $table->integer('id_pulpit');
            $table->integer('id_year_learning');
            $table->integer('id_plan');

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
        Schema::dropIfExists('practices');
    }
}
