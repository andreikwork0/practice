<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PracticeFidKofactivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practices', function (Blueprint $table) {
            $table->foreignId('kind_of_activity_id')->nullable()->constrained()->onUpdate('cascade')->nullOnDelete();

        });

        Schema::table('practices_storage', function (Blueprint $table) {
            $table->bigInteger('kind_of_activity_id')->nullable();

        });
        Schema::table('practices_tmp', function (Blueprint $table) {
            $table->bigInteger('kind_of_activity_id')->nullable();

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
            $table->dropForeign('practices_kind_of_activity_id_foreign');
            $table->dropColumn('kind_of_activity_id');
        });

        Schema::table('practices_storage', function (Blueprint $table) {
            $table->dropColumn('kind_of_activity_id');

        });
        Schema::table('practices_tmp', function (Blueprint $table) {
            $table->dropColumn('kind_of_activity_id');

        });
    }
}
