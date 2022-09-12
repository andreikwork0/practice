<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('prs_rule', 30);
            $table->string('prs_lname', 20);
            $table->string('prs_fname', 20);
            $table->string('prs_sname', 20)->nullable();
            $table->string('prs_job', 50);
            $table->string('prs_office', 50)->nullable();
            $table->tinyInteger('is_negotiation')->nullable();
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
        Schema::dropIfExists('contact_people');
    }
}
