<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table): void {
                if (! Schema::hasColumn('users', 'student_mode')) {
                    $table->string('student_mode', 20)->default('regular')->after('role');
                }
                if (! Schema::hasColumn('users', 'grade_level')) {
                    $table->string('grade_level', 30)->nullable()->after('student_mode');
                }
                if (! Schema::hasColumn('users', 'branch')) {
                    $table->string('branch', 30)->nullable()->after('grade_level');
                }
            });
        }

        if (! Schema::hasTable('sections')) {
            Schema::create('sections', function (Blueprint $table): void {
                $table->id();
                $table->string('name', 160);
                $table->string('grade_level', 30)->nullable();
                $table->string('branch', 30)->nullable();
                $table->string('mode', 20)->default('regular');
                $table->boolean('is_shared')->default(false);
                $table->string('status', 20)->default('active');
                $table->timestamps();
                $table->index(['grade_level', 'branch', 'status']);
            });
        }

        if (Schema::hasTable('enrollments')) {
            Schema::table('enrollments', function (Blueprint $table): void {
                if (! Schema::hasColumn('enrollments', 'section_id')) {
                    $table->unsignedBigInteger('section_id')->nullable()->after('subject_id');
                    $table->index('section_id');
                }
                if (! Schema::hasColumn('enrollments', 'enrollment_mode')) {
                    $table->string('enrollment_mode', 20)->default('subject_only')->after('section_id');
                }
            });
        }

        if (Schema::hasTable('class_schedules') && ! Schema::hasColumn('class_schedules', 'section_id')) {
            Schema::table('class_schedules', function (Blueprint $table): void {
                $table->unsignedBigInteger('section_id')->nullable()->after('subject_id');
                $table->index(['section_id', 'day_of_week', 'starts_at']);
            });
        }

        if (! Schema::hasTable('student_attendance')) {
            Schema::create('student_attendance', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('student_id');
                $table->date('attendance_date');
                $table->timestamp('started_at');
                $table->timestamp('ended_at')->nullable();
                $table->string('status', 20)->default('active');
                $table->timestamps();
                $table->unique(['student_id', 'attendance_date']);
                $table->index(['student_id', 'status']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('student_attendance');

        if (Schema::hasTable('class_schedules') && Schema::hasColumn('class_schedules', 'section_id')) {
            Schema::table('class_schedules', fn (Blueprint $table) => $table->dropColumn('section_id'));
        }

        if (Schema::hasTable('enrollments')) {
            Schema::table('enrollments', function (Blueprint $table): void {
                foreach (['section_id', 'enrollment_mode'] as $column) {
                    if (Schema::hasColumn('enrollments', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        Schema::dropIfExists('sections');

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table): void {
                foreach (['student_mode', 'grade_level', 'branch'] as $column) {
                    if (Schema::hasColumn('users', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
