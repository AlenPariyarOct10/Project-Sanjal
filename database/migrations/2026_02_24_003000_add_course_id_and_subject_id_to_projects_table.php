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
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable()->after('status');
            $table->unsignedBigInteger('subject_id')->nullable()->after('course_id');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->nullOnDelete();

            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['subject_id']);
            $table->dropColumn(['course_id', 'subject_id']);
        });
    }
};
