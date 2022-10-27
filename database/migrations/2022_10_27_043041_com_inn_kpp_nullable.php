<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ComInnKppNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {

            $table->string('inn', 15)->nullable()->change();
            $table->string('kpp', 15)->nullable()->change();
            $table->foreignId('country_id')->nullable()->constrained()->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {

            $table->string('inn', 15)->change();
            $table->string('kpp', 15)->change();

            $table->dropForeign('companies_country_id_foreign');
            $table->dropColumn('country_id');
        });
    }
}
