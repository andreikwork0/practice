<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DpConventionKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribution_practices', function (Blueprint $table) {
            $table->foreignId('convention_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->dropForeign('distribution_practices_agreement_id_foreign');
            $table->dropColumn('agreement_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribution_practices', function (Blueprint $table) {

            $table->foreignId('agreement_id')->nullable()->constrained()->onUpdate('cascade');

            $table->dropForeign('distribution_practices_convention_id_foreign');
            $table->dropColumn('convention_id');
        });
    }
}
