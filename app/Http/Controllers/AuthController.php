<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MoodleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('phone', trim($credentials['phone']))
            ->where('status', 'active')
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password_hash)) {
            return back()->withErrors(['phone' => 'رقم الجوال أو كلمة المرور غير صحيحة.'])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request, MoodleService $moodle): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:160'],
            'phone' => ['required', 'string', 'max:30', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[^a-zA-Z0-9]/'],
            'country' => ['nullable', 'string', 'max:80'],
            'city' => ['nullable', 'string', 'max:100'],
            'student_mode' => ['required', 'in:regular,external'],
            'grade_level' => ['nullable', 'string', 'max:30'],
            'branch' => ['nullable', 'in:general,scientific,literary'],
        ], [
            'phone.unique' => 'رقم الجوال مستخدم مسبقًا.',
            'password.regex' => 'كلمة المرور يجب أن تحتوي حرفًا كبيرًا ورمزًا خاصًا.',
        ]);

        $user = User::create([
            ...$data,
            'password_hash' => Hash::make($data['password']),
            'status' => 'active',
            'role' => 'student',
            'student_mode' => $data['student_mode'],
            'grade_level' => $data['grade_level'] ?? null,
            'branch' => $data['branch'] ?? null,
            'market_id' => 1,
        ]);

        $message = 'تم إنشاء الحساب بنجاح. يمكنك تسجيل الدخول الآن.';
        try {
            $moodle->createUser($user->full_name, $data['phone'], $data['password'], 'student');
        } catch (\Throwable $exception) {
            $message .= ' تعذر إنشاء الحساب في Moodle: '.$exception->getMessage();
        }

        return redirect()->route('login')->with('success', $message);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
