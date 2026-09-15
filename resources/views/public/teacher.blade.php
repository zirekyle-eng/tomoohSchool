@extends('layouts.public', ['title' => $teacher->full_name . ' | مدرسونا'])
@section('content')
<style>
    .teacher-profile-page{background:#f8f5f1;min-height:calc(100vh - 72px);padding:34px 0 90px;color:#261735}
    .teacher-profile-wrap{width:min(1120px,calc(100% - 36px));margin:auto}
    .teacher-profile-back{display:inline-flex;align-items:center;gap:8px;margin-bottom:26px;color:#76677d;font-size:12px;font-weight:700;transition:color .2s ease}
    .teacher-profile-back:hover{color:var(--coral)}
    .teacher-profile-hero{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(280px,.65fr);overflow:hidden;min-height:360px;border-radius:28px;background:#2b1749;color:#fff;box-shadow:0 22px 48px rgba(43,23,73,.16)}
    .teacher-profile-intro{position:relative;display:flex;flex-direction:column;justify-content:center;padding:54px 58px;isolation:isolate}
    .teacher-profile-intro:before{content:'';position:absolute;z-index:-1;width:390px;height:390px;right:-170px;bottom:-245px;border:1px solid rgba(255,200,87,.28);border-radius:50%;box-shadow:0 0 0 30px rgba(255,200,87,.04),0 0 0 60px rgba(255,200,87,.03)}
    .teacher-profile-kicker{display:inline-flex;width:max-content;padding:6px 12px;border:1px solid rgba(255,255,255,.2);border-radius:99px;color:#ffd779;font-size:10px;font-weight:800;letter-spacing:.2px}
    .teacher-profile-intro h1{max-width:610px;margin:19px 0 8px;color:#fff;font-size:clamp(32px,5vw,58px);line-height:1.25}
    .teacher-profile-role{margin:0;color:#dccfe8;font-size:14px}
    .teacher-profile-meta{display:flex;flex-wrap:wrap;gap:10px;margin-top:26px}
    .teacher-profile-meta span{padding:8px 12px;border-radius:10px;background:rgba(255,255,255,.1);color:#f7edf9;font-size:11px}
    .teacher-profile-meta strong{color:#ffd779;font-size:16px;margin-left:3px}
    .teacher-profile-photo{position:relative;display:flex;align-items:center;justify-content:center;padding:42px;background:#f1e7df}
    .teacher-profile-photo:before{content:'';position:absolute;inset:24px;border:1px solid #ddcdbf;border-radius:50% 50% 14px 50%;transform:rotate(-7deg)}
    .teacher-profile-photo img,.teacher-profile-photo-placeholder{position:relative;width:min(100%,220px);aspect-ratio:1;display:grid;place-items:center;object-fit:cover;border:9px solid #fff;border-radius:50% 50% 16px 50%;box-shadow:0 16px 30px rgba(43,23,73,.18)}
    .teacher-profile-photo-placeholder{background:var(--coral);color:#fff;font-size:62px;font-weight:800}
    .teacher-profile-body{display:grid;grid-template-columns:minmax(0,1.15fr) minmax(260px,.85fr);gap:20px;margin-top:20px}
    .teacher-profile-section{padding:28px;border:1px solid #e7ddd5;border-radius:20px;background:#fff;box-shadow:0 9px 22px rgba(43,23,73,.04)}
    .teacher-profile-section-heading{display:flex;align-items:center;gap:12px;margin:0 0 17px;color:#2b1749;font-size:20px}
    .teacher-profile-section-heading:before{content:'';width:5px;height:23px;border-radius:5px;background:var(--coral)}
    .teacher-profile-section p{margin:0;color:#76677d;font-size:13px;line-height:2.1}
    .teacher-profile-qualification{margin-top:24px;padding-top:21px;border-top:1px solid #eee6df}
    .teacher-profile-qualification h3{margin:0 0 8px;color:#2b1749;font-size:14px}
    .teacher-subject-list{display:grid;gap:11px}
    .teacher-subject-row{display:flex;align-items:center;gap:13px;padding:13px 14px;border:1px solid #eee5de;border-radius:14px;background:#fffaf7;transition:transform .2s ease,border-color .2s ease}
    .teacher-subject-row:hover{transform:translateX(-3px);border-color:#efb8aa}
    .teacher-subject-icon{width:38px;height:38px;display:grid;place-items:center;flex:0 0 auto;border-radius:11px;background:#ffe9df;color:var(--coral);font-size:17px}
    .teacher-subject-row strong{display:block;color:#2b1749;font-size:13px}
    .teacher-subject-row small{display:block;margin-top:2px;color:#8a7b8f;font-size:10px}
    .teacher-subject-empty{padding:22px;text-align:center;color:#8a7b8f;border:1px dashed #daccc2;border-radius:14px;font-size:12px}
    @media(max-width:760px){.teacher-profile-page{padding-top:22px}.teacher-profile-wrap{width:min(100% - 22px,600px)}.teacher-profile-hero{grid-template-columns:1fr;min-height:0}.teacher-profile-photo{order:-1;padding:32px}.teacher-profile-photo:before{inset:18px}.teacher-profile-photo img,.teacher-profile-photo-placeholder{width:150px}.teacher-profile-photo-placeholder{font-size:45px}.teacher-profile-intro{padding:34px 25px 38px}.teacher-profile-intro h1{font-size:35px}.teacher-profile-meta{margin-top:20px}.teacher-profile-body{grid-template-columns:1fr}.teacher-profile-section{padding:22px 19px}}
</style>

<div class="teacher-profile-page">
    <div class="teacher-profile-wrap">
        <a class="teacher-profile-back" href="{{ route('teachers') }}"><span aria-hidden="true">→</span> العودة إلى قائمة المدرسين</a>

        <header class="teacher-profile-hero">
            <div class="teacher-profile-intro">
                <span class="teacher-profile-kicker">مدرس معتمد في مدرسة طموح</span>
                <h1>{{ $teacher->full_name }}</h1>
                <p class="teacher-profile-role">{{ $teacher->specialization ?: 'مدرس متخصص لمتابعة الطلاب وتبسيط المادة التعليمية.' }}</p>
                <div class="teacher-profile-meta">
                    <span><strong>{{ (int)($teacher->years_experience ?? 0) }}</strong> سنوات خبرة</span>
                    <span><strong>{{ $subjects->count() }}</strong> مواد دراسية</span>
                    @if($teacher->phone)<span>{{ $teacher->phone }} ☎</span>@endif
                </div>
            </div>
            <div class="teacher-profile-photo">
                @if($teacher->photo_path)
                    <img src="{{ asset(str_replace('public/', '', $teacher->photo_path)) }}" alt="صورة {{ $teacher->full_name }}" onerror="this.style.display='none';this.nextElementSibling.style.display='grid'">
                    <span class="teacher-profile-photo-placeholder" style="display:none">{{ mb_substr($teacher->full_name, 0, 1) }}</span>
                @else
                    <span class="teacher-profile-photo-placeholder">{{ mb_substr($teacher->full_name, 0, 1) }}</span>
                @endif
            </div>
        </header>

        <div class="teacher-profile-body">
            <section class="teacher-profile-section">
                <h2 class="teacher-profile-section-heading">نبذة عن المدرس</h2>
                <p>{{ $teacher->bio ?: 'مدرس متخصص لمتابعة الطلاب وتبسيط المادة التعليمية.' }}</p>
                @if($teacher->qualifications)
                    <div class="teacher-profile-qualification">
                        <h3>المؤهلات والخبرة</h3>
                        <p>{{ $teacher->qualifications }}</p>
                    </div>
                @endif
            </section>

            <section class="teacher-profile-section">
                <h2 class="teacher-profile-section-heading">المواد التي يدرسها</h2>
                <div class="teacher-subject-list">
                    @forelse($subjects as $subject)
                        <div class="teacher-subject-row">
                            <span class="teacher-subject-icon" aria-hidden="true">📚</span>
                            <div><strong>{{ $subject->name }}</strong><small>{{ $subject->grade }}</small></div>
                        </div>
                    @empty
                        <p class="teacher-subject-empty">لا توجد مواد مرتبطة حاليًا.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
@endsection