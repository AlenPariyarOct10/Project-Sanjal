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
//        Links algorithms to algorithm categories
        Schema::create('algorithm_algorithm_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('algorithm_id')->constrained('algorithms')->onDelete('cascade');
            $table->foreignId('algorithm_category_id')->constrained('algorithm_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('algorithm_algorithm_category');
    }
};
