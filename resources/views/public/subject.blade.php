@extends('layouts.public', ['title' => $subject->name])
@section('content')
<style>
    .subject-hero {
        background: linear-gradient(135deg, #4b2c75 0%, #21133d 100%);
        color: white;
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }
    .subject-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 200, 87, 0.1);
        border-radius: 50%;
    }
    .subject-hero-content {
        position: relative;
        z-index: 1;
        max-width: 600px;
    }
    .subject-grade-badge {
        display: inline-block;
        background: rgba(255, 200, 87, 0.2);
        color: var(--sun);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-bottom: 15px;
        font-weight: 600;
        border: 1px solid rgba(255, 200, 87, 0.3);
    }
    .subject-title {
        font-size: 3rem;
        font-weight: 800;
        margin: 0 0 20px 0;
        line-height: 1.2;
    }
    .subject-subtitle {
        font-size: 1.1rem;
        opacity: 0.95;
        margin: 0;
    }
    .subject-content {
        padding: 60px 0;
        background: var(--paper);
    }
    .subject-main-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 50px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .subject-details-left h2 {
        font-size: 2rem;
        color: var(--ink);
        margin-bottom: 20px;
        font-weight: 800;
    }
    .info-card {
        background: var(--soft);
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 20px;
        border-left: 4px solid var(--coral);
        border: 1px solid var(--line);
        border-left: 4px solid var(--coral);
    }
    .info-card h3 {
        font-size: 0.85rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 10px 0;
    }
    .info-card-content {
        font-size: 1.1rem;
        color: var(--ink);
        margin: 0;
        line-height: 1.6;
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin: 30px 0;
    }
    .info-grid .info-card {
        margin-bottom: 0;
    }
    .sidebar {
        position: sticky;
        top: 100px;
    }
    .cta-box {
        background: white;
        border-radius: 16px;
        padding: 40px 30px;
        box-shadow: 0 10px 40px rgba(36, 20, 50, 0.15);
        text-align: center;
        margin-bottom: 20px;
        border: 1px solid var(--line);
    }
    .cta-box h2 {
        font-size: 1.6rem;
        color: var(--ink);
        margin: 0 0 15px 0;
        font-weight: 800;
    }
    .cta-box p {
        color: var(--muted);
        font-size: 0.95rem;
        margin: 0 0 25px 0;
        line-height: 1.6;
    }
    .subject-price {
        margin: 4px 0 12px;
        color: var(--plum);
        font-size: 1.8rem;
        font-weight: 800;
    }
    .subject-price small {
        color: var(--muted);
        font-size: .75rem;
        font-weight: 500;
    }
    .btn-primary {
        display: block;
        width: 100%;
        background: var(--coral);
        color: white;
        padding: 16px 30px;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        margin-bottom: 12px;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(244, 103, 74, 0.4);
        opacity: 0.9;
    }
    
    .btn-secondary {
        display: block;
        width: 100%;
        background: transparent;
        color: var(--coral);
        padding: 16px 30px;
        border: 2px solid var(--coral);
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: var(--coral);
        color: white;
    }
        color: white;
    }
    .note-box {
        background: var(--soft);
        border-left: 4px solid var(--sun);
        padding: 20px;
        border-radius: 8px;
        color: var(--ink);
        font-size: 0.9rem;
        margin-top: 20px;
        border: 1px solid var(--line);
        border-left: 4px solid var(--sun);
    }
    .note-box strong {
        display: block;
        margin-bottom: 5px;
        color: var(--coral);
    }
    .breadcrumb {
        padding: 20px 0;
        max-width: 1200px;
        margin: 0 auto;
    }
    .breadcrumb a {
        color: var(--coral);
        text-decoration: none;
        font-weight: 600;
    }
    .breadcrumb a:hover {
        text-decoration: underline;
    }
    .breadcrumb span {
        color: var(--muted);
        margin: 0 10px;
    }
    @media (max-width: 768px) {
        .subject-main-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .subject-title {
            font-size: 2rem;
        }
        .sidebar {
            position: static;
        }
    }

    /* Match the course page to the shared public-page layout. */
    .subject-hero{min-height:280px;padding:54px 20px 92px;background:linear-gradient(115deg,#291541 0%,#432568 58%,#56377d 100%);text-align:center}
    .subject-hero::before{top:-180px;right:auto;left:-100px;width:300px;height:300px;background:#ffc857;opacity:.08}
    .subject-hero-content{max-width:760px;margin:auto}
    .subject-grade-badge{background:#ffffff18;border:1px solid #ffffff14;color:#ffc857;padding:7px 16px}
    .subject-title{font-size:clamp(32px,4.5vw,48px);line-height:1.35;margin:17px auto 9px}
    .subject-subtitle{color:#e8dff0;font-size:14px}
    .subject-content{padding:0 0 86px;background:#fbf9fd}
    .subject-content>.container{width:min(1120px,calc(100% - 64px));margin:-30px auto 0;padding:28px;position:relative;z-index:2;border:1px solid #eadfeb;border-radius:22px;background:#fff;box-shadow:0 18px 45px rgba(41,21,65,.1)}
    .breadcrumb{width:min(1120px,calc(100% - 64px));padding:20px 0 10px}
    .subject-main-grid{grid-template-columns:1.35fr .75fr;gap:22px;max-width:none}
    .subject-details-left h2{font-size:24px;color:var(--plum)}
    .info-card{padding:18px;border-radius:16px;background:#fff;border:1px solid var(--line);border-right:4px solid var(--coral)}
    .info-grid{gap:12px;margin:20px 0}
    .info-grid .info-card{background:#fffdfa}
    .info-card h3{font-size:11px;color:var(--muted)}
    .info-card-content{font-size:13px}
    .cta-box{padding:24px 20px;border-radius:18px;box-shadow:none;border:1px solid var(--line)}
    .cta-box h2{font-size:22px;color:var(--plum)}
    .btn-primary,.btn-secondary{padding:12px 18px;border-radius:10px;font-size:12px}
    .note-box{border-right:4px solid var(--sun);border-left:1px solid var(--line);background:#fff7df}
    @media(max-width:768px){
        .subject-hero{min-height:260px;padding:42px 18px 82px}
        .subject-title{font-size:31px}
        .subject-subtitle{font-size:12px}
        .subject-content>.container,.breadcrumb{width:min(100% - 20px,600px)}
        .subject-content>.container{padding:19px 16px 24px;border-radius:20px}
        .breadcrumb{padding:16px 0 9px}
    }
</style>

<main>
    <div class="breadcrumb container">
        <a href="{{ route('catalog') }}">المواد الدراسية</a>
        <span>→</span>
        <span>{{ $subject->name }}</span>
    </div>

    <section class="subject-hero">
        <div class="container">
            <div class="subject-hero-content">
                <span class="subject-grade-badge">📚 {{ $subject->grade?->name ?? 'عام' }}</span>
                <h1 class="subject-title">{{ $subject->name }}</h1>
                <p class="subject-subtitle">اخطو خطوات ثابتة نحو التفوق والتميز</p>
            </div>
        </div>
    </section>

    <section class="subject-content">
        <div class="container">
            <div class="subject-main-grid">
                <div class="subject-details-left">
                    <h2>عن المادة</h2>
                    <div class="info-card">
                        <p class="info-card-content">
                            {{ $subject->description ?: 'شرح منظم ومتابعة مستمرة ضمن خطة واضحة مع متخصصين في المجال.' }}
                        </p>
                    </div>

                    <h2 style="margin-top: 40px;">معلومات المادة</h2>
                    <div class="info-grid">
                        <div class="info-card">
                            <h3>📋 المرحلة الدراسية</h3>
                            <p class="info-card-content">{{ $subject->grade?->name ?? 'عامة' }}</p>
                        </div>
                        <div class="info-card">
                            <h3>🎓 الفرع</h3>
                            <p class="info-card-content">{{ ['general'=>'مواد مشتركة','scientific'=>'العلمي','literary'=>'الأدبي','sharia'=>'الشرعي','entrepreneurship'=>'الريادة والأعمال','vocational'=>'المهني والصناعي'][$subject->tawjihi_branch] ?? 'مواد مشتركة' }}</p>
                        </div>
                        <div class="info-card">
                            <h3>📅 مدة الاشتراك</h3>
                            <p class="info-card-content">{{ ['full_year'=>'المنهج كاملًا','first'=>'الفصل الأول','second'=>'الفصل الثاني'][$subject->enrollment_term] ?? 'المنهج كاملًا' }}</p>
                        </div>
                        <div class="info-card">
                            <h3>🕒 الحصص الأسبوعية</h3>
                            <p class="info-card-content">{{ $subject->sessions_per_week ?? 2 }} حصص</p>
                        </div>
                        @if($subject->total_hours)
                            <div class="info-card">
                                <h3>⌛ إجمالي الساعات</h3>
                                <p class="info-card-content">{{ $subject->total_hours }} ساعة</p>
                            </div>
                        @endif
                        @if($subject->start_date || $subject->end_date)
                            <div class="info-card">
                                <h3>🗓️ مدة البرنامج</h3>
                                <p class="info-card-content">{{ $subject->start_date ?: 'غير محدد' }} - {{ $subject->end_date ?: 'غير محدد' }}</p>
                            </div>
                        @endif
                    </div>

                    @if($subject->unit_plan)
                        <div class="info-card">
                            <h3>📚 خطة الوحدات</h3>
                            <p class="info-card-content" style="white-space:pre-line">{{ $subject->unit_plan }}</p>
                        </div>
                    @endif
                    @if($subject->make_up_policy)
                        <div class="info-card">
                            <h3>🔄 سياسة تعويض الحصص</h3>
                            <p class="info-card-content" style="white-space:pre-line">{{ $subject->make_up_policy }}</p>
                        </div>
                    @endif

                    <div class="info-card" style="border-left-color: #25D366;">
                        <h3>✓ المميزات</h3>
                        <ul style="color: #333; padding-right: 20px; margin: 10px 0;">
                            <li style="margin-bottom: 8px;">شرح مفصل من قبل معلمين متخصصين</li>
                            <li style="margin-bottom: 8px;">متابعة مستمرة وتقويم شامل</li>
                            <li style="margin-bottom: 8px;">حل تمارين وواجبات منزلية</li>
                            <li style="margin-bottom: 8px;">جلسات مراجعة منتظمة</li>
                            <li>دعم تقني وتعليمي طوال الأسبوع</li>
                        </ul>
                    </div>
                </div>

                <div class="sidebar">
                    <div class="cta-box">
                        <h2>ابدأ الآن</h2>
                        <p>تواصل معنا الآن لمعرفة التفاصيل والخطة المناسبة لك</p>

                        @if($subject->delivery_type === 'recorded' && $subject->recorded_lectures_url)
                            <a href="{{ $subject->recorded_lectures_url }}" target="_blank" rel="noopener" class="btn-primary">▶ مشاهدة المحاضرات المسجلة</a>
                        @elseif($subject->free_preview_url)
                            <a href="{{ $subject->free_preview_url }}" target="_blank" rel="noopener" class="btn-secondary">▶ مشاهدة النموذج المجاني</a>
                        @endif

                        <a href="{{ route('pricing') }}" class="btn-primary">
                            ✓ تسجيل في المادة
                        </a>

                        <a href="{{ route('catalog') }}" class="btn-secondary" style="margin-top: 15px;">
                            ← العودة للمواد
                        </a>
                    </div>

                        <div class="note-box">
                            <strong>💡 معلومة مهمة</strong>
                            لمعرفة الرسوم والباقات المتاحة، انتقل إلى صفحة الأسعار واختر النظام والمنطقة المناسبة لك.
                        </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
