@extends('layouts.public', ['title' => 'تواصل معنا'])

@php
    $site = [
        'support_whatsapp' => '00972569177111',
        'email' => 'قيد التحديث',
        'support_hours' => 'يتم الرد خلال يوم عمل واحد، من السبت إلى الخميس.',
    ];
    $whatsapp = preg_replace('/\D+/', '', $site['support_whatsapp']);
@endphp

@section('content')
<style>
    .contact-page{background:#fbf9fd;min-height:calc(100vh - 72px);padding-bottom:86px}
    .contact-hero{position:relative;overflow:hidden;min-height:280px;padding:54px 20px 92px;background:linear-gradient(115deg,#291541 0%,#432568 58%,#56377d 100%);color:#fff;text-align:center}
    .contact-hero:before,.contact-hero:after{content:'';position:absolute;border-radius:50%;background:#ffc857;opacity:.08;pointer-events:none}
    .contact-hero:before{width:300px;height:300px;left:-100px;top:-180px}
    .contact-hero:after{width:240px;height:240px;right:-80px;bottom:-160px}
    .contact-hero>*{position:relative;z-index:1}
    .contact-hero .eyebrow{background:#ffffff18;border:1px solid #ffffff14;color:#ffc857;padding:7px 16px}
    .contact-hero h1{margin:17px auto 9px;color:#fff;font-size:clamp(32px,4.5vw,48px);line-height:1.35}
    .contact-hero p{max-width:690px;margin:0 auto;color:#e8dff0;font-size:14px;line-height:2}
    .contact-panel{width:min(1000px,calc(100% - 64px));margin:-30px auto 0;padding:28px;position:relative;z-index:2;border:1px solid #eadfeb;border-radius:22px;background:#fff;box-shadow:0 18px 45px rgba(41,21,65,.1)}
    .contact-heading{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:22px;padding-bottom:18px;border-bottom:1px solid #f1e9ef}
    .contact-heading h2{margin:0;color:var(--plum);font-size:24px}
    .contact-heading p{margin:4px 0 0;color:var(--muted);font-size:12px}
    .contact-mark{width:52px;height:52px;display:grid;place-items:center;border-radius:16px 16px 5px 16px;background:#ffeadf;color:var(--coral);font-size:25px}
    .contact-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
    .contact-card{padding:20px;border:1px solid var(--line);border-radius:17px;background:#fff}
    .contact-card h3{margin:0 0 10px;color:var(--plum);font-size:18px}
    .contact-card p{margin:0;color:var(--muted);font-size:12px;line-height:2}
    .contact-channel{display:flex;align-items:center;gap:12px;margin-bottom:13px}
    .contact-icon{width:40px;height:40px;display:grid;place-items:center;flex:0 0 auto;border-radius:12px;background:#e7f9ee;color:#159957;font-size:20px}
    .contact-channel strong{display:block;color:var(--ink);font-size:13px}
    .contact-channel small{display:block;color:var(--muted);font-size:10px}
    .whatsapp-button{display:block;margin-top:16px;padding:11px 14px;border-radius:10px;background:#25d366;color:#fff;text-align:center;font-size:12px;font-weight:800}
    .email-value{color:var(--coral)!important;font-weight:800;word-break:break-word}
    .contact-note{grid-column:1/-1;background:#fff7df;border-color:#f8e8b7}
    .contact-note h3{color:#755c18}
    .contact-note strong{color:#755c18}
    @media(max-width:700px){.contact-hero{min-height:260px;padding:42px 18px 82px}.contact-hero h1{font-size:31px}.contact-hero p{font-size:12px}.contact-panel{width:min(100% - 20px,600px);padding:19px 16px 24px;border-radius:20px}.contact-heading{align-items:flex-start}.contact-heading h2{font-size:21px}.contact-mark{width:45px;height:45px;font-size:21px}.contact-grid{grid-template-columns:1fr}.contact-note{grid-column:auto}}
</style>

<div class="contact-page">
    <section class="contact-hero">
        <span class="eyebrow">نحن هنا لمساعدتك</span>
        <h1>تواصل معنا</h1>
        <p>فريق الدعم جاهز لمساعدتك في التسجيل، الدفع، الدخول للحصص، أو أي استفسار يتعلق بالمنصة.</p>
    </section>

    <main class="contact-panel">
        <header class="contact-heading">
            <div>
                <h2>يسعدنا تواصلك معنا</h2>
                <p>اختر وسيلة التواصل المناسبة وسنعود إليك في أقرب وقت.</p>
            </div>
            <div class="contact-mark" aria-hidden="true">✉</div>
        </header>

        <div class="contact-grid">
            <article class="contact-card">
                <div class="contact-channel">
                    <span class="contact-icon">☏</span>
                    <div>
                        <strong>تواصل سريع عبر واتساب</strong>
                        <small>{{ $site['support_whatsapp'] }}</small>
                    </div>
                </div>
                <p>للاستفسار عن التسجيل، الأسعار، الحصص، أو أي مساعدة تحتاجها.</p>
                <a class="whatsapp-button" target="_blank" rel="noopener" href="https://wa.me/{{ $whatsapp }}">ابدأ المحادثة عبر واتساب</a>
            </article>

            <article class="contact-card">
                <div class="contact-channel">
                    <span class="contact-icon">✉</span>
                    <div>
                        <strong>البريد الإلكتروني</strong>
                        <small>للاستفسارات المكتوبة</small>
                    </div>
                </div>
                <p>يمكنك مراسلتنا على:</p>
                <p class="email-value">{{ $site['email'] }}</p>
                <p style="margin-top:14px"><strong>وقت الرد المتوقع:</strong><br>{{ $site['support_hours'] }}</p>
            </article>

            <article class="contact-card contact-note">
                <h3>ملاحظة مهمة</h3>
                <p>للحصول على رد أسرع، اذكر اسم الطالب ورقم الجوال والمادة التي تحتاج مساعدة بشأنها.</p>
            </article>
        </div>
    </main>
</div>
@endsection
