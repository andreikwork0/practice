<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_short')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        Schema::table('tools', function (Blueprint $table) {
            $table->foreignId('t_category_id')->nullable()->constrained()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('tools', function (Blueprint $table) {

            $table->dropForeign('tools_t_category_id_foreign');
            $table->dropColumn('t_category_id');
        });
        Schema::dropIfExists('t_categories');
    }
}
