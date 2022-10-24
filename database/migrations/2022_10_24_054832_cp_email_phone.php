<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CpEmailPhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_people', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->string('prs_rule', 50)->change();
            $table->string('prs_lname', 50)->change();
            $table->string('prs_fname', 50)->change();
            $table->string('prs_sname', 50)->nullable()->change();
            $table->string('prs_office')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_people', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('email');

            $table->string('prs_rule', 30)->change();;
            $table->string('prs_lname', 20)->change();;
            $table->string('prs_fname', 20)->change();;
            $table->string('prs_sname', 20)->nullable()->change();;
            $table->string('prs_office', 50)->nullable()->change();
        });
    }
}
