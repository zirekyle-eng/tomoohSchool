<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index(): View
    {
        $subjects = Subject::query()
            ->with('grade')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    public function dashboard(): View
    {
        $enrollments = DB::table('enrollments as e')
            ->join('subjects as s', 's.id', '=', 'e.subject_id')
            ->leftJoin('grades as g', 'g.id', '=', 's.grade_id')
            ->where('e.student_id', Auth::id())
            ->orderByDesc('e.created_at')
            ->select('e.id', 's.name as subject_name', 'g.name as grade_name', 'e.status', 's.delivery_type', 's.recorded_lectures_url')
            ->get();

        $classes = DB::table('enrollments as e')
            ->join('class_schedules as cs', 'cs.subject_id', '=', 'e.subject_id')
            ->join('subjects as s', 's.id', '=', 'cs.subject_id')
            ->join('users as u', 'u.id', '=', 'cs.teacher_id')
            ->where('e.student_id', Auth::id())
            ->where('e.status', 'active')
            ->where('cs.status', 'active')
            ->orderBy('cs.day_of_week')->orderBy('cs.starts_at')
            ->select('cs.id as schedule_id', 's.name as subject_name', 'u.full_name as teacher_name', 'cs.day_of_week', 'cs.starts_at', 'cs.ends_at', 'cs.viva_z_join_url', 'cs.viva_z_meeting_id', 'cs.bbb_attendee_password')
            ->get();

        $classes->transform(function (object $class): object {
            $class->viva_z_join_url = route('bbb.student.join', ['id' => $class->schedule_id]);

            return $class;
        });

        return view('dashboard', compact('enrollments', 'classes'));
    }

    public function enroll(Request $request): RedirectResponse
    {
        $data = $request->validate(['subject_id' => ['required', 'integer', 'exists:subjects,id']]);
        $subject = Subject::where('id', $data['subject_id'])->where('status', 'active')->firstOrFail();

        $alreadyExists = DB::table('enrollments')
            ->where('student_id', Auth::id())
            ->where('subject_id', $subject->id)
            ->exists();

        if (!$alreadyExists) {
            DB::table('enrollments')->insert([
                'student_id' => Auth::id(),
                'subject_id' => $subject->id,
                'starts_on' => now()->toDateString(),
                'status' => 'pending',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'تم حفظ طلب التسجيل. أكمل الدفع من لوحة الطالب.');
    }
}