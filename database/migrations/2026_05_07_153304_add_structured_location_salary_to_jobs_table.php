<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->after('location')->constrained('countries')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->after('country_id')->constrained('cities')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->after('city_id')->constrained('districts')->nullOnDelete();

            $table->enum('work_arrangement', ['onsite', 'remote', 'hybrid'])->nullable()->after('district_id');

            $table->string('salary_range')->nullable()->after('salary');
            $table->enum('salary_type', ['gross', 'net'])->nullable()->after('salary_range');
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['district_id']);

            $table->dropColumn([
                'country_id',
                'city_id',
                'district_id',
                'work_arrangement',
                'salary_range',
                'salary_type',
            ]);
        });
    }
};