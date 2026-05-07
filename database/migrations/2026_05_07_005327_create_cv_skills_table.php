<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            $table->foreignId('proficiency_level_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['cv_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_skills');
    }
};