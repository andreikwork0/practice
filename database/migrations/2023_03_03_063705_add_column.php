<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practices', function (Blueprint $table) {
            $table->string('block')->nullable();
        });
        Schema::table('practices_storage', function (Blueprint $table) {
            $table->string('block')->nullable();
        });
        Schema::table('practices_tmp', function (Blueprint $table) {
            $table->string('block')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practices', function (Blueprint $table) {
            $table->dropColumn('block');
        });
        Schema::table('practices_storage', function (Blueprint $table) {
            $table->dropColumn('block');
        });
        Schema::table('practices_tmp', function (Blueprint $table) {
            $table->dropColumn('block');
        });
    }
}
