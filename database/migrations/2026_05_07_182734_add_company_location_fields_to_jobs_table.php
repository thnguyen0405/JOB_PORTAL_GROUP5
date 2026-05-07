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
        Schema::table('jobs', function (Blueprint $table) {
            $table->foreignId('company_country_id')->nullable()->after('company_location')->constrained('countries')->nullOnDelete();
            $table->foreignId('company_city_id')->nullable()->after('company_country_id')->constrained('cities')->nullOnDelete();
            $table->foreignId('company_district_id')->nullable()->after('company_city_id')->constrained('districts')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['company_country_id']);
            $table->dropForeign(['company_city_id']);
            $table->dropForeign(['company_district_id']);

            $table->dropColumn([
                'company_country_id',
                'company_city_id',
                'company_district_id',
            ]);
        });
    }
};
