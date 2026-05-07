<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_work_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->cascadeOnDelete();

            $table->string('company_name');
            $table->string('job_title');

            $table->foreignId('job_type_id')->nullable()->constrained('job_types')->nullOnDelete();
            $table->foreignId('industry_id')->constrained()->cascadeOnDelete();

            $table->year('start_year');
            $table->year('end_year')->nullable();
            $table->boolean('is_present')->default(false);
            $table->text('job_description');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_work_histories');
    }
};