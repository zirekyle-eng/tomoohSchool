<?php

namespace App\Http\Controllers;

use App\Services\MoodleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminApplicationsController extends Controller
{
    public function index(): View
    {
        $applications = DB::table('teacher_applications')->orderByDesc('created_at')->get();

        return view('admin.applications', compact('applications'));
    }

    // public function approve(int $id, MoodleService $moodle): RedirectResponse
    // {
    //     $application = DB::table('teacher_applications')->where('id', $id)->where('status', 'new')->first();
    //     abort_unless($application, 404);
    //     abort_if(DB::table('users')->where('phone', $application->phone)->exists(), 422, 'يوجد حساب بهذا الرقم مسبقًا.');


    //     $temporaryPassword = 'Nukhba!' . Str::random(8);
    //     DB::transaction(function () use ($application, $temporaryPassword): void {
    //         $teacherId = DB::table('users')->insertGetId([
    //             'full_name' => $application->full_name,
    //             'phone' => $application->phone,
    //             'password_hash' => Hash::make($temporaryPassword),
    //             'role' => 'teacher',
    //             'status' => 'active',
    //             'created_at' => now(),
    //             // 'updated_at' => now(),
    //         ]);
    //         DB::table('teachers_profiles')->insert([
    //             'user_id' => $teacherId,
    //             'specialization' => $application->specialization,
    //             'years_experience' => $application->years_experience ?? 0,
    //             'bio' => $application->bio,
    //             'qualifications' => $application->qualifications,
    //             'verification_source' => $application->verification_source,
    //         ]);
    //         DB::table('teacher_applications')->where('id', $application->id)->update(['status' => 'approved', 'updated_at' => now()]);
    //     });

    //     $message = 'تم قبول الطلب وإنشاء حساب المدرس. كلمة المرور المؤقتة: ' . $temporaryPassword;
    //     try {
    //         $moodle->createUser($application->full_name, $application->phone, $temporaryPassword, 'teacher');
    //     } catch (\Throwable $exception) {
    //         $message .= ' تعذر إنشاء الحساب في Moodle: ' . $exception->getMessage();
    //     }

    //     return back()->with('success', $message);
    // }

    // public function reject(int $id): RedirectResponse
    // {
    //     DB::table('teacher_applications')->where('id', $id)->where('status', 'new')->update(['status' => 'rejected'
    //     // , 'updated_at' => now()
    // ]);


    //     return back()->with('success', 'تم رفض طلب المدرس.');
    // }
}
