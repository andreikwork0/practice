<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgreemtsCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agreements', function (Blueprint $table) {
           $table->string('path')->nullable();
            $table->date('date_agreement')->nullable()->change();
            $table->date('date_bg')->nullable()->change();
            $table->date('date_end')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('num_agreement')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agreements', function (Blueprint $table) {
            $table->dropColumn('path');
            $table->dateTime('date_agreement', 4)->change();
            $table->dateTime('date_bg', 4)->change();
            $table->dateTime('date_end', 4)->change();

            $table->string('name')->change();
            $table->string('num_agreement')->change();
        });
    }
}
