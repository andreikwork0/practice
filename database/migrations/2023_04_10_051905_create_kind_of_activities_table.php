<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKindOfActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kind_of_activities', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('name');
            $table->foreignId('spec_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['spec_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kind_of_activities');
    }
}
