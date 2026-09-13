@extends('layouts.public', ['title' => $teacher->full_name . ' | مدرسونا'])
@section('content')
<style>
    .teacher-page{background:#fbf9fd;min-height:calc(100vh - 72px);padding-bottom:86px}
    .teacher-hero{position:relative;overflow:hidden;min-height:250px;padding:48px 20px 88px;background:linear-gradient(115deg,#291541 0%,#432568 58%,#56377d 100%);color:#fff;text-align:center}
    .teacher-hero:before,.teacher-hero:after{content:'';position:absolute;border-radius:50%;background:#ffc857;opacity:.08;pointer-events:none}
    .teacher-hero:before{width:280px;height:280px;left:-100px;top:-170px}
    .teacher-hero:after{width:230px;height:230px;right:-80px;bottom:-155px}
    .teacher-hero>*{position:relative;z-index:1}
    .teacher-hero .eyebrow{background:#ffffff18;border:1px solid #ffffff14;color:#ffc857;padding:7px 16px}
    .teacher-hero h1{margin:16px auto 7px;color:#fff;font-size:clamp(30px,4.5vw,45px);line-height:1.35}
    .teacher-hero p{margin:0;color:#e8dff0;font-size:13px}
    .teacher-panel{width:min(1000px,calc(100% - 64px));margin:-30px auto 0;padding:28px;position:relative;z-index:2;border:1px solid #eadfeb;border-radius:22px;background:#fff;box-shadow:0 18px 45px rgba(41,21,65,.1)}
    .teacher-back{display:inline-block;margin-bottom:18px;color:var(--coral);font-size:12px;font-weight:800}
    .teacher-profile{display:grid;grid-template-columns:auto 1fr;align-items:center;gap:18px;padding-bottom:23px;border-bottom:1px solid #f1e9ef}
    .teacher-avatar-large{width:90px;height:90px;display:grid;place-items:center;overflow:hidden;border-radius:24px 24px 7px 24px;background:linear-gradient(135deg,var(--plum),#59369b);color:#fff;font-size:36px;font-weight:800;box-shadow:7px 7px 0 #ffc857}
    .teacher-avatar-large img{width:100%;height:100%;object-fit:cover}
    .teacher-profile h2{margin:0;color:var(--plum);font-size:26px}
    .teacher-profile .specialization{margin:4px 0 0;color:var(--coral);font-size:12px;font-weight:800}
    .teacher-stats{display:flex;flex-wrap:wrap;gap:8px;margin-top:12px}
    .teacher-stats span{padding:6px 10px;border-radius:999px;background:#f8f0fb;color:var(--muted);font-size:10px}
    .teacher-contact{display:flex;flex-wrap:wrap;gap:8px;margin-top:13px}
    .teacher-contact span{padding:6px 10px;border-radius:999px;background:#fff7df;color:#755c18;font-size:10px}
    .teacher-content{display:grid;grid-template-columns:1fr 1.2fr;gap:26px;padding-top:25px}
    .teacher-content h3{margin:0 0 10px;color:var(--plum);font-size:19px}
    .teacher-content p{margin:0;color:var(--muted);font-size:12px;line-height:2}
    .teacher-qualifications{margin-top:22px}
    .teacher-subjects{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}
    .teacher-subject{display:flex;align-items:center;gap:10px;padding:13px;border:1px solid var(--line);border-radius:13px;background:#fff}
    .teacher-subject-icon{width:32px;height:32px;display:grid;place-items:center;border-radius:10px;background:#ffeadf;color:var(--coral);font-size:15px}
    .teacher-subject strong{display:block;color:var(--ink);font-size:12px}
    .teacher-subject small{display:block;margin-top:2px;color:var(--muted);font-size:10px}
    .teacher-empty{grid-column:1/-1;padding:22px;text-align:center;color:var(--muted);border:1px dashed #d9c9df;border-radius:14px;font-size:12px}
    @media(max-width:700px){.teacher-panel{width:min(100% - 20px,600px);padding:19px 16px 24px;border-radius:20px}.teacher-profile{grid-template-columns:1fr;text-align:center}.teacher-avatar-large{margin:auto}.teacher-stats{justify-content:center}.teacher-content{grid-template-columns:1fr;gap:22px}.teacher-subjects{grid-template-columns:1fr}.teacher-hero{min-height:235px;padding:40px 18px 80px}.teacher-hero h1{font-size:30px}}
</style>

<div class="teacher-page">
    <section class="teacher-hero">
        <span class="eyebrow">ملف المدرس</span>
        <h1>{{ $teacher->full_name }}</h1>
        <p>{{ $teacher->specialization ?: 'مدرس معتمد في مدرسة طموح الإلكترونية' }}</p>
    </section>

    <main class="teacher-panel">
        <a class="teacher-back" href="{{ route('teachers') }}">→ العودة إلى المدرسين</a>

        <header class="teacher-profile">
            <div class="teacher-avatar-large">
                @if($teacher->photo_path)
                    <img src="{{ asset(str_replace('public/', '', $teacher->photo_path)) }}" alt="{{ $teacher->full_name }}">
                @else
                    {{ mb_substr($teacher->full_name, 0, 1) }}
                @endif
            </div>
            <div>
                <h2>{{ $teacher->full_name }}</h2>
                <p class="specialization">{{ $teacher->specialization ?: 'مدرس معتمد' }}</p>
                <div class="teacher-stats">
                    <span>{{ (int)($teacher->years_experience ?? 0) }} سنوات خبرة</span>
                    <span>{{ $subjects->count() }} مواد يدرسها</span>
                </div>
                <div class="teacher-contact">
                    @if($teacher->phone)<span>☎ {{ $teacher->phone }}</span>@endif
                    <span>● مدرس نشط</span>
                </div>
            </div>
        </header>

        <div class="teacher-content">
            <section>
                <h3>نبذة عن المدرس</h3>
                <p>{{ $teacher->bio ?: 'مدرس متخصص لمتابعة الطلاب وتبسيط المادة التعليمية.' }}</p>
                @if($teacher->qualifications)
                    <div class="teacher-qualifications">
                        <h3>المؤهلات</h3>
                        <p>{{ $teacher->qualifications }}</p>
                    </div>
                @endif
            </section>

            <section>
                <h3>المواد التي يدرسها</h3>
                <div class="teacher-subjects">
                    @forelse($subjects as $subject)
                        <div class="teacher-subject">
                            <span class="teacher-subject-icon">📚</span>
                            <div>
                                <strong>{{ $subject->name }}</strong>
                                <small>{{ $subject->grade }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="teacher-empty">لا توجد مواد مرتبطة حاليًا.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </main>
</div>
@endsection
