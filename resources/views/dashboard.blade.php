<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>لوحة الطالب | مدرسة طموح الإلكترونية</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--plum:#2e1a47;--coral:#ff6b4a;--gold:#ffc857;--green:#22a66b;--ink:#241432;--muted:#736686;--line:#efe3f1}
        *{box-sizing:border-box}
        body{margin:0;background:#faf7fb;color:var(--ink);font-family:Tajawal,sans-serif}
        a{text-decoration:none}
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
        .student-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:26px}
        .student-head h1{font:700 32px 'Baloo Bhaijaan 2';margin:0}
        .student-head p{color:var(--muted);font-size:12px;margin:4px 0}
        .student-avatar{width:44px;height:44px;border-radius:50%;display:grid;place-items:center;background:#ffe9e1;color:#e14f2e;font-weight:800}
        .student-welcome,.student-moodle{background:linear-gradient(110deg,var(--plum),#51337b);border-radius:21px;padding:25px 28px;color:#fff;display:flex;justify-content:space-between;align-items:center}
        .student-moodle{margin-top:18px}
        .student-welcome h2,.student-moodle h2{font:700 23px 'Baloo Bhaijaan 2';margin:0 0 5px}
        .student-welcome p,.student-moodle p{color:#d9cbe8;font-size:12px;margin:0}
        .student-welcome a,.student-moodle a{background:var(--gold);color:var(--plum);border-radius:99px;padding:10px 15px;font-size:11px;font-weight:800;white-space:nowrap}
        .student-top-cards{display:grid;grid-template-columns:1fr 1fr;gap:18px}
        .student-section{background:#fff;border:1px solid var(--line);border-radius:19px;padding:22px;margin-top:20px}
        .student-section h2{font:700 20px 'Baloo Bhaijaan 2';margin:0 0 16px}
        .student-week{display:grid;grid-template-columns:repeat(7,1fr);gap:9px}
        .student-day{min-height:166px;border:1px solid #f0e9f2;border-radius:12px;padding:9px}
        .student-day h3{font-size:11px;margin:0 0 8px;color:var(--muted)}
        .lesson{background:#f2edff;border-right:3px solid #7c5ce0;padding:8px;border-radius:7px;margin-top:7px}
        .lesson b,.lesson small{display:block}.lesson b{font-size:10px}.lesson small{font-size:9px;color:#6b5d82;margin-top:3px}
        .lesson a,.student-welcome button{display:inline-block;font-size:9px;color:#fff;background:var(--coral);border:0;border-radius:7px;padding:7px 9px;font-weight:800;margin-top:7px;cursor:pointer}
        .lesson-state{display:block;color:#a99bb2!important;margin-top:7px}
        .student-lower{display:grid;grid-template-columns:1.15fr .85fr;gap:20px}
        .student-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:11px}
        .student-card{border:1px solid #f0e9f2;border-radius:12px;padding:13px}
        .student-card span{display:block;color:var(--green);font-size:10px;font-weight:800}.student-card h3{font-size:15px;margin:5px 0}.student-card p{font-size:10px;color:var(--muted);margin:0}.student-card .recorded-link{display:inline-block;margin-top:10px;color:#e14f2e;font-size:11px;font-weight:800}
        .student-card.pending{border-color:#ffe1a5;background:#fffaf0}.student-card .button{display:inline-block;margin-top:10px;background:var(--coral);color:#fff;border-radius:8px;padding:8px 12px;font-size:11px;font-weight:800}
        .payment-row{display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid #f0e9f2;font-size:12px}.payment-row:last-child{border:0}.payment-row span{color:var(--muted);font-size:10px}
        .student-profile{display:grid;grid-template-columns:70px 1fr;gap:16px;align-items:center}.profile-avatar{width:65px;height:65px;border-radius:20px;background:#f3e8ff;color:#7e4fd3;display:grid;place-items:center;font:700 28px 'Baloo Bhaijaan 2'}.student-profile h3{margin:0;font-size:18px}.student-profile p{font-size:11px;color:var(--muted);margin:4px 0}
        .muted{color:var(--muted);font-size:12px}.success,.error{padding:10px 12px;border-radius:9px;font-size:12px}.success{background:#e8f8ef;color:#17734d}.error{background:#fff0ed;color:#a63e2a}
        @media(max-width:1050px){.student-week{grid-template-columns:repeat(4,1fr)}.student-shell{grid-template-columns:68px 1fr}.student-side{padding:20px 10px}.student-brand span:not(.student-mark),.student-menu a{font-size:0}.student-brand{margin:0 auto 30px}.student-menu a{padding:12px;text-align:center}.student-menu a:first-letter{font-size:17px}.student-logout{font-size:0}}
        @media(max-width:700px){.student-shell{grid-template-columns:1fr}.student-side{display:none}.student-main{padding:22px 15px}.student-head h1{font-size:26px}.student-week{grid-template-columns:repeat(2,1fr)}.student-top-cards,.student-lower{grid-template-columns:1fr}.student-welcome,.student-moodle{display:block}.student-welcome a,.student-moodle a{display:inline-block;margin-top:15px}.student-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
@include('partials.site-nav')
<div class="student-shell">
    <aside class="student-side">
        <a class="student-brand" href="{{ route('home') }}"><b class="student-mark">ن</b><span>مدرسة طموح الإلكترونية<small>مساحة الطالب</small></span></a>
        <nav class="student-menu">
            <a class="active" href="#schedule">◈ جدولي</a>
            <a href="#subjects">▣ موادي</a>
            <a href="{{ route('subjects.index') }}">＋ اختر مادة</a>
        </nav>
        <form method="post" action="{{ route('logout') }}">@csrf<button class="student-logout" type="submit">↩ تسجيل الخروج</button></form>
    </aside>
    <main class="student-main">
        @if(session('success'))<p class="success">{{ session('success') }}</p>@endif
        @if($errors->has('attendance'))<p class="error">{{ $errors->first('attendance') }}</p>@endif
        <header class="student-head"><div><h1>مرحبًا، {{ auth()->user()->full_name }} 👋</h1><p>تابع موادك وجدولك الدراسي من مكان واحد.</p></div><div class="student-avatar">{{ mb_substr(auth()->user()->full_name, 0, 1) }}</div></header>
        <div class="student-top-cards">
            <section class="student-welcome">
                <div>
                    @if(auth()->user()->student_mode === 'regular')
                        <h2>{{ $attendanceStarted ? 'دوامك مفتوح الآن' : 'ابدأ دوامك اليومي' }}</h2>
                        <p>من 10:00 إلى 14:00، وستنتقل الحصص تلقائيًا حسب جدولك.</p>
                    @else
                        <h2>حصصك المسجلة</h2>
                        <p>تفتح كل مادة فقط خلال موعد حصتها.</p>
                    @endif
                </div>
                @if(auth()->user()->student_mode === 'regular' && !$attendanceStarted)
                    <form method="post" action="{{ route('school-day.start') }}">@csrf<button type="submit">بدء الدوام</button></form>
                @else
                    <a href="#schedule">عرض الجدول</a>
                @endif
            </section>
            <section class="student-moodle"><div><h2>الدخول إلى الغرفة الدراسية</h2><p>استخدم رقم الجوال ونفس كلمة المرور الخاصة بك.</p></div><a href="{{ config('services.moodle.url', '/moodle') }}" target="_blank" rel="noopener">دخول Moodle</a></section>
        </div>
        <section class="student-section" id="schedule"><h2>جدولي الأسبوعي</h2><div class="student-week">
            @foreach([1=>'السبت',2=>'الأحد',3=>'الإثنين',4=>'الثلاثاء',5=>'الأربعاء',6=>'الخميس',7=>'الجمعة'] as $dayNumber => $dayName)
                <div class="student-day"><h3>{{ $dayName }}</h3>
                    @forelse($classes->where('day_of_week',$dayNumber) as $class)
                        <article class="lesson"><b>{{ $class->subject_name }}</b><small>{{ $class->teacher_name }} · {{ substr($class->starts_at,0,5) }} - {{ substr($class->ends_at,0,5) }}</small>
                            @if($class->access_state === 'open' && (auth()->user()->student_mode !== 'regular' || $attendanceStarted))
                                <a href="{{ $class->viva_z_join_url }}" target="_blank" rel="noopener">الدخول إلى الحصة الدراسية ←</a>
                            @elseif($class->access_state === 'upcoming')
                                <small class="lesson-state">تفتح عند موعدها</small>
                            @elseif($class->access_state === 'ended')
                                <small class="lesson-state">انتهت الحصة</small>
                            @else
                                <small class="lesson-state">ابدأ الدوام للدخول</small>
                            @endif
                        </article>
                    @empty<p class="muted">لا توجد حصص</p>@endforelse
                </div>
            @endforeach
        </div></section>
        <section class="student-section" id="subjects"><h2>موادي المفعلة</h2><div class="student-grid">
                @forelse($enrollments as $enrollment)
                    <article class="student-card {{ $enrollment->status === 'pending' ? 'pending' : '' }}">@if($enrollment->grade_name)<span>{{ $enrollment->grade_name }}</span>@endif<h3>{{ $enrollment->subject_name }}</h3><p>{{ $enrollment->status === 'active' ? 'مادة مفعلة في حسابك' : 'طلب التسجيل بانتظار الدفع' }}</p>@if($enrollment->status === 'active' && $enrollment->delivery_type === 'recorded' && $enrollment->recorded_lectures_url)<a class="recorded-link" href="{{ $enrollment->recorded_lectures_url }}" target="_blank" rel="noopener">فتح المحاضرات المسجلة ←</a>@elseif($enrollment->status === 'active')<a class="button" href="#schedule">الدخول إلى حصصي</a>@elseif($enrollment->status === 'pending')<a class="button" href="{{ route('payment.create', ['enrollment_id'=>$enrollment->id]) }}">إكمال الدفع</a>@endif</article>
                @empty<p class="muted">لا توجد مواد مسجلة بعد.</p>@endforelse
            </div></section>
        <section class="student-section" id="profile"><h2>ملفي الشخصي</h2><div class="student-profile"><div class="profile-avatar">{{ mb_substr(auth()->user()->full_name, 0, 1) }}</div><div><h3>{{ auth()->user()->full_name }}</h3><p>{{ auth()->user()->phone }} · حساب طالب نشط</p></div></div></section>
    </main>
</div>
@include('partials.site-footer')
</body>
</html>