<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('parent_name');

            $table->unsignedBigInteger('g_id');
            $table->unsignedBigInteger('g_parent_id');

            $table->foreignId('education_type_id')->constrained()->onUpdate('cascade');


            $table->unique(['g_id','g_parent_id', 'education_type_id' ]);

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
        Schema::dropIfExists('d_groups');
    }
}
