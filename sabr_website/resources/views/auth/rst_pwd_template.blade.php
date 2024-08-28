<!DOCTYPE html>
<html lang="ar-SA">
    <head>
        <meta charset="utf-8">
    </head>
    <body style=" direction:rtl;">
        <h2>إعادة تعيين كلمة المرور</h2>

        <div>
        أهلاً وسهلاً بك يا {{$name}} نأمل أن تكون في صحة وسلامة<br /><br />
            لقد تم إرسال هذا البريد لإعادة تعيين كلمة المرور الخاصة بك في برنامج {{config('app.name')}}.<br /><br />
            الرجاء اتباع <a href="{{ url('/reset').
            '/'.$to.'/'.$confirmation_code.'/reset'}}">
                 الرابط التالي </a>لإعادة تعيين كلمة المرور الخاصة بك .<br/><br />
            في حال عدم عمل الرابط السابق انسخ الكود التالي والصقه في المستعرض
        <br /><br />
            {{ \URL::to('/reset/'.$to.'/'.$confirmation_code).'/reset' }}<br/><br />
            وفي حال لم تطلب إعادة تعيين كلمة المرور تجاهل الرسالة.
        </div>
    </body>
</html>
