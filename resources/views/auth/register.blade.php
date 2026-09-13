<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>إنشاء حساب | النخبة التعليمية</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--ink:#241432;--muted:#756882;--coral:#ff6b4a;--line:#eadfeb}
        *{box-sizing:border-box}
        body{margin:0;background:#fffaf6;color:var(--ink);font-family:Cairo,Arial,sans-serif}
        .register-page{min-height:calc(100vh - 72px);display:grid;place-items:center;padding:45px 18px;background:radial-gradient(circle at 85% 15%,#ffc8574d 0 2px,transparent 3px),linear-gradient(130deg,#fff8f1,#f5efff)}
        .register-layout{width:min(980px,100%);display:grid;grid-template-columns:.85fr 1.15fr;background:#fff;border:1px solid var(--line);border-radius:30px 30px 8px 30px;overflow:hidden;box-shadow:0 24px 55px #2915401a}
        .register-aside{padding:46px 38px;background:linear-gradient(145deg,#1f1234,#59368a);color:#fff}
        .register-aside h1{font-size:30px;line-height:1.5;margin:16px 0 9px}
        .register-aside h1 span{color:#ffc857}
        .register-aside p{font-size:13px;line-height:2;color:#ded2eb}
        .benefits{display:grid;gap:10px;margin-top:28px}
        .benefits span{background:#ffffff12;border:1px solid #ffffff1b;border-radius:13px;padding:10px;font-size:11px}
        .register-card{padding:36px 42px}
        .eyebrow{display:inline-block;background:#ffe8e0;color:#d74a2e;border-radius:99px;padding:5px 12px;font-size:11px;font-weight:800}
        .register-card h2{font-size:27px;margin:12px 0 4px}
        .intro{font-size:12px;color:var(--muted);margin:0 0 18px}
        .register-card form{display:grid;gap:10px}
        label{font-size:11px;font-weight:800}
        input,select{display:block;width:100%;border:1px solid var(--line);border-radius:11px;padding:11px 13px;margin-top:5px;background:#fffdfb;font:12px Cairo;color:var(--ink)}
        input:focus,select:focus{outline:2px solid #ffb5a5;border-color:var(--coral)}
        .two{display:grid;grid-template-columns:1fr 1fr;gap:10px}
        .pw-wrap{position:relative}
        .pw-wrap input{padding-left:38px}
        .pw-toggle{position:absolute;left:6px;top:50%;transform:translateY(-50%);background:none;border:0;cursor:pointer;font-size:14px;padding:4px;line-height:1;color:var(--muted)}
        .pw-toggle:hover{color:var(--coral)}
        .submit{border:0;border-radius:12px;padding:12px;background:var(--coral);color:#fff;font:800 13px Cairo;cursor:pointer;margin-top:4px}
        .submit:hover{background:#e95638}
        .alert{border-radius:11px;padding:9px 11px;font-size:11px;margin:0 0 10px}
        .error{background:#fff0f0;color:#b52e3e}
        .auth-foot{margin:15px 0 0;font-size:12px;color:var(--muted);line-height:2}
        .auth-foot a{color:#d94d31;font-weight:800;text-decoration:none}
        @media(max-width:720px){.register-page{padding:28px 14px}.register-layout{grid-template-columns:1fr}.register-aside{padding:28px}.register-aside h1{font-size:25px}.benefits{display:none}.register-card{padding:28px 22px}.two{grid-template-columns:1fr}}
    </style>
</head>
<body>
@include('partials.site-nav')
<main class="register-page">
    <section class="register-layout">
        <aside class="register-aside">
            <span class="eyebrow" style="background:#ffffff1b;color:#fff">خطوتك الأولى</span>
            <h1>ابدأ طريقك نحو<br><span>التفوق اليوم</span></h1>
            <p>أنشئ حسابك خلال دقيقة، ثم اختر المواد التي تناسب مرحلتك الدراسية.</p>
            <div class="benefits">
                <span>✓ مدرسون متخصصون ومواد منظمة</span>
                <span>✓ حصص مباشرة ومتابعة مستمرة</span>
                <span>✓ سجلّك الدراسي في مكان واحد</span>
            </div>
        </aside>
        <section class="register-card">
            <span class="eyebrow">حساب جديد</span>
            <h2>إنشاء حساب طالب</h2>
            <p class="intro">بعدها يمكنك تصفح المواد والاشتراك فيها.</p>
            @if($errors->any())
                <p class="alert error">{{ $errors->first() }}</p>
            @endif
            <form method="post" action="{{ route('register.store') }}">
                @csrf
                <label>الاسم الكامل
                    <input name="full_name" value="{{ old('full_name') }}" required placeholder="أدخل الاسم الكامل">
                </label>
                <label>رقم الجوال / واتساب
                    <input name="phone" type="tel" value="{{ old('phone') }}" required placeholder="أدخل رقم الجوال">
                </label>
                <div class="two">
                    <label>الدولة
                        <select name="country">
                            <option value="فلسطين" @selected(old('country', 'فلسطين') === 'فلسطين')>فلسطين</option>
                            <option value="مصر" @selected(old('country') === 'مصر')>مصر</option>
                            <option value="الأردن" @selected(old('country') === 'الأردن')>الأردن</option>
                            <option value="أخرى" @selected(old('country') === 'أخرى')>أخرى</option>
                        </select>
                    </label>
                    <label>المدينة
                        <input name="city" value="{{ old('city') }}" placeholder="مثال: رام الله">
                    </label>
                </div>
                <label>كلمة المرور
                    <div class="pw-wrap">
                        <input id="password" name="password" type="password" minlength="8" required placeholder="8 أحرف تشمل حرفًا كبيرًا ورمزًا خاصًا">
                        <button type="button" class="pw-toggle" onclick="togglePassword()" aria-label="إظهار أو إخفاء كلمة المرور">👁</button>
                    </div>
                </label>
                <button class="submit" type="submit">إنشاء الحساب</button>
            </form>
            <p class="auth-foot">لديك حساب؟ <a href="{{ route('login') }}">تسجيل الدخول</a></p>
        </section>
    </section>
</main>
<script>
function togglePassword() {
    var input = document.getElementById('password');
    var button = document.querySelector('.pw-toggle');
    input.type = input.type === 'password' ? 'text' : 'password';
    button.textContent = input.type === 'password' ? '👁' : '🙈';
}
</script>
</body>
</html>