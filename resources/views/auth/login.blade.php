<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>تسجيل الدخول | النخبة التعليمية</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--ink:#241432;--muted:#756882;--coral:#ff6b4a;--line:#eadfeb}
        *{box-sizing:border-box}
        body{margin:0;background:#fffaf6;color:var(--ink);font-family:Cairo,Arial,sans-serif}
        .auth-page{min-height:calc(100vh - 72px);display:grid;place-items:center;padding:55px 18px;background:radial-gradient(circle at 14% 20%,#ffc85742 0 2px,transparent 3px),linear-gradient(130deg,#fff8f1,#f5efff)}
        .auth-layout{width:min(960px,100%);display:grid;grid-template-columns:.9fr 1.1fr;background:#fff;border:1px solid var(--line);border-radius:30px 30px 8px 30px;overflow:hidden;box-shadow:0 24px 55px #2915401a}
        .auth-aside{padding:48px 40px;background:linear-gradient(145deg,#28163f,#51307e);color:#fff;position:relative;overflow:hidden}
        .auth-aside:after{content:'';position:absolute;width:190px;height:190px;border-radius:50%;left:-55px;bottom:-65px;background:#ffc8572b}
        .auth-aside h1{font-size:31px;line-height:1.5;margin:16px 0 10px}
        .auth-aside h1 span{color:#ffc857}
        .auth-aside p{font-size:13px;line-height:2;color:#ded2eb}
        .auth-note{position:relative;z-index:1;margin-top:32px;border:1px solid #ffffff27;background:#ffffff12;border-radius:16px;padding:13px;font-size:11px;line-height:2}
        .auth-card{padding:45px}
        .eyebrow{display:inline-block;background:#ffe8e0;color:#d74a2e;border-radius:99px;padding:5px 12px;font-size:11px;font-weight:800}
        .auth-card h2{font-size:28px;margin:14px 0 5px}
        .intro{margin:0 0 24px;font-size:12px;color:var(--muted)}
        .auth-card form{display:grid;gap:13px}
        label{font-size:12px;font-weight:800}
        input{display:block;width:100%;border:1px solid var(--line);border-radius:12px;padding:13px 14px;margin-top:6px;background:#fffdfb;color:var(--ink);font:13px Cairo}
        input:focus{outline:2px solid #ffb5a5;border-color:var(--coral)}
        .submit{border:0;border-radius:12px;padding:13px;background:var(--coral);color:#fff;font:800 13px Cairo;cursor:pointer}
        .submit:hover{background:#e95638}
        .alert{border-radius:11px;padding:10px 12px;font-size:12px;margin:0 0 14px}
        .error{background:#fff0f0;color:#b52e3e}
        .auth-foot{margin:20px 0 0;font-size:12px;color:var(--muted);line-height:2}
        .auth-foot a{color:#d94d31;font-weight:800;text-decoration:none}
        @media(max-width:720px){.auth-page{padding:28px 14px}.auth-layout{grid-template-columns:1fr}.auth-aside{padding:28px}.auth-aside h1{font-size:25px}.auth-note{display:none}.auth-card{padding:30px 22px}}
    </style>
</head>
<body>
@include('partials.site-nav')
<main class="auth-page">
    <section class="auth-layout">
        <aside class="auth-aside">
            <span class="eyebrow" style="background:#ffffff1b;color:#fff">مرحبًا بعودتك</span>
            <h1>تابع تعلّمك،<br><span>خطوة بخطوة</span></h1>
            <p>ادخل إلى حسابك لمتابعة الحصص، المواد، وجدولك الدراسي في مكان واحد.</p>
            <div class="auth-note">✓ حصص مباشرة ومحتوى منظم<br>✓ متابعة واضحة لتقدمك</div>
        </aside>
        <section class="auth-card">
            <span class="eyebrow">أهلاً بك</span>
            <h2>تسجيل الدخول</h2>
            <p class="intro">الطالب والمدرس والإدارة يدخلون من هذه الصفحة.</p>
            @if($errors->any())
                <p class="alert error">{{ $errors->first() }}</p>
            @endif
            <form method="post" action="{{ route('login.store') }}">
                @csrf
                <label>رقم الجوال
                    <input name="phone" type="tel" value="{{ old('phone') }}" required placeholder="أدخل رقم الجوال">
                </label>
                <label>كلمة المرور
                    <input name="password" type="password" required placeholder="أدخل كلمة المرور">
                </label>
                <button class="submit" type="submit">دخول إلى حسابي</button>
            </form>
            <p class="auth-foot">ليس لديك حساب؟ <a href="{{ route('register') }}">أنشئ حساب طالب</a></p>
        </section>
    </section>
</main>
@include('partials.site-footer')
</body>
</html>