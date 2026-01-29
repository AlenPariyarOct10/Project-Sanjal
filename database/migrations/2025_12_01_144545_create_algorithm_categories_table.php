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
        Schema::create('algorithm_categories', function (Blueprint $table) {
            $table->id();
            $table->string('type');  // e.g., 'Design Approach', 'Problem Type', 'Complexity'
            $table->string('name'); // e.g., 'Divide and Conquer'
            $table->string('description')->nullable();
            $table->string('slug')->unique();
            $table->string('key')->unique();
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('algorithm_categories');
    }
};
