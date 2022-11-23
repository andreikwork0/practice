<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConventionPremise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convention_premise', function (Blueprint $table) {

            $table->foreignId('convention_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('premise_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['convention_id', 'premise_id']);
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
        Schema::dropIfExists('convention_premise');
    }
}
