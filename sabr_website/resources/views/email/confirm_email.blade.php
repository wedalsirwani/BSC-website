<!DOCTYPE html>
<html lang="ar-SA">
    <head>
        <meta charset="utf-8">
    </head>
    <body style=" direction:rtl;">
        <h2>تأكيد بريدك الالكتروني</h2>

        <div>
        أهلاً وسهلاً بك يا {{$name}} نأمل أن تكون في صحة وسلامة<br /><br />
            لقد تم إرسال هذا البريد لتأكيد اشتراكك في برنامج {{config('app.name')}}.<br /><br />
            الرجاء اتباع <a href="{{ url('/login').
            '/'.$to.'/'.$confirmation_code}}">
                الرابط التالي</a>.<br/><br />
            في حال عدم عمل الرابط السابق انسخ الكود التالي والصقه في المستعرض
        <br /><br />
            {{ \URL::to('/login/'.$to.'/'.$confirmation_code) }}<br/><br />
        </div>
    </body>
</html>
