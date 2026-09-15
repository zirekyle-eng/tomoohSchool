@extends('layouts.app', ['title' => 'مساحة المدرس'])

@section('content')
<style>
    .teacher-page-shell{max-width:none;padding:0}
    .teacher-shell{min-height:calc(100vh - 72px);display:grid;grid-template-columns:250px minmax(0,1fr);background:#faf7fb;color:#241432}
    .teacher-side{display:flex;flex-direction:column;padding:25px 17px;background:#2e1a47;color:#fff}
    .teacher-brand{display:flex;align-items:center;gap:10px;margin:3px 8px 37px;color:#fff;font:700 19px 'Baloo Bhaijaan 2';text-decoration:none}
    .teacher-brand small{display:block;color:#cdbfdb;font:11px Tajawal}
    .teacher-mark{width:39px;height:39px;display:grid;place-items:center;border-radius:13px 13px 13px 4px;background:#ff6b4a}
    .teacher-menu{display:grid;gap:6px}
    .teacher-menu a,.teacher-logout{padding:12px 13px;border:0;border-radius:11px;color:#d9cbe8;font:700 13px Tajawal;text-align:right;text-decoration:none;transition:background .2s ease,color .2s ease}
    .teacher-menu a:hover,.teacher-menu a.active{background:#ffffff18;color:#fff}
    .teacher-logout{margin-top:auto;background:transparent;color:#ffc5b8;cursor:pointer}
    .teacher-main{min-width:0;padding:30px 36px}
    .teacher-head{display:flex;align-items:center;justify-content:space-between;gap:18px;margin-bottom:25px}
    .teacher-head h1{margin:0;font:700 32px 'Baloo Bhaijaan 2'}
    .teacher-head p{margin:4px 0;color:#736686;font-size:12px}
    .teacher-avatar{width:46px;height:46px;display:grid;place-items:center;overflow:hidden;border-radius:50%;background:#ddf3e8;color:#22a66b;font-weight:800}
    .teacher-avatar img{width:100%;height:100%;object-fit:cover}
    .teacher-top-cards{display:grid;grid-template-columns:1.2fr .8fr;gap:18px}
    .teacher-intro,.teacher-moodle{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:25px 28px;border-radius:21px;background:linear-gradient(110deg,#2e1a47,#51337b);color:#fff}
    .teacher-moodle{background:#fff;border:1px solid #efe3f1;color:#241432}
    .teacher-intro h2,.teacher-moodle h2{margin:0 0 5px;font:700 23px 'Baloo Bhaijaan 2'}
    .teacher-intro p,.teacher-moodle p{margin:0;color:#d9cbe8;font-size:12px}
    .teacher-moodle p{color:#736686}
    .teacher-intro a,.teacher-moodle a{padding:10px 15px;border-radius:99px;background:#ffc857;color:#2e1a47;font-size:11px;font-weight:800;white-space:nowrap;text-decoration:none}
    .teacher-section{margin-top:20px;padding:22px;border:1px solid #efe3f1;border-radius:19px;background:#fff}
    .teacher-section h2{margin:0 0 16px;font:700 20px 'Baloo Bhaijaan 2'}
    .teacher-week{display:grid;grid-template-columns:repeat(7,minmax(120px,1fr));gap:9px;overflow-x:auto}
    .teacher-day{min-height:166px;padding:9px;border:1px solid #f0e9f2;border-radius:12px}
    .teacher-day h3{margin:0 0 8px;color:#736686;font-size:11px}
    .teacher-lesson{margin-top:7px;padding:8px;border-radius:7px;border-right:3px solid #22a66b;background:#eaf8f1}
    .teacher-lesson b,.teacher-lesson small{display:block}.teacher-lesson b{font-size:10px}.teacher-lesson small{margin-top:3px;color:#6b5d82;font-size:9px;line-height:1.7}
    .teacher-lesson a{display:inline-block;margin-top:7px;color:#e14f2e;font-size:9px;font-weight:800;text-decoration:none}
    .teacher-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:11px}
    .teacher-card{display:block;width:100%;padding:16px;border:1px solid #f0e9f2;border-radius:14px;background:#fff;color:#241432;text-align:right;cursor:pointer;font:inherit;transition:border-color .2s ease,box-shadow .2s ease,transform .2s ease}.teacher-card:hover,.teacher-card.is-selected{border-color:#22a66b;box-shadow:0 9px 20px #22a66b18;transform:translateY(-2px)}
    .teacher-card span{display:block;color:#22a66b;font-size:10px;font-weight:800}.teacher-card h3{margin:5px 0;font-size:15px}.teacher-card p{margin:0;color:#736686;font-size:10px}.teacher-card small{display:block;margin-top:12px;color:#e14f2e;font-size:10px;font-weight:800}
    .teacher-recordings-heading{display:flex;align-items:end;justify-content:space-between;gap:12px}.teacher-recordings-heading h2{margin-bottom:3px}.teacher-recordings-heading p{margin:0 0 16px;color:#736686;font-size:11px}.teacher-recordings-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.teacher-recording-subject{padding:15px;border:1px solid #f0e9f2;border-radius:13px;background:#fff}.teacher-recording-subject.is-hidden{display:none}.teacher-recording-subject h3{margin:0 0 4px;font-size:15px}.teacher-recording-subject>p{margin:0 0 12px;color:#736686;font-size:10px}.teacher-recording-list{display:grid;gap:8px}.teacher-recording{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:10px;border-radius:9px;background:#f7f3ff}.teacher-recording strong{display:block;font-size:11px}.teacher-recording small{display:block;margin-top:3px;color:#736686;font-size:9px}.teacher-recording a{padding:7px 9px;border-radius:7px;background:#ff6b4a;color:#fff;font-size:9px;font-weight:800;white-space:nowrap;text-decoration:none}.teacher-recordings-empty{padding:22px;border-radius:12px;background:#faf7fb;color:#736686;font-size:12px;text-align:center}.teacher-recordings-error{margin-bottom:12px;padding:10px 12px;border-radius:9px;background:#fff1f2;color:#b91c1c;font-size:11px}
    .teacher-profile{display:grid;grid-template-columns:70px 1fr;gap:16px;align-items:center;margin-bottom:22px}.profile-avatar{width:65px;height:65px;display:grid;place-items:center;border-radius:20px;background:#ddf3e8;color:#22a66b;font:700 28px 'Baloo Bhaijaan 2'}.teacher-profile h3{margin:0;font-size:18px}.teacher-profile p{margin:4px 0;color:#736686;font-size:11px}
    .teacher-profile-form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:13px}.teacher-profile-form .full{grid-column:1/-1}.teacher-profile-form label{display:grid;gap:6px;color:#736686;font-size:11px;font-weight:700}.teacher-profile-form input,.teacher-profile-form textarea{width:100%;padding:11px;border:1px solid #eadfeb;border-radius:9px;background:#fff;color:#241432;font:inherit}.teacher-profile-form textarea{min-height:90px;resize:vertical}.teacher-profile-form button{justify-self:start;padding:10px 16px;border:0;border-radius:10px;background:#ff6b4a;color:#fff;font:700 12px Tajawal;cursor:pointer}
    .teacher-notice{padding:10px 12px;border-radius:9px;background:#e8f8ef;color:#17734d;font-size:12px}.muted{color:#736686;font-size:12px}
    @media(max-width:1050px){.teacher-shell{grid-template-columns:68px 1fr}.teacher-side{padding:20px 10px}.teacher-brand{justify-content:center;margin:0 auto 30px}.teacher-brand span,.teacher-menu a span{display:none}.teacher-menu a{padding:12px;text-align:center;font-size:0}.teacher-menu a:first-letter{font-size:17px}.teacher-logout{font-size:0;text-align:center}.teacher-logout:first-letter{font-size:17px}.teacher-week{grid-template-columns:repeat(4,minmax(120px,1fr))}}
    @media(max-width:700px){.teacher-shell{display:block}.teacher-side{display:none}.teacher-main{padding:22px 15px}.teacher-head h1{font-size:26px}.teacher-top-cards{grid-template-columns:1fr}.teacher-intro,.teacher-moodle{display:block}.teacher-intro a,.teacher-moodle a{display:inline-block;margin-top:15px}.teacher-week{grid-template-columns:repeat(2,minmax(120px,1fr))}.teacher-grid,.teacher-recordings-grid,.teacher-profile-form{grid-template-columns:1fr}.teacher-profile-form .full{grid-column:auto}.teacher-recording{align-items:flex-start;flex-direction:column}.teacher-recording a{align-self:stretch;text-align:center}}
</style>

<div class="teacher-shell">
    <aside class="teacher-side">
        <a class="teacher-brand" href="{{ route('home') }}"><b class="teacher-mark">ن</b><span>مدرسة طموح الإلكترونية<small>مساحة المدرس</small></span></a>
        <nav class="teacher-menu" aria-label="تنقل المدرس">
            <a class="active" href="#schedule">◈ <span>جدولي</span></a>
            <a href="#subjects">▣ <span>موادي</span></a>
            <a href="#recordings">▶ <span>التسجيلات</span></a>
            <a href="#profile">♙ <span>حسابي</span></a>
        </nav>
        <form method="post" action="{{ route('logout') }}">@csrf<button class="teacher-logout" type="submit">↩ تسجيل الخروج</button></form>
    </aside>

    <main class="teacher-main">
        @if(session('success'))<p class="teacher-notice">{{ session('success') }}</p>@endif
        <header class="teacher-head"><div><h1>مرحبًا أ. {{ $profile->full_name }} 👋</h1><p>{{ $profile->specialization ?: 'مدرس معتمد في مدرسة طموح الإلكترونية' }}</p></div><div class="teacher-avatar">@if($profile->photo_path)<img src="{{ asset(str_replace('public/', '', $profile->photo_path)) }}" alt="{{ $profile->full_name }}">@else{{ mb_substr($profile->full_name, 0, 1) }}@endif</div></header>

        <div class="teacher-top-cards">
            <section class="teacher-intro"><div><h2>حصصك في مكان واحد</h2><p>ابدأ الغرفة الدراسية من جدولك في موعد الحصة.</p></div><a href="#schedule">عرض جدول الحصص</a></section>
            <section class="teacher-moodle"><div><h2>الغرفة الدراسية</h2><p>انتقل إلى مساحة Moodle الخاصة بك.</p></div><a href="{{ config('services.moodle.url', '/moodle') }}" target="_blank" rel="noopener">دخول Moodle</a></section>
        </div>

        <section class="teacher-section" id="schedule"><h2>جدولي الأسبوعي</h2><div class="teacher-week">
            @foreach([1=>'السبت',2=>'الأحد',3=>'الإثنين',4=>'الثلاثاء',5=>'الأربعاء',6=>'الخميس',7=>'الجمعة'] as $dayNumber => $dayName)
                <div class="teacher-day"><h3>{{ $dayName }}</h3>@forelse($classes->where('day_of_week', $dayNumber) as $class)<article class="teacher-lesson"><b>{{ $class->subject_name }}</b><small>{{ $class->grade_name }} · {{ substr($class->starts_at, 0, 5) }} - {{ substr($class->ends_at, 0, 5) }}<br>{{ $class->students }} طالب</small><a href="{{ $class->viva_z_join_url }}" target="_blank" rel="noopener">دخول الغرفة ←</a></article>@empty<p class="muted">لا توجد حصص</p>@endforelse</div>
            @endforeach
        </div></section>

        <section class="teacher-section" id="subjects"><h2>موادي</h2><div class="teacher-grid">@forelse($subjects as $subject)<button class="teacher-card" type="button" data-subject="{{ $subject->subject_name }}"><span>{{ $subject->grade_name }}</span><h3>{{ $subject->subject_name }}</h3><p>مادة ضمن جدولك الدراسي</p><small>عرض التسجيلات ←</small></button>@empty<p class="muted">لا توجد مواد مرتبطة بحسابك.</p>@endforelse</div></section>

        <section class="teacher-section" id="recordings"><div class="teacher-recordings-heading"><div><h2>تسجيلات الحصص</h2><p id="recordings-caption">اختر مادة من البطاقات لعرض تسجيلاتها.</p></div></div>@if($recordingsError)<div class="teacher-recordings-error">{{ $recordingsError }}</div>@endif @if($recordingsBySubject->isEmpty())<div class="teacher-recordings-empty">لا توجد تسجيلات متاحة حاليًا لموادك.</div>@else<div class="teacher-recordings-grid">@foreach($recordingsBySubject as $subjectName => $recordings)<article class="teacher-recording-subject" data-recording-subject="{{ $subjectName }}"><h3>{{ $subjectName }}</h3><p>{{ $recordings->first()['class']->grade_name }} · {{ $recordings->count() }} تسجيل</p><div class="teacher-recording-list">@foreach($recordings as $recording)<div class="teacher-recording"><div><strong>{{ $profile->full_name }}</strong>@if($recording['start_time'])<small>{{ date('d/m/Y - H:i', (int) ($recording['start_time'] / 1000)) }}</small>@endif</div>@if($recording['playback_url'])<a href="{{ $recording['playback_url'] }}" target="_blank" rel="noopener">مشاهدة التسجيل</a>@endif</div>@endforeach</div></article>@endforeach</div>@endif</section>

        <section class="teacher-section" id="profile"><h2>ملفي الشخصي</h2><div class="teacher-profile"><div class="profile-avatar">{{ mb_substr($profile->full_name, 0, 1) }}</div><div><h3>{{ $profile->full_name }}</h3><p>{{ $profile->phone }} · {{ $profile->years_experience ?: 0 }} سنوات خبرة</p></div></div><form class="teacher-profile-form" method="post" action="{{ route('teacher.profile.update') }}" enctype="multipart/form-data">@csrf<label>الاسم الكامل<input name="full_name" value="{{ $profile->full_name }}" required></label><label>رقم الجوال<input name="phone" value="{{ $profile->phone }}" required></label><label>التخصص<input name="specialization" value="{{ $profile->specialization }}"></label><label>سنوات الخبرة<input type="number" name="years_experience" min="0" max="60" value="{{ $profile->years_experience }}"></label><label>الصورة الشخصية<input type="file" name="photo" accept="image/*"></label><label class="full">نبذة عنك<textarea name="bio">{{ $profile->bio }}</textarea></label><button type="submit">حفظ التعديلات</button></form></section>
    </main>
</div>
<script>
    document.querySelectorAll('.teacher-card[data-subject]').forEach(function (card) {
        card.addEventListener('click', function () {
            var subject = card.dataset.subject;
            document.querySelectorAll('.teacher-card[data-subject]').forEach(function (item) { item.classList.toggle('is-selected', item === card); });
            document.querySelectorAll('.teacher-recording-subject[data-recording-subject]').forEach(function (item) { item.classList.toggle('is-hidden', item.dataset.recordingSubject !== subject); });
            var caption = document.getElementById('recordings-caption');
            if (caption) caption.textContent = 'التسجيلات المتاحة لمادة ' + subject;
            document.getElementById('recordings').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    var recordingsLink = document.querySelector('.teacher-menu a[href="#recordings"]');
    if (recordingsLink) recordingsLink.addEventListener('click', function () {
        document.querySelectorAll('.teacher-card[data-subject]').forEach(function (item) { item.classList.remove('is-selected'); });
        document.querySelectorAll('.teacher-recording-subject[data-recording-subject]').forEach(function (item) { item.classList.remove('is-hidden'); });
        var caption = document.getElementById('recordings-caption');
        if (caption) caption.textContent = 'كل التسجيلات مرتبة حسب المادة.';
    });
</script>
@endsection
