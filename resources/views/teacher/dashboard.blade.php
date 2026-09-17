@extends('layouts.app', ['title' => 'مساحة المدرس'])

@section('content')

<style>
    :root{
        --plum:#2e1a47;
        --coral:#ff6b4a;
        --gold:#ffc857;
        --green:#22a66b;
        --ink:#241432;
        --muted:#736686;
        --line:#efe3f1;
        --soft:#faf7fb;
    }

    .teacher-page{
        min-height:100vh;
        background:var(--soft);
        color:var(--ink);
        font-family:Tajawal,sans-serif;
    }

    *{
        box-sizing:border-box;
    }

    .teacher-shell{
        min-height:100vh;
        display:grid;
        grid-template-columns:250px 1fr;
    }

    /* =========================
       SIDEBAR
    ========================= */

    .teacher-side{
        background:var(--plum);
        color:#fff;
        padding:25px 17px;
        display:flex;
        flex-direction:column;
        min-height:100%;
    }

    .teacher-brand{
        display:flex;
        align-items:center;
        gap:10px;
        margin:3px 8px 37px;
        color:#fff;
        text-decoration:none;
        font:700 19px 'Baloo Bhaijaan 2';
    }

    .teacher-brand small{
        display:block;
        color:#cdbfdb;
        font:11px Tajawal;
        margin-top:2px;
    }

    .teacher-mark{
        width:39px;
        height:39px;
        border-radius:13px 13px 13px 4px;
        background:var(--coral);
        display:grid;
        place-items:center;
        flex-shrink:0;
    }

    .teacher-menu{
        display:grid;
        gap:6px;
    }

    .teacher-menu a,
    .teacher-logout{
        color:#d9cbe8;
        padding:12px 13px;
        border-radius:11px;
        font-size:14px;
        font-weight:700;
        text-decoration:none;
        transition:.2s ease;
    }

    .teacher-menu a:hover,
    .teacher-menu a.active{
        background:#ffffff18;
        color:#fff;
    }

    .teacher-logout{
        margin-top:auto;
        border:0;
        background:none;
        text-align:right;
        font:700 14px Tajawal;
        cursor:pointer;
        color:#ffc5b8;
    }

    /* =========================
       MAIN
    ========================= */

    .teacher-main{
        padding:30px 36px;
        min-width:0;
    }

    .teacher-head{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:26px;
    }

    .teacher-head h1{
        font:700 32px 'Baloo Bhaijaan 2';
        margin:0;
        line-height:1.4;
    }

    .teacher-head p{
        color:var(--muted);
        font-size:15px;
        margin:4px 0;
    }

    .teacher-avatar{
        width:48px;
        height:48px;
        border-radius:50%;
        overflow:hidden;
        background:#ddf3e8;
        color:var(--green);
        display:grid;
        place-items:center;
        font-weight:800;
        font-size:18px;
        flex-shrink:0;
    }

    .teacher-avatar img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    /* =========================
       TOP CARDS
    ========================= */

    .teacher-top-cards{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:18px;
        align-items:stretch;
    }

    .teacher-top-cards > section{
        min-width:0;
        min-height:145px;
        height:145px;
    }

    .teacher-intro,
    .teacher-moodle{
        background:linear-gradient(110deg,var(--plum),#51337b);
        border-radius:21px;
        padding:25px 28px;
        color:#fff;

        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:20px;

        margin-top:0;
        height:145px;
    }

    .teacher-intro h2,
    .teacher-moodle h2{
        font:700 27px 'Baloo Bhaijaan 2';
        margin:0 0 6px;
    }

    .teacher-intro p,
    .teacher-moodle p{
        color:#d9cbe8;
        font-size:15px;
        line-height:1.8;
        margin:0;
    }

    .teacher-intro a,
    .teacher-moodle a{
        background:var(--gold);
        color:var(--plum);
        border-radius:14px;
        padding:15px 25px;

        min-width:165px;
        min-height:52px;

        display:inline-flex;
        align-items:center;
        justify-content:center;

        font-family:Tajawal,sans-serif;
        font-size:16px;
        font-weight:800;

        text-decoration:none;
        white-space:nowrap;
        transition:.2s ease;
    }

    .teacher-intro a:hover,
    .teacher-moodle a:hover{
        transform:translateY(-2px);
        box-shadow:0 7px 18px rgba(46,26,71,.15);
    }

    /* =========================
       SECTIONS
    ========================= */

    .teacher-section{
        background:#fff;
        border:1px solid var(--line);
        border-radius:19px;
        padding:22px;
        margin-top:20px;
    }

    .teacher-section h2{
        font:700 22px 'Baloo Bhaijaan 2';
        margin:0 0 16px;
    }

    /* =========================
       WEEKLY SCHEDULE
    ========================= */

    .teacher-week{
        display:grid;
        grid-template-columns:repeat(7,minmax(130px,1fr));
        gap:9px;
        overflow-x:auto;
    }

    .teacher-day{
        min-height:180px;
        border:1px solid #f0e9f2;
        border-radius:12px;
        padding:10px;
        background:#fff;
    }

    .teacher-day h3{
        font-size:14px;
        margin:0 0 9px;
        color:var(--muted);
        font-weight:800;
    }

    .teacher-lesson{
        background:#f2edff;
        border-right:3px solid #7c5ce0;
        padding:10px;
        border-radius:8px;
        margin-top:8px;
    }

    .teacher-lesson b{
        display:block;
        font-size:14px;
        line-height:1.5;
    }

    .teacher-lesson small{
        display:block;
        color:#6b5d82;
        font-size:12px;
        line-height:1.7;
        margin-top:4px;
    }

    .teacher-lesson a{
        display:inline-block;
        margin-top:9px;
        color:#e14f2e;
        font-size:13px !important;
        font-weight:800;
        text-decoration:none;
    }

    /* =========================
       SUBJECTS (clickable to filter recordings)
    ========================= */

    .teacher-subject-grid{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:11px;
    }

    .teacher-card{
        display:block;
        width:100%;
        border:1px solid #f0e9f2;
        border-radius:12px;
        padding:16px;
        background:#fff;
        color:var(--ink);
        text-align:right;
        cursor:pointer;
        font:inherit;
        transition:border-color .2s ease,box-shadow .2s ease,transform .2s ease;
    }

    .teacher-card:hover,
    .teacher-card.is-selected{
        border-color:var(--green);
        box-shadow:0 9px 20px rgba(34,166,107,.1);
        transform:translateY(-2px);
    }

    .teacher-card strong{
        display:block;
        font-size:17px;
        margin-bottom:6px;
    }

    .teacher-card p{
        margin:0;
    }

    .teacher-card small{
        display:block;
        margin-top:12px;
        color:var(--coral);
        font-size:12px;
        font-weight:800;
    }

    .muted{
        color:var(--muted);
        font-size:14px;
    }

    /* =========================
       RECORDINGS
    ========================= */

    .teacher-recordings-heading{
        display:flex;
        align-items:end;
        justify-content:space-between;
        gap:12px;
    }

    .teacher-recordings-heading h2{
        margin-bottom:3px;
    }

    .teacher-recordings-heading p{
        margin:0 0 16px;
        color:var(--muted);
        font-size:13px;
    }

    .teacher-recordings-grid{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:14px;
    }

    .teacher-recording-subject{
        padding:15px;
        border:1px solid #f0e9f2;
        border-radius:13px;
        background:#fff;
    }

    .teacher-recording-subject.is-hidden{
        display:none;
    }

    .teacher-recording-subject h3{
        margin:0 0 4px;
        font-size:16px;
    }

    .teacher-recording-subject > p{
        margin:0 0 12px;
        color:var(--muted);
        font-size:12px;
    }

    .teacher-recording-list{
        display:grid;
        gap:8px;
    }

    .teacher-recording{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        padding:10px;
        border-radius:9px;
        background:#f7f3ff;
    }

    .teacher-recording strong{
        display:block;
        font-size:13px;
    }

    .teacher-recording small{
        display:block;
        margin-top:3px;
        color:var(--muted);
        font-size:11px;
    }

    .teacher-recording a{
        padding:7px 9px;
        border-radius:7px;
        background:var(--coral);
        color:#fff;
        font-size:11px;
        font-weight:800;
        white-space:nowrap;
        text-decoration:none;
    }

    .teacher-recordings-empty{
        padding:22px;
        border-radius:12px;
        background:var(--soft);
        color:var(--muted);
        font-size:13px;
        text-align:center;
    }

    .teacher-recordings-error{
        margin-bottom:12px;
        padding:10px 12px;
        border-radius:9px;
        background:#fff1f2;
        color:#b91c1c;
        font-size:13px;
    }

    /* =========================
       PROFILE
    ========================= */

    .teacher-profile-box{
        border:1px solid #f0e9f2;
        border-radius:16px;
        padding:20px;
        background:#fff;
    }

    .teacher-profile-row{
        display:flex;
        align-items:center;
        gap:16px;
        padding-bottom:18px;
        border-bottom:1px solid #f0e9f2;
    }

    .teacher-profile-row .teacher-avatar{
        width:68px;
        height:68px;
        border-radius:20px;
        font-size:26px;
    }

    .teacher-profile-row h3{
        margin:0;
        font-size:21px;
    }

    .teacher-profile-row p{
        margin:5px 0 0;
    }

    .teacher-bio{
        margin:18px 0 0;
        line-height:1.9;
        font-size:14px;
    }

    /* =========================
       PROFILE FORM
    ========================= */

    .teacher-form{
        display:grid;
        gap:14px;
        margin-top:20px;
        padding-top:20px;
        border-top:1px solid #f0e9f2;
    }

    .teacher-form-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:14px;
    }

    .teacher-form label{
        display:grid;
        gap:7px;
        font-size:14px;
        font-weight:800;
    }

    .teacher-form label.full{
        grid-column:1/-1;
    }

    .teacher-form input,
    .teacher-form textarea{
        width:100%;
        border:1px solid var(--line);
        border-radius:11px;
        padding:12px 13px;
        font:14px Tajawal;
        color:var(--ink);
        background:#fffdfa;
        outline:none;
        transition:.2s ease;
    }

    .teacher-form input:focus,
    .teacher-form textarea:focus{
        border-color:#c9b6df;
        box-shadow:0 0 0 3px rgba(126,79,211,.08);
    }

    .teacher-form textarea{
        min-height:100px;
        resize:vertical;
        line-height:1.8;
    }

    .teacher-form input[type="file"]{
        padding:10px;
    }

    .teacher-save{
        border:0;
        border-radius:12px;
        background:var(--green);
        color:#fff;
        padding:13px 23px;
        font:800 15px Tajawal;
        width:max-content;
        cursor:pointer;
        transition:.2s ease;
    }

    .teacher-save:hover{
        transform:translateY(-2px);
        box-shadow:0 7px 18px rgba(34,166,107,.18);
    }

    /* =========================
       EMPTY / MESSAGES
    ========================= */

    .teacher-empty{
        padding:20px;
        text-align:center;
        background:var(--soft);
        border-radius:12px;
    }

    .teacher-success,
    .teacher-error{
        padding:12px 15px;
        border-radius:10px;
        margin-bottom:18px;
        font-size:14px;
    }

    .teacher-success{
        background:#e8f8ef;
        color:#17734d;
    }

    .teacher-error{
        background:#fff0ed;
        color:#a63e2a;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media(max-width:1100px){

        .teacher-shell{
            grid-template-columns:68px 1fr;
        }

        .teacher-side{
            padding:20px 10px;
        }

        .teacher-brand{
            justify-content:center;
            margin:0 auto 30px;
        }

        .teacher-brand span{
            display:none;
        }

        .teacher-menu a{
            font-size:0;
            text-align:center;
            padding:12px;
        }

        .teacher-menu a::first-letter{
            font-size:18px;
        }

        .teacher-logout{
            font-size:0;
            text-align:center;
            padding:12px;
        }
    }

    @media(max-width:800px){

        .teacher-main{
            padding:25px 20px;
        }

        .teacher-week{
            grid-template-columns:repeat(4,minmax(140px,1fr));
        }

        .teacher-subject-grid,
        .teacher-recordings-grid{
            grid-template-columns:1fr;
        }

        .teacher-form-grid{
            grid-template-columns:1fr;
        }

        .teacher-form label.full{
            grid-column:auto;
        }
    }

    @media(max-width:700px){

        .teacher-shell{
            grid-template-columns:1fr;
        }

        .teacher-side{
            display:none;
        }

        .teacher-main{
            padding:22px 15px;
        }

        .teacher-head h1{
            font-size:27px;
        }

        .teacher-head p{
            font-size:14px;
        }

        .teacher-intro{
            display:block;
            padding:22px;
        }

        .teacher-intro h2{
            font-size:24px;
        }

        .teacher-intro a{
            display:flex;
            width:100%;
            margin-top:16px;
        }

        .teacher-section{
            padding:17px;
        }

        .teacher-section h2{
            font-size:21px;
        }

        .teacher-week{
            grid-template-columns:repeat(2,minmax(145px,1fr));
        }

        .teacher-profile-row{
            align-items:flex-start;
        }

        .teacher-profile-row h3{
            font-size:19px;
        }

        .teacher-recording{
            align-items:flex-start;
            flex-direction:column;
        }

        .teacher-recording a{
            align-self:stretch;
            text-align:center;
        }

        .teacher-top-cards{
            grid-template-columns:1fr;
        }

        .teacher-intro,
        .teacher-moodle{
            height:auto;
            min-height:145px;
            display:block;
        }

        .teacher-intro a,
        .teacher-moodle a{
            display:flex;
            width:100%;
            margin-top:15px;
        }

    }
