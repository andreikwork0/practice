<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('legal_adress', 200);
            $table->string('fact_adress', 200)->nullable();


            $table->string('mng_surname', 40);
            $table->string('mng_name', 40);
            $table->string('mng_patronymic', 40)->nullable();

            $table->string('inn', 15);
            $table->string('kpp', 15);

            $table->string('ch_account', 70)->nullable();;
            $table->string('cr_account', 30)->nullable();;

            $table->string('bik')->nullable();;

            $table->unsignedBigInteger('parent_id')->nullable();
//
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
        Schema::dropIfExists('companies');
    }
}
