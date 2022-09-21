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

            $table->string('name', 300);
            $table->string('plan_title');

            $table->integer('course');
            $table->integer('semester');

            $table->float('day')->nullable();
            $table->float('week')->nullable();

            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();

            /*
             * Группа
             */
            $table->string('depart_name');

            $table->string('spec');
            $table->string('agroup');
            $table->integer('contingent');

            $table->integer('l_pr_plan_id');
            $table->integer('l_id_plan');

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
