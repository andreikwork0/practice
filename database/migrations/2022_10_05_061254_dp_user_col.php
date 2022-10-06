<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DpUserCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribution_practices', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
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
            $table->dropForeign('distribution_practices_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
