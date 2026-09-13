<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $subjects = Subject::query()->where('status', 'active')->orderBy('name')->limit(6)->get();

        return view('public.home', compact('subjects'));
    }

    public function catalog(Request $request): View
    {
        $markets = DB::table('markets')
            ->where('active', true)
            ->orderBy('id')
            ->pluck('name', 'id')
            ->all();
        $selectedMarketId = $request->integer('market') ?: null;
        $selectedGradeId = $request->integer('grade') ?: null;
        $allGrades = DB::table('grades')->orderBy('sort_order')->orderBy('name')->get(['id', 'name']);
        $subjects = Subject::query()->with('grade')->where('status', 'active')->orderBy('name')->get();
        $filteredSubjects = $subjects
            ->when($selectedMarketId, fn ($items) => $items->where('market_id', $selectedMarketId))
            ->when($selectedGradeId, fn ($items) => $items->where('grade_id', $selectedGradeId));
        $gradeGroups = $filteredSubjects
            ->groupBy('grade_id')
            ->sortBy(fn ($items) => $items->first()->grade?->sort_order ?? 999);

        return view('public.catalog', compact('markets', 'selectedMarketId', 'selectedGradeId', 'allGrades', 'subjects', 'filteredSubjects', 'gradeGroups'));
    }

    public function subject(int $id): View
    {
        $subject = Subject::query()->with('grade')->where('id', $id)->where('status', 'active')->firstOrFail();

        return view('public.subject', compact('subject'));
    }

    public function pricing(Request $request): View
    {
        $regionKey = $request->string('region')->toString() === 'egypt' ? 'egypt' : 'palestine';
        $subjects = Subject::query()
            ->with('grade')
            ->where('status', 'active')
            ->where('monthly_fee', '>', 0)
            ->orderBy('grade_id')
            ->orderBy('name')
            ->get();
        $region = config('pricing.regions.'.$regionKey);
        $packages = collect($region['packages'])->map(function (array $package) use ($subjects): array {
            $package['subjects'] = $subjects->filter(function (Subject $subject) use ($package): bool {
                return (string) $subject->grade?->name === 'الصف '.$package['grade_level']
                    && in_array($subject->tawjihi_branch, ['general', $package['branch']], true);
            })->values();

            return $package;
        });

        $currency = $region['currency'];
        $regionTitle = $region['title'];
        $whatsapp = config('pricing.whatsapp.'.$regionKey);

        return view('public.pricing', compact('subjects', 'packages', 'currency', 'regionKey', 'regionTitle', 'whatsapp'));
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
            ->select('users.id', 'users.full_name', 'users.phone', 'teachers_profiles.specialization', 'teachers_profiles.years_experience', 'teachers_profiles.bio', 'teachers_profiles.photo_path', 'teachers_profiles.qualifications', 'teachers_profiles.verification_source')
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
        abort_unless(in_array($page, ['about', 'contact', 'policies'], true), 404);

        return view('public.'.$page);
    }
}
