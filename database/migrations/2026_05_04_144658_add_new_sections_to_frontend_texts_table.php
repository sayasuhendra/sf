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
        Schema::table('frontend_texts', function (Blueprint $table) {
            $table->json('about')->nullable();
            $table->json('pillars')->nullable();
            $table->json('program')->nullable();
            $table->json('sponsor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('frontend_texts', function (Blueprint $table) {
            $table->dropColumn(['about', 'pillars', 'program', 'sponsor']);
        });
    }
};
