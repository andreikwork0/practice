<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('practices', function (Blueprint $table) {
//            $table->dropColumn(['day', 'week', 'l_pr_plan_id']);
//            $table->string('plan_title')->nullable()->change();
//        });

        Schema::create('practices_tmp', function (Blueprint $table) {

            $table->id();

            $table->string('name', 300);
            $table->string('plan_title')->nullable();

            $table->integer('course');
            $table->integer('semester');


            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();

            /*
             * Группа
             */
            $table->string('depart_name');
            $table->string('spec');
            $table->string('agroup');
            $table->integer('contingent');

            $table->integer('l_id_plan');


            $table->timestamps();

            $table->bigInteger('education_type_id')->unsigned();
            $table->bigInteger('year_learning_id')->unsigned();
            $table->bigInteger('pulpit_id')->unsigned();

            $table->bigInteger('practice_type_id')->unsigned()->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

//        Schema::table('practices', function (Blueprint $table) {
//            $table->integer('l_pr_plan_id')->nullable()->change();
//            $table->float('day')->nullable()->change();
//            $table->float('week')->nullable()->change();
//            $table->string('plan_title')->nullable()->change();
//        });

        Schema::dropIfExists('practices_tmp');

    }
}
