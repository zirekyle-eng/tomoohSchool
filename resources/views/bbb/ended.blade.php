<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>انتهت الحصة</title>
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:20px;background:#faf7fb;color:#241432;font-family:Cairo,Tahoma,Arial,sans-serif}.ended{width:min(520px,100%);padding:42px 30px;text-align:center;background:#fff;border:1px solid #eadfeb;border-radius:24px;box-shadow:0 20px 45px #29154012}.icon{width:62px;height:62px;margin:0 auto 18px;display:grid;place-items:center;border-radius:50%;background:#e9f8ef;color:#16834b;font-size:28px}.ended h1{margin:0 0 10px;font-size:25px}.ended p{margin:8px 0;color:#756882;font-size:13px;line-height:1.9}.ended strong{color:#2e1a47}.back{display:inline-block;margin-top:18px;padding:11px 18px;border-radius:10px;background:#ff6b4a;color:#fff;text-decoration:none;font-size:12px;font-weight:800}
    </style>
</head>
<body>
<main class="ended">
    <div class="icon">✓</div>
    <h1>انتهت الحصة</h1>
    <p>تم إنهاء غرفة BigBlueButton لهذه الحصة.</p>
    <p><strong>{{ $class->subject_name }}</strong> · {{ $class->grade_name }}</p>
    <a class="back" href="{{ $requesterIsTeacher ? route('teacher.dashboard') : route('dashboard') }}">العودة إلى الصفحة الرئيسية</a>
</main>
</body>
</html>