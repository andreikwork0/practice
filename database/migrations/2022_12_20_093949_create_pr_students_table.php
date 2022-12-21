<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_id')->constrained()->onUpdate('cascade'); // на самом деле ключ составной
            $table->foreignId('student_id')->constrained()->onUpdate('cascade'); //  на самом деле ключ составной
            $table->foreignId('distribution_practice_id')->nullable()->constrained()->onUpdate('cascade');
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
        Schema::dropIfExists('pr_students');
    }
}
