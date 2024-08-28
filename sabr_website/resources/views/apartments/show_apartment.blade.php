@extends('layouts.auth_master')
@isset($apartment)
    @section('title', $apartment->name)
@endif
@section('content')
<div class="background">
</div>
<div class="row animate__animated d-none" id="edit">
    <div class="col background show">
        <div class="edit animate__animated">
        </div>
    </div>
</div>
<div class="row pt-2">
    @auth()
    @else <p class="w-100 text-center txt-master">عزيزي الزائر يتوجب عليك التسجيل أو تسجيل الدخول للاطلاع على معلومات الاستئجار</p>
    @endauth
    @isset($apartment)
        <div class="col text-right txt-master">
            <div class="row">
                <div class="col-auto pl-0">
                    <i class="fas fa-building" style="font-size: 12rem"></i>
                    <span class="circle"  style="background-color:
                            @if($apartment->contract()->count() > 0)
                                @if($apartment->contract->is_avialable($apartment->id)) green
                                @else red
                                @endif
                            @else green
                            @endif
                                "></span>
                </div>
                <div class="col-auto">
                    <p class="h2" id="name">{{$apartment->name}}</p>
                    <p class="txt-slave" id="description">{{$apartment->description}}</p>
                    <p class="txt-slave" id="rent_val">قيمة الايجار: <span class="txt-master" >{{$apartment->rent_val}}</span></p>
                    <p class="txt-slave" id="floor_number">رقم الدور: <span class="txt-master" >{{$apartment->floor_number}}</span></p>
                    <p class="txt-slave" id="room_number">عدد الغرف: <span class="txt-master" >{{$apartment->room_number}}</p>
                    <p class="txt-slave" id="electric_id">رقم حساب عداد الكهرباء: <span class="txt-master" >{{$apartment->electric_id}}</p>
                </div>
                <div class="col text-left">
                    <input type="hidden" id="apartment_name" value="{{$apartment->name}}" />
                    <input type="hidden" id="apartment_rent_val" value="{{$apartment->rent_val}}" />
                    <input type="hidden" id="apartment_description" value="{{$apartment->description}}" />
                    <input type="hidden" id="apartment_floor_number" value="{{$apartment->floor_number}}" />
                    <input type="hidden" id="apartment_room_number" value="{{$apartment->room_number}}" />
                    <input type="hidden" id="apartment_electric_id" value="{{$apartment->electric_id}}" />
                    @auth()
                        @if(Auth()->User()->hasAnyRole(["admin","employee"]))
                            <button type="button" class="btn btn-outline-warning"
                                onclick="show_edit()">
                                تحرير</button>
                            @if(!$apartment->is_avialable())
                                <button type="button" class="btn btn-outline-info"
                                    onclick="change_renter({{$apartment->contract->id}},'{{$apartment->name}}')">
                                    تغيير المستأجر</button>
                                @auth()
                                    @if(Auth()->User()->hasRole("admin"))
                                        <button type="button" class="btn btn-danger"
                                            onclick="emptying({{$apartment->id}})">
                                            إخلاء</button>
                                    @endif
                                @endauth
                            @endif
                        @endif
                    @endauth
                    @if($apartment->is_avialable())
                        @auth()
                            <a href="/contract/{{Auth()->User()->id_num}}/{{$apartment->id}}" class="btn btn-outline-success">
                            استئجار</a>
                            @if(Auth()->User()->hasRole("user"))
                                <a href="/book_appointment/apartment/{{$apartment->id}}" class="btn btn-outline-primary">
                                حجز موعد</a>
                            @endif
                        @endauth
                    @else
                        @if (DB::table("contracts")
                            ->where("apartment_id",$apartment->id)
                            ->whereActive(1)->first()->renter_id == Auth()->User()->renter->id)
                            <a href="/request/apartment/{{$apartment->id}}" class="btn btn-outline-success"
                                >
                                طلب صيانة</a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h3>معرض الصور</h3>
                    @if(count($files) > 0)
                        <div class="row" id="files_img">
                            @foreach ($files as $i=>$file)
                                <div class="col-lg-6 col-12 p-2">
                                    <img src="{{$file}}" alt="imge{{$i+1}}" class="rounded img-thumbnail img{{$i+1}}" />
                                    @if(Auth()->User()->hasAnyRole(["admin","employee"]))
                                        <i class="fas fa-trash-alt del-img" title="حذف الصورة" onclick="delete_img({{$apartment->id}},'img{{$i+1}}')"></i>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else <p>لا يوجد صور متاحة</p>
                    @endif
                </div>
            </div>
            <div class="row">
                @auth()
                    @if(Auth()->User()->hasAnyRole(["admin","employee"]))
                        @if($apartment->contract()->count() > 0)
                            @if(!$apartment->contract->is_avialable($apartment->id))
                                <div class="col-12 mt-5">
                                    <p>بيانات المستأجر</p>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <p class="txt-slave text-center">الاسم</p>
                                    <p class="text-center">{{$apartment->contract->renter->name}}</p>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <p class="txt-slave text-center">رقم الهوية الوطنية / رقم هوية مقيم</p>
                                    <p class="text-center">{{$apartment->contract->renter->id_number}}</p>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <p class="txt-slave text-center">رقم الجوال</p>
                                    <p class="text-center">{{$apartment->contract->renter->phone_number}}</p>
                                </div>

                                <div class="col-12 mt-5">
                                    <p>بيانات العقد</p>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <p class="txt-slave text-center">تاريخ بداية العقد</p>
                                    <p class="text-center">{{Carbon\Carbon::parse($apartment->contract->hijri_start_date)->format('Y-m-d')}}</p>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <p class="txt-slave text-center">الموافق</p>
                                    <p class="text-center">{{Carbon\Carbon::parse($apartment->contract->start_date)->format('Y-m-d')}}</p>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <p class="txt-slave text-center">تاريخ نهاية العقد</p>
                                    <p class="text-center">{{Carbon\Carbon::parse($apartment->contract->hijri_end_date)->format('Y-m-d')}}</p>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <p class="txt-slave text-center">الموافق</p>
                                    <p class="text-center">{{Carbon\Carbon::parse($apartment->contract->end_date)->format('Y-m-d')}}</p>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <p class="txt-slave text-center">مدة العقد</p>
                                    <p class="text-center">{{$apartment->contract->rent_duration}} {{$apartment->contract->rent_unit}}</p>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <p class="txt-slave text-center">قيمة العقد</p>
                                    <p class="text-center balance">{{number_format($apartment->contract->rent_amount)}}</p>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <p class="txt-slave text-center">المتبقي</p>
                                    <p class="text-center balance">{{number_format($apartment->contract->remaining())}}</p>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <p class="txt-slave text-center">التفاصيل</p>
                                    <p class="text-center"><a href="/contract/{{$apartment->contract->id}}">انقر هنا</a></p>
                                </div>
                            @endif
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    @endif
</div>

@endsection
