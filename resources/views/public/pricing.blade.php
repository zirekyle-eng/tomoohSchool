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
    .subject-card{border:1px solid #eee3f1;border-radius:18px;padding:18px;background:linear-gradient(180deg,#ffffff 0%, #f8faff 100%);transition:.2s;box-shadow:0 8px 22px rgba(53,39,79,.06)}
    .subject-card:hover{border-color:#ffb09e;transform:translateY(-2px);box-shadow:0 14px 28px rgba(53,39,79,.12)}
    .subject-card h4{margin:0 0 7px;color:#2e1a47;font-size:18px}
    .subject-card p{min-height:38px;margin:0 0 12px;color:#756882;font-size:11px;line-height:1.7}
    .subject-info{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px}
    .subject-info span{padding:5px 8px;border-radius:999px;background:#f8f2fa;color:#756882;font-size:10px}
    .subject-price{display:flex;align-items:baseline;gap:5px;color:#2e1a47;margin-top:8px}
    .subject-price strong{font-size:22px}
    .subject-price small{color:#756882;font-size:10px}
    .subject-payment-tag{display:inline-block;margin-bottom:8px;padding:5px 10px;border-radius:999px;background:#fff8df;border:1px solid #f7d982;color:#7a5a11;font-size:10px;font-weight:800}
    .subject-link{display:block;margin-top:12px;text-align:center;padding:10px;border-radius:10px;background:#ff6b4a;color:#fff;font-size:11px;font-weight:800}
    .subject-category-list{display:flex;flex-wrap:wrap;gap:8px;margin:12px 0 18px}
    .subject-category-list span{padding:7px 12px;border-radius:999px;background:#f1ebff;color:#4f2b88;font-size:11px;font-weight:800;border:1px solid #e3d8ff}
    .empty-prices{text-align:center;padding:24px;color:#756882}
    .pricing-note{display:flex;gap:10px;align-items:flex-start;padding:15px;border-radius:14px;background:#fff7df;color:#755c18;font-size:12px;line-height:1.8}
    .package-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
    .package-card{border:2px solid #ffb09e;border-radius:18px;padding:20px;background:linear-gradient(145deg,#fff8f4,#fff)}
    .package-card h3{margin:0 0 7px;color:#2e1a47;font-size:19px}
    .package-card p{margin:0;color:#756882;font-size:12px;line-height:1.8}
    .package-price{margin:12px 0 8px;color:#2e1a47;font-size:30px;font-weight:800}
    .package-price small{color:#756882;font-size:11px;font-weight:500}
    .package-payment-tag{display:inline-block;margin:0 0 8px;padding:5px 12px;border-radius:999px;background:#fff7de;border:1px solid #f3d67d;color:#7e5d00;font-size:10px;font-weight:800}
    .package-subjects{display:flex;flex-wrap:wrap;gap:6px;margin:0 0 16px}
    .package-subjects span{padding:5px 8px;border-radius:999px;background:#f2eaff;color:#64468e;font-size:10px}
    .package-action{display:block;text-align:center;padding:11px;border-radius:10px;background:#ff6b4a;color:#fff;font-size:12px;font-weight:800;cursor:pointer;border:0}
    .package-empty{padding:10px 0;color:#a63e2a;font-size:11px}
    .registration-modal{position:fixed;inset:0;background:rgba(32,16,46,.28);display:flex;align-items:center;justify-content:center;z-index:1000;padding:16px}
    .registration-modal.hidden{display:none}
    .registration-panel{width:min(520px,100%);background:#fff;border-radius:22px;padding:20px 18px 18px;box-shadow:0 25px 60px rgba(21,12,35,.16);position:relative}
    .registration-panel h3{margin:0 0 20px;text-align:center;color:#2e1a47;font-size:30px;line-height:1.2;font-weight:800}
    .registration-close{position:absolute;top:12px;right:14px;background:#f5eef9;border:none;border-radius:50%;width:34px;height:34px;font-size:22px;color:#56377d;cursor:pointer}
    .registration-form{display:grid;gap:16px}
    .registration-row{display:grid;gap:8px}
    .registration-row label{color:#2f1f42;font-size:16px;font-weight:700;text-align:right;display:block}
    .registration-row input,.registration-row select{width:100%;border:2px solid #f6a177;border-radius:12px;padding:12px 14px;font-size:14px;background:#fff;color:#2e1a47;appearance:none;-webkit-appearance:none;-moz-appearance:none;box-sizing:border-box}
    .select-wrap{position:relative}
    .select-wrap select{padding-left:42px}
    .select-wrap .select-caret{position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:14px;color:#2e1a47;pointer-events:none}
    .registration-row input::placeholder{color:#9aa0ae}
    .registration-row input:focus,.registration-row select:focus{outline:none;border-color:#ff8c56;box-shadow:0 0 0 3px rgba(255,140,86,.14)}
    .registration-submit{margin-top:10px;border:0;border-radius:14px;padding:14px;background:linear-gradient(135deg,#ff7b4d,#ff5b50);color:#fff;font-weight:800;font-size:16px;cursor:pointer;box-shadow:0 8px 16px rgba(255,107,74,.2)}
    .hidden{display:none!important}
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
                            <span class="package-payment-tag">الدفع فصلي</span>
                            <div class="package-price">{{ number_format($package['price'], 0) }} <small>{{ $currency }} / {{ config('pricing.term_label') }}</small></div>
                            @if($package['subjects']->isNotEmpty())
                                <div class="package-subjects">
                                    @foreach($package['subjects'] as $subject)<span>{{ $subject->name }}</span>@endforeach
                                </div>
                            @else
                                <div class="package-empty">سيتم تحديد مواد هذا الفرع عند اكتمال جدول المواد.</div>
                            @endif
                            <button type="button"
                                    class="package-action registration-trigger"
                                    data-type="package"
                                    data-title="{{ $package['title'] }}"
                                    data-price="{{ $package['price'] }}"
                                    data-region="{{ $regionTitle }}"
                                    data-currency="{{ $currency }}"
                                    data-whatsapp="{{ preg_replace('/\D+/', '', $whatsapp) }}">
                                ابدأ تسجيل البكج عبر واتساب
                            </button>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="pricing-view" data-pricing-view="subjects">
                <div class="section-heading">
                    <div>
                        <h2>المواد المنفصلة</h2>
                        <p>الأسعار الثابتة للمواد المنفصلة حسب المرحلة، بدون ربط بالمواد الإلكترونية في النظام.</p>
                    </div>
                </div>

                <div class="subject-category-list">
                    <span>التاريخ</span>
                    <span>العلوم</span>
                    <span>الرياضيات</span>
                    <span>اللغة الإنجليزية</span>
                    <span>الفزياء</span>
                    <span>الكيمياء</span>
                    <span>الأحياء</span>
                    <span>اللغة العربية</span>
                    <span>الجغرافيا </span>
                    <span>الثقافة العلمية</span>
                </div>

                @foreach($subjectPricing as $groupKey => $group)
                    @php
                        $groupTitle = $groupKey === 'basic' ? 'المرحلة الأساسية' : 'المرحلة الثانوية';
                    @endphp
                    <div class="subject-group" style="margin-top: 20px;">
                        <h3>{{ $groupTitle }} <span>{{ count($group) }} مواد</span></h3>
                        <div class="subject-grid">
                            @foreach($group as $item)
                                <article class="subject-card">
                                    <h4>{{ $item['label'] }}</h4>
                                    <p>مادة منفصلة حسب المستوى الدراسي المختار.</p>
                                    <span class="subject-payment-tag">الدفع فصلي</span>
                                    <div class="subject-price">
                                        <strong>{{ number_format((float) $item['price'], 0) }}</strong>
                                        <small>{{ $currency }}</small>
                                    </div>
                                    <button type="button"
                                            class="subject-link registration-trigger"
                                            data-type="subject"
                                            data-title="{{ $item['label'] }}"
                                            data-price="{{ $item['price'] }}"
                                            data-region="{{ $regionTitle }}"
                                            data-currency="{{ $currency }}"
                                            data-whatsapp="{{ preg_replace('/\D+/', '', $whatsapp) }}">
                                        تسجيل المادة
                                    </button>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="pricing-note">
            <span>💡</span>
            <div><strong>هل تحتاج مساعدة؟</strong><br>إذا لم تعرف أي نظام يناسب الطالب، ابدأ بالمواد المنفصلة أو تواصل معنا لنساعدك في اختيار الصف والمواد المناسبة.</div>
        </div>
    </main>
</div>

<div id="registrationModal" class="registration-modal hidden" aria-hidden="true">
    <div class="registration-panel" role="dialog" aria-modal="true" aria-labelledby="registrationTitle">
        <button type="button" class="registration-close" aria-label="إغلاق">×</button>
        <h3 id="registrationTitle">تسجيل الطالب</h3>
        <form id="registrationForm" class="registration-form">
            <input type="hidden" name="registrationType" id="registrationType">
            <input type="hidden" name="registrationTitle" id="registrationTitleHidden">
            <input type="hidden" name="registrationPrice" id="registrationPriceHidden">
            <input type="hidden" name="registrationRegion" id="registrationRegionHidden">
            <input type="hidden" name="registrationCurrency" id="registrationCurrencyHidden">
            <input type="hidden" name="registrationWhatsapp" id="registrationWhatsappHidden">

            <div class="registration-row">
                <label for="studentName">اسم الطالب</label>
                <input id="studentName" name="studentName" type="text" placeholder="اكتب اسم الطالب" required>
            </div>

            <div class="registration-row">
                <label for="studentPhone">رقم الهاتف</label>
                <input id="studentPhone" name="studentPhone" type="tel" placeholder="05XXXXXXXX" required>
            </div>

            <div class="registration-row" id="gradeRow">
                <label for="studentGrade">الصف</label>
                <div class="select-wrap">
                    <select id="studentGrade" name="studentGrade" required>
                        <option value="">اختر الصف</option>
                        <option value="الصف السابع">الصف السابع</option>
                        <option value="الصف الثامن">الصف الثامن</option>
                        <option value="الصف التاسع">الصف التاسع</option>
                        <option value="الصف العاشر">الصف العاشر</option>
                        <option value="الصف حادي عشر علمي">الصف حادي عشر علمي</option>
                        <option value="الصف حادي عشر أدبي">الصف حادي عشر أدبي</option>
                        <option value="الصف توجيهي علمي">الصف توجيهي علمي</option>
                        <option value="الصف توجيهي أدبي">الصف توجيهي أدبي</option>
                    </select>
                    <span class="select-caret">⌄</span>
                </div>
            </div>

            <div class="registration-row hidden" id="subjectRow">
                <label for="studentSubject">المادة</label>
                <div class="select-wrap">
                    <select id="studentSubject" name="studentSubject">
                        <option value="">اختر المادة</option>
                        <option value="التاريخ">التاريخ</option>
                        <option value="العلوم">العلوم</option>
                        <option value="الرياضيات">الرياضيات</option>
                        <option value="اللغة الإنجليزية">اللغة الإنجليزية</option>
                        <option value="الفزياء">الفزياء</option>
                        <option value="الكيمياء">الكيمياء</option>
                        <option value="الأحياء">الأحياء</option>
                        <option value="اللغة العربية">اللغة العربية</option>
                        <option value="الجغرافيا">الجغرافيا</option>
                        <option value="الثقافة العلمية">الثقافة العلمية</option>
                    </select>
                    <span class="select-caret">⌄</span>
                </div>
            </div>

            <button type="submit" class="registration-submit">إرسال على الواتساب</button>
        </form>
    </div>
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

var modal = document.getElementById('registrationModal');
var form = document.getElementById('registrationForm');
var gradeRow = document.getElementById('gradeRow');
var subjectRow = document.getElementById('subjectRow');
var closeBtn = document.querySelector('.registration-close');

function openRegistrationModal(button) {
    var type = button.dataset.type;
    var title = button.dataset.title || '';
    var price = button.dataset.price || '';
    var region = button.dataset.region || '';
    var currency = button.dataset.currency || '';
    var whatsapp = button.dataset.whatsapp || '';

    document.getElementById('registrationType').value = type;
    document.getElementById('registrationTitleHidden').value = title;
    document.getElementById('registrationPriceHidden').value = price;
    document.getElementById('registrationRegionHidden').value = region;
    document.getElementById('registrationCurrencyHidden').value = currency;
    document.getElementById('registrationWhatsappHidden').value = whatsapp;

    if (type === 'package') {
        gradeRow.classList.remove('hidden');
        subjectRow.classList.add('hidden');
        document.getElementById('studentGrade').setAttribute('required', 'required');
        document.getElementById('studentSubject').removeAttribute('required');
        document.getElementById('studentSubject').value = '';
    } else {
        gradeRow.classList.remove('hidden');
        subjectRow.classList.remove('hidden');
        document.getElementById('studentGrade').setAttribute('required', 'required');
        document.getElementById('studentSubject').setAttribute('required', 'required');
    }

    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');
    document.getElementById('studentName').focus();
}

function closeRegistrationModal() {
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
    form.reset();
}

document.querySelectorAll('.registration-trigger').forEach(function (button) {
    button.addEventListener('click', function () {
        openRegistrationModal(button);
    });
});

closeBtn.addEventListener('click', closeRegistrationModal);
modal.addEventListener('click', function (event) {
    if (event.target === modal) {
        closeRegistrationModal();
    }
});

form.addEventListener('submit', function (event) {
    event.preventDefault();

    var type = document.getElementById('registrationType').value;
    var title = document.getElementById('registrationTitleHidden').value;
    var price = document.getElementById('registrationPriceHidden').value;
    var region = document.getElementById('registrationRegionHidden').value;
    var currency = document.getElementById('registrationCurrencyHidden').value;
    var whatsapp = document.getElementById('registrationWhatsappHidden').value;
    var studentName = document.getElementById('studentName').value.trim();
    var studentPhone = document.getElementById('studentPhone').value.trim();
    var studentGrade = document.getElementById('studentGrade').value.trim();
    var studentSubject = document.getElementById('studentSubject').value.trim();

    var selectedItem = type === 'package' ? title : studentSubject || title;
    var selectedGrade = studentGrade || 'غير محدد';
    var itemLabel = type === 'package' ? 'البكج' : 'المادة';

    var message = [
        'مرحباً، أود التسجيل.',
        '',
        'النوع: ' + itemLabel,
        'العنوان: ' + selectedItem,
        'السعر: ' + price + ' ' + currency,
        'المنطقة: ' + region,
        'اسم الطالب: ' + studentName,
        'رقم الهاتف: ' + studentPhone,
        'الصف: ' + selectedGrade,
        type === 'subject' ? 'المادة المختارة: ' + studentSubject : 'اسم البكج: ' + title,
        '',
        'يرجى تزويدي بتفاصيل التسجيل.'
    ].join('\n');

    var waUrl = 'https://wa.me/' + whatsapp + '?text=' + encodeURIComponent(message);
    window.open(waUrl, '_blank', 'noopener');
    closeRegistrationModal();
});
</script>
@endsection
