<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practices_storage', function (Blueprint $table) {
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

            $table->string('pr_state')->nullable();
        });

        Schema::table('practices', function (Blueprint $table) {
            $table->string('pr_state')->nullable();
        });

        Schema::table('practices_tmp', function (Blueprint $table) {
            $table->string('pr_state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practices_storage');

        Schema::table('practices', function (Blueprint $table) {
            $table->dropColumn('pr_state');
        });

        Schema::table('practices_tmp', function (Blueprint $table) {
            $table->dropColumn('pr_state');
        });
    }
}
