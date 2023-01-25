<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('firstname');
            $table->string('lastname')->nullable();


            $table->foreignId('pulpit_id')->nullable()->constrained()->onUpdate('cascade');

            $table->unsignedBigInteger('l_id')->nullable();
            $table->unsignedBigInteger('l_id_pulpit')->nullable();

            $table->string('type');
            $table->string('post');

            $table->unique(['l_id', 'pulpit_id']);
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
        Schema::dropIfExists('teachers');
    }
}
