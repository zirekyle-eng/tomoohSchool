<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="refresh" content="15">
    <title>الحصة لم تبدأ بعد</title>
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:20px;background:#faf7fb;color:#241432;font-family:Cairo,Tahoma,Arial,sans-serif}.waiting{width:min(520px,100%);padding:42px 30px;text-align:center;background:#fff;border:1px solid #eadfeb;border-radius:24px;box-shadow:0 20px 45px #29154012}.icon{width:62px;height:62px;margin:0 auto 18px;display:grid;place-items:center;border-radius:50%;background:#fff0e9;color:#ff6b4a;font-size:28px}.waiting h1{margin:0 0 10px;font-size:25px}.waiting p{margin:8px 0;color:#756882;font-size:13px;line-height:1.9}.waiting strong{color:#2e1a47}.reload{display:inline-block;margin-top:18px;padding:11px 18px;border-radius:10px;background:#ff6b4a;color:#fff;text-decoration:none;font-size:12px;font-weight:800}
    </style>
</head>
<body>
<main class="waiting">
    <div class="icon">◷</div>
    <h1>الحصة لم تبدأ بعد</h1>
    <p>لم يدخل المدرس إلى الغرفة الدراسية حتى الآن.</p>
    <p><strong>{{ $class->subject_name }}</strong> · {{ $class->grade_name }}</p>
    <p>انتظر قليلًا وأعد تحميل الصفحة بعد دخول المدرس.</p>
    <a class="reload" href="{{ url()->current() }}">إعادة تحميل الصفحة</a>
</main>
</body>
</html>
