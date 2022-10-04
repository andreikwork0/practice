<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionPracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_practices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('agreement_id')->nullable()->constrained()->onUpdate('cascade');
            $table->foreignId('company_id')->constrained()->onUpdate('cascade');
            $table->foreignId('practice_id')->constrained()->onUpdate('cascade');

            $table->integer('num_plan')->default(0);
            $table->integer('num_fact')->nullable();

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
        Schema::dropIfExists('distribution_practices');
    }
}
