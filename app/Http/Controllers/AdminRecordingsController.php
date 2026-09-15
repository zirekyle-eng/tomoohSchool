<?php

namespace App\Http\Controllers;

use App\Services\BigBlueButtonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class AdminRecordingsController extends Controller
{
    public function index(Request $request, BigBlueButtonService $bigBlueButton): View
    {
        $selectedGrade = $request->integer('grade_id') ?: null;
        $selectedSubject = $request->integer('subject_id') ?: null;

        $classesQuery = DB::table('class_schedules as cs')
            ->join('subjects as s', 's.id', '=', 'cs.subject_id')
            ->join('grades as g', 'g.id', '=', 's.grade_id')
            ->join('users as u', 'u.id', '=', 'cs.teacher_id')
            ->whereNotNull('cs.viva_z_meeting_id')
            ->where('cs.viva_z_meeting_id', '<>', '')
            ->when($selectedGrade, fn ($query) => $query->where('s.grade_id', $selectedGrade))
            ->when($selectedSubject, fn ($query) => $query->where('cs.subject_id', $selectedSubject))
            ->select('cs.id', 'cs.viva_z_meeting_id', 's.name as subject_name', 'g.name as grade_name', 'u.full_name as teacher_name');

        $classes = $classesQuery->get();
        $recordings = collect();
        $bbbError = null;

        if ($classes->isNotEmpty()) {
            try {
                $classesByMeetingId = $classes->keyBy('viva_z_meeting_id');
                $recordings = collect($bigBlueButton->getRecordings())
                    ->filter(fn (array $recording): bool => $classesByMeetingId->has($recording['meeting_id']))
                    ->map(function (array $recording) use ($classesByMeetingId): array {
                        $recording['class'] = $classesByMeetingId->get($recording['meeting_id']);

                        return $recording;
                    })
                    ->sortByDesc('start_time')
                    ->values();
            } catch (Throwable $exception) {
                report($exception);
                $bbbError = 'تعذر جلب التسجيلات من BigBlueButton حاليًا.';
            }
        }

        $grades = DB::table('grades')->orderBy('sort_order')->orderBy('name')->get(['id', 'name']);
        $subjects = DB::table('subjects as s')
            ->join('grades as g', 'g.id', '=', 's.grade_id')
            ->where('s.status', 'active')
            ->when($selectedGrade, fn ($query) => $query->where('s.grade_id', $selectedGrade))
            ->orderBy('g.sort_order')->orderBy('s.name')
            ->get(['s.id', 's.name', 's.grade_id', 'g.name as grade_name']);

        return view('admin.recordings', compact(
            'recordings',
            'grades',
            'subjects',
            'selectedGrade',
            'selectedSubject',
            'bbbError',
        ));
    }
}
