<style>
    .site-footer{background:#21133d;color:#d9cbe8;padding:48px 0 20px;font-family:Cairo,Arial,sans-serif}
    .site-footer .footer-grid{width:min(1140px,calc(100% - 36px));margin:auto;display:grid;grid-template-columns:1.5fr repeat(3,1fr);gap:35px}
    .site-footer .footer-brand{display:flex;align-items:flex-start;gap:11px;color:#fff;font-size:16px;font-weight:800}
    .site-footer .footer-brand img{width:44px;height:44px;border-radius:13px;object-fit:cover}
    .site-footer .footer-brand small{display:block;color:#bdaed0;font-size:10px;font-weight:400;margin-top:1px}
    .site-footer .footer-about{max-width:260px;color:#bdaed0;font-size:11px;line-height:2;margin:14px 0 0}
    .site-footer h3{color:#ffc857;font-size:13px;margin:2px 0 13px}
    .site-footer nav{display:grid;gap:7px}
    .site-footer nav a{color:#d9cbe8;font-size:11px;transition:color .2s}
    .site-footer nav a:hover{color:#ffc857}
    .site-footer .footer-bottom{width:min(1140px,calc(100% - 36px));margin:35px auto 0;padding-top:16px;border-top:1px solid #ffffff1c;display:flex;justify-content:space-between;gap:20px;color:#a99ab9;font-size:10px}
    @media(max-width:720px){.site-footer{padding-top:35px}.site-footer .footer-grid{grid-template-columns:1fr 1fr;gap:28px 18px}.site-footer .footer-main{grid-column:span 2}.site-footer .footer-bottom{display:block;margin-top:28px}.site-footer .footer-bottom span{display:block;margin-top:6px}}
</style>
<footer class="site-footer">
    <div class="footer-grid">
        <div class="footer-main">
            <a class="footer-brand" href="{{ route('home') }}"><img src="{{ asset('logo.jpeg') }}" alt="شعار مدرسة طموح الإلكترونية"><span>مدرسة طموح الإلكترونية<small>لدروس التقوية والتعلم الواضح</small></span></a>
            <p class="footer-about">نرافق الطالب بخطة تعليمية واضحة، مدرسين متخصصين، وحصص مباشرة تساعده على التقدم بثقة.</p>
        </div>
        <div><h3>استكشف</h3><nav><a href="{{ route('home') }}">الرئيسية</a><a href="{{ route('catalog') }}">المواد الدراسية</a><a href="{{ route('pricing') }}">الأسعار والتسجيل</a><a href="{{ route('teachers') }}">مدرسونا</a></nav></div>
        <div><h3>عن طموح</h3><nav><a href="{{ route('about') }}">من نحن</a><a href="{{ route('contact') }}">تواصل معنا</a><a href="{{ route('teacher.apply') }}">انضم كمدرس</a><a href="{{ route('policies') }}">السياسات والشروط</a></nav></div>
        <div><h3>حسابك</h3><nav><a href="{{ route('login') }}">تسجيل الدخول</a><a href="{{ route('register') }}">إنشاء حساب طالب</a></nav></div>
    </div>
    <div class="footer-bottom"><span>© {{ date('Y') }} مدرسة طموح الإلكترونية. جميع الحقوق محفوظة.</span><span>تعلم منظّم، خطوة أقرب للنجاح.</span></div>
</footer>
