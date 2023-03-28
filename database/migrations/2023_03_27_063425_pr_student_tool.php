<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrStudentTool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_student_tool', function (Blueprint $table) {
            $table->primary(['pr_student_id', 'tool_id']);
            $table->foreignId('pr_student_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tool_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pr_student_tool');
    }
}
