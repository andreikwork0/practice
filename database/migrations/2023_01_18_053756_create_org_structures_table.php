<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_structures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_short')->nullable();
            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('org_structure_id')->nullable()->constrained('org_structures')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['name', 'company_id', 'org_structure_id']);
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
        Schema::dropIfExists('org_structures');
    }
}
