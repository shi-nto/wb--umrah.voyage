<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>اختبار نص عربي — PDF Test</title>

  <style>
    @font-face {
      font-family: "NotoNaskh";
      src: url("{{ asset('fonts/NotoNaskhArabic-Regular.ttf') }}") format("truetype");
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }

    html, body {
      height: 100%;
      margin: 0;
      padding: 20px;
      direction: rtl;
      unicode-bidi: embed;
      font-family: "NotoNaskh", "Amiri", serif;
      font-size: 18px;
      line-height: 1.6;
    }

    .card {
      border: 1px solid #ddd;
      padding: 16px;
      border-radius: 6px;
      max-width: 800px;
      margin: 0 auto;
    }

    h1 { text-align: center; margin-top: 0 }
  </style>
</head>
<body>
  <div class="card">
    <h1>اختبار نص عربي — Arabic Text Test</h1>

    <p>
      هذا نص عربي للتجربة. يجب أن تظهر الحروف متصلة وبالترتيب الصحيح من اليمين إلى اليسار.
      جرب حفظ هذه الصفحة كـ PDF من متصفح Chrome أو استخدم أداة Puppeteer في مشروعك.
    </p>

    <p>مثال جملة: السلام عليكم ورحمة الله وبركاته.</p>

    <p>نص مختلط: رقم 1234 ثم كلمة عربية ثم English text.</p>
  </div>
</body>
</html>
