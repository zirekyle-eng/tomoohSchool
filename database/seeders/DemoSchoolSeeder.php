<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoSchoolSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $market = DB::table('markets')->first();

        if (! $market) {
            $marketId = DB::table('markets')->insertGetId([
                'code' => 'PS',
                'name' => 'فلسطين',
                'timezone' => 'Asia/Gaza',
                'currency_code' => 'ILS',
                'currency_name' => 'شيكل',
                'active' => true,
            ]);
        } else {
            $marketId = $market->id;
        }

        $grades = [];
        foreach ([
            ['name' => 'الصف 12', 'sort_order' => 12],
            ['name' => 'الصف 11', 'sort_order' => 11],
            ['name' => 'الصف 10', 'sort_order' => 10],
        ] as $grade) {
            $grades[$grade['name']] = DB::table('grades')->updateOrInsert(
                ['name' => $grade['name']],
                ['sort_order' => $grade['sort_order'], 'curriculum' => 'النظام المدرسي'],
            );
            $grades[$grade['name']] = DB::table('grades')->where('name', $grade['name'])->value('id');
        }

        $teacherId = $this->user($marketId, [
            'phone' => '0599000001',
            'full_name' => 'أحمد المدرس التجريبي',
            'role' => 'teacher',
            'student_mode' => 'regular',
        ]);
        $this->user($marketId, [
            'phone' => '0599000002',
            'full_name' => 'مدير المدرسة التجريبي',
            'role' => 'admin',
            'student_mode' => 'regular',
        ]);
        $regularId = $this->user($marketId, [
            'phone' => '0599000011',
            'full_name' => 'طالب نظامي - محمد',
            'role' => 'student',
            'student_mode' => 'regular',
            'grade_level' => '12',
            'branch' => 'scientific',
        ]);
        $externalId = $this->user($marketId, [
            'phone' => '0599000012',
            'full_name' => 'طالب خارجي - سارة',
            'role' => 'student',
            'student_mode' => 'external',
            'grade_level' => '12',
            'branch' => 'literary',
        ]);

        $englishId = $this->subject($grades['الصف 12'], $marketId, 'اللغة الإنجليزية', 'general', $teacherId);
        $mathId = $this->subject($grades['الصف 12'], $marketId, 'الرياضيات المتقدمة', 'scientific', $teacherId);

        $sharedSectionId = $this->section('الصف 12 - إنجليزي مشتركة علمي وأدبي', '12', null, true);
        $scientificSectionId = $this->section('الصف 12 - رياضيات علمي', '12', 'scientific', false);

        $this->enrollment($regularId, $englishId, $sharedSectionId, 'regular');
        $this->enrollment($regularId, $mathId, $scientificSectionId, 'regular');
        $this->enrollment($externalId, $englishId, $sharedSectionId, 'subject_only');

        $englishSunday = $this->schedule($englishId, $sharedSectionId, $teacherId, 2, '11:00', '12:00', 'English-12-Shared');
        $mathSunday = $this->schedule($mathId, $scientificSectionId, $teacherId, 2, '12:15', '13:15', 'Math-12-Scientific');
        $this->schedule($englishId, $sharedSectionId, $teacherId, 3, '10:00', '11:00', 'English-12-Shared');
        $this->schedule($mathId, $scientificSectionId, $teacherId, 4, '13:00', '14:00', 'Math-12-Scientific');

        $regularEnglishEnrollment = DB::table('enrollments')
            ->where('student_id', $regularId)->where('subject_id', $englishId)->value('id');
        $externalEnglishEnrollment = DB::table('enrollments')
            ->where('student_id', $externalId)->where('subject_id', $englishId)->value('id');

        foreach ([
            [$regularId, $englishSunday, $regularEnglishEnrollment],
            [$regularId, $mathSunday, DB::table('enrollments')->where('student_id', $regularId)->where('subject_id', $mathId)->value('id')],
            [$externalId, $englishSunday, $externalEnglishEnrollment],
        ] as [$studentId, $scheduleId, $enrollmentId]) {
            DB::table('student_schedule')->updateOrInsert(
                ['student_id' => $studentId, 'schedule_id' => $scheduleId],
                ['enrollment_id' => $enrollmentId, 'active_from' => today()->toDateString(), 'active_until' => null],
            );
        }

        $this->command?->info('تم تجهيز بيانات المدرسة التجريبية.');
        $this->command?->line('نظامي: 0599000011 / Demo@12345');
        $this->command?->line('خارجي: 0599000012 / Demo@12345');
        $this->command?->line('مدرس: 0599000001 / Demo@12345');
        $this->command?->line('مدير: 0599000002 / Demo@12345');
    }

    private function user(int $marketId, array $data): int
    {
        $phone = $data['phone'];
        $attributes = [
            ...$data,
            'email' => $data['email'] ?? null,
            'password_hash' => Hash::make('Demo@12345'),
            'status' => 'active',
            'market_id' => $marketId,
            'country' => 'فلسطين',
            'city' => 'رام الله',
            'updated_at' => now(),
        ];
        unset($attributes['password']);

        DB::table('users')->updateOrInsert(
            ['phone' => $phone],
            [...$attributes, 'created_at' => now()],
        );

        return (int) DB::table('users')->where('phone', $phone)->value('id');
    }

    private function subject(int $gradeId, int $marketId, string $name, string $branch, int $teacherId): int
    {
        DB::table('subjects')->updateOrInsert(
            ['grade_id' => $gradeId, 'name' => $name],
            [
                'market_id' => $marketId,
                'tawjihi_branch' => $branch,
                'delivery_type' => 'live',
                'sessions_per_week' => 2,
                'total_hours' => 40,
                'monthly_fee' => 100,
                'primary_teacher_id' => $teacherId,
                'status' => 'active',
            ],
        );

        return (int) DB::table('subjects')->where('grade_id', $gradeId)->where('name', $name)->value('id');
    }

    private function section(string $name, string $gradeLevel, ?string $branch, bool $shared): int
    {
        DB::table('sections')->updateOrInsert(
            ['name' => $name],
            [
                'grade_level' => $gradeLevel,
                'branch' => $branch,
                'mode' => 'regular',
                'is_shared' => $shared,
                'status' => 'active',
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );

        return (int) DB::table('sections')->where('name', $name)->value('id');
    }

    private function enrollment(int $studentId, int $subjectId, int $sectionId, string $mode): void
    {
        DB::table('enrollments')->updateOrInsert(
            ['student_id' => $studentId, 'subject_id' => $subjectId],
            [
                'section_id' => $sectionId,
                'enrollment_mode' => $mode,
                'starts_on' => today()->toDateString(),
                'status' => 'active',
                'created_at' => now(),
            ],
        );
    }

    private function schedule(int $subjectId, int $sectionId, int $teacherId, int $day, string $starts, string $ends, string $room): int
    {
        DB::table('class_schedules')->updateOrInsert(
            ['subject_id' => $subjectId, 'section_id' => $sectionId, 'day_of_week' => $day, 'starts_at' => $starts],
            [
                'teacher_id' => $teacherId,
                'ends_at' => $ends,
                'room_code' => $room,
                'status' => 'active',
            ],
        );

        return (int) DB::table('class_schedules')
            ->where('subject_id', $subjectId)
            ->where('section_id', $sectionId)
            ->where('day_of_week', $day)
            ->where('starts_at', $starts)
            ->value('id');
    }
}
