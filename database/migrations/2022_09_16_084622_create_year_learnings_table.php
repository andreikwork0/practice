<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearLearningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_learnings', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->tinyInteger('active')->default(0);
            $table->integer('id_vo')->nullable();
            $table->integer('id_spo')->nullable();
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
        Schema::dropIfExists('year_learnings');
    }
}
