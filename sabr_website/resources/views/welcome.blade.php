@extends('layouts.auth_master')
@section('title', 'الرئيسية')
@section('content')
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($offers as $index => $offer)
                <div class="carousel-item {{$index==0?'active':null}}">
                    <img class="d-block w-100" src="{{$offer->img}}" alt="{{$offer->caption}}">
                    <div class="carousel-caption d-none d-md-block">
                        <a class="link-light text-light" href="{{$offer->offer_url}}"><h5 class="h2">{{$offer->caption}}</h5>
                        <p></p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="row">
        <div class="col-lg-6 col-12 mt-2">
            <div class="card">
                <img class="card-img-top" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQnLI4KWWrjcwbN4ahRP01gb-Jni_Bd68Uz8w&usqp=CAU" alt="Card image cap">
                <div class="card-body bg-master">
                    <h5 class="card-title">الشقق</h5>
                    <p class="card-text">شركة بكر صبر العقارية توفر مجموعة متنوعة من الشقق المتاحة للإيجار في المدينة المنورة بدءاً من الشقق الفاخرة والمفروشة بالكامل إلى الشقق العائلية الواسعة </p>
                    <a href="/apartments" class="btn btn-primary">عرض الكل</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12 mt-2">
            <div class="card">
                <img class="card-img-top" src="https://cf.bstatic.com/xdata/images/hotel/square600/293738695.jpg?k=a6117afbb3ce08ea7202d6c846c9679872f3f028e48b62b994e1040cff5a97cf&o" alt="Card image cap">
                <div class="card-body bg-master">
                    <h5 class="card-title">العمائر</h5>
                    <p class="card-text">شركة بكر صبر العقارية توفر مجموعة متنوعة من العمائر للإيجار في المدينة المنورة بما في ذلك المباني السكنية والتجارية مع تصاميم حديثة ومؤافق متكاملة وأسعار منافسة</p>
                    <a href="/buildings" class="btn btn-primary">عرض الكل</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-6 col-12 mt-4">
            <h2 class="text-center">شركة بكر صبر العقارية</h2>
            <p class="text-right">
                يسعدنا أن نرحب بكم في شركة بكر صبر العقارية حيث نتشرف بتقديم خدمات عالية الجودة في مجال تأجير العمائر والشقق في المدينة المنورة ونلتزم بتقديم خدمات متميزة وفق أعلى معايير الاحترافية لأننا نحن ندرك أهمية العقارات في حياة الأفراد والشركات نسعى جاهدين لتلبية توقعات العملاء وتحقيق رضاهم التام نفتخر بتاريخنا الحافل بالنجاحات والتفاني في خدمة عملائنا ونتطلع للعمل معكم لتحقيق أهدافكم العقارية وتلبية احتياجاتكم بشكل مثالي
            </p>
        </div>

        <div class="col-lg-6 col-12 mt-4">
            <div class="container no-border-bottom no-border-top pr-0 pl-0 pb-3 pt-3">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3631.0607492108375!2d39.64452240000001!3d24.4833519!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15bdbf6357801ae5%3A0xec6720becb37a11f!2z2YXZg9iq2Kgg2KjZg9ixINi12KjYsQ!5e0!3m2!1sar!2ssa!4v1709715392876!5m2!1sar!2ssa"
                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    $("body").css("backgroundColor","#fff");
@endsection
