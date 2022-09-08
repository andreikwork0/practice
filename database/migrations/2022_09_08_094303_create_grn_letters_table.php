<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrnLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grn_letters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->string('num_letter',30);
            $table->dateTime('date_letter', 4);

            $table->string('note_letter',300);

            $table->dateTime('created_at', 4);
            $table->dateTime('updated_at', 4);
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grn_letters');
    }
}