</style>


<div class="teacher-page">

    <div class="teacher-shell">

        {{-- =========================
             SIDEBAR
        ========================== --}}
        <aside class="teacher-side">

            <a class="teacher-brand" href="{{ route('home') }}">
                <b class="teacher-mark">ن</b>

                <span>
                    مدرسة طموح الإلكترونية
                    <small>مساحة المدرس</small>
                </span>
            </a>

            <nav class="teacher-menu">

                <a class="active" href="#schedule">
                    ◈ جدولي
                </a>

                <a href="#subjects">
                    ▣ موادي
                </a>

                <a href="#recordings">
                    ▶ التسجيلات
                </a>

                <a href="#profile">
                    ♙ حسابي
                </a>

            </nav>

            <form method="post"
                  action="{{ route('logout') }}"
                  style="margin-top:auto">

                @csrf

                <button class="teacher-logout" type="submit">
                    ↩ تسجيل الخروج
                </button>

            </form>

        </aside>


        {{-- =========================
             MAIN
        ========================== --}}
        <main class="teacher-main">

            {{-- Messages --}}
            @if(session('success'))
                <div class="teacher-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="teacher-error">
                    {{ $errors->first() }}
                </div>
            @endif


            {{-- =========================
                 HEADER
            ========================== --}}
            <header class="teacher-head">

                <div>

                    <h1>
                        مرحبًا أ. {{ $profile->full_name }} 👋
                    </h1>

                    <p>
                        {{ $profile->specialization ?: 'مدرس معتمد في مدرسة طموح الإلكترونية' }}
                    </p>

                </div>

                <div class="teacher-avatar">

                    @if($profile->photo_path)

                        <img
                            src="{{ asset(str_replace('public/', '', $profile->photo_path)) }}"
                            alt="{{ $profile->full_name }}"
                        >

                    @else

                        {{ mb_substr($profile->full_name, 0, 1) }}

                    @endif

                </div>

            </header>


            {{-- =========================
                 MOODLE / INTRO CARD
            ========================== --}}
            <div class="teacher-top-cards">

                {{-- كارد جدول الحصص --}}
                <section class="teacher-intro">

                    <div>
                        <h2>
                            حصصك في مكان واحد
                        </h2>

                        <p>
                            تابع جدولك الدراسي وابدأ حصصك في موعدها.
                        </p>
                    </div>

                    <a href="#schedule">
                        عرض الجدول
                    </a>

                </section>


                {{-- كارد Moodle --}}
                <section class="teacher-moodle">

                    <div>
                        <h2>
                            الدخول إلى الغرفة الدراسية
                        </h2>

                        <p>
                            استخدم رقم الجوال ونفس كلمة المرور الخاصة بك.
                        </p>
                    </div>

                    <a
                        href="{{ config('services.moodle.url', '/moodle') }}"
                        target="_blank"
                        rel="noopener"
                    >
                        دخول Moodle
                    </a>

                </section>

            </div>


            {{-- =========================
                 WEEKLY SCHEDULE
            ========================== --}}
            <section class="teacher-section" id="schedule">

                <h2>
                    جدولي الأسبوعي
                </h2>

                <div class="teacher-week">

                    @foreach([
                        1=>'السبت',
                        2=>'الأحد',
                        3=>'الإثنين',
                        4=>'الثلاثاء',
                        5=>'الأربعاء',
                        6=>'الخميس',
                        7=>'الجمعة'
                    ] as $dayNumber => $dayName)

                        <div class="teacher-day">

                            <h3>
                                {{ $dayName }}
                            </h3>

                            @forelse($classes->where('day_of_week', $dayNumber) as $class)

                                <article class="teacher-lesson">

                                    <b>
                                        {{ $class->subject_name }}
                                    </b>

                                    <small>
                                        {{ $class->grade_name }}
                                        ·
                                        {{ substr($class->starts_at, 0, 5) }}
                                        -
                                        {{ substr($class->ends_at, 0, 5) }}

                                        <br>

                                        {{ $class->students }} طالب
                                    </small>

                                    @if($class->viva_z_join_url)

                                        <a
                                            href="{{ $class->viva_z_join_url }}"
                                            target="_blank"
                                            rel="noopener"
                                        >
                                            دخول الغرفة ←
                                        </a>

                                    @endif

                                </article>

                            @empty

                                <p class="muted">
                                    لا توجد حصص
                                </p>

                            @endforelse

                        </div>

                    @endforeach

                </div>

            </section>


            {{-- =========================
                 SUBJECTS (اضغط لعرض تسجيلات المادة)
            ========================== --}}
            <section class="teacher-section" id="subjects">

                <h2>
                    موادي
                </h2>

                <div class="teacher-subject-grid">

                    @forelse($subjects as $subject)

                        <button class="teacher-card" type="button" data-subject="{{ $subject->subject_name }}">

                            <strong>
                                {{ $subject->subject_name }}
                            </strong>

                            <p class="muted">
                                {{ $subject->grade_name }}
                            </p>

                            <small>
                                عرض التسجيلات ←
                            </small>

                        </button>

                    @empty

                        <div class="teacher-empty muted">
                            لا توجد مواد مرتبطة.
                        </div>

                    @endforelse

                </div>

            </section>


            {{-- =========================
                 RECORDINGS
            ========================== --}}
            <section class="teacher-section" id="recordings">

                <div class="teacher-recordings-heading">
                    <div>
                        <h2>تسجيلات الحصص</h2>
                        <p id="recordings-caption">اختر مادة من البطاقات لعرض تسجيلاتها.</p>
                    </div>
                </div>

                @if($recordingsError)
                    <div class="teacher-recordings-error">
                        {{ $recordingsError }}
                    </div>
                @endif

                @if($recordingsBySubject->isEmpty())

                    <div class="teacher-recordings-empty">
                        لا توجد تسجيلات متاحة حاليًا لموادك.
                    </div>

                @else

                    <div class="teacher-recordings-grid">

                        @foreach($recordingsBySubject as $subjectName => $recordings)

                            <article class="teacher-recording-subject" data-recording-subject="{{ $subjectName }}">

                                <h3>{{ $subjectName }}</h3>

                                <p>
                                    {{ $recordings->first()['class']->grade_name }}
                                    ·
                                    {{ $recordings->count() }} تسجيل
                                </p>

                                <div class="teacher-recording-list">

                                    @foreach($recordings as $recording)

                                        <div class="teacher-recording">

                                            <div>
                                                <strong>{{ $profile->full_name }}</strong>

                                                @if($recording['start_time'])
                                                    <small>{{ date('d/m/Y - H:i', (int) ($recording['start_time'] / 1000)) }}</small>
                                                @endif
                                            </div>

                                            @if($recording['playback_url'])
                                                <a href="{{ $recording['playback_url'] }}" target="_blank" rel="noopener">
                                                    مشاهدة التسجيل
                                                </a>
                                            @endif

                                        </div>

                                    @endforeach

                                </div>

                            </article>

                        @endforeach

                    </div>

                @endif

            </section>


            {{-- =========================
                 PROFILE
            ========================== --}}
            <section class="teacher-section" id="profile">

                <h2>
                    ملفي الشخصي
                </h2>

                <div class="teacher-profile-box">

                    <div class="teacher-profile-row">

                        <div class="teacher-avatar">

                            @if($profile->photo_path)

                                <img
                                    src="{{ asset(str_replace('public/', '', $profile->photo_path)) }}"
                                    alt=""
                                >

                            @else

                                {{ mb_substr($profile->full_name, 0, 1) }}

                            @endif

                        </div>

                        <div>

                            <h3>
                                {{ $profile->full_name }}
                            </h3>

                            <p class="muted">
                                {{ $profile->phone }}
                                ·
                                {{ $profile->specialization ?: '—' }}
                                ·
                                {{ (int) $profile->years_experience }}
                                سنوات خبرة
                            </p>

                        </div>

                    </div>


                    @if($profile->bio)

                        <p class="teacher-bio muted">
                            {{ $profile->bio }}
                        </p>

                    @endif


                    {{-- Edit Profile --}}
                    <form
                        class="teacher-form"
                        method="post"
                        action="{{ route('teacher.profile.update') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        <div class="teacher-form-grid">

                            <label>
                                الاسم الكامل

                                <input
                                    name="full_name"
                                    value="{{ old('full_name', $profile->full_name) }}"
                                    required
                                >
                            </label>


                            <label>
                                رقم الجوال

                                <input
                                    name="phone"
                                    value="{{ old('phone', $profile->phone) }}"
                                    required
                                >
                            </label>


                            <label>
                                التخصص

                                <input
                                    name="specialization"
                                    value="{{ old('specialization', $profile->specialization) }}"
                                >
                            </label>


                            <label>
                                سنوات الخبرة

                                <input
                                    name="years_experience"
                                    type="number"
                                    min="0"
                                    max="60"
                                    value="{{ old('years_experience', $profile->years_experience) }}"
                                >
                            </label>


                            <label class="full">
                                نبذة تعريفية

                                <textarea name="bio">{{ old('bio', $profile->bio) }}</textarea>
                            </label>


                            <label class="full">
                                الصورة الشخصية

                                <input
                                    name="photo"
                                    type="file"
                                    accept="image/jpeg,image/png,image/webp"
                                >
                            </label>

                        </div>


                        <button
                            class="teacher-save"
                            type="submit"
                        >
                            حفظ التعديلات
                        </button>

                    </form>

                </div>

            </section>

        </main>

    </div>

