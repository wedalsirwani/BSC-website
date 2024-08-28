<!DOCTYPE html>
<html lang="ar-SA">
    <head>
        <meta charset="utf-8">
    </head>
    <body style=" direction:rtl;">
        <h2>مستخدم جديد في الانتظار</h2>

        <div>
        أهلاً وسهلاً بك يا {{$name}} نأمل أن تكون في صحة وسلامة<br /><br />
        نود أن نعلمك أن {{$user}} قد سجل في برنامج {{config('app.name')}} وبانتظار موافقة أحد أعضاء الإدارة.
        <br />
        <br />
        للاطلاع على قائمة المستخدمين اتبع <a href="{{ url('/new_users') }}">
            الرابط التالي</a>.<br/><br />
            في حال عدم عمل الرابط السابق انسخ الكود التالي والصقه في المستعرض
        <br /><br />
            {{ \URL::to('/new_users') }}<br/><br />
        </div>
    </body>
</html>
