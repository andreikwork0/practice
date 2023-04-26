<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeacherCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pr_students', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->constrained()->onUpdate('cascade')->nullOnDelete();

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
            $table->dropForeign('pr_students_teacher_id_foreign');
            $table->dropColumn('teacher_id');
        });
    }
}
