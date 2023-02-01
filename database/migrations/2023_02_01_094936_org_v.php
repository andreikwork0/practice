<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrgV extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('org_structures', function (Blueprint $table) {
            $table->tinyInteger('is_disabled')->default(0);
            $table->string('kod_dep')->nullable();
            $table->string('kod_dep_parent')->nullable();
            $table->integer('version')->default(0);
            $table->dropUnique(['name', 'company_id', 'org_structure_id']);
            $table->unique(['name', 'company_id', 'org_structure_id', 'version']);
            $table->unique(['kod_dep', 'company_id', 'kod_dep_parent', 'version']);
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->integer('org_structure_version')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('org_structures', function (Blueprint $table) {
            $table->unique(['name', 'company_id', 'org_structure_id']);
            $table->dropUnique(['name', 'company_id', 'org_structure_id', 'version']);
            $table->dropUnique(['kod_dep', 'company_id', 'kod_dep_parent', 'version']);
            $table->dropColumn('is_disabled');
            $table->dropColumn('kod_dep');
            $table->dropColumn('kod_dep_parent');
            $table->dropColumn('version');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('org_structure_version');
        });

    }
}
