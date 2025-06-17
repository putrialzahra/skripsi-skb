<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('class_students', function (Blueprint $table) {
        // Drop the old (wrong) foreign key first
        $table->dropForeign(['student_id']);

        // Add the correct foreign key to the users table
        $table->foreign('student_id')->references('id')->on('users')->cascadeOnDelete();
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_students', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete(); // assuming original was like this
        });

    }
};
