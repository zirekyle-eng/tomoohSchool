@extends('layouts.public', ['title' => 'الأسعار والتسجيل'])

@section('content')
<style>
    .pricing-page{background:#fbf8fc;padding-bottom:70px}
    .pricing-hero{background:linear-gradient(135deg,#2e1a47,#56377d);color:#fff;padding:54px 20px 72px;text-align:center}
    .pricing-hero .eyebrow{display:inline-block;padding:7px 14px;border-radius:999px;background:#ffffff1c;color:#ffd36b;font-size:12px;font-weight:800}
    .pricing-hero h1{margin:16px auto 8px;font:800 clamp(30px,5vw,48px) 'Baloo Bhaijaan 2',sans-serif}
    .pricing-hero p{max-width:650px;margin:0 auto;color:#e5dced;line-height:1.9;font-size:14px}
    .pricing-wrap{width:min(1120px,calc(100% - 32px));margin:-30px auto 0;position:relative}
    .pricing-section{background:#fff;border:1px solid #eadfeb;border-radius:24px;padding:26px;margin-bottom:22px;box-shadow:0 12px 35px #32154d0d}
    .pricing-switch{display:flex;gap:8px;padding:6px;background:#f7f0fa;border-radius:14px;margin-bottom:20px}
    .pricing-switch button{flex:1;border:0;border-radius:10px;padding:12px;background:transparent;color:#756882;font:800 13px Tajawal;cursor:pointer}
    .pricing-switch button.active{background:#2e1a47;color:#fff;box-shadow:0 5px 12px #2e1a4726}
    .pricing-view{display:none}.pricing-view.active{display:block}
    .region-switch{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:18px}
    .region-switch a{padding:9px 15px;border:1px solid #eadfeb;border-radius:999px;color:#756882;font-size:12px;font-weight:800}
    .region-switch a.active{background:#ffc857;color:#2e1a47;border-color:#ffc857}
    .section-heading{display:flex;align-items:end;justify-content:space-between;gap:15px;margin-bottom:18px}
    .section-heading h2{margin:0;color:#2e1a47;font:800 25px 'Baloo Bhaijaan 2',sans-serif}
    .section-heading p{margin:4px 0 0;color:#756882;font-size:12px}
    .plans{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
    .plan{border:1px solid #eadfeb;border-radius:18px;padding:20px;position:relative;background:#fff}
    .plan.featured{border:2px solid #ff6b4a;background:linear-gradient(145deg,#fff8f4,#fff)}
    .plan-badge{position:absolute;top:14px;left:14px;padding:5px 9px;border-radius:999px;background:#ffe4dc;color:#c84b32;font-size:10px;font-weight:800}
    .plan-icon{width:44px;height:44px;display:grid;place-items:center;border-radius:14px;background:#f2eaff;font-size:22px}
    .plan h3{margin:15px 0 7px;color:#2e1a47;font-size:19px}
    .plan p{margin:0;color:#756882;font-size:12px;line-height:1.8}
    .plan ul{list-style:none;padding:0;margin:16px 0 0;display:grid;gap:9px}
    .plan li{color:#473454;font-size:12px}
    .plan li:before{content:'✓';color:#22a66b;font-weight:800;margin-left:7px}
    .subject-toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px;padding:12px 14px;border-radius:13px;background:#faf6fc;color:#756882;font-size:12px}
    .subject-toolbar strong{color:#2e1a47}
    .subject-groups{display:grid;gap:22px}
    .subject-group h3{display:flex;align-items:center;gap:8px;margin:0 0 10px;color:#2e1a47;font-size:16px}
    .subject-group h3 span{padding:4px 8px;border-radius:999px;background:#f2eaff;color:#7651ad;font-size:10px}
    .subject-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
    .subject-card{border:1px solid #eee3f1;border-radius:16px;padding:16px;background:#fff;transition:.2s}
    .subject-card:hover{border-color:#ffb09e;transform:translateY(-2px)}
    .subject-card h4{margin:0 0 7px;color:#2e1a47;font-size:16px}
    .subject-card p{min-height:38px;margin:0 0 12px;color:#756882;font-size:11px;line-height:1.7}
    .subject-info{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px}
    .subject-info span{padding:5px 8px;border-radius:999px;background:#f8f2fa;color:#756882;font-size:10px}
    .subject-price{display:flex;align-items:baseline;gap:5px;color:#2e1a47}
    .subject-price strong{font-size:22px}
    .subject-price small{color:#756882;font-size:10px}
    .subject-link{display:block;margin-top:12px;text-align:center;padding:10px;border-radius:10px;background:#ff6b4a;color:#fff;font-size:11px;font-weight:800}
    .empty-prices{text-align:center;padding:24px;color:#756882}
    .pricing-note{display:flex;gap:10px;align-items:flex-start;padding:15px;border-radius:14px;background:#fff7df;color:#755c18;font-size:12px;line-height:1.8}
    .package-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
    .package-card{border:2px solid #ffb09e;border-radius:18px;padding:20px;background:linear-gradient(145deg,#fff8f4,#fff)}
    .package-card h3{margin:0 0 7px;color:#2e1a47;font-size:19px}
    .package-card p{margin:0;color:#756882;font-size:12px;line-height:1.8}
    .package-price{margin:18px 0;color:#2e1a47;font-size:30px;font-weight:800}
    .package-price small{color:#756882;font-size:11px;font-weight:500}
    .package-subjects{display:flex;flex-wrap:wrap;gap:6px;margin:0 0 16px}
    .package-subjects span{padding:5px 8px;border-radius:999px;background:#f2eaff;color:#64468e;font-size:10px}
    .package-action{display:block;text-align:center;padding:11px;border-radius:10px;background:#ff6b4a;color:#fff;font-size:12px;font-weight:800}
    .package-empty{padding:10px 0;color:#a63e2a;font-size:11px}
    @media(max-width:800px){.subject-grid{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:600px){.package-grid{grid-template-columns:1fr}}
    @media(max-width:600px){.pricing-wrap{width:min(100% - 20px,1120px)}.pricing-section{padding:18px}.plans,.subject-grid{grid-template-columns:1fr}.section-heading{display:block}.subject-card p{min-height:0}}
    /* Pricing landing layout aligned with the site's purple/orange visual identity. */
    .pricing-page{background:#fbf9fd;min-height:calc(100vh - 72px);padding-bottom:86px}
    .pricing-hero{position:relative;overflow:hidden;min-height:280px;padding:54px 20px 92px;background:linear-gradient(115deg,#291541 0%,#432568 58%,#56377d 100%)}
    .pricing-hero:before,.pricing-hero:after{content:'';position:absolute;border-radius:50%;background:#ffc857;opacity:.08;pointer-events:none}
    .pricing-hero:before{width:300px;height:300px;left:-100px;top:-180px}
    .pricing-hero:after{width:240px;height:240px;right:-80px;bottom:-160px}
    .pricing-hero>*{position:relative;z-index:1}
    .pricing-hero .eyebrow{background:#ffffff18;border:1px solid #ffffff14;color:#ffc857;padding:7px 16px}
    .pricing-hero h1{margin:17px auto 9px;font-size:clamp(32px,4.5vw,48px);line-height:1.35;letter-spacing:-.3px}
    .pricing-hero p{max-width:690px;color:#e8dff0;font-size:14px;line-height:2}
    .pricing-wrap{width:min(1120px,calc(100% - 32px));margin:-30px auto 0;z-index:2}
    .pricing-section{padding:26px 28px 30px;border:1px solid #eadfeb;border-radius:24px;background:#fff;box-shadow:0 18px 45px rgba(41,21,65,.1)}
    .region-switch{justify-content:flex-start;margin-bottom:18px}
    .region-switch a{padding:9px 17px;background:#fff;color:var(--muted);border-color:var(--line)}
    .region-switch a.active{background:#ffc857;border-color:#ffc857;color:var(--plum)}
    .pricing-switch{margin-bottom:24px;background:#faf5fc;border:1px solid #f0e6f2}
    .pricing-switch button{padding:13px;color:var(--muted)}
    .pricing-switch button.active{background:var(--plum);color:#fff}
    .section-heading{border-bottom:1px solid #f2ebf4;padding-bottom:16px}
    .section-heading h2{font-size:24px;color:var(--plum)}
    .package-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
    .package-card{border:1px solid var(--line);border-radius:17px;padding:19px;background:#fff;transition:transform .2s ease,box-shadow .2s ease}
    .package-card:hover{transform:translateY(-3px);box-shadow:0 12px 25px rgba(41,21,65,.09)}
    .package-card h3{font-size:18px;color:var(--plum)}
    .package-price{margin:16px 0;color:var(--coral);font-size:28px}
    .package-action{background:var(--coral);border-radius:10px}
    .pricing-note{margin-top:20px;background:#fff7df;border:1px solid #f8e8b7}
    @media(max-width:900px){.package-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:600px){
        .pricing-hero{min-height:260px;padding:42px 18px 82px}
        .pricing-hero h1{font-size:31px}
        .pricing-hero p{font-size:12px}
        .pricing-wrap{width:min(100% - 20px,1120px);margin-top:-28px}
        .pricing-section{padding:18px 15px 22px;border-radius:20px}
        .region-switch{justify-content:center}
        .region-switch a{flex:1;text-align:center;padding:9px 8px;font-size:11px}
        .pricing-switch{display:grid;grid-template-columns:1fr 1fr}
        .pricing-switch button{font-size:11px;padding:11px 6px}
        .package-grid{grid-template-columns:1fr}
    }
</style>

<div class="pricing-page">
    <section class="pricing-hero">
        <span class="eyebrow">أسعار واضحة بدون تعقيد</span>
        <h1>اختر الطريقة المناسبة لابنك</h1>
        <p>إما دوام مدرسي كامل من الساعة 10 إلى 2، أو تسجيل مواد منفصلة والدخول إلى كل حصة في موعدها.</p>
    </section>

    <main class="pricing-wrap">
        <section class="pricing-section">
            <div class="region-switch">
                <a class="{{ $regionKey === 'palestine' ? 'active' : '' }}" href="{{ route('pricing', ['region' => 'palestine']) }}">غزة والضفة · شيكل</a>
                <a class="{{ $regionKey === 'egypt' ? 'active' : '' }}" href="{{ route('pricing', ['region' => 'egypt']) }}">مصر · جنيه مصري</a>
            </div>
            <div class="pricing-switch" role="tablist">
                <button class="active" type="button" data-pricing-tab="regular">🏫 المدرسة النظامية</button>
                <button type="button" data-pricing-tab="subjects">📚 مواد منفصلة</button>
            </div>

            <div class="pricing-view active" data-pricing-view="regular">
                <div class="section-heading">
                    <div>
                        <h2>بكجات المدرسة النظامية</h2>
                        <p>تسجيل كل مواد الصف في بكج واحد خلال الفصل الدراسي في {{ $regionTitle }}.</p>
                    </div>
                </div>
                <div class="package-grid">
                    @foreach($packages as $package)
                        <article class="package-card">
                            <h3>{{ $package['title'] }}</h3>
                            <p>{{ $package['description'] }}</p>
                            <div class="package-price">{{ number_format($package['price'], 0) }} <small>{{ $currency }} / {{ config('pricing.term_label') }}</small></div>
                            @if($package['subjects']->isNotEmpty())
                                <div class="package-subjects">
                                    @foreach($package['subjects'] as $subject)<span>{{ $subject->name }}</span>@endforeach
                                </div>
                            @else
                                <div class="package-empty">سيتم تحديد مواد هذا الفرع عند اكتمال جدول المواد.</div>
                            @endif
                            @php
                                $packageMessage = "مرحباً، أرغب بالتسجيل في {$package['title']} للمدرسة النظامية في {$regionTitle}. السعر: {$package['price']} {$currency} / " . config('pricing.term_label') . ".";
                                $packageWhatsapp = 'https://wa.me/' . preg_replace('/\D+/', '', $whatsapp) . '?text=' . rawurlencode($packageMessage);
                            @endphp
                            <a class="package-action" href="{{ $packageWhatsapp }}" target="_blank" rel="noopener">ابدأ تسجيل البكج عبر واتساب</a>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="pricing-view" data-pricing-view="subjects">
            <div class="section-heading">
                <div>
                    <h2>المواد المتاحة للتسجيل</h2>
                    <p>الأسعار التالية للمواد المنفصلة، أما البكجات النظامية فموضحة في التبويب الأول.</p>
                </div>
            </div>
            <div class="subject-toolbar">
                <span><strong>{{ $subjects->count() }}</strong> مادة متاحة حاليًا</span>
                <span>العملة: <strong>{{ $currency }}</strong></span>
            </div>

            @if($subjects->isEmpty())
                <div class="empty-prices">لا توجد مواد بسعر محدد حاليًا. تواصل معنا لمعرفة البرامج المتاحة.</div>
            @else
                <div class="subject-groups">
                    @foreach($subjects->groupBy(fn ($subject) => $subject->grade?->name ?: 'مواد عامة') as $gradeName => $gradeSubjects)
                        <div class="subject-group">
                            <h3>{{ $gradeName }} <span>{{ $gradeSubjects->count() }} مواد</span></h3>
                            <div class="subject-grid">
                                @foreach($gradeSubjects as $subject)
                                    <article class="subject-card">
                                        <h4>{{ $subject->name }}</h4>
                                        <p>{{ $subject->description ?: 'مادة تعليمية مع شرح ومتابعة حسب الجدول الدراسي.' }}</p>
                                        <div class="subject-info">
                                            <span>{{ $subject->delivery_type === 'recorded' ? 'مسجلة' : 'مباشرة' }}</span>
                                            <span>{{ $subject->sessions_per_week ?? 0 }} حصص أسبوعيًا</span>
                                        </div>
                                        <div class="subject-price">
                                            <strong>{{ number_format((float) $subject->monthly_fee, 2) }}</strong>
                                            <small>للمادة / شهريًا</small>
                                        </div>
                                        @php
                                            $subjectMessage = "مرحباً، أرغب بالتسجيل في مادة {$subject->name} ضمن {$regionTitle}. السعر الظاهر: {$subject->monthly_fee} {$currency} شهريًا. أرجو تزويدي بتفاصيل التسجيل.";
                                            $subjectWhatsapp = 'https://wa.me/' . preg_replace('/\D+/', '', $whatsapp) . '?text=' . rawurlencode($subjectMessage);
                                        @endphp
                                        <a class="subject-link" href="{{ $subjectWhatsapp }}" target="_blank" rel="noopener">عرض التفاصيل والتسجيل</a>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            </div>
        </section>

        <div class="pricing-note">
            <span>💡</span>
            <div><strong>هل تحتاج مساعدة؟</strong><br>إذا لم تعرف أي نظام يناسب الطالب، ابدأ بالمواد المنفصلة أو تواصل معنا لنساعدك في اختيار الصف والمواد المناسبة.</div>
        </div>
    </main>
</div>
<script>
document.querySelectorAll('[data-pricing-tab]').forEach(function (button) {
    button.addEventListener('click', function () {
        var key = button.dataset.pricingTab;
        document.querySelectorAll('[data-pricing-tab]').forEach(function (item) {
            item.classList.toggle('active', item === button);
        });
        document.querySelectorAll('[data-pricing-view]').forEach(function (view) {
            view.classList.toggle('active', view.dataset.pricingView === key);
        });
    });
});
</script>
@endsection
