<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>تسجيلات الحصص | مدرسة طموح الإلكترونية</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--plum:#2e1a47;--coral:#ff6b4a;--gold:#ffc857;--green:#22a66b;--ink:#241432;--muted:#736686;--line:#efe3f1;--bg:#faf7fb}
        *{box-sizing:border-box}
        html,body{margin:0;background:var(--bg);color:var(--ink);font-family:Tajawal,sans-serif}
        body{min-height:100vh}
        a{text-decoration:none}
        button{font:inherit}
        .student-shell{min-height:100vh;display:grid;grid-template-columns:250px 1fr}
        .student-side{background:var(--plum);color:#fff;padding:25px 17px;display:flex;flex-direction:column}
        .student-brand{display:flex;align-items:center;gap:10px;margin:3px 8px 37px;color:#fff;font:700 19px 'Baloo Bhaijaan 2'}
        .student-brand small{display:block;color:#cdbfdb;font:11px Tajawal}
        .student-mark{width:39px;height:39px;border-radius:13px 13px 13px 4px;background:var(--coral);display:grid;place-items:center}
        .student-menu{display:grid;gap:6px}
        .student-menu a,.student-logout{color:#d9cbe8;padding:12px 13px;border-radius:11px;font-size:13px;font-weight:700}
        .student-menu a:hover,.student-menu a.active{background:#ffffff18;color:#fff}
        .student-logout{margin-top:auto;border:0;background:none;text-align:right;font:700 13px Tajawal;cursor:pointer;color:#ffc5b8}

        .student-main{padding:30px 36px;min-width:0}
        .recordings-layout{display:flex;flex-direction:column;gap:18px}
        .recordings-empty,.recordings-error{padding:20px;border-radius:14px;text-align:center;font-size:13px}
        .recordings-error{margin-bottom:10px;background:#fff1f2;color:#b91c1c}
        .recordings-empty{background:#fff;border:1px solid var(--line);color:var(--muted)}

        .recordings-subjects{display:grid;grid-template-columns:repeat(2,minmax(240px,1fr));gap:18px;max-width:760px}
        .recordings-subject-card{display:block;width:100%;padding:18px;border:1px solid var(--line);border-radius:17px;background:#fff;color:#241432;text-align:right;cursor:pointer;transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease}
        .recordings-subject-card:hover,.recordings-subject-card.is-selected{border-color:#7c5ce0;box-shadow:0 12px 25px #7c5ce018;transform:translateY(-2px)}
        .recordings-subject-card span{display:block;color:#7c5ce0;font-size:10px;font-weight:800}
        .recordings-subject-card h2{margin:6px 0;font:700 19px 'Baloo Bhaijaan 2'}
        .recordings-subject-card p{margin:0;color:var(--muted);font-size:11px}
        .recordings-subject-card small{display:block;margin-top:15px;color:#e14f2e;font-size:10px;font-weight:800}

        .recordings-lessons{padding:22px;border:1px solid var(--line);border-radius:19px;background:#fff;max-width:760px}
        .recordings-lessons-head{display:flex;align-items:end;justify-content:space-between;gap:12px;margin-bottom:16px}
        .recordings-lessons h2{margin:0;font:700 22px 'Baloo Bhaijaan 2'}
        .recordings-lessons-head p{margin:4px 0 0;color:var(--muted);font-size:11px}
        .recordings-lesson-list{display:grid;gap:12px}
        .recordings-lesson{padding:14px;border:1px solid #f0e9f2;border-radius:13px;background:#faf7fb}
        .recordings-lesson h3{margin:0 0 4px;font-size:14px}
        .recordings-lesson p{margin:3px 0;color:var(--muted);font-size:11px}
        .recordings-lesson-frame{display:block;width:100%;height:clamp(311px,42vh,540px);margin-top:12px;border:0;border-radius:10px;background:#21162a}
        .recordings-no-lessons{padding:25px;border-radius:12px;background:#faf7fb;color:var(--muted);font-size:12px;text-align:center}
        .recordings-subject-lessons.is-hidden{display:none}

        @media(max-width:1050px){
            .student-shell{grid-template-columns:68px 1fr}
            .student-side{padding:20px 10px}
            .student-brand{margin:0 auto 30px;justify-content:center}
            .student-brand span:not(.student-mark),.student-menu a{font-size:0}
            .student-menu a{padding:12px;text-align:center}
            .student-menu a:first-letter{font-size:17px}
            .student-logout{font-size:0}
            .student-main{padding:24px 18px}
            .recordings-subjects{grid-template-columns:1fr}
        }
        @media(max-width:700px){
            .student-shell{grid-template-columns:1fr}
            .student-side{display:none}
            .student-main{padding:22px 15px}
            .recordings-lessons{padding:15px}
            .recordings-lesson-frame{height:420px}
        }
    </style>
</head>
<body>
    @include('partials.site-nav')
<div class="student-shell">
    <aside class="student-side">
        <a class="student-brand" href="{{ route('home') }}"><b class="student-mark">ن</b><span>مدرسة طموح الإلكترونية<small>مساحة الطالب</small></span></a>
        <nav class="student-menu" aria-label="تنقل الطالب">
            <a href="{{ route('dashboard') }}">◈ <span>جدولي</span></a>
            <a href="{{ route('subjects.index') }}">▣ <span>موادي</span></a>
            <a class="active" href="{{ route('recordings.index') }}">▶ <span>التسجيلات</span></a>
        </nav>
        <form method="post" action="{{ route('logout') }}">@csrf<button class="student-logout" type="submit">↩ تسجيل الخروج</button></form>
    </aside>

    <main class="student-main">
        <div class="recordings-layout">
            @if($bbbError)
                <div class="recordings-error">{{ $bbbError }}</div>
            @endif

            @if($subjects->isEmpty())
                <div class="recordings-empty">لا توجد مواد مفعلة في حسابك حاليًا.</div>
            @else
                <section class="recordings-subjects" aria-label="المواد المسجل بها الطالب">
                    @foreach($subjects as $subject)
                        <button class="recordings-subject-card" type="button" data-subject-id="{{ $subject->subject_id }}">
                            <span>{{ $subject->grade_name ?: 'مادة دراسية' }}</span>
                            <h2>{{ $subject->subject_name }}</h2>
                            <p>المحاضرات المسجلة الخاصة بالمادة</p>
                            <small>عرض الحصص المسجلة ←</small>
                        </button>
                    @endforeach
                </section>

                <section class="recordings-lessons" id="subject-recordings">
                    <div class="recordings-lessons-head">
                        <div>
                            <h2 id="selected-subject-title">اختر مادة</h2>
                            <p id="selected-subject-caption">اضغط على إحدى البطاقات لعرض تسجيلاتها.</p>
                        </div>
                    </div>

                    @foreach($subjects as $subject)
                        @php($subjectRecordings = $recordingsBySubject->get((int) $subject->subject_id, collect()))
                        <div class="recordings-subject-lessons is-hidden" data-recordings-subject="{{ $subject->subject_id }}">
                            @if($subjectRecordings->isEmpty())
                                <div class="recordings-no-lessons">لا توجد حصص مسجلة لهذه المادة حاليًا.</div>
                            @else
                                <div class="recordings-lesson-list">
                                    @foreach($subjectRecordings as $recording)
                                        <article class="recordings-lesson">
                                            <h3>حصة {{ $subject->subject_name }}</h3>
                                            <p>{{ $recording['class']->grade_name }} · {{ $recording['class']->teacher_name }}</p>
                                            @if($recording['start_time'])
                                                <p>التاريخ: {{ date('d/m/Y - H:i', (int) ($recording['start_time'] / 1000)) }}</p>
                                            @endif
                                            @if($recording['playback_url'])
                                                <iframe class="recordings-lesson-frame" src="{{ $recording['playback_url'] }}" title="تسجيل {{ $subject->subject_name }}" allow="fullscreen" scrolling="no" loading="lazy"></iframe>
                                            @endif
                                        </article>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif
        </div>
    </main>
</div>

<script>
    document.querySelectorAll('.recordings-subject-card').forEach(function (card) {
        card.addEventListener('click', function () {
            var subjectId = card.dataset.subjectId;
            var title = card.querySelector('h2').textContent;
            document.querySelectorAll('.recordings-subject-card').forEach(function (item) {
                item.classList.toggle('is-selected', item === card);
            });
            document.querySelectorAll('.recordings-subject-lessons').forEach(function (item) {
                item.classList.toggle('is-hidden', item.dataset.recordingsSubject !== subjectId);
            });
            document.getElementById('selected-subject-title').textContent = title;
            document.getElementById('selected-subject-caption').textContent = 'الحصص المسجلة المتاحة لمادة ' + title;
            document.getElementById('subject-recordings').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
</script>
@include('partials.site-footer')

</body>
</html>
