<!DOCTYPE html>
<html lang="ar-SA">
    <head>
        <meta charset="utf-8">
    </head>
    <body style=" direction:rtl;">
        <h2>تم {{$response}} كفالة القرض</h2>

        <div>
        أهلاً وسهلاً بك يا {{$name}} نأمل أن تكون في صحة وسلامة<br /><br />
        نود أن نعلمك أن {{$user}} قد قام ب{{$response}} كفالة القرض في برنامج {{config('app.name')}}
        @if($owner)
            وقد طلب كفالتك له
        @endif
         وبانتظار موافقة الإدارة.
        <br />
        <br />
        للاطلاع على قائمة القروض اتبع <a href='{{ url("/loan/".$loan_id) }}'>
            الرابط التالي</a>.<br/><br />
            في حال عدم عمل الرابط السابق انسخ الكود التالي والصقه في المستعرض
        <br /><br />
            {{ \URL::to("/loan/".$loan_id) }}<br/><br />
        </div>
    </body>
</html>
