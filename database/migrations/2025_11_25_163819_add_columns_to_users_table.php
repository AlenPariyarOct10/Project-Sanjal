<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('website')->nullable();

            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();

            $table->text('description')->nullable();
            $table->string('profile_image')->nullable();

            $table->unsignedBigInteger('college_id')->nullable();
            $table->foreign('college_id')
                ->references('id')
                ->on('colleges')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['college_id']);

            $table->dropColumn([
                'phone',
                'address',
                'city',
                'state',
                'country',
                'website',
                'facebook',
                'twitter',
                'instagram',
                'youtube',
                'linkedin',
                'github',
                'description',
                'profile_image',
                'college_id',
            ]);
        });
    }
};
