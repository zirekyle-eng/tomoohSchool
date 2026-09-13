@extends('layouts.public', ['title' => 'انضم كمدرس'])
@section('content')
<style>
    .apply-page{background:#fbf9fd;min-height:calc(100vh - 72px);padding-bottom:86px}
    .apply-hero{position:relative;overflow:hidden;min-height:280px;padding:54px 20px 92px;background:linear-gradient(115deg,#291541 0%,#432568 58%,#56377d 100%);color:#fff;text-align:center}
    .apply-hero:before,.apply-hero:after{content:'';position:absolute;border-radius:50%;background:#ffc857;opacity:.08;pointer-events:none}
    .apply-hero:before{width:300px;height:300px;left:-100px;top:-180px}
    .apply-hero:after{width:240px;height:240px;right:-80px;bottom:-160px}
    .apply-hero>*{position:relative;z-index:1}
    .apply-hero .eyebrow{background:#ffffff18;border:1px solid #ffffff14;color:#ffc857;padding:7px 16px}
    .apply-hero h1{margin:17px auto 9px;color:#fff;font-size:clamp(32px,4.5vw,48px);line-height:1.35}
    .apply-hero p{max-width:690px;margin:0 auto;color:#e8dff0;font-size:14px;line-height:2}
    .apply-panel{width:min(1120px,calc(100% - 64px));margin:-30px auto 0;padding:28px;position:relative;z-index:2;border:1px solid #eadfeb;border-radius:22px;background:#fff;box-shadow:0 18px 45px rgba(41,21,65,.1)}
    .apply-layout{display:grid;grid-template-columns:.8fr 1.2fr;gap:20px;align-items:stretch}
    .apply-intro,.apply-form{border:1px solid var(--line);border-radius:18px;padding:24px}
    .apply-intro{background:linear-gradient(145deg,#291541,#59369b);color:#fff}
    .apply-intro h2{margin:16px 0 9px;color:#fff;font-size:28px;line-height:1.5}
    .apply-intro h2 span{color:var(--sun)}
    .apply-intro p{color:#e3d8ee;font-size:12px;line-height:2}
    .apply-points{display:grid;gap:9px;margin-top:22px}
    .apply-points span{padding:10px;border:1px solid #ffffff25;border-radius:11px;color:#f5edf9;font-size:11px}
    .apply-form h2{margin:0 0 5px;color:var(--plum);font-size:23px}
    .apply-form>p{margin:0 0 18px;color:var(--muted);font-size:12px}
    .apply-alert{padding:10px 12px;border-radius:10px;background:#e8f8ef;color:#17734d;font-size:12px;margin-bottom:15px}
    .apply-fields{display:grid;grid-template-columns:1fr 1fr;gap:13px}
    .apply-fields label{display:grid;gap:6px;color:var(--ink);font-size:12px;font-weight:800}
    .apply-fields .wide{grid-column:1/-1}
    .apply-fields input,.apply-fields textarea{width:100%;border:1px solid var(--line);border-radius:10px;padding:11px 12px;font:12px Cairo;color:var(--ink);background:#fffdfa}
    .apply-fields textarea{min-height:100px;resize:vertical}
    .apply-fields input:focus,.apply-fields textarea:focus{outline:2px solid #ffb5a5;border-color:var(--coral)}
    .apply-submit{width:100%;margin-top:2px}
    @media(max-width:800px){.apply-layout{grid-template-columns:1fr}}
    @media(max-width:600px){.apply-hero{min-height:260px;padding:42px 18px 82px}.apply-hero h1{font-size:31px}.apply-hero p{font-size:12px}.apply-panel{width:min(100% - 20px,600px);padding:18px 15px 22px;border-radius:20px}.apply-intro,.apply-form{padding:19px 16px}.apply-fields{grid-template-columns:1fr}.apply-fields .wide{grid-column:auto}}
</style>

<div class="apply-page">
    <section class="apply-hero">
        <span class="eyebrow">فرصة جديدة</span>
        <h1>انضم إلى فريق مدرسينا</h1>
        <p>شارك خبرتك وساعد طلاب طموح على فهم موادهم بثقة من خلال بيئة تعليمية منظمة.</p>
    </section>

    <main class="apply-panel">
        <div class="apply-layout">
            <aside class="apply-intro">
                <span class="eyebrow">كن جزءًا من طموح</span>
                <h2>شارك خبرتك مع <span>طلاب طموح</span></h2>
                <p>نبحث عن مدرسين متخصصين يقدمون شرحًا واضحًا ومتابعة حقيقية للطلاب.</p>
                <div class="apply-points">
                    <span>✓ بيئة تعليمية منظمة</span>
                    <span>✓ طلاب يبحثون عن شرح واضح</span>
                    <span>✓ مراجعة عادلة لكل طلب</span>
                </div>
            </aside>

            <section class="apply-form">
                <h2>طلب الانضمام كمدرس</h2>
                <p>أرسل بياناتك، وسيتواصل معك فريق الإدارة بعد المراجعة.</p>
                @if(session('success'))<p class="apply-alert">{{ session('success') }}</p>@endif
                <form method="post" action="{{ route('teacher.apply.store') }}">
                    @csrf
                    <div class="apply-fields">
                        <label>الاسم الكامل<input name="full_name" value="{{ old('full_name') }}" required></label>
                        <label>رقم الهاتف<input name="phone" value="{{ old('phone') }}" required></label>
                        <label>البريد الإلكتروني<input name="email" type="email" value="{{ old('email') }}"></label>
                        <label>التخصص<input name="specialization" value="{{ old('specialization') }}" required></label>
                        <label>سنوات الخبرة<input name="years_experience" type="number" min="0" value="{{ old('years_experience') }}"></label>
                        <label class="wide">المؤهلات<input name="qualifications" value="{{ old('qualifications') }}" required></label>
                        <label class="wide">نبذة تعريفية<textarea name="bio">{{ old('bio') }}</textarea></label>
                        <label class="wide">مصدر التحقق أو رابط الأعمال<input name="verification_source" value="{{ old('verification_source') }}"></label>
                        <button class="button apply-submit wide" type="submit">إرسال طلب الانضمام</button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</div>
@endsection
