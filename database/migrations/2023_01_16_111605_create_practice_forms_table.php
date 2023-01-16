<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('practices', function (Blueprint $table) {
            $table->foreignId('practice_form_id')->nullable()->constrained('practice_forms')->onUpdate('cascade');
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
            $table->dropForeign('practices_practice_form_id_foreign');
            $table->dropColumn('practice_form_id');
        });
        Schema::dropIfExists('practice_forms');

    }
}