</div>

<script>
    document.querySelectorAll('.teacher-card[data-subject]').forEach(function (card) {
        card.addEventListener('click', function () {
            var subject = card.dataset.subject;

            document.querySelectorAll('.teacher-card[data-subject]').forEach(function (item) {
                item.classList.toggle('is-selected', item === card);
            });

            document.querySelectorAll('.teacher-recording-subject[data-recording-subject]').forEach(function (item) {
                item.classList.toggle('is-hidden', item.dataset.recordingSubject !== subject);
            });

            var caption = document.getElementById('recordings-caption');
            if (caption) caption.textContent = 'التسجيلات المتاحة لمادة ' + subject;

            document.getElementById('recordings').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    var recordingsLink = document.querySelector('.teacher-menu a[href="#recordings"]');
    if (recordingsLink) {
        recordingsLink.addEventListener('click', function () {
            document.querySelectorAll('.teacher-card[data-subject]').forEach(function (item) {
                item.classList.remove('is-selected');
            });

            document.querySelectorAll('.teacher-recording-subject[data-recording-subject]').forEach(function (item) {
                item.classList.remove('is-hidden');
            });

            var caption = document.getElementById('recordings-caption');
            if (caption) caption.textContent = 'كل التسجيلات مرتبة حسب المادة.';
        });
    }
</script>

@endsection
