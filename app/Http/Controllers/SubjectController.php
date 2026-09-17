<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function index(): View
    {
        $student = Auth::user();

        $subjectsQuery = Subject::query()
            ->with('grade')
            ->where('status', 'active');

        if ($student && $student->role === 'student') {
            $gradeId = DB::table('grades')
                ->get(['id', 'name'])
                ->first(function ($grade) use ($student): bool {
                    $normalized = preg_replace('/^الصف\s*/u', '', $grade->name) ?: $grade->name;

                    return $normalized === $student->grade_level;
                })?->id;

                $subjectsQuery
                ->where('grade_id', $gradeId ?? 0)
                ->when($student->market_id, fn ($query) => $query->where('market_id', $student->market_id));
        }
        // dd($gradeId);

        $subjects = $subjectsQuery->orderBy('name')->get();

        return view('subjects.index', compact('subjects'));
    }

    public function dashboard(): View
    {
        $student = Auth::user();
        $enrollments = DB::table('enrollments as e')
            ->join('subjects as s', 's.id', '=', 'e.subject_id')
            ->leftJoin('grades as g', 'g.id', '=', 's.grade_id')
            ->where('e.student_id', $student->id)
            ->orderByDesc('e.created_at')
            ->select('e.id', 's.name as subject_name', 'g.name as grade_name', 'e.status', 's.delivery_type', 's.recorded_lectures_url')
            ->get();

        $classes = DB::table('enrollments as e')
            ->join('class_schedules as cs', 'cs.subject_id', '=', 'e.subject_id')
            ->join('subjects as s', 's.id', '=', 'cs.subject_id')
            ->join('users as u', 'u.id', '=', 'cs.teacher_id')
            ->where('e.student_id', $student->id)
            ->where('e.status', 'active')
            ->where('cs.status', 'active')
            ->where(function ($query): void {
                $query->whereNull('cs.section_id')
                    ->orWhereColumn('cs.section_id', 'e.section_id');
            })
            ->orderBy('cs.day_of_week')->orderBy('cs.starts_at')
            ->select('cs.id as schedule_id', 's.name as subject_name', 'u.full_name as teacher_name', 'cs.day_of_week', 'cs.starts_at', 'cs.ends_at', 'cs.viva_z_join_url', 'cs.viva_z_meeting_id', 'cs.bbb_attendee_password')
            ->get();

        $classes->transform(function (object $class): object {
            $class->viva_z_join_url = route('bbb.student.join', ['id' => $class->schedule_id]);
            $class->access_state = $this->classAccessState($class);

            return $class;
        });

        $today = $this->schoolDayNumber();
        $now = now();
        $schoolDayOpen = $this->isSchoolHours($now) && in_array($today, $this->schoolDays(), true);
        $attendanceStarted = DB::table('student_attendance')
            ->where('student_id', $student->id)
            ->whereDate('attendance_date', today())
            ->where('status', 'active')
            ->exists();

        return view('dashboard', compact('enrollments', 'classes', 'schoolDayOpen', 'attendanceStarted'));
    }




    public function updateProfile(Request $request): RedirectResponse
{
    $user = $request->user();

    $data = $request->validate([
        'full_name' => ['required', 'string', 'max:160'],

        'phone' => [
            'required',
            'string',
            'max:30',
            Rule::unique('users', 'phone')->ignore($user->id),
        ],

        'email' => [
            'nullable',
            'email',
            'max:160',
            Rule::unique('users', 'email')->ignore($user->id),
        ],
    ], [
        'full_name.required' => 'الاسم الكامل مطلوب.',

        'phone.required' => 'رقم الجوال مطلوب.',
        'phone.unique' => 'رقم الجوال مستخدم مسبقًا.',

        'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
        'email.unique' => 'البريد الإلكتروني مستخدم مسبقًا.',
    ]);

    $user->update([
        'full_name' => $data['full_name'],
        'phone' => $data['phone'],
        'email' => $data['email'] ?? null,
    ]);

    return back()->with('success', 'تم تحديث بيانات ملفك الشخصي بنجاح.');
}


    public function startSchoolDay(Request $request): RedirectResponse
    {
        $student = $request->user();
        abort_unless($student->student_mode === 'regular', 403);

        if (! in_array($this->schoolDayNumber(), $this->schoolDays(), true) || ! $this->isSchoolHours(now())) {
            return back()->withErrors(['attendance' => 'الدوام متاح من الساعة 10:00 إلى 14:00 في أيام الدوام فقط.']);
        }

        DB::table('student_attendance')->upsert([[
            'student_id' => $student->id,
            'attendance_date' => today()->toDateString(),
            'started_at' => now(),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]], ['student_id', 'attendance_date'], ['status', 'updated_at']);

        return back()->with('success', 'تم بدء دوامك اليومي. ستفتح الحصص تلقائيًا حسب الجدول.');
    }

    private function classAccessState(object $class): string
    {
        $today = $this->schoolDayNumber();
        if ((int) $class->day_of_week !== $today) {
            return 'closed';
        }

        $now = now();
        $start = Carbon::today()->setTimeFromTimeString($class->starts_at);
        $end = Carbon::today()->setTimeFromTimeString($class->ends_at);

        return $now->lt($start) ? 'upcoming' : ($now->lt($end) ? 'open' : 'ended');
    }

    private function schoolDayNumber(): int
    {
        return (now()->dayOfWeek + 1) % 7 + 1;
    }

    private function schoolDays(): array
    {
        return array_map('intval', explode(',', (string) env('SCHOOL_DAYS', '1,2,3,4,5')));
    }

    private function isSchoolHours(Carbon $time): bool
    {
        return $time->betweenIncluded(
            $time->copy()->setTimeFromTimeString((string) env('SCHOOL_START_TIME', '10:00')),
            $time->copy()->setTimeFromTimeString((string) env('SCHOOL_END_TIME', '14:00')),
        );
    }

    public function enroll(Request $request): RedirectResponse
    {
        $data = $request->validate(['subject_id' => ['required', 'integer', 'exists:subjects,id']]);
        $subject = Subject::where('id', $data['subject_id'])->where('status', 'active')->firstOrFail();

        $alreadyExists = DB::table('enrollments')
            ->where('student_id', Auth::id())
            ->where('subject_id', $subject->id)
            ->exists();

        if (! $alreadyExists) {
            DB::table('enrollments')->insert([
                'student_id' => Auth::id(),
                'subject_id' => $subject->id,
                'starts_on' => now()->toDateString(),
                'enrollment_mode' => Auth::user()->student_mode === 'regular' ? 'regular' : 'subject_only',
                'status' => 'pending',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'تم حفظ طلب التسجيل. أكمل الدفع من لوحة الطالب.');
    }
}
