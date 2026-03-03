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
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropUnique(['project_id', 'user_id']);
            $table->dropColumn('project_id');

            $table->unsignedBigInteger('team_id')->after('id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unique(['team_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropUnique(['team_id', 'user_id']);
            $table->dropColumn('team_id');

            $table->unsignedBigInteger('project_id')->after('id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unique(['project_id', 'user_id']);
        });
    }
};
