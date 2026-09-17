@extends('layouts.admin', ['title' => 'الصفوف والمواد'])

@section('content')
<style>
    .academics-head { display:flex; justify-content:space-between; align-items:end; gap:18px; margin-bottom:22px; }
    .academics-head h1 { margin:0; }
    .academics-head p { margin:5px 0 0; }
    .academic-layout { display:grid; grid-template-columns:minmax(0, 1.35fr) minmax(310px, .65fr); gap:22px; align-items:start; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .form-grid .wide { grid-column:1/-1; }
    .field { display:grid; gap:6px; }
    .field small { color:var(--muted); font-weight:500; }
    .form-section { grid-column:1/-1; margin-top:5px; padding-top:14px; border-top:1px solid var(--line); color:var(--muted); font-size:12px; font-weight:800; }
    .subjects-list { display:grid; gap:10px; max-height:760px; overflow:auto; }
    .subject-card { display:grid; grid-template-columns:64px 1fr; gap:12px; padding:12px; border:1px solid var(--line); border-radius:14px; background:#fff; }
    .subject-image { width:64px; height:64px; border-radius:12px; object-fit:cover; background:linear-gradient(135deg,#ff6b4a,#51337b); }
    .subject-card h3 { margin:0 0 4px; font-size:15px; }
    .subject-card p { margin:0; color:var(--muted); font-size:11px; line-height:1.8; }
    .subject-tags { display:flex; flex-wrap:wrap; gap:5px; margin-top:7px; }
    .subject-tags span { padding:3px 7px; border-radius:99px; background:#f7effa; color:var(--muted); font-size:10px; font-weight:700; }
    .subject-actions { display:flex; justify-content:flex-end; margin-top:12px; }
    .subject-actions button { border:0; border-radius:10px; background:#f0ebff; color:var(--plum); font:700 12px Tajawal; padding:8px 12px; cursor:pointer; }
    @media(max-width:960px){.academic-layout{grid-template-columns:1fr}}
    @media(max-width:600px){.academics-head{display:block}.form-grid{grid-template-columns:1fr}.panel{padding:16px}}
</style>

<header class="academics-head">
    <div>
        <h1>الصفوف والمواد الدراسية</h1>
        <p class="muted">أضف المادة مع بياناتها التعليمية والتفاصيل التي ستظهر للطلاب.</p>
    </div>
</header>

<div class="academic-layout">
    <section class="panel">
        <h2>إضافة مادة جديدة</h2>
        <form method="post" action="{{ route('admin.subjects.store') }}" enctype="multipart/form-data" class="form-grid" id="subjectForm">
            @csrf
            <input type="hidden" name="subject_id" id="subject_id" value="">
            <label class="field">الصف الدراسي
                <select name="grade_id" id="grade_id" required>
                    <option value="">اختر الصف</option>
                    @foreach($grades as $grade)<option value="{{ $grade->id }}">{{ $grade->name }}</option>@endforeach
                </select>
            </label>
            <label class="field">منطقة الدراسة
                <select name="market_id" id="market_id" required>
                    <option value="1">قطاع غزة</option><option value="2">الضفة الغربية</option><option value="3">مصر</option>
                </select>
            </label>
            <label class="field">الفرع
                <select name="tawjihi_branch" id="tawjihi_branch" required>
                    <option value="general">مواد مشتركة</option><option value="scientific">العلمي</option><option value="literary">الأدبي</option><option value="sharia">الشرعي</option><option value="entrepreneurship">الريادة والأعمال</option><option value="vocational">المهني والصناعي</option>
                </select>
            </label>
            <label class="field">المدرس الأساسي
                <select name="primary_teacher_id" id="primary_teacher_id"><option value="">اختر المدرس</option>@foreach($teachers as $teacher)<option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>@endforeach</select>
            </label>
            <label class="field wide">اسم المادة
                <input name="name" id="name" required placeholder="مثال: الرياضيات - التوجيهي">
            </label>
            <label class="field">مدة الاشتراك
                <select name="enrollment_term" id="enrollment_term" required><option value="full_year">المنهج كاملًا</option><option value="first">الفصل الأول</option><option value="second">الفصل الثاني</option></select>
            </label>
            <label class="field">السعر الشهري (شيكل)
                <input name="monthly_fee" id="monthly_fee" type="number" min="0" step=".01" value="0" required>
                <small>يظهر في الكتالوج وصفحة الأسعار وبطاقة التسجيل.</small>
            </label>
            <label class="field">صورة المادة
                <input name="image" type="file" accept="image/jpeg,image/png,image/webp"><small>JPG أو PNG أو WebP، بحد أقصى 4MB</small>
            </label>
            <label class="field">عدد الحصص أسبوعيًا
                <input name="sessions_per_week" id="sessions_per_week" type="number" min="1" value="2" required>
            </label>
            <label class="field">إجمالي الساعات
                <input name="total_hours" id="total_hours" type="number" min="0" step=".5" placeholder="اختياري">
            </label>
            <label class="field">تاريخ البداية<input name="start_date" id="start_date" type="date"></label>
            <label class="field">تاريخ النهاية<input name="end_date" id="end_date" type="date"></label>

            <div class="form-section">تفاصيل تعليمية إضافية</div>
            <label class="field wide">وصف المادة
                <textarea name="description" id="description" rows="3" placeholder="وصف مختصر يظهر للطلاب"></textarea>
            </label>
            <label class="field wide">خطة الوحدات
                <textarea name="unit_plan" id="unit_plan" rows="4" placeholder="الوحدات والمواضيع الرئيسية"></textarea>
            </label>
            <label class="field wide">سياسة تعويض الحصص
                <textarea name="make_up_policy" id="make_up_policy" rows="3" placeholder="ماذا يحدث عند تأجيل أو إلغاء حصة؟"></textarea>
            </label>
            <label class="field">نوع المحاضرات
                <select name="delivery_type" id="delivery-type"><option value="live">مباشرة حسب الجدول</option><option value="recorded">محاضرات مسجلة</option></select>
            </label>
            <label class="field wide" id="recorded-url-field" hidden>رابط المحاضرات المسجلة
                <input name="recorded_lectures_url" id="recorded-url" type="url" placeholder="https://...">
                <small>يظهر للطالب بدل جدول الحصص.</small>
            </label>
            <label class="field wide">رابط نموذج أو حصة مجانية
                <input name="free_preview_url" id="free_preview_url" type="url" placeholder="https://...">
            </label>
            <button class="button wide" type="submit" id="submitButton">إضافة المادة</button>
        </form>
    </section>

    <aside class="panel">
        <h2>المواد المسجلة</h2>
        <div class="subjects-list">
            @forelse($subjects as $subject)
                <article class="subject-card" data-subject='{{ json_encode([
                    "id" => $subject->id,
                    "grade_id" => $subject->grade_id,
                    "market_id" => $subject->market_id,
                    "name" => $subject->name,
                    "description" => $subject->description,
                    "monthly_fee" => $subject->monthly_fee,
                    "tawjihi_branch" => $subject->tawjihi_branch,
                    "enrollment_term" => $subject->enrollment_term,
                    "sessions_per_week" => $subject->sessions_per_week,
                    "total_hours" => $subject->total_hours,
                    "start_date" => $subject->start_date,
                    "end_date" => $subject->end_date,
                    "free_preview_url" => $subject->free_preview_url,
                    "unit_plan" => $subject->unit_plan,
                    "make_up_policy" => $subject->make_up_policy,
                    "delivery_type" => $subject->delivery_type,
                    "recorded_lectures_url" => $subject->recorded_lectures_url,
                    "primary_teacher_id" => $subject->primary_teacher_id,
                ]) }}'>
                    @if($subject->image_path)<img class="subject-image" src="{{ asset(str_replace('public/', '', $subject->image_path)) }}" alt="{{ $subject->name }}">@else<div class="subject-image"></div>@endif
                    <div>
                        <h3>{{ $subject->name }}</h3>
                        <p>{{ $subject->description ?: 'لا يوجد وصف مختصر لهذه المادة.' }}</p>
                        <div class="subject-tags">
                            <span>{{ $subject->grade_name }}</span>
                            <span>{{ ['general'=>'مشتركة','scientific'=>'العلمي','literary'=>'الأدبي','sharia'=>'الشرعي','entrepreneurship'=>'الريادة','vocational'=>'المهني'][$subject->tawjihi_branch] ?? 'مشتركة' }}</span>
                            <span>{{ $subject->delivery_type === 'recorded' ? 'مسجلة' : 'مباشرة' }}</span>
                            <span>{{ $subject->sessions_per_week ?? 2 }} حصص أسبوعيًا</span>
                            <span>{{ number_format((float) $subject->monthly_fee, 2) }} ₪ شهريًا</span>
                        </div>
                        <div class="subject-actions">
                            <button type="button" class="edit-subject-btn" data-subject='{{ json_encode([
                                "id" => $subject->id,
                                "grade_id" => $subject->grade_id,
                                "market_id" => $subject->market_id,
                                "name" => $subject->name,
                                "description" => $subject->description,
                                "monthly_fee" => $subject->monthly_fee,
                                "tawjihi_branch" => $subject->tawjihi_branch,
                                "enrollment_term" => $subject->enrollment_term,
                                "sessions_per_week" => $subject->sessions_per_week,
                                "total_hours" => $subject->total_hours,
                                "start_date" => $subject->start_date,
                                "end_date" => $subject->end_date,
                                "free_preview_url" => $subject->free_preview_url,
                                "unit_plan" => $subject->unit_plan,
                                "make_up_policy" => $subject->make_up_policy,
                                "delivery_type" => $subject->delivery_type,
                                "recorded_lectures_url" => $subject->recorded_lectures_url,
                                "primary_teacher_id" => $subject->primary_teacher_id,
                            ]) }}'>تعديل</button>
                        </div>
                    </div>
                </article>
            @empty
                <p class="muted">لا توجد مواد بعد.</p>
            @endforelse
        </div>
    </aside>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const type = document.querySelector('#delivery-type');
    const field = document.querySelector('#recorded-url-field');
    const url = document.querySelector('#recorded-url');
    const form = document.querySelector('#subjectForm');
    const submitButton = document.querySelector('#submitButton');
    if (!type || !field || !url) return;

    function refresh() {
        const recorded = type.value === 'recorded';
        field.hidden = !recorded;
        url.required = recorded;
    }

    function setFormMode(subject) {
        if (!subject) return;
        form.querySelector('#subject_id').value = subject.id || '';
        form.querySelector('#grade_id').value = subject.grade_id || '';
        form.querySelector('#market_id').value = subject.market_id || 1;
        form.querySelector('#tawjihi_branch').value = subject.tawjihi_branch || 'general';
        form.querySelector('#primary_teacher_id').value = subject.primary_teacher_id || '';
        form.querySelector('#name').value = subject.name || '';
        form.querySelector('#enrollment_term').value = subject.enrollment_term || 'full_year';
        form.querySelector('#monthly_fee').value = subject.monthly_fee || 0;
        form.querySelector('#sessions_per_week').value = subject.sessions_per_week || 2;
        form.querySelector('#total_hours').value = subject.total_hours || '';
        form.querySelector('#start_date').value = subject.start_date || '';
        form.querySelector('#end_date').value = subject.end_date || '';
        form.querySelector('#description').value = subject.description || '';
        form.querySelector('#unit_plan').value = subject.unit_plan || '';
        form.querySelector('#make_up_policy').value = subject.make_up_policy || '';
        form.querySelector('#delivery-type').value = subject.delivery_type || 'live';
        form.querySelector('#recorded-url').value = subject.recorded_lectures_url || '';
        form.querySelector('#free_preview_url').value = subject.free_preview_url || '';
        submitButton.textContent = 'تحديث المادة';
        refresh();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.querySelectorAll('.edit-subject-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            try {
                const subject = JSON.parse(button.dataset.subject);
                setFormMode(subject);
            } catch (error) {
                console.error('Failed to parse subject data', error);
            }
        });
    });

    type.addEventListener('change', refresh);
    refresh();
});
</script>
@endsection
