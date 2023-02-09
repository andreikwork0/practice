<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pr_students', function (Blueprint $table) {
            $table->string('st_type')->nullable()->default('практикант');
            $table->string('org_empl_fio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pr_students', function (Blueprint $table) {
            $table->dropColumn('st_type');
            $table->dropColumn('org_empl_fio');
        });
    }
}
