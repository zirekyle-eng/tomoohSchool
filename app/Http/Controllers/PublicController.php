<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home(): View
    {
        $subjects = Subject::query()->where('status', 'active')->orderBy('name')->limit(6)->get();

        return view('public.home', compact('subjects'));
    }

    public function catalog(): View
    {
        $subjects = Subject::query()->with('grade')->where('status', 'active')->orderBy('name')->get();

        return view('public.catalog', compact('subjects'));
    }

    public function subject(int $id): View
    {
        $subject = Subject::query()->with('grade')->where('id', $id)->where('status', 'active')->firstOrFail();

        return view('public.subject', compact('subject'));
    }

    public function teachers(): View
    {
        $teachers = User::query()
            ->select('users.id', 'users.full_name', 'teachers_profiles.specialization', 'teachers_profiles.years_experience', 'teachers_profiles.bio', 'teachers_profiles.photo_path')
            ->leftJoin('teachers_profiles', 'teachers_profiles.user_id', '=', 'users.id')
            ->where('users.role', 'teacher')
            ->where('users.status', 'active')
            ->orderBy('users.full_name')
            ->get();

        return view('public.teachers', compact('teachers'));
    }

    public function teacher(int $id): View
    {
        $teacher = User::query()
            ->select('users.id', 'users.full_name', 'teachers_profiles.specialization', 'teachers_profiles.years_experience', 'teachers_profiles.bio', 'teachers_profiles.photo_path', 'teachers_profiles.qualifications', 'teachers_profiles.verification_source')
            ->leftJoin('teachers_profiles', 'teachers_profiles.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->where('users.role', 'teacher')
            ->where('users.status', 'active')
            ->firstOrFail();

        $subjects = Subject::query()
            ->select('subjects.name', 'grades.name as grade')
            ->join('class_schedules', 'class_schedules.subject_id', '=', 'subjects.id')
            ->join('grades', 'grades.id', '=', 'subjects.grade_id')
            ->where('class_schedules.teacher_id', $id)
            ->where('class_schedules.status', 'active')
            ->distinct()
            ->orderBy('subjects.name')
            ->get();

        return view('public.teacher', compact('teacher', 'subjects'));
    }

    public function homeTeachers(): JsonResponse
    {
        $teachers = User::query()
            ->select('users.id', 'users.full_name', 'teachers_profiles.specialization', 'teachers_profiles.bio', 'teachers_profiles.photo_path')
            ->leftJoin('teachers_profiles', 'teachers_profiles.user_id', '=', 'users.id')
            ->where('users.role', 'teacher')
            ->where('users.status', 'active')
            ->orderBy('users.full_name')
            ->limit(6)
            ->get();

        foreach ($teachers as $teacher) {
            $teacher->subjects = Subject::query()
                ->join('class_schedules', 'class_schedules.subject_id', '=', 'subjects.id')
                ->where('class_schedules.teacher_id', $teacher->id)
                ->where('class_schedules.status', 'active')
                ->distinct()
                ->pluck('subjects.name')
                ->implode('، ');
        }

        return response()->json(['ok' => true, 'teachers' => $teachers]);
    }

    public function showTeacherApplication(): View
    {
        return view('public.teacher-apply');
    }

    public function storeTeacherApplication(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:160'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:160'],
            'specialization' => ['required', 'string', 'max:180'],
            'qualifications' => ['required', 'string', 'max:2000'],
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:60'],
            'bio' => ['nullable', 'string', 'max:3000'],
            'verification_source' => ['nullable', 'string', 'max:500'],
        ]);
        $data['status'] = 'pending';
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('teacher_applications')->insert($data);

        return redirect()->route('teacher.apply')->with('success', 'تم إرسال طلبك بنجاح. ستتم مراجعته من الإدارة.');
    }

    public function page(string $page): View
    {
        abort_unless(in_array($page, ['about', 'contact', 'policies', 'pricing'], true), 404);

        return view('public.' . $page);
    }
}