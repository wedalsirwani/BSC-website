<!DOCTYPE html>
<html lang="ar-SA">
    <head>
        <meta charset="utf-8">
    </head>
    <body style=" direction:rtl;">
        <h2>تم طلب قرض جديد</h2>

        <div>
        أهلاً وسهلاً بك يا {{$name}} نأمل أن تكون في صحة وسلامة<br /><br />
        نود أن نعلمك أن {{$user}} قد قام بطلب قرض جديد في برنامج {{config('app.name')}}
        @if($sponsor)
            وقد طلب كفالتك له
        @endif
         وبانتظار الموافقة.
        <br />
        <br />
        للاطلاع على قائمة القروض اتبع <a href=
            @if($sponsor)
            '{{ url("/sponsor_loan/".$loan_id) }}'
            @else
            '{{ url("/loan/".$loan_id) }}'
            @endif>
            الرابط التالي</a>.<br/><br />
            في حال عدم عمل الرابط السابق انسخ الكود التالي والصقه في المستعرض
        <br /><br />
            {{ \URL::to("/loan/".$loan_id) }}<br/><br />
        </div>
    </body>
</html>
