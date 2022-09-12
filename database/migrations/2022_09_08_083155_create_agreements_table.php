<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->string('num_agreement',10)->unique();
            $table->dateTime('date_agreement', 4);

            $table->dateTime('date_bg', 4);
            $table->dateTime('date_end', 4);

            $table->tinyInteger('is_actual')->nullable();

//            $table->dateTime('created_at', 4);
//            $table->dateTime('updated_at', 4);
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
        Schema::dropIfExists('agreements');
    }
}
