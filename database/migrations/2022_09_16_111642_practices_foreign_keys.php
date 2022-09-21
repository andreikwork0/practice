<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PracticesForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practices', function (Blueprint $table) {
            $table->foreignId('education_type_id')->constrained()->onUpdate('cascade');
            $table->foreignId('year_learning_id')->constrained()->onUpdate('cascade');
            $table->foreignId('pulpit_id')->constrained()->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practices', function (Blueprint $table) {

            $table->dropForeign('practices_education_type_id_foreign');
            $table->dropColumn('education_type_id');

            $table->dropForeign('practices_year_learning_id_foreign');
            $table->dropColumn('year_learning_id');


            $table->dropForeign('practices_pulpit_id_foreign');
            $table->dropColumn('pulpit_id');




//            $table->dropIndex('practices_education_type_id_index');
//            constraint practices_education_type_id_foreign
//        foreign key (education_type_id) references education_types (id)
//            on update cascade on delete cascade
        });

    }
}
