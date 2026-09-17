<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? 'النخبة التعليمية' }}</title>

    <style>
        :root{
            font-family:Tahoma,Arial,sans-serif;
            color:#241432;
            background:#fffaf6;
        }

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            background:#fffaf6;
        }

        a{
            color:#d94d31;
            text-decoration:none;
        }

        .shell{
            max-width:1100px;
            margin:auto;
            padding:28px 18px;
        }

        .nav{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:32px;
        }

        .brand{
            font-weight:800;
            color:#2e1a47;
        }

        .nav-actions{
            display:flex;
            gap:14px;
            align-items:center;
            font-size:13px;
        }

        .button{
            display:inline-block;
            border:0;
            border-radius:10px;
            background:#ff6b4a;
            color:#fff;
            padding:11px 16px;
            font:700 13px Tahoma;
            cursor:pointer;
        }

        .panel{
            background:#fff;
            border:1px solid #eadfeb;
            border-radius:16px;
            padding:22px;
            box-shadow:0 12px 30px #2915400d;
        }

        .grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:14px;
        }

        .field{
            display:grid;
            gap:6px;
            margin-bottom:13px;
            font-size:13px;
            font-weight:700;
        }

        .field input{
            border:1px solid #eadfeb;
            border-radius:9px;
            padding:11px;
            font:inherit;
        }

        .alert{
            padding:10px 12px;
            border-radius:9px;
            background:#fff0f0;
            color:#b52e3e;
            font-size:13px;
        }

        .success{
            background:#e8f8ef;
            color:#17734d;
        }

        .muted{
            color:#756882;
            font-size:13px;
        }


        /* =====================================================
           TEACHER DASHBOARD
           ===================================================== */

        .shell.teacher-layout{
            max-width:none;
            width:100%;
            padding:0;
        }

        .shell.teacher-layout > .alert{
            max-width:1400px;
            margin:20px auto 0;
            padding-left:20px;
            padding-right:20px;
        }


        /* ===== Main teacher shell ===== */

        .teacher-shell{
            min-height:100vh;
            display:grid;
            grid-template-columns:250px 1fr;
            background:#fffaf6;
        }

        /* ===== Sidebar ===== */

        .teacher-side{
            background:#2e1a47;
            color:#fff;
            padding:28px 15px;
            min-height:100vh;

            display:flex;
            flex-direction:column;

            position:sticky;
            top:0;
            height:100vh;
        }

        .teacher-brand{
            display:flex;
            align-items:center;
            gap:10px;

            color:#fff;
            text-decoration:none;

            font-weight:800;
            margin:3px 8px 36px;
        }

        .teacher-brand span{
            line-height:1.35;
        }

        .teacher-brand small{
            display:block;
            color:#cdbfdb;
            font-size:11px;
            font-weight:400;
            margin-top:2px;
        }

        .teacher-mark{
            width:42px;
            height:42px;

            display:grid;
            place-items:center;

            background:#ff6b4a;
            border-radius:14px 14px 14px 4px;

            flex-shrink:0;
        }

        .teacher-menu{
            display:grid;
            gap:7px;
        }

        .teacher-menu a{
            color:#d9cbe8;
            text-decoration:none;

            padding:13px 14px;
            border-radius:11px;

            font-size:14px;
            font-weight:700;

            transition:.2s;
        }

        .teacher-menu a:hover,
        .teacher-menu a.active{
            background:#ffffff18;
            color:#fff;
        }

        .teacher-logout{
            margin-top:auto;
        }

        .teacher-logout button{
            width:100%;
            border:0;
            background:none;

            color:#ffc5b8;

            padding:13px 14px;
            border-radius:11px;

            font:700 14px Tahoma;
            text-align:right;

            cursor:pointer;
        }

        .teacher-logout button:hover{
            background:#ffffff12;
        }


        /* ===== Main ===== */

        .teacher-main{
            min-width:0;
            padding:30px 36px;
        }


        /* ===== Header ===== */

        .teacher-head{
            display:flex;
            justify-content:space-between;
            align-items:center;

            margin-bottom:24px;
        }

        .teacher-head h1{
            margin:0;

            color:#241432;

            font-size:30px;
            line-height:1.3;
            font-weight:700;
        }

        .teacher-head p{
            margin:7px 0 0;

            color:#736686;
            font-size:15px;
        }

        .teacher-avatar{
            width:50px;
            height:50px;

            border-radius:50%;
            overflow:hidden;

            background:#ddf3e8;
            color:#22a66b;

            display:grid;
            place-items:center;

            font-size:18px;
            font-weight:800;

            flex-shrink:0;
        }

        .teacher-avatar img{
            width:100%;
            height:100%;
            object-fit:cover;
        }


        /* ===== Intro ===== */

        .teacher-intro{
            display:flex;
            justify-content:space-between;
            align-items:center;

            gap:20px;

            margin-bottom:32px;

            background:linear-gradient(
                105deg,
                #2e1a47,
                #51337b
            );

            border-radius:20px;
            padding:26px 28px;

            color:#fff;
        }

        .teacher-intro h2{
            margin:0 0 6px;

            font-size:25px;
        }

        .teacher-intro p{
            margin:0;

            color:#d9cbe8;
            font-size:15px;
        }

        .teacher-intro a{
            display:inline-block;

            background:#ffc857;
            color:#2e1a47;

            border-radius:99px;

            padding:12px 18px;

            font-size:14px;
            font-weight:800;

            white-space:nowrap;
        }


        /* ===== Sections ===== */

        .teacher-section{
            margin-top:30px;
        }

        .teacher-section h2{
            margin:0 0 14px;

            font-size:23px;
            color:#241432;
        }


        /* ===== Weekly schedule ===== */

        .teacher-week{
            display:grid;
            grid-template-columns:repeat(7,minmax(145px,1fr));
            gap:12px;

            overflow-x:auto;

            padding-bottom:5px;
        }

        .teacher-day{
            background:#fff;

            border:1px solid #efe3f1;
            border-radius:16px;

            padding:12px;

            min-height:170px;
        }

        .teacher-day h3{
            margin:0 0 12px;

            background:#f0e9ff;
            color:#6041a5;

            border-radius:9px;

            padding:9px;

            text-align:center;

            font-size:14px;
        }

        .teacher-lesson{
            background:#fffafc;

            border:1px solid #f0e9f2;
            border-radius:11px;

            padding:10px;

            margin:8px 0;
        }

        .teacher-lesson b{
            display:block;

            font-size:14px;
            line-height:1.5;
        }

        .teacher-lesson small{
            display:block;

            color:#736686;

            font-size:12px;
            line-height:1.6;

            margin-top:5px;
        }

        .teacher-lesson a{
            display:inline-block;

            margin-top:8px;

            color:#e14f2e;

            font-size:12px;
            font-weight:800;
        }


        /* ===== Subjects ===== */

        .teacher-subject-grid{
            display:grid;

            grid-template-columns:
                repeat(auto-fit,minmax(220px,1fr));

            gap:14px;
        }

        .teacher-card{
            background:#fff;

            border:1px solid #efe3f1;
            border-radius:16px;

            padding:18px;
        }

        .teacher-card strong{
            display:block;

            color:#241432;

            font-size:16px;
        }

        .teacher-card .muted{
            margin:7px 0 0;
            font-size:14px;
        }


        /* ===== Profile ===== */

        .teacher-profile-box{
            background:#fff;

            border:1px solid #efe3f1;
            border-radius:18px;

            padding:20px;
        }

        .teacher-profile-row{
            display:flex;
            align-items:center;

            gap:15px;
        }

        .teacher-profile-row .teacher-avatar{
            width:65px;
            height:65px;

            font-size:22px;
        }

        .teacher-profile-row h3{
            margin:0;

            font-size:20px;
        }

        .teacher-profile-row p{
            margin:5px 0 0;

            font-size:14px;
        }

        .teacher-profile-box > .muted{
            margin:18px 0 0;

            font-size:14px;
            line-height:1.8;
        }


        /* ===== Profile form ===== */

        .teacher-form{
            display:grid;
            gap:14px;

            margin-top:20px;
        }

        .teacher-form-grid{
            display:grid;

            grid-template-columns:1fr 1fr;

            gap:14px;
        }

        .teacher-form label{
            display:grid;
            gap:7px;

            font-size:14px;
            font-weight:800;
        }

        .teacher-form label.full{
            grid-column:1/-1;
        }

        .teacher-form input,
        .teacher-form textarea{
            width:100%;

            border:1px solid #efe3f1;
            border-radius:11px;

            padding:12px;

            font:14px Tahoma;

            background:#fffdfa;
            color:#241432;

            outline:none;
        }

        .teacher-form input:focus,
        .teacher-form textarea:focus{
            border-color:#bba3d4;
        }

        .teacher-form textarea{
            min-height:100px;
            resize:vertical;
        }

        .teacher-save{
            border:0;
            border-radius:99px;

            background:#22a66b;
            color:#fff;

            padding:12px 22px;

            font:800 14px Tahoma;

            width:max-content;

            cursor:pointer;
        }


        /* =====================================================
           RESPONSIVE
           ===================================================== */

        @media(max-width:1050px){

            .teacher-shell{
                grid-template-columns:68px 1fr;
            }

            .teacher-side{
                padding:20px 9px;
            }

            .teacher-brand{
                justify-content:center;
                margin:0 auto 30px;
            }

            .teacher-brand span{
                display:none;
            }

            .teacher-menu a{
                font-size:0;
                text-align:center;
                padding:13px;
            }

            .teacher-menu a:first-letter{
                font-size:20px;
            }

            .teacher-logout button{
                font-size:0;
                text-align:center;
            }

            .teacher-logout button:first-letter{
                font-size:20px;
            }

            .teacher-main{
                padding:28px 24px;
            }
        }


        @media(max-width:700px){

            .teacher-shell{
                grid-template-columns:1fr;
            }

            .teacher-side{
                display:none;
            }

            .teacher-main{
                padding:22px 15px;
            }

            .teacher-head h1{
                font-size:25px;
            }

            .teacher-head p{
                font-size:14px;
            }

            .teacher-intro{
                display:block;
                padding:22px;
            }

            .teacher-intro h2{
                font-size:22px;
            }

            .teacher-intro p{
                font-size:14px;
            }

            .teacher-intro a{
                display:inline-block;
                margin-top:15px;
            }

            .teacher-week{
                grid-template-columns:
                    repeat(7,minmax(170px,1fr));
            }

            .teacher-form-grid{
                grid-template-columns:1fr;
            }

            .teacher-form label.full{
                grid-column:auto;
            }
        }

        /* ================================
   Teacher Footer
   ================================ */

body:has(.teacher-layout) {
    background:#fffaf6;
}

body:has(.teacher-layout) .site-footer {
    margin-top:0;
    background:#2e1a47;
    color:#fff;
}

body:has(.teacher-layout) .site-footer a {
    color:#d9cbe8;
}

body:has(.teacher-layout) .site-footer a:hover {
    color:#ffc857;
}
    </style>
</head>

<body>

@include('partials.site-nav')

<main class="shell {{ request()->routeIs('teacher.dashboard') ? 'teacher-layout' : '' }}">

    {{-- @if(session('success'))
        <p class="alert success">
            {{ session('success') }}
        </p>
    @endif

    @if($errors->any())
        <div class="alert">
            {{ $errors->first() }}
        </div>
    @endif --}}

    @yield('content')

</main>

@include('partials.site-footer')

</body>
</html>
