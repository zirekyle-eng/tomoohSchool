@extends('layouts.public', ['title' => 'المواد الدراسية'])
@section('content')

<style>
    .catalog-hero {
        background: var(--plum);
        color: #fff;
        padding: 62px 0 98px;
        position: relative;
        overflow: hidden;
        clip-path: polygon(0 0, 100% 0, 100% 91%, 0 100%);
    }
    
    .catalog-hero .container {
        position: relative;
        z-index: 1;
    }
    
    .catalog-hero p {
        max-width: 590px;
        color: #D9CBE8;
        line-height: 2;
    }
    
    .catalog-hero h1 {
        color: #fff;
        font-size: 44px;
        margin: 14px 0;
    }
    
    .catalog-hero em {
        color: var(--sun);
        font-style: normal;
    }
    
    .catalog-hero .orb {
        position: absolute;
        left: 8%;
        top: -65px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: var(--sun);
        opacity: 0.14;
    }
    
    .catalog-main {
        padding: 0 0 78px;
        margin-top: -26px;
        position: relative;
    }
    
    .tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin: 0 0 16px;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 24px;
        box-shadow: 0 24px 50px -34px rgba(46, 26, 71, 0.31);
    }

    .market-picker {
        max-width: 640px;
        margin: 0 auto 28px;
        padding: 28px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 24px;
        box-shadow: 0 24px 50px -34px rgba(46, 26, 71, 0.31);
    }

    .market-picker h2 {
        margin: 0 0 8px;
        color: var(--ink);
        font-size: 24px;
    }

    .market-picker p {
        margin: 0 0 22px;
        color: var(--muted);
        line-height: 1.9;
    }

    .market-options {
        display: grid;
        gap: 10px;
    }

    .market-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        border: 1px solid var(--line);
        border-radius: 14px;
        color: var(--ink);
        font-weight: 700;
        cursor: pointer;
    }

    .market-option:has(input:checked) {
        border-color: var(--coral);
        background: #fff7f4;
    }

    .market-option input {
        accent-color: var(--coral);
    }

    .market-picker .button {
        width: 100%;
        margin-top: 18px;
        opacity: .5;
    }

    .market-picker:has(input:checked) .button {
        opacity: 1;
    }
    
    .tabs a {
        padding: 9px 15px;
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 999px;
        color: var(--ink);
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .tabs a:hover {
        border-color: var(--coral);
        color: var(--coral);
    }
    
    .tabs a.active {
        background: var(--coral);
        color: #fff;
        border-color: var(--coral);
    }
    
    .catalog-note {
        color: var(--muted);
        font-size: 13px;
        margin: 25px 0;
    }
    
    .grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 26px 26px 26px 6px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.15s ease;
        min-height: 100%;
    }

    .card:hover {
        transform: translateY(-5px) rotate(-0.5deg);
        box-shadow: 0 10px 30px rgba(46, 26, 71, 0.2);
    }

    .cover {
        height: 150px;
        min-height: 150px;
        background: linear-gradient(135deg, var(--coral), var(--plum-light));
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 44px;
        font-weight: 800;
        position: relative;
        flex-shrink: 0;
        overflow: hidden;
    }

    .cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        background: linear-gradient(135deg, var(--coral), var(--plum-light));
        font-size: 3.5rem;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .card-copy {
        padding: 20px;
        display: block;
        position: relative;
        z-index: 1;
        background: #fff;
    .card h2 {
        font-size: 19px;
        margin: 12px 0 7px;
        color: var(--ink);
    }
    
    .card p {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.85;
        min-height: 48px;
    }
    
    .tag {
        display: inline-block;
        background: var(--mint-light);
        color: var(--mint);
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-decoration: none;
    }
    
    .card .button {
        display: block;
        margin-top: 15px;
        text-align: center;
        color: white;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s ease;
        padding: 12px 16px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
    }
    
    .card .button:hover {
        opacity: 0.9;
        box-shadow: 0 5px 15px rgba(255, 107, 74, 0.3);
    }
    
    .card .button:after {
        content: '';
    }
    
    .empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 45px;
        background: #fff;
        border: 1px dashed var(--line);
        border-radius: 18px;
        color: var(--muted);
    }
    
    @media (max-width: 780px) {
        .catalog-hero h1 {
            font-size: 34px;
        }
        
        .catalog-hero .orb {
            display: none;
        }
        
        .grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="catalog-hero">
    <div class="container">
        <span class="orb"></span>
        <div class="eyebrow" style="color: #c7d2fe;">المنهج الفلسطيني</div>
        <h1>اختر المادة التي <em>تناسبك</em></h1>
        <p>تصفح الصفوف والمواد حسب المرحلة، ثم افتح تفاصيل المادة قبل التسجيل.</p>
    </div>
</section>

<main class="container catalog-main">
    <header class="catalog-intro">
        <div>
            <span class="eyebrow">الكتالوج الدراسي</span>
            <h1>اكتشف المواد المناسبة لصفك</h1>
            <p>اختر المرحلة والصف، ثم تعرّف على تفاصيل المادة ومواعيدها قبل التسجيل.</p>
        </div>
        <div class="catalog-intro-mark" aria-hidden="true">📚</div>
    </header>

    <form class="catalog-filter" method="get" action="{{ route('catalog') }}">
        <label>المنطقة (اختياري)
            <select name="market" onchange="this.form.submit()">
                <option value="">كل المناطق</option>
                @foreach($markets as $marketId => $marketName)
                    <option value="{{ $marketId }}" @selected($selectedMarketId === (int) $marketId)>{{ $marketName }}</option>
                @endforeach
            </select>
        </label>
        @if($selectedGradeId)<input type="hidden" name="grade" value="{{ $selectedGradeId }}">@endif
        <span>{{ $selectedMarketId ? 'عرض مواد ' . ($markets[$selectedMarketId] ?? '') : 'عرض كل المواد' }}</span>
    </form>

    <nav class="stage-tabs" aria-label="المراحل الدراسية">
        <a class="active" href="#stage-basic">المرحلة الأساسية</a>
        <a href="#stage-middle">المرحلة المتوسطة</a>
        <a href="#stage-secondary">المرحلة الثانوية</a>
    </nav>

    @if($gradeGroups->isEmpty())
        <div class="catalog-empty">لا توجد مواد منشورة حاليًا.</div>
    @else
            @php
                $stages = [
                    'basic' => ['title' => 'المرحلة الأساسية', 'description' => 'الصفوف من الأول حتى السادس', 'icon' => '📗', 'grades' => $gradeGroups->filter(fn ($items) => (int) ($items->first()->grade?->sort_order ?? 0) <= 6)],
                    'middle' => ['title' => 'المرحلة المتوسطة', 'description' => 'الصفوف السابع والثامن والتاسع', 'icon' => '📘', 'grades' => $gradeGroups->filter(fn ($items) => (int) ($items->first()->grade?->sort_order ?? 0) >= 7 && (int) ($items->first()->grade?->sort_order ?? 0) <= 9)],
                    'secondary' => ['title' => 'المرحلة الثانوية', 'description' => 'الصفوف العاشر والحادي عشر والتوجيهي', 'icon' => '🎓', 'grades' => $gradeGroups->filter(fn ($items) => (int) ($items->first()->grade?->sort_order ?? 0) >= 10)],
                ];
            @endphp
            <div class="catalog-structure">
                @foreach($stages as $stageKey => $stage)
                    @if($stage['grades']->isNotEmpty())
                        <section class="catalog-stage" id="stage-{{ $stageKey }}">
                            <header class="catalog-stage-head">
                                <div class="catalog-stage-icon">{{ $stage['icon'] }}</div>
                                <div>
                                    <h2>{{ $stage['title'] }}</h2>
                                    <p>{{ $stage['description'] }}</p>
                                </div>
                            </header>
                            <div class="catalog-grades">
                                @foreach($stage['grades'] as $gradeSubjects)
                                    @php $grade = $gradeSubjects->first()->grade; @endphp
                                    <section class="catalog-grade">
                                        <h3>{{ $grade?->name ?: 'مواد عامة' }} <span>{{ $gradeSubjects->count() }} مواد</span></h3>
                                        <div class="grid">
                                            @foreach($gradeSubjects as $subject)
                                                <article class="card">
                                                    <div class="cover">
                                                        @if($subject->image_path)
                                                            <img src="{{ asset(str_replace('public/', '', $subject->image_path)) }}" alt="{{ $subject->name }}">
                                                        @else
                                                            <div class="cover-placeholder">📚</div>
                                                        @endif
                                                    </div>
                                                    <div class="card-copy">
                                                        <h2>{{ $subject->name }}</h2>
                                                        <p>{{ $subject->description ?: 'تفاصيل المساق وخطته متاحة في صفحة المادة.' }}</p>
                                                        <div class="catalog-meta">
                                                            <span>{{ $subject->delivery_type === 'recorded' ? 'مسجلة' : 'مباشرة حسب الجدول' }}</span>
                                                            <span>{{ $subject->sessions_per_week ?? 0 }} حصص أسبوعيًا</span>
                                                        </div>
                                                        <a class="button" href="{{ route('subjects.show', $subject->id) }}">عرض تفاصيل المادة</a>
                                                    </div>
                                                </article>
                                            @endforeach
                                        </div>
                                    </section>
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach
            </div>
    @endif
</main>

<style>
    .catalog-price{display:flex;align-items:baseline;gap:6px;margin:14px 0 7px;color:#2e1a47}
    .catalog-price strong{font-size:21px}
    .catalog-price span,.catalog-meta{color:#756882;font-size:11px}
    .catalog-meta{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px}
    .catalog-meta span{padding:4px 8px;border-radius:99px;background:#f7effa}
    .catalog-structure{display:grid;gap:32px}
    .catalog-stage{padding:24px;border:1px solid #eadfeb;border-radius:24px;background:#fff;box-shadow:0 12px 30px #32154d0a}
    .catalog-stage-head{display:flex;align-items:center;gap:14px;padding-bottom:18px;border-bottom:1px solid #f0e6f2;margin-bottom:22px}
    .catalog-stage-icon{width:52px;height:52px;display:grid;place-items:center;border-radius:16px;background:#f2eaff;font-size:26px}
    .catalog-stage h2{margin:0;color:#2e1a47;font:800 25px 'Baloo Bhaijaan 2',sans-serif}
    .catalog-stage p{margin:3px 0 0;color:#756882;font-size:12px}
    .catalog-grades{display:grid;gap:24px}
    .catalog-grade h3{display:flex;align-items:center;gap:9px;margin:0 0 12px;color:#2e1a47;font-size:18px}
    .catalog-grade h3 span{padding:4px 9px;border-radius:99px;background:#fff0e9;color:#d95337;font-size:10px}
    .catalog-grade .grid{margin:0}
    .catalog-empty{padding:30px;text-align:center;color:#756882;border:1px dashed #d9c9df;border-radius:16px}
    .catalog-filter{display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:16px;padding:14px 16px;border:1px solid #eadfeb;border-radius:15px;background:#fff;color:#756882;font-size:12px}
    .catalog-filter label{display:flex;align-items:center;gap:10px;color:#2e1a47;font-weight:800}
    .catalog-filter select{border:1px solid #eadfeb;border-radius:999px;padding:8px 12px;background:#fff;color:#756882;font:12px Tajawal}
    .stage-tabs{display:flex;justify-content:flex-start;gap:9px;flex-wrap:wrap;margin:0 0 22px}
    .stage-tabs a{padding:10px 16px;border:1px solid #dce8e3;border-radius:999px;background:#fff;color:#58717a;font-size:12px;font-weight:800}
    .stage-tabs a:hover,.stage-tabs a.active{background:#ce3942;color:#fff;border-color:#ce3942}
    .catalog-selected{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:20px;padding:14px 16px;border-radius:15px;background:#fff7df;color:#755c18;font-size:12px}
    .catalog-selected a{color:#a24f22;font-weight:800}
    @media(max-width:600px){.catalog-filter{display:block}.catalog-filter label{justify-content:space-between;margin-bottom:8px}.stage-tabs a{flex:1;text-align:center}}

    /* Compact catalogue layout: stages contain calm grade panels and lightweight subject cards. */
    .catalog-hero{display:block;position:relative;overflow:hidden;min-height:280px;padding:54px 20px 92px;background:linear-gradient(115deg,#291541 0%,#432568 58%,#56377d 100%);color:#fff;text-align:center;clip-path:none}
    .catalog-hero:before,.catalog-hero:after{content:'';position:absolute;border-radius:50%;background:#ffc857;opacity:.08;pointer-events:none}
    .catalog-hero:before{width:300px;height:300px;left:-100px;top:-180px}
    .catalog-hero:after{width:240px;height:240px;right:-80px;bottom:-160px}
    .catalog-hero .container{position:relative;z-index:1}
    .catalog-hero .eyebrow{background:#ffffff18;border:1px solid #ffffff14;color:#ffc857;padding:7px 16px}
    .catalog-hero h1{margin:17px auto 9px;font-size:clamp(32px,4.5vw,48px);line-height:1.35;color:#fff}
    .catalog-hero p{max-width:690px;margin:0 auto;color:#e8dff0;font-size:14px;line-height:2}
    .catalog-main{width:min(1140px,calc(100% - 64px));max-width:none;margin:-30px auto 0;padding:26px 28px 34px;position:relative;z-index:2;border:1px solid #eadfeb;border-radius:22px;background:#fff;box-shadow:0 18px 45px rgba(41,21,65,.1)}
    .catalog-filter{margin-bottom:16px;background:transparent;border:0;padding:0;justify-content:flex-start}
    .catalog-filter label{font-size:12px}
    .catalog-filter select{min-width:150px}
    .catalog-filter>span{color:#87949a;font-size:11px}
    .stage-tabs{justify-content:flex-start;gap:10px;margin-bottom:24px}
    .stage-tabs a{padding:10px 18px;background:#fff;border-color:#d8e4df;color:#54717a}
    .stage-tabs a.active{background:#c93643;border-color:#c93643}
    .catalog-structure{gap:20px}
    .catalog-stage{padding:22px 25px;border:1px solid #cfe2da;border-radius:20px;background:#edf8f3;box-shadow:none}
    .catalog-stage-head{padding:0 0 17px;margin-bottom:18px;border-bottom:0;flex-direction:row-reverse;justify-content:flex-start}
    .catalog-stage-icon{width:42px;height:42px;background:#fff;border-radius:50%;font-size:20px}
    .catalog-stage h2{font-size:25px;font-weight:700}
    .catalog-stage h2:before{content:counter(stage);counter-increment:stage;color:#d13c48;font:700 13px Tajawal;margin-left:10px}
    .catalog-structure{counter-reset:stage}
    .catalog-stage p{font-size:11px}
    .catalog-grades{gap:14px}
    .catalog-grade{padding:16px 0 0}
    .catalog-grade h3{margin:0 0 10px;font-size:18px;font-weight:700}
    .catalog-grade h3 span{background:transparent;color:#d13c48;padding:0;font-weight:700}
    .catalog-grade .grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
    .catalog-grade .card{min-height:0;border:1px solid #d8e4df;border-radius:12px;background:#fff;box-shadow:none;display:block}
    .catalog-grade .card:hover{transform:translateY(-2px);box-shadow:0 8px 18px #31564c14}
    .catalog-grade .cover{display:none}
    .catalog-grade .card-copy{padding:15px}
    .catalog-grade .card h2{margin:0 0 6px;font-size:16px;font-weight:700}
    .catalog-grade .card p{display:none}
    .catalog-grade .catalog-price{margin:8px 0 4px}
    .catalog-grade .catalog-price strong{font-size:16px}
    .catalog-grade .catalog-price span{font-size:9px}
    .catalog-grade .catalog-meta{margin:0 0 9px;gap:4px}
    .catalog-grade .catalog-meta span{padding:3px 6px;font-size:9px}
    .catalog-grade .card .button{margin-top:8px;padding:7px 8px;border-radius:7px;font-size:10px;background:#fff;color:#d13c48;border:1px solid #f0c5c9}
    .catalog-grade .card .button:hover{background:#d13c48;color:#fff;box-shadow:none}
    @media(max-width:780px){.catalog-main{padding:22px 14px 60px}.catalog-grade .grid{grid-template-columns:repeat(2,minmax(0,1fr))}.catalog-stage{padding:18px}.catalog-stage h2{font-size:21px}}
    @media(max-width:480px){.catalog-filter{display:grid;gap:8px}.catalog-grade .grid{grid-template-columns:1fr}.stage-tabs{overflow:auto;flex-wrap:nowrap}.stage-tabs a{white-space:nowrap}}

    /* Keep the catalogue visually aligned with the public site navigation and cards. */
    .catalog-main{width:min(1140px,calc(100% - 64px));max-width:none;margin:-30px auto 0;padding:26px 28px 34px;position:relative;z-index:2;border:1px solid #eadfeb;border-radius:22px;background:#fff;box-shadow:0 18px 45px rgba(41,21,65,.1)}
    .catalog-intro{display:none}
    .catalog-intro .eyebrow{background:#ffeadf;color:#c7462d}
    .catalog-intro h1{margin:9px 0 4px;color:var(--plum);font-size:28px;line-height:1.45}
    .catalog-intro p{margin:0;color:var(--muted);font-size:13px}
    .catalog-intro-mark{width:66px;height:66px;display:grid;place-items:center;flex:0 0 auto;border-radius:20px 20px 6px 20px;background:var(--plum);font-size:30px;box-shadow:8px 8px 0 #ffc857}
    .catalog-filter{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;padding:12px 14px;border:0;border-radius:13px;background:#faf5fc}
    .catalog-filter label{gap:12px;color:var(--ink);font-size:12px}
    .catalog-filter select{min-width:160px;border-color:var(--line);color:var(--ink);background:var(--paper);font-family:Cairo}
    .catalog-filter>span{color:var(--muted);font-size:11px}
    .stage-tabs{gap:8px;margin-bottom:22px}
    .stage-tabs a{padding:9px 17px;border-color:var(--line);color:var(--muted);font-size:12px}
    .stage-tabs a:hover,.stage-tabs a.active{background:var(--coral);border-color:var(--coral);color:#fff}
    .catalog-structure{gap:18px}
    .catalog-stage{padding:22px;border:1px solid var(--line);border-radius:20px;background:#fff;box-shadow:0 10px 25px rgba(41,21,65,.05)}
    .catalog-stage-head{direction:ltr;align-items:center;justify-content:flex-start;gap:13px;padding-bottom:16px;margin-bottom:18px;border-bottom:1px solid #f1e9ef}
    .catalog-stage-icon{width:44px;height:44px;border-radius:14px 14px 5px 14px;background:#ffeadf;font-size:21px}
    .catalog-stage h2{font-size:22px;color:var(--plum)}
    .catalog-stage h2:before{color:var(--coral)}
    .catalog-stage p{color:var(--muted)}
    .catalog-stage-head > div:last-child{direction:rtl;flex:0 1 auto;text-align:right}
    .catalog-grades{gap:18px}
    .catalog-grade{padding-top:2px}
    .catalog-grade h3{margin-bottom:11px;color:var(--plum);font-size:17px}
    .catalog-grade h3 span{color:var(--coral)}
    .catalog-grade .grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
    .catalog-grade .card{border:1px solid var(--line);border-radius:16px;background:#fff;transition:transform .2s ease,box-shadow .2s ease}
    .catalog-grade .card:hover{transform:translateY(-3px);box-shadow:0 12px 25px rgba(41,21,65,.1)}
    .catalog-grade .card-copy{padding:16px}
    .catalog-grade .card h2{color:var(--ink);font-size:16px}
    .catalog-grade .catalog-price{color:var(--plum)}
    .catalog-grade .catalog-price strong{font-size:18px}
    .catalog-grade .catalog-price span{color:var(--muted)}
    .catalog-grade .catalog-meta span{background:#f8f0fb;color:var(--muted)}
    .catalog-grade .card .button{color:var(--coral);border-color:#f3c9c0;background:#fff}
    .catalog-grade .card .button:hover{background:var(--coral);border-color:var(--coral)}
    .catalog-empty{background:#fff;border-color:var(--line)}
    @media(max-width:760px){
        .catalog-hero{min-height:260px;padding:42px 18px 82px}
        .catalog-hero h1{font-size:31px}
        .catalog-hero p{font-size:12px}
        .catalog-main{width:min(100% - 20px,600px);padding:18px 15px 22px;border-radius:20px}
        .catalog-intro{padding:22px;align-items:flex-start}
        .catalog-intro h1{font-size:23px}
        .catalog-intro-mark{width:52px;height:52px;font-size:23px;box-shadow:5px 5px 0 #ffc857}
        .catalog-filter{display:grid;gap:9px}
        .catalog-filter label{justify-content:space-between}
        .catalog-filter>span{display:block}
        .catalog-stage{padding:18px}
    }
    @media(max-width:480px){
        .catalog-intro-mark{display:none}
        .catalog-intro h1{font-size:21px}
    }

    /* Final catalogue pass: open layout, softer stages, and more useful subject cards. */
    body{background:#fffaf6}
    .catalog-hero{min-height:310px;padding:66px 20px 112px;background:linear-gradient(118deg,#21133d 0%,#4c2b78 62%,#6b438d 100%);text-align:right}
    .catalog-hero:before{width:360px;height:360px;left:-130px;top:-210px;opacity:.1}
    .catalog-hero:after{width:260px;height:260px;right:8%;bottom:-190px;opacity:.08}
    .catalog-hero .container{text-align:right}
    .catalog-hero h1{max-width:680px;margin:18px 0 8px;font-size:clamp(34px,5vw,54px)}
    .catalog-hero p{max-width:590px;margin:0;font-size:13px}
    .catalog-main{width:min(1140px,calc(100% - 36px));margin:-42px auto 0;padding:0 0 80px;background:transparent;border:0;box-shadow:none}
    .catalog-intro{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:20px;padding:24px 28px;background:#fff;border:1px solid var(--line);border-radius:20px;box-shadow:0 14px 35px #2915400d}
    .catalog-intro h1{margin:7px 0 3px;font-size:25px;color:var(--plum)}
    .catalog-intro p{margin:0;color:var(--muted);font-size:12px}
    .catalog-intro-mark{background:var(--coral);box-shadow:7px 7px 0 var(--sun)}
    .catalog-filter{margin:0 0 12px;padding:13px 17px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:none}
    .stage-tabs{margin:0 0 22px;padding:4px;gap:5px;width:max-content;max-width:100%;background:#f3eaf7;border-radius:999px}
    .stage-tabs a{border:0;padding:9px 16px;background:transparent;color:var(--muted);font-size:11px}
    .stage-tabs a:hover,.stage-tabs a.active{background:var(--plum);border-color:var(--plum);color:#fff}
    .catalog-structure{gap:24px}
    .catalog-stage{padding:24px;background:#fff;border:1px solid var(--line);border-radius:22px;box-shadow:0 12px 30px #2915400a}
    .catalog-stage:nth-child(2){background:#f5fbf7;border-color:#d7ecdf}
    .catalog-stage:nth-child(3){background:#fffaf0;border-color:#f0dfb7}
    .catalog-stage-head{padding-bottom:17px;margin-bottom:20px;border-bottom:1px solid #f0e7f1}
    .catalog-stage-icon{background:#ffebe5}
    .catalog-stage:nth-child(2) .catalog-stage-icon{background:#dff3e7}
    .catalog-stage:nth-child(3) .catalog-stage-icon{background:#fff0c6}
    .catalog-stage h2{font-size:23px}
    .catalog-grade{padding:0}
    .catalog-grade h3{margin:0 0 11px;padding-right:4px;font-size:16px}
    .catalog-grade .grid{gap:14px}
    .catalog-grade .card{overflow:hidden;border:1px solid #eadfeb;border-radius:16px;background:#fff;box-shadow:0 5px 15px #29154008}
    .catalog-grade .card:hover{transform:translateY(-4px);box-shadow:0 14px 26px #29154018}
    .catalog-grade .cover{display:grid;height:88px;background:linear-gradient(135deg,#f4674a,#59369b);font-size:30px}
    .catalog-grade .card:nth-child(2n) .cover{background:linear-gradient(135deg,#1d9b69,#14624d)}
    .catalog-grade .card:nth-child(3n) .cover{background:linear-gradient(135deg,#ffc857,#c27e17)}
    .catalog-grade .card-copy{padding:14px 15px 15px}
    .catalog-grade .card h2{font-size:16px;margin:0 0 5px}
    .catalog-grade .catalog-price{margin:9px 0 5px}
    .catalog-grade .catalog-price strong{font-size:17px}
    .catalog-grade .card .button{padding:8px 9px;font-size:10px}
    @media(max-width:760px){
        .catalog-hero{min-height:280px;padding:48px 18px 100px}
        .catalog-hero .container{text-align:center}
        .catalog-hero h1{margin:16px auto 8px}
        .catalog-main{width:min(100% - 24px,600px);margin-top:-35px}
        .catalog-intro{display:block;padding:20px}
        .catalog-intro-mark{display:none}
        .stage-tabs{width:100%;overflow:auto;justify-content:flex-start}
        .stage-tabs a{white-space:nowrap}
        .catalog-stage{padding:18px}
    }

    /* Restrained catalogue palette: plum structure, coral actions, quiet surfaces. */
    .catalog-hero{background:var(--plum)}
    .catalog-main{background:transparent}
    .catalog-intro,.catalog-filter,.catalog-stage,.catalog-grade .card{background:#fff}
    .catalog-stage:nth-child(2),.catalog-stage:nth-child(3){background:#fff;border-color:var(--line)}
    .catalog-stage-icon,.catalog-stage:nth-child(2) .catalog-stage-icon,.catalog-stage:nth-child(3) .catalog-stage-icon{background:#f5eef9}
    .catalog-stage h2,.catalog-grade h3,.catalog-grade .card h2{color:var(--plum)}
    .catalog-grade .cover,.catalog-grade .card:nth-child(2n) .cover,.catalog-grade .card:nth-child(3n) .cover{background:var(--plum)}
    .catalog-grade .cover-placeholder{background:var(--plum);color:#fff}
    .catalog-grade .catalog-meta span{background:#f5eef9;color:var(--muted)}
    .catalog-grade .card .button{color:var(--coral);border-color:#f3c9c0;background:#fff}
    .catalog-grade .card .button:hover{background:var(--coral);color:#fff}
    .catalog-stage:nth-child(2) .catalog-stage-icon,.catalog-stage:nth-child(3) .catalog-stage-icon{color:var(--plum)}
</style>
@endsection
