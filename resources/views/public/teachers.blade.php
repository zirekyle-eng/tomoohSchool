@extends('layouts.public', ['title' => 'مدرسونا'])
@section('content')
<style>
    .teachers-page{background:#fbf9fd;min-height:calc(100vh - 72px);padding-bottom:86px}
    .teachers-hero{position:relative;overflow:hidden;min-height:280px;padding:54px 20px 92px;background:linear-gradient(115deg,#291541 0%,#432568 58%,#56377d 100%);color:#fff;text-align:center}
    .teachers-hero:before,.teachers-hero:after{content:'';position:absolute;border-radius:50%;background:#ffc857;opacity:.08;pointer-events:none}
    .teachers-hero:before{width:300px;height:300px;left:-100px;top:-180px}
    .teachers-hero:after{width:240px;height:240px;right:-80px;bottom:-160px}
    .teachers-hero>*{position:relative;z-index:1}
    .teachers-hero .eyebrow{background:#ffffff18;border:1px solid #ffffff14;color:#ffc857;padding:7px 16px}
    .teachers-hero h1{margin:17px auto 9px;color:#fff;font-size:clamp(32px,4.5vw,48px);line-height:1.35}
    .teachers-hero p{max-width:690px;margin:0 auto;color:#e8dff0;font-size:14px;line-height:2}
    .teachers-panel{width:min(1140px,calc(100% - 64px));margin:-30px auto 0;padding:26px 28px 34px;position:relative;z-index:2;border:1px solid #eadfeb;border-radius:22px;background:#fff;box-shadow:0 18px 45px rgba(41,21,65,.1)}
    .teachers-heading{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px;padding-bottom:18px;border-bottom:1px solid #f1e9ef}
    .teachers-heading h2{margin:0;color:var(--plum);font-size:24px}
    .teachers-heading p{margin:3px 0 0;color:var(--muted);font-size:12px}
    .teachers-count{padding:7px 12px;border-radius:999px;background:#fff0e9;color:#c7462d;font-size:11px;font-weight:800;white-space:nowrap}
    .teachers-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
    .teacher-card{display:block;padding:18px;border:1px solid var(--line);border-radius:17px;background:#fff;color:inherit;transition:transform .2s ease,box-shadow .2s ease,border-color .2s ease}
    .teacher-card:hover{transform:translateY(-3px);border-color:#f1b4a5;box-shadow:0 12px 25px rgba(41,21,65,.09)}
    .teacher-photo-wrap{position:relative;width:112px;height:112px;margin:2px auto 18px;border-radius:25px 25px 7px 25px;background:#fff0e9;overflow:visible}
    .teacher-photo{display:block;width:100%;height:100%;object-fit:cover;object-position:center center;border-radius:25px 25px 7px 25px;box-shadow:6px 6px 0 #ffc857}
    .teacher-photo-placeholder{width:100%;height:100%;display:grid;place-items:center;position:absolute;inset:0;border-radius:25px 25px 7px 25px;background:linear-gradient(135deg,var(--plum),#59369b);color:#fff;font-size:28px;font-weight:800;box-shadow:6px 6px 0 #ffc857}
    .teacher-photo-fallback{display:none}
    .teacher-photo-badge{position:absolute;right:-5px;bottom:6px;padding:5px 8px;border-radius:999px;background:#fff;color:var(--plum);font-size:9px;font-weight:800;box-shadow:0 4px 12px rgba(41,21,65,.12)}
    .teacher-card-top{display:flex;align-items:center;gap:12px;margin-bottom:13px}
    .teacher-avatar{width:52px;height:52px;display:grid;place-items:center;flex:0 0 auto;border-radius:16px 16px 5px 16px;background:linear-gradient(135deg,var(--plum),#59369b);color:#fff;font-size:21px;font-weight:800}
    .teacher-card h3{margin:0;color:var(--plum);font-size:17px}
    .teacher-specialization{margin:3px 0 0;color:var(--coral);font-size:11px;font-weight:800}
    .teacher-card .bio{min-height:43px;margin:0 0 14px;color:var(--muted);font-size:11px;line-height:1.8}
    .teacher-card-footer{display:flex;align-items:center;justify-content:space-between;gap:8px;padding-top:12px;border-top:1px solid #f3edf4;color:var(--coral);font-size:11px;font-weight:800}
    .teacher-card-footer small{color:var(--muted);font-size:10px;font-weight:400}
    .teachers-empty{padding:30px;text-align:center;color:var(--muted);border:1px dashed #d9c9df;border-radius:16px}
    @media(max-width:900px){.teachers-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:600px){.teachers-hero{min-height:260px;padding:42px 18px 82px}.teachers-hero h1{font-size:31px}.teachers-hero p{font-size:12px}.teachers-panel{width:min(100% - 20px,600px);padding:18px 15px 22px;border-radius:20px}.teachers-heading{display:block}.teachers-count{display:inline-block;margin-top:10px}.teachers-grid{grid-template-columns:1fr}}

    /* Calm teacher directory: open page, stronger hierarchy, quieter cards. */
    .teachers-page{background:#fffaf6;padding-bottom:92px}
    .teachers-hero{min-height:320px;padding:64px 20px 116px;background:var(--plum);text-align:right}
    .teachers-hero:before{width:390px;height:390px;left:-150px;top:-230px;background:#ffc857;opacity:.08}
    .teachers-hero:after{width:280px;height:280px;right:10%;bottom:-220px;background:#fff;opacity:.04}
    .teachers-hero .container{width:min(1140px,calc(100% - 36px))}
    .teachers-hero h1{max-width:670px;margin:18px 0 8px;font-size:clamp(34px,5vw,54px)}
    .teachers-hero p{max-width:540px;margin:0;color:#d9cbe8;font-size:13px}
    .teachers-panel{width:min(1140px,calc(100% - 36px));margin:-45px auto 0;padding:25px 0 0;background:transparent;border:0;box-shadow:none}
    .teachers-heading{padding:20px 24px;margin-bottom:22px;background:#fff;border:1px solid var(--line);border-radius:18px;box-shadow:0 12px 30px #2915400d;border-bottom:0}
    .teachers-heading h2{font-size:23px}
    .teachers-heading p{font-size:11px}
    .teachers-count{background:#f5eef9;color:var(--plum)}
    .teachers-grid{gap:16px}
    .teacher-card{position:relative;min-height:320px;padding:22px 20px 16px;border:1px solid var(--line);border-radius:20px;background:#fff;box-shadow:0 7px 18px #29154008}
    .teacher-card:before{content:'';position:absolute;top:0;right:20px;left:20px;height:3px;border-radius:0 0 5px 5px;background:var(--plum)}
    .teacher-card:hover{transform:translateY(-5px);border-color:#d9c8e4;box-shadow:0 18px 32px #29154016}
    .teacher-photo-wrap{width:126px;height:126px;margin:4px auto 20px;border-radius:50%;background:#f5eef9}
    .teacher-photo,.teacher-photo-placeholder{border-radius:50%;box-shadow:0 0 0 6px #f5eef9}
    .teacher-photo-placeholder{background:var(--plum);box-shadow:0 0 0 6px #f5eef9;color:#fff}
    .teacher-photo-badge{right:-12px;bottom:7px;padding:5px 9px;background:var(--plum);color:#fff;box-shadow:none}
    .teacher-card-top{display:block;text-align:center;margin-bottom:13px}
    .teacher-card h3{font-size:18px}
    .teacher-specialization{font-size:10px}
    .teacher-card .bio{min-height:45px;text-align:center;font-size:11px}
    .teacher-card-footer{margin-top:auto;border-top:1px solid #f1e9f2;color:var(--coral)}
    .teacher-card-footer small{font-size:10px}
    @media(max-width:600px){
        .teachers-hero{min-height:280px;padding:48px 18px 100px}
        .teachers-hero .container{text-align:center}
        .teachers-hero h1{margin:16px auto 8px}
        .teachers-panel{width:min(100% - 24px,600px);margin-top:-35px;padding-top:0}
        .teachers-heading{padding:18px 19px}
    }
</style>

<div class="teachers-page">
    <section class="teachers-hero">
        <span class="eyebrow">خبرة تساندك</span>
        <h1>مدرسون يشرحون لك بطريقتك</h1>
        <p>مدرسون متخصصون وشرح قريب من الطالب ومتابعة حقيقية لتقدمك.</p>
    </section>

    <main class="teachers-panel">
        <header class="teachers-heading">
            <div>
                <h2>تعرف على مدرسينا</h2>
                <p>اختر المدرس المناسب وتعرّف على خبرته وتخصصه.</p>
            </div>
            <span class="teachers-count">{{ $teachers->count() }} مدرسين</span>
        </header>

        <div class="teachers-grid">
            @forelse($teachers as $teacher)
                <a class="teacher-card" href="{{ route('teachers.show', $teacher->id) }}">
                    <div class="teacher-photo-wrap">
                        @if($teacher->photo_path)
                            <img class="teacher-photo" src="{{ asset(str_replace('public/', '', $teacher->photo_path)) }}" alt="{{ $teacher->full_name }}" onerror="this.style.display='none';this.nextElementSibling.style.display='grid'">
                            <span class="teacher-photo-placeholder teacher-photo-fallback">{{ mb_substr($teacher->full_name, 0, 1) }}</span>
                        @else
                            <span class="teacher-photo-placeholder">{{ mb_substr($teacher->full_name, 0, 1) }}</span>
                        @endif
                        <span class="teacher-photo-badge">مدرس معتمد</span>
                    </div>
                    <div class="teacher-card-top">
                        <div>
                            <h3>{{ $teacher->full_name }}</h3>
                            <p class="teacher-specialization">{{ $teacher->specialization ?: 'مدرس معتمد' }}</p>
                        </div>
                    </div>
                    <p class="bio">{{ $teacher->bio ?: 'مدرس متخصص لمتابعة الطلاب وتبسيط المادة التعليمية.' }}</p>
                    <div class="teacher-card-footer">
                        <span>عرض الملف ←</span>
                        <small>{{ (int)($teacher->years_experience ?? 0) }} سنوات خبرة</small>
                    </div>
                </a>
            @empty
                <p class="teachers-empty">سيتم عرض المدرسين المعتمدين هنا قريبًا.</p>
            @endforelse
        </div>
    </main>
</div>
@endsection