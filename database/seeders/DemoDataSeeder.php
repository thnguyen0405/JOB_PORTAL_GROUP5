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
                // Skip if this exact job title already exists for this employer
                if (DB::table('jobs')->where('title', $j['title'])->where('user_id', $employerIds[$empIdx])->exists()) {
                    continue;
                }

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
                    'isFeatured'         => ($empIdx === 0) ? 1 : 0,
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

        // ── 7. Collect seeder users & reference IDs ───────────────────────────
        $seekerEmails = ['alice@demo.com', 'bob@demo.com', 'carol@demo.com'];
        $seekerIds    = DB::table('users')->whereIn('email', $seekerEmails)->pluck('id')->toArray();

        $cvCategoryId       = DB::table('cv_categories')->first()->id;
        $institutionId      = DB::table('institutions')->first()->id;
        $degreeLevelId      = DB::table('degree_levels')->where('name', 'Bachelor')->first()->id;
        $majorId            = DB::table('majors')->first()->id;
        $industryId         = DB::table('industries')->first()->id;
        $certNameId         = DB::table('certificate_names')->first()->id;
        $issuingOrgId       = DB::table('issuing_organizations')->first()->id;
        $skillIds           = DB::table('skills')->pluck('id')->toArray();
        $proficiencyLevelId = DB::table('proficiency_levels')->where('name', 'Intermediate')->first()->id;
        $jobTypeId          = $jobTypeIds[0]; // Full Time

        $seekerProfiles = [
            [
                'full_name'    => 'Alice Nguyen',
                'gender'       => 'Female',
                'dob'          => '1999-03-15',
                'phone'        => '0901234567',
                'street'       => '12 Nguyen Hue',
                'postal'       => '700000',
                'summary'      => 'Passionate software developer with 2 years of experience in web development using PHP and Laravel.',
                'skills'       => [0, 1, 2], // PHP, Laravel, JavaScript
                'work_title'   => 'Junior PHP Developer',
                'work_company' => 'Startup X',
            ],
            [
                'full_name'    => 'Bob Tran',
                'gender'       => 'Male',
                'dob'          => '1998-07-22',
                'phone'        => '0912345678',
                'street'       => '45 Le Loi',
                'postal'       => '700000',
                'summary'      => 'Finance graduate with strong analytical skills and experience in financial reporting and data analysis.',
                'skills'       => [3, 4, 5], // HTML, CSS, MySQL
                'work_title'   => 'Financial Analyst Intern',
                'work_company' => 'Finance Corp',
            ],
            [
                'full_name'    => 'Carol Le',
                'gender'       => 'Female',
                'dob'          => '2000-11-05',
                'phone'        => '0923456789',
                'street'       => '78 Tran Hung Dao',
                'postal'       => '700000',
                'summary'      => 'Creative designer with a strong eye for aesthetics and 1 year of experience in UI/UX and graphic design.',
                'skills'       => [6, 7, 8], // React, Communication, Teamwork
                'work_title'   => 'UI/UX Design Intern',
                'work_company' => 'Creative Studio Y',
            ],
        ];

        foreach ($seekerIds as $i => $seekerId) {
            // Skip if CV already exists
            if (DB::table('cvs')->where('user_id', $seekerId)->exists()) {
                continue;
            }

            $profile = $seekerProfiles[$i];

            // Create CV
            $cvId = DB::table('cvs')->insertGetId([
                'user_id'        => $seekerId,
                'cv_category_id' => $cvCategoryId,
                'full_name'      => $profile['full_name'],
                'date_of_birth'  => $profile['dob'],
                'gender'         => $profile['gender'],
                'email'          => $seekerEmails[$i],
                'phone_number'   => $profile['phone'],
                'country_id'     => $countryId,
                'city_id'        => $cityId,
                'district_id'    => $districtIds[0],
                'street_address' => $profile['street'],
                'postal_code'    => $profile['postal'],
                'summary'        => $profile['summary'],
                'template'       => 'modern',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // Education
            DB::table('cv_educations')->insert([
                'cv_id'           => $cvId,
                'institution_id'  => $institutionId,
                'degree_level_id' => $degreeLevelId,
                'major_id'        => $majorId,
                'start_year'      => 2018,
                'end_year'        => 2022,
                'description'     => 'Graduated with honors.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Work History
            DB::table('cv_work_histories')->insert([
                'cv_id'           => $cvId,
                'company_name'    => $profile['work_company'],
                'job_title'       => $profile['work_title'],
                'job_type_id'     => $jobTypeId,
                'industry_id'     => $industryId,
                'start_year'      => 2022,
                'end_year'        => null,
                'is_present'      => true,
                'job_description' => 'Responsible for day-to-day tasks related to ' . $profile['work_title'] . '.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Certificate
            DB::table('cv_certificates')->insert([
                'cv_id'                   => $cvId,
                'certificate_name_id'     => $certNameId,
                'issuing_organization_id' => $issuingOrgId,
                'year_issued'             => 2023,
                'description'             => 'Passed with high score.',
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);

            // Skills (3 per user, unique)
            $usedSkills = [];
            foreach ($profile['skills'] as $skillIdx) {
                $skillId = $skillIds[$skillIdx];
                if (!in_array($skillId, $usedSkills)) {
                    DB::table('cv_skills')->insert([
                        'cv_id'               => $cvId,
                        'skill_id'            => $skillId,
                        'proficiency_level_id'=> $proficiencyLevelId,
                        'created_at'          => now(),
                        'updated_at'          => now(),
                    ]);
                    $usedSkills[] = $skillId;
                }
            }
        }

        // ── 8. Job Applications (each user applies to 3 different jobs) ───────
        $allJobIds = DB::table('jobs')->where('status', 1)->pluck('id', 'user_id');
        $allJobs   = DB::table('jobs')->where('status', 1)->get();

        foreach ($seekerIds as $seekerId) {
            $applied = 0;
            foreach ($allJobs->shuffle() as $job) {
                // Don't apply to own jobs (seekers have no jobs, but good practice)
                if ($job->user_id == $seekerId) continue;
                // Don't apply twice
                if (DB::table('job_applications')->where(['user_id' => $seekerId, 'job_id' => $job->id])->exists()) continue;

                DB::table('job_applications')->insert([
                    'user_id'      => $seekerId,
                    'job_id'       => $job->id,
                    'employer_id'  => $job->user_id,
                    'applied_date' => now(),
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);

                $applied++;
                if ($applied >= 3) break;
            }
        }

        $this->command->info('✅  Demo data seeded successfully!');
        $this->command->info('   Employers  : techvision@demo.com | finserve@demo.com | creativehub@demo.com  (password: password123)');
        $this->command->info('   Job-seekers: alice@demo.com | bob@demo.com | carol@demo.com  (password: password123)');
        $this->command->info('   Each seeker has a full CV + 3 job applications.');
    }
}
