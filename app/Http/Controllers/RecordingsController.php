<?php

namespace App\Http\Controllers;

use App\Services\BigBlueButtonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class RecordingsController extends Controller
{
    public function index(Request $request, BigBlueButtonService $bigBlueButton): View
    {
        $user = $request->user();
        $classes = DB::table('class_schedules as cs')
            ->join('subjects as s', 's.id', '=', 'cs.subject_id')
            ->join('grades as g', 'g.id', '=', 's.grade_id')
            ->join('users as u', 'u.id', '=', 'cs.teacher_id')
            ->where('cs.status', 'active')
            ->whereNotNull('cs.viva_z_meeting_id')
            ->where('cs.viva_z_meeting_id', '<>', '')
            ->when($user->role === 'teacher', fn ($query) => $query->where('cs.teacher_id', $user->id))
            ->when($user->role === 'student', function ($query) use ($user): void {
                $query->whereExists(function ($enrollmentQuery) use ($user): void {
                    $enrollmentQuery->from('enrollments as e')
                        ->whereColumn('e.subject_id', 'cs.subject_id')
                        ->where('e.student_id', $user->id)
                        ->where('e.status', 'active')
                        ->where(function ($sectionQuery): void {
                            $sectionQuery->whereNull('cs.section_id')->orWhereColumn('e.section_id', 'cs.section_id');
                        });
                });
            })
            ->select('cs.viva_z_meeting_id', 's.id as subject_id', 's.name as subject_name', 'g.name as grade_name', 'u.full_name as teacher_name')
            ->get();

        $subjects = DB::table('enrollments as e')
            ->join('subjects as s', 's.id', '=', 'e.subject_id')
            ->leftJoin('grades as g', 'g.id', '=', 's.grade_id')
            ->where('e.student_id', $user->id)
            ->where('e.status', 'active')
            ->orderBy('s.name')
            ->select('s.id as subject_id', 's.name as subject_name', 'g.name as grade_name')
            ->distinct()
            ->get();

        $recordingsBySubject = collect();
        $bbbError = null;
        if ($classes->isNotEmpty()) {
            try {
                $classesByMeetingId = $classes->keyBy('viva_z_meeting_id');
                $recordingsBySubject = collect($bigBlueButton->getRecordings())
                    ->filter(fn (array $recording): bool => $classesByMeetingId->has($recording['meeting_id']))
                    ->map(function (array $recording) use ($classesByMeetingId): array {
                        $recording['class'] = $classesByMeetingId->get($recording['meeting_id']);

                        return $recording;
                    })->sortByDesc('start_time')->groupBy(fn (array $recording): int => (int) $recording['class']->subject_id);
            } catch (Throwable $exception) {
                report($exception);
                $bbbError = 'تعذر جلب التسجيلات حاليًا.';
            }
        }

        return view('recordings.index', compact('subjects', 'recordingsBySubject', 'bbbError'));
    }
}
