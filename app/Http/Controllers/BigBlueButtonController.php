<?php

namespace App\Http\Controllers;

use App\Services\BigBlueButtonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RuntimeException;

class BigBlueButtonController extends Controller
{
    public function studentJoin(Request $request, int $id, BigBlueButtonService $bigBlueButton): RedirectResponse|View
    {
        $class = DB::table('class_schedules as cs')
            ->join('subjects as s', 's.id', '=', 'cs.subject_id')
            ->join('grades as g', 'g.id', '=', 's.grade_id')
            ->where('cs.id', $id)
            ->where('cs.status', 'active')
            ->whereExists(function ($query) use ($request, $id): void {
                $query->from('enrollments as e')
                    ->whereColumn('e.subject_id', 'cs.subject_id')
                    ->where('e.student_id', $request->user()->id)
                    ->where('e.status', 'active');
            })
            ->select('cs.*', 's.name as subject_name', 'g.name as grade_name')
            ->first();

        abort_unless($class, 404);

        if (!$class->bbb_attendee_password || !$class->bbb_moderator_password || !$class->viva_z_meeting_id) {
            return view('bbb.waiting', ['class' => $class]);
        }

        return redirect()->away($bigBlueButton->joinUrl(
            $class->viva_z_meeting_id,
            $class->bbb_attendee_password,
            (string) $request->user()->full_name,
        ));
    }

    public function teacherJoin(Request $request, int $id, BigBlueButtonService $bigBlueButton): RedirectResponse
    {
        $class = DB::table('class_schedules as cs')
            ->join('subjects as s', 's.id', '=', 'cs.subject_id')
            ->join('grades as g', 'g.id', '=', 's.grade_id')
            ->where('cs.id', $id)
            ->where('cs.teacher_id', $request->user()->id)
            ->where('cs.status', 'active')
            ->select('cs.*', 's.name as subject_name', 'g.name as grade_name')
            ->first();

        abort_unless($class, 404);

        if (!$class->bbb_moderator_password || !$class->bbb_attendee_password || !$class->viva_z_meeting_id) {
            $meetingId = 'class-' . bin2hex(random_bytes(8));
            $meeting = $bigBlueButton->createMeeting(
                $class->subject_name . ' - ' . $class->grade_name,
                $meetingId,
                (string) $request->user()->full_name,
            );

            DB::table('class_schedules')->where('id', $class->id)->update([
                'viva_z_meeting_id' => $meetingId,
                'viva_z_join_url' => $meeting['attendee_url'],
                'bbb_attendee_password' => $meeting['attendee_password'],
                'bbb_moderator_password' => $meeting['moderator_password'],
                'viva_z_moderator_join_url' => $meeting['moderator_url'],
            ]);

            $class->viva_z_meeting_id = $meetingId;
            $class->bbb_moderator_password = $meeting['moderator_password'];
        }

        return redirect()->away($bigBlueButton->joinUrl(
            $class->viva_z_meeting_id,
            $class->bbb_moderator_password,
            (string) $request->user()->full_name,
        ));
    }
}
