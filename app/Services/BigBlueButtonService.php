<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class BigBlueButtonService
{
    public function createMeeting(string $name, string $meetingId, string $moderatorName = 'المدرس'): array
    {
        $baseUrl = config('services.bbb.base_url');
        $secret = config('services.bbb.secret');

        if (! $baseUrl || ! $secret) {
            throw new RuntimeException('إعدادات BigBlueButton غير مكتملة.');
        }

        $params = [
            'allowStartStopRecording' => 'true',
            'attendeePW' => Str::random(16),
            'autoStartRecording' => 'true',
            'meetingID' => $meetingId,
            'moderatorPW' => Str::random(20),
            'name' => $name,
            'record' => 'true',
        ];

        $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $checksum = sha1('create'.$query.$secret);
        $response = Http::timeout(15)->get($baseUrl.'api/create', $params + ['checksum' => $checksum]);

        if (! $response->successful()) {
            throw new RuntimeException('تعذر الاتصال بخادم BigBlueButton.');
        }

        $xml = @simplexml_load_string($response->body());
        if (! $xml || (string) $xml->returncode !== 'SUCCESS') {
            throw new RuntimeException((string) ($xml->message ?? 'تعذر إنشاء غرفة BigBlueButton.'));
        }

        return [
            'attendee_password' => $params['attendeePW'],
            'moderator_password' => $params['moderatorPW'],
            'attendee_url' => $this->joinUrl($meetingId, $params['attendeePW'], 'طالب'),
            'moderator_url' => $this->joinUrl($meetingId, $params['moderatorPW'], $moderatorName),
        ];
    }

    public function joinUrl(string $meetingId, string $password, string $fullName, ?string $logoutUrl = null): string
    {
        $baseUrl = config('services.bbb.base_url');
        $secret = config('services.bbb.secret');
        $joinParams = compact('fullName', 'meetingId', 'password');
        if ($logoutUrl !== null) {
            $joinParams['logoutURL'] = $logoutUrl;
        }
        $joinParams['meetingID'] = $joinParams['meetingId'];
        unset($joinParams['meetingId']);
        $joinQuery = http_build_query($joinParams, '', '&', PHP_QUERY_RFC3986);
        $joinChecksum = sha1('join'.$joinQuery.$secret);

        return $baseUrl.'api/join?'.$joinQuery.'&checksum='.$joinChecksum;
    }

    /**
     * @return array<int, array{record_id: string, meeting_id: string, name: string, published: bool, start_time: int, end_time: int, playback_url: string, video_url: string}>
     */
    public function getRecordings(?string $meetingId = null): array
    {
        $baseUrl = config('services.bbb.base_url');
        $secret = config('services.bbb.secret');

        if (! $baseUrl || ! $secret) {
            throw new RuntimeException('إعدادات BigBlueButton غير مكتملة.');
        }

        $params = array_filter([
            'meetingID' => $meetingId,
        ], static fn (?string $value): bool => $value !== null && $value !== '');
        $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $checksum = sha1('getRecordings'.$query.$secret);
        $response = Http::connectTimeout(3)
            ->timeout(15)
            ->get($baseUrl.'api/getRecordings', $params + ['checksum' => $checksum]);

        if (! $response->successful()) {
            throw new RuntimeException('تعذر الاتصال بخادم BigBlueButton.');
        }

        $xml = @simplexml_load_string($response->body());
        if (! $xml || (string) $xml->returncode !== 'SUCCESS') {
            throw new RuntimeException((string) ($xml->message ?? 'تعذر جلب تسجيلات BigBlueButton.'));
        }

        $recordings = [];
        foreach ($xml->recordings->recording ?? [] as $recording) {
            $playbackUrl = '';
            $videoUrl = '';
            foreach ($recording->playback->format ?? [] as $format) {
                if ((string) $format->url !== '') {
                    $formatUrl = (string) $format->url;
                    $formatType = (string) $format->type;

                    if ($formatType === 'video') {
                        $playbackUrl = $this->playbackUrl($formatUrl);
                        $videoUrl = str_ends_with($formatUrl, '/')
                            ? $formatUrl.'video-0.m4v'
                            : $formatUrl;
                        break;
                    }
                }
            }
            $recordings[] = [
                'record_id' => (string) $recording->recordID,
                'meeting_id' => (string) $recording->meetingID,
                'name' => (string) $recording->name,
                'published' => (string) $recording->published === 'true',
                'start_time' => (int) $recording->startTime,
                'end_time' => (int) $recording->endTime,
                'playback_url' => $playbackUrl,
                'video_url' => $videoUrl,
            ];
        }

        return $recordings;
    }

    private function playbackUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (! is_string($path) || $path === '') {
            return $url;
        }

        $query = parse_url($url, PHP_URL_QUERY);
        $playbackUrl = config('services.bbb.playback_host').$path;

        return $query ? $playbackUrl.'?'.$query : $playbackUrl;
    }
}
