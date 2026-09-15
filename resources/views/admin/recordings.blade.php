@extends('layouts.admin', ['title' => 'تسجيلات الحصص'])

@section('content')
<style>
    .recordings-head { display:flex; justify-content:space-between; align-items:end; gap:18px; margin-bottom:22px; }
    .recordings-head h1 { margin:0; }
    .recordings-head p { margin:5px 0 0; }
    .recordings-filters { display:flex; gap:10px; align-items:end; flex-wrap:wrap; margin-bottom:22px; }
    .recordings-field { display:grid; gap:6px; min-width:190px; }
    .recordings-filters .button { border:0; cursor:pointer; }
    .recordings-group { margin-bottom:22px; }
    .recordings-group h2 { display:flex; align-items:center; gap:9px; margin:0 0 11px; }
    .recordings-group h2 span { padding:4px 9px; border-radius:99px; background:#f0e9ff; color:#6041a5; font:700 11px Tajawal; }
    .recordings-grid { display:grid; grid-template-columns:minmax(0,1fr); gap:22px; }
    .recording-card { display:flex; flex-direction:column; gap:14px; min-width:0; padding:24px; background:#fff; border:1px solid var(--line); border-radius:15px; }
    .recording-video { width:100%; aspect-ratio:16/9; display:block; border-radius:11px; background:#21162a; object-fit:contain; }
    .recording-frame { width:100%; height:clamp(560px,72vh,820px); display:block; border:0; border-radius:11px; background:#21162a; overflow:hidden; }
    .recording-unavailable { aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; padding:15px; border-radius:11px; background:#f7f3f8; color:var(--muted); text-align:center; font-size:11px; }
    .recording-card h3 { margin:0; font-size:15px; }
    .recording-meta { display:grid; gap:4px; color:var(--muted); font-size:11px; line-height:1.7; }
    .recording-meta strong { color:var(--ink); }
    .recording-link { margin-top:auto; display:inline-flex; justify-content:center; padding:9px 12px; border-radius:9px; background:var(--c); color:#fff; text-decoration:none; font-size:11px; font-weight:800; }
    .recording-link.disabled { background:#eee8f0; color:#9a8ca4; pointer-events:none; }
    .recordings-empty { padding:42px 20px; text-align:center; color:var(--muted); }
    .recordings-error { margin-bottom:18px; padding:12px 14px; border:1px solid #fecaca; border-radius:10px; background:#fff1f2; color:#b91c1c; font-size:12px; }
    @media(max-width:600px){.recordings-head{display:block}.recordings-field{width:100%}.recordings-filters .button{width:100%}.recording-card{padding:14px}.recording-frame{height:600px}}
</style>

<header class="recordings-head">
    <div>
        <h1>تسجيلات الحصص</h1>
        <p class="muted">كل تسجيلات BigBlueButton مصنفة حسب الصف والمادة.</p>
    </div>
</header>

<form class="panel recordings-filters" method="get" action="{{ route('admin.recordings') }}">
    <label class="recordings-field">الصف
        <select name="grade_id" onchange="this.form.submit()">
            <option value="">كل الصفوف</option>
            @foreach($grades as $grade)<option value="{{ $grade->id }}" @selected($selectedGrade === $grade->id)>{{ $grade->name }}</option>@endforeach
        </select>
    </label>
    <label class="recordings-field">المادة
        <select name="subject_id">
            <option value="">كل المواد</option>
            @foreach($subjects as $subject)<option value="{{ $subject->id }}" @selected($selectedSubject === $subject->id)>{{ $subject->name }} - {{ $subject->grade_name }}</option>@endforeach
        </select>
    </label>
    <button class="button" type="submit">تطبيق التصفية</button>
</form>

@if($bbbError)<div class="recordings-error">{{ $bbbError }}</div>@endif

@forelse($recordings->groupBy(fn (array $recording): string => $recording['class']->grade_name) as $gradeName => $gradeRecordings)
    <section class="recordings-group">
        <h2>{{ $gradeName }} <span>{{ $gradeRecordings->count() }} تسجيل</span></h2>
        <div class="recordings-grid">
            @foreach($gradeRecordings->groupBy(fn (array $recording): string => $recording['class']->subject_name) as $subjectName => $subjectRecordings)
                @foreach($subjectRecordings as $recording)
                    @php($durationMinutes = $recording['end_time'] > $recording['start_time'] ? max(1, (int) round(($recording['end_time'] - $recording['start_time']) / 60000)) : null)
                    <article class="recording-card">
                        @if($recording['playback_url'])
                            <iframe class="recording-frame" src="{{ $recording['playback_url'] }}" title="تسجيل {{ $subjectName }}" allow="fullscreen" scrolling="no" loading="lazy"></iframe>
                        @endif
                        <h3>{{ $subjectName }}</h3>
                        <div class="recording-meta">
                            <span><strong>المدرس:</strong> {{ $recording['class']->teacher_name }}</span>
                            @if($recording['start_time'])<span><strong>التاريخ:</strong> {{ date('d/m/Y - H:i', (int) ($recording['start_time'] / 1000)) }}</span>@endif
                            @if($durationMinutes)<span><strong>المدة:</strong> {{ $durationMinutes }} دقيقة</span>@endif
                        </div>
                        @if(! $recording['playback_url'])<span class="recording-link disabled">الفيديو غير متاح</span>@endif
                    </article>
                @endforeach
            @endforeach
        </div>
    </section>
@empty
    <section class="panel recordings-empty">لا توجد تسجيلات مطابقة حاليًا.</section>
@endforelse
@endsection