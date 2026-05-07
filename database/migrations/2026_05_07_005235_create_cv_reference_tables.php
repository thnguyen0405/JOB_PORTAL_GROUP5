<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('degree_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('certificate_names', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('issuing_organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('proficiency_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rank')->default(1);
            $table->timestamps();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('cv_categories')->insert([
            ['name' => 'Software Development'],
            ['name' => 'Data Science'],
            ['name' => 'Finance & Accounting'],
            ['name' => 'Marketing'],
            ['name' => 'Education'],
            ['name' => 'Design & Creative'],
        ]);

        DB::table('degree_levels')->insert([
            ['name' => 'High School'],
            ['name' => 'Diploma'],
            ['name' => 'Bachelor'],
            ['name' => 'Master'],
            ['name' => 'PhD'],
        ]);

        DB::table('majors')->insert([
            ['name' => 'Computer Science'],
            ['name' => 'Information Technology'],
            ['name' => 'Business Administration'],
            ['name' => 'Marketing'],
            ['name' => 'Finance'],
            ['name' => 'Graphic Design'],
        ]);

        DB::table('institutions')->insert([
            ['name' => 'Ho Chi Minh City University of Technology'],
            ['name' => 'University of Economics Ho Chi Minh City'],
            ['name' => 'FPT University'],
            ['name' => 'RMIT University Vietnam'],
        ]);

        DB::table('industries')->insert([
            ['name' => 'Information Technology'],
            ['name' => 'Finance'],
            ['name' => 'Education'],
            ['name' => 'Marketing'],
            ['name' => 'Design'],
        ]);

        DB::table('certificate_names')->insert([
            ['name' => 'IELTS'],
            ['name' => 'TOEIC'],
            ['name' => 'AWS Certified Cloud Practitioner'],
            ['name' => 'Google Data Analytics Certificate'],
            ['name' => 'Laravel Certification'],
        ]);

        DB::table('issuing_organizations')->insert([
            ['name' => 'British Council'],
            ['name' => 'ETS'],
            ['name' => 'Amazon Web Services'],
            ['name' => 'Google'],
            ['name' => 'Microsoft'],
        ]);

        DB::table('skills')->insert([
            ['name' => 'PHP'],
            ['name' => 'Laravel'],
            ['name' => 'JavaScript'],
            ['name' => 'HTML'],
            ['name' => 'CSS'],
            ['name' => 'MySQL'],
            ['name' => 'React'],
            ['name' => 'Communication'],
            ['name' => 'Teamwork'],
        ]);

        DB::table('proficiency_levels')->insert([
            ['name' => 'Beginner', 'rank' => 1],
            ['name' => 'Intermediate', 'rank' => 2],
            ['name' => 'Advanced', 'rank' => 3],
            ['name' => 'Expert', 'rank' => 4],
        ]);

        $vietnamId = DB::table('countries')->insertGetId(['name' => 'Vietnam']);

        $hcmcId = DB::table('cities')->insertGetId([
            'country_id' => $vietnamId,
            'name' => 'Ho Chi Minh City',
        ]);

        DB::table('districts')->insert([
            ['city_id' => $hcmcId, 'name' => 'District 1'],
            ['city_id' => $hcmcId, 'name' => 'District 3'],
            ['city_id' => $hcmcId, 'name' => 'District 10'],
            ['city_id' => $hcmcId, 'name' => 'Binh Thanh District'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('districts');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('proficiency_levels');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('issuing_organizations');
        Schema::dropIfExists('certificate_names');
        Schema::dropIfExists('industries');
        Schema::dropIfExists('institutions');
        Schema::dropIfExists('majors');
        Schema::dropIfExists('degree_levels');
        Schema::dropIfExists('cv_categories');
    }
};