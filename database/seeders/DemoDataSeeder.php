<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Job Types ──────────────────────────────────────────────────────
        $jobTypeIds = [];
        $jobTypes = ['Full Time', 'Part Time', 'Freelance', 'Internship', 'Remote'];
        foreach ($jobTypes as $name) {
            $existing = DB::table('job_types')->where('name', $name)->first();
            if ($existing) {
                $jobTypeIds[] = $existing->id;
            } else {
                $jobTypeIds[] = DB::table('job_types')->insertGetId([
                    'name'       => $name,
                    'status'     => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ── 2. Categories ─────────────────────────────────────────────────────
        $categoryIds = [];
        $categories = [
            'Information Technology',
            'Finance & Banking',
            'Marketing & Sales',
            'Design & Creative',
            'Engineering',
        ];
        foreach ($categories as $name) {
            $existing = DB::table('categories')->where('name', $name)->first();
            if ($existing) {
                $categoryIds[] = $existing->id;
            } else {
                $categoryIds[] = DB::table('categories')->insertGetId([
                    'name'       => $name,
                    'status'     => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ── 3. Country / City / District (re-use existing or create) ──────────
        $country = DB::table('countries')->where('name', 'Vietnam')->first();
        $countryId = $country ? $country->id : DB::table('countries')->insertGetId([
            'name' => 'Vietnam', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $city = DB::table('cities')->where('name', 'Ho Chi Minh City')->first();
        $cityId = $city ? $city->id : DB::table('cities')->insertGetId([
            'country_id' => $countryId, 'name' => 'Ho Chi Minh City',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $districtData = ['District 1', 'District 3', 'District 10', 'Binh Thanh District'];
        $districtIds = [];
        foreach ($districtData as $dName) {
            $d = DB::table('districts')->where('name', $dName)->where('city_id', $cityId)->first();
            $districtIds[] = $d ? $d->id : DB::table('districts')->insertGetId([
                'city_id' => $cityId, 'name' => $dName,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // ── 4. Employers ──────────────────────────────────────────────────────
        $employers = [
            [
                'name'     => 'TechVision Corp',
                'email'    => 'techvision@demo.com',
                'password' => Hash::make('password123'),
                'role'     => 'employer',
            ],
            [
                'name'     => 'FinServe Solutions',
                'email'    => 'finserve@demo.com',
                'password' => Hash::make('password123'),
                'role'     => 'employer',
            ],
            [
                'name'     => 'CreativeHub Agency',
                'email'    => 'creativehub@demo.com',
                'password' => Hash::make('password123'),
                'role'     => 'employer',
            ],
        ];

        $employerIds = [];
        foreach ($employers as $emp) {
            $existing = DB::table('users')->where('email', $emp['email'])->first();
            if ($existing) {
                $employerIds[] = $existing->id;
            } else {
                $employerIds[] = DB::table('users')->insertGetId(array_merge($emp, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        // ── 5. Jobs (5 per employer) ──────────────────────────────────────────
        $companyLocation = 'District 1, Ho Chi Minh City, Vietnam';

        $jobsPerEmployer = [
            // TechVision Corp
            [
                ['title' => 'Senior Laravel Developer',     'category_idx' => 0, 'jobtype_idx' => 0, 'experience' => '3',  'salary_range' => '1500_2000', 'salary_type' => 'net',   'work_arrangement' => 'onsite',  'description' => 'We are looking for a Senior Laravel Developer to build and maintain scalable web applications. You will work closely with our product team.', 'benefits' => '13th month salary, health insurance, flexible working hours.', 'keywords' => 'laravel, php, mysql, api'],
                ['title' => 'React Frontend Engineer',       'category_idx' => 0, 'jobtype_idx' => 0, 'experience' => '2',  'salary_range' => '1000_1500', 'salary_type' => 'gross', 'work_arrangement' => 'hybrid',  'description' => 'Join our frontend team to build stunning user interfaces using React.js and modern CSS frameworks.', 'benefits' => 'Remote Fridays, annual bonus, team lunch.', 'keywords' => 'react, javascript, frontend, css'],
                ['title' => 'DevOps Engineer',               'category_idx' => 0, 'jobtype_idx' => 0, 'experience' => '4',  'salary_range' => '2000_plus', 'salary_type' => 'net',   'work_arrangement' => 'remote',  'description' => 'Maintain and improve CI/CD pipelines, cloud infrastructure, and system reliability for our SaaS platform.', 'benefits' => 'Stock options, home office stipend, premium health plan.', 'keywords' => 'devops, docker, aws, ci/cd'],
                ['title' => 'Mobile Developer (Flutter)',    'category_idx' => 0, 'jobtype_idx' => 0, 'experience' => '2',  'salary_range' => '1000_1500', 'salary_type' => 'gross', 'work_arrangement' => 'onsite',  'description' => 'Develop cross-platform mobile apps for our growing user base using Flutter and Dart.', 'benefits' => 'MacBook Pro provided, training budget, gym membership.', 'keywords' => 'flutter, dart, mobile, ios, android'],
                ['title' => 'IT Support Specialist',         'category_idx' => 0, 'jobtype_idx' => 1, 'experience' => '1',  'salary_range' => '500_1000',  'salary_type' => 'gross', 'work_arrangement' => 'onsite',  'description' => 'Provide first-line technical support to our staff and help maintain internal IT infrastructure.', 'benefits' => 'Transport allowance, lunch provided, overtime pay.', 'keywords' => 'it support, helpdesk, networking, windows'],
            ],
            // FinServe Solutions
            [
                ['title' => 'Financial Analyst',             'category_idx' => 1, 'jobtype_idx' => 0, 'experience' => '3',  'salary_range' => '1500_2000', 'salary_type' => 'gross', 'work_arrangement' => 'onsite',  'description' => 'Analyze financial data, prepare reports, and provide insights to support business decision-making.', 'benefits' => 'Performance bonus, health insurance, annual leave 15 days.', 'keywords' => 'finance, excel, reporting, analysis'],
                ['title' => 'Accountant',                    'category_idx' => 1, 'jobtype_idx' => 0, 'experience' => '2',  'salary_range' => '1000_1500', 'salary_type' => 'net',   'work_arrangement' => 'onsite',  'description' => 'Manage day-to-day bookkeeping, prepare financial statements, and ensure regulatory compliance.', 'benefits' => '13th month salary, health check-up, team bonding activities.', 'keywords' => 'accounting, tax, bookkeeping, quickbooks'],
                ['title' => 'Risk & Compliance Officer',     'category_idx' => 1, 'jobtype_idx' => 0, 'experience' => '5',  'salary_range' => '2000_plus', 'salary_type' => 'gross', 'work_arrangement' => 'hybrid',  'description' => 'Oversee compliance frameworks, conduct risk assessments, and liaise with regulatory bodies.', 'benefits' => 'Leadership allowance, premium insurance, professional certification support.', 'keywords' => 'compliance, risk, regulation, banking'],
                ['title' => 'Investment Banking Intern',     'category_idx' => 1, 'jobtype_idx' => 3, 'experience' => '1',  'salary_range' => 'under_500',  'salary_type' => 'gross', 'work_arrangement' => 'onsite',  'description' => 'Support the investment banking team with market research, financial modeling, and pitch decks.', 'benefits' => 'Mentorship program, certificate of completion, networking events.', 'keywords' => 'intern, finance, investment, modeling'],
                ['title' => 'Customer Relationship Manager', 'category_idx' => 1, 'jobtype_idx' => 0, 'experience' => '3',  'salary_range' => '1000_1500', 'salary_type' => 'gross', 'work_arrangement' => 'onsite',  'description' => 'Build and maintain strong relationships with key clients, resolve issues, and drive customer satisfaction.', 'benefits' => 'Commission structure, phone allowance, car parking.', 'keywords' => 'crm, customer service, banking, relationship'],
            ],
            // CreativeHub Agency
            [
                ['title' => 'UI/UX Designer',                'category_idx' => 3, 'jobtype_idx' => 0, 'experience' => '2',  'salary_range' => '1000_1500', 'salary_type' => 'net',   'work_arrangement' => 'hybrid',  'description' => 'Design beautiful and intuitive user interfaces for our clients across web and mobile platforms using Figma.', 'benefits' => 'Creative environment, design tools budget, flexible hours.', 'keywords' => 'ui, ux, figma, design, wireframe'],
                ['title' => 'Graphic Designer',              'category_idx' => 3, 'jobtype_idx' => 0, 'experience' => '1',  'salary_range' => '500_1000',  'salary_type' => 'gross', 'work_arrangement' => 'onsite',  'description' => 'Create compelling visual content for social media, branding, and marketing campaigns.', 'benefits' => 'Adobe CC license provided, monthly team outing, training allowance.', 'keywords' => 'graphic design, photoshop, illustrator, branding'],
                ['title' => 'Content Marketing Specialist',  'category_idx' => 2, 'jobtype_idx' => 0, 'experience' => '2',  'salary_range' => '500_1000',  'salary_type' => 'gross', 'work_arrangement' => 'remote',  'description' => 'Develop and execute content strategies including blog posts, social media content, and email campaigns.', 'benefits' => 'Work from anywhere, performance bonus, learning budget.', 'keywords' => 'content, marketing, seo, social media, copywriting'],
                ['title' => 'Video Editor & Motion Designer','category_idx' => 3, 'jobtype_idx' => 2, 'experience' => '2',  'salary_range' => '500_1000',  'salary_type' => 'net',   'work_arrangement' => 'hybrid',  'description' => 'Edit promotional videos and create motion graphics for client campaigns and social media channels.', 'benefits' => 'High-spec workstation, project bonus, flexible schedule.', 'keywords' => 'video editing, after effects, premiere, motion graphics'],
                ['title' => 'Digital Marketing Manager',     'category_idx' => 2, 'jobtype_idx' => 0, 'experience' => '5',  'salary_range' => '1500_2000', 'salary_type' => 'gross', 'work_arrangement' => 'onsite',  'description' => 'Lead digital marketing strategy, manage paid campaigns across Google and Meta, and drive measurable growth.', 'benefits' => 'Leadership bonus, health package, company events.', 'keywords' => 'digital marketing, google ads, meta, seo, analytics'],
            ],
        ];

        $companyNames = ['TechVision Corp', 'FinServe Solutions', 'CreativeHub Agency'];

        foreach ($jobsPerEmployer as $empIdx => $jobs) {
            foreach ($jobs as $j) {
                DB::table('jobs')->insert([
                    'title'              => $j['title'],
                    'category_id'        => $categoryIds[$j['category_idx']],
                    'job_type_id'        => $jobTypeIds[$j['jobtype_idx']],
                    'user_id'            => $employerIds[$empIdx],
                    'vacancy'            => rand(1, 5),
                    'salary'             => $j['salary_range'],
                    'salary_range'       => $j['salary_range'],
                    'salary_type'        => $j['salary_type'],
                    'location'           => $companyLocation,
                    'country_id'         => $countryId,
                    'city_id'            => $cityId,
                    'district_id'        => $districtIds[array_rand($districtIds)],
                    'work_arrangement'   => $j['work_arrangement'],
                    'description'        => $j['description'],
                    'benefits'           => $j['benefits'],
                    'keywords'           => $j['keywords'],
                    'experience'         => $j['experience'],
                    'company_name'       => $companyNames[$empIdx],
                    'company_location'   => $companyLocation,
                    'company_country_id' => $countryId,
                    'company_city_id'    => $cityId,
                    'company_district_id'=> $districtIds[0],
                    'company_website'    => 'https://example.com',
                    'status'             => 1,
                    'isFeatured'         => ($empIdx === 0) ? 1 : 0, // TechVision jobs are featured
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }
        }

        // ── 6. Job-seeker demo users ───────────────────────────────────────────
        $seekers = [
            ['name' => 'Alice Nguyen',  'email' => 'alice@demo.com'],
            ['name' => 'Bob Tran',      'email' => 'bob@demo.com'],
            ['name' => 'Carol Le',      'email' => 'carol@demo.com'],
        ];
        foreach ($seekers as $s) {
            if (!DB::table('users')->where('email', $s['email'])->exists()) {
                DB::table('users')->insert(array_merge($s, [
                    'password'   => Hash::make('password123'),
                    'role'       => 'user',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        $this->command->info('✅  Demo data seeded successfully!');
        $this->command->info('   Employers : techvision@demo.com | finserve@demo.com | creativehub@demo.com  (password: password123)');
        $this->command->info('   Job-seekers: alice@demo.com | bob@demo.com | carol@demo.com  (password: password123)');
    }
}
