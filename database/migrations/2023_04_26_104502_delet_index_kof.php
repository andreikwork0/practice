<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeletIndexKof extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kind_of_activities', function (Blueprint $table) {

            $table->dropForeign('kind_of_activities_spec_id_foreign');
         //   $table->bigInteger('spec_id')->change();

            $table->dropUnique(['spec_id', 'code']);

            $table->foreignId('spec_id')->change()->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kind_of_activities', function (Blueprint $table) {

            $table->unique(['spec_id', 'code']);
        });
    }
}
