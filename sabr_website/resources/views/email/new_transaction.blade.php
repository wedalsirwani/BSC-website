<!DOCTYPE html>
<html lang="ar-SA">
    <head>
        <meta charset="utf-8">
    </head>
    <body style=" direction:rtl;">
        <h2>تم تسجيل دفعة جديدة</h2>

        <div>
        أهلاً وسهلاً بك يا {{$name}} نأمل أن تكون في صحة وسلامة<br /><br />
        نود أن نعلمك أن {{$user}} قد سجل دفعة جديدة في برنامج {{config('app.name')}} وبانتظار تأكيدها من قبل أحد أعضاء الإدارة.
        <br />
        <br />
        للاطلاع على الدفعة اتبع <a href="{{ url('/show_transactions').'/'.$id }}">
            الرابط التالي</a>.<br/><br />
        للاطلاع على قائمة الدفعات اتبع <a href="{{ url('/show_transactions') }}">
            الرابط التالي</a>.<br/><br />
            في حال عدم عمل الرابط السابق انسخ الكود التالي والصقه في المستعرض
        <br /><br />
        هذه الدفعة
            {{ \URL::to('/show_transactions/'.$id) }}<br/><br />
            كل الدفعات
            {{ \URL::to('/show_transactions') }}<br/><br />
        </div>
    </body>
</html>
