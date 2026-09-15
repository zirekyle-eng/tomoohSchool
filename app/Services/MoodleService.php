<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class MoodleService
{
    public function createUser(string $fullName, string $phone, string $password, string $role): int
    {
        $baseUrl = config('services.moodle.url');
        $token = config('services.moodle.token');

        if (! $baseUrl || ! $token) {
            throw new RuntimeException('إعدادات Moodle غير مكتملة.');
        }

        $parts = preg_split('/\s+/u', trim($fullName), 2) ?: [$fullName];
        $firstname = $parts[0] ?? $fullName;
        $lastname = $parts[1] ?? $firstname;
        $username = $this->username($phone);
        $email = 'tomooh@student.local';

        $response = Http::timeout(20)->asForm()->post($baseUrl.'webservice/rest/server.php', [
            'wstoken' => $token,
            'wsfunction' => 'core_user_create_users',
            'moodlewsrestformat' => 'json',
            'users[0][username]' => $username,
            'users[0][password]' => $password,
            'users[0][firstname]' => $firstname,
            'users[0][lastname]' => $lastname,
            'users[0][email]' => $email,
            'users[0][auth]' => 'manual',
            'users[0][city]' => $role === 'teacher' ? 'Teacher' : 'Student',
        ]);

        if (! $response->successful()) {
            throw new RuntimeException('تعذر الاتصال بخادم Moodle.');
        }

        $payload = $response->json();
        if (isset($payload['exception']) || isset($payload['errorcode'])) {
            throw new RuntimeException((string) ($payload['message'] ?? 'تعذر إنشاء الحساب في Moodle.'));
        }

        $userId = $payload[0]['id'] ?? null;
        if (! $userId) {
            throw new RuntimeException('لم يُرجع Moodle رقم الحساب الجديد.');
        }

        return (int) $userId;
    }

    private function username(string $phone): string
    {
        $username = preg_replace('/[^a-zA-Z0-9_]/', '', $phone) ?: 'user';

        return strtolower('nukhba_'.$username);
    }
}
