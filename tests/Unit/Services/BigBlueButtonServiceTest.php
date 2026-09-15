<?php

namespace Tests\Unit\Services;

use App\Services\BigBlueButtonService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BigBlueButtonServiceTest extends TestCase
{
    public function test_get_recordings_returns_recording_metadata_and_video_url(): void
    {
        config([
            'services.bbb.base_url' => 'https://bbb.test/',
            'services.bbb.secret' => 'secret',
            'services.bbb.playback_host' => 'https://viva-zoom.fame-uk.net',
        ]);
        Http::preventStrayRequests();
        Http::fake([
            'https://bbb.test/api/getRecordings*' => Http::response('<?xml version="1.0"?><response><returncode>SUCCESS</returncode><recordings><recording><recordID>record-1</recordID><meetingID>class-1</meetingID><name>رياضيات</name><published>true</published><startTime>1720000000000</startTime><endTime>1720003600000</endTime><playback><format><type>presentation</type><url>https://bbb.test/presentation</url></format><format><type>video</type><url>https://bbb.test/video</url></format></playback></recording></recordings></response>'),
        ]);

        $recordings = app(BigBlueButtonService::class)->getRecordings();

        $this->assertSame('record-1', $recordings[0]['record_id']);
        $this->assertSame('class-1', $recordings[0]['meeting_id']);
        $this->assertTrue($recordings[0]['published']);
        $this->assertSame('https://viva-zoom.fame-uk.net/video', $recordings[0]['playback_url']);
        $this->assertSame('https://bbb.test/video', $recordings[0]['video_url']);
        Http::assertSent(fn (Request $request): bool => str_contains($request->url(), 'checksum='));
    }

    public function test_get_recordings_does_not_use_presentation_when_video_format_is_unavailable(): void
    {
        config([
            'services.bbb.base_url' => 'https://bbb.test/',
            'services.bbb.secret' => 'secret',
            'services.bbb.playback_host' => 'https://viva-zoom.fame-uk.net',
        ]);
        Http::preventStrayRequests();
        Http::fake([
            'https://bbb.test/api/getRecordings*' => Http::response('<?xml version="1.0"?><response><returncode>SUCCESS</returncode><recordings><recording><recordID>record-2</recordID><meetingID>class-2</meetingID><name>علوم</name><published>true</published><startTime>1720000000000</startTime><endTime>1720003600000</endTime><playback><format><type>podcast</type><url>https://bbb.test/audio.ogg</url></format><format><type>presentation</type><url>https://bbb.test/playback.html</url></format></playback></recording></recordings></response>'),
        ]);

        $recordings = app(BigBlueButtonService::class)->getRecordings();

        $this->assertSame('', $recordings[0]['playback_url']);
        $this->assertSame('', $recordings[0]['video_url']);
    }

    public function test_get_recordings_adds_video_file_to_video_directory_url(): void
    {
        config([
            'services.bbb.base_url' => 'https://bbb.test/',
            'services.bbb.secret' => 'secret',
            'services.bbb.playback_host' => 'https://viva-zoom.fame-uk.net',
        ]);
        Http::preventStrayRequests();
        Http::fake([
            'https://bbb.test/api/getRecordings*' => Http::response('<?xml version="1.0"?><response><returncode>SUCCESS</returncode><recordings><recording><recordID>record-3</recordID><meetingID>class-3</meetingID><name>فيزياء</name><published>true</published><startTime>1720000000000</startTime><endTime>1720003600000</endTime><playback><format><type>video</type><url>https://bbb.test/playback/video/class-3/</url></format></playback></recording></recordings></response>'),
        ]);

        $recordings = app(BigBlueButtonService::class)->getRecordings();

        $this->assertSame('https://viva-zoom.fame-uk.net/playback/video/class-3/', $recordings[0]['playback_url']);
        $this->assertSame('https://bbb.test/playback/video/class-3/video-0.m4v', $recordings[0]['video_url']);
    }
}
