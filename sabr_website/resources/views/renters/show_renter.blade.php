@extends('layouts.auth_master')
@section('title', 'بيانات المستأجر')
@section('content')
<div class="background">
</div>
@isset($renter)
<div class="row m-4">
    <div class="col-auto">
        <i class="fas fa-user fa-7x d-block border pri-color p-2 rounded"></i>
    </div>
    <div class="col text-left">
        <button type="button" class="btn btn-outline-warning"
            onclick="show_edit()">
            تحرير</button>
        @if($renter->contracts->count() > 0)
            <a class="btn btn-outline-info" href="/summary/renter/{{$renter->id}}" target="_blank">
            كشف حساب {{$renter->name}}
            </a>
        @endif
    </div>
    <div class="container mt-3">
        <div class="row m-1">
            <div class="col-auto pl-0 text-right">
                <p class="h4">الاسم:</p>
            </div>
            <div class="col">
                <input type="text" class="form-control" id="name" value="{{$renter->name}}" disabled />
            </div>
        </div>
        <div class="row m-1">
            <div class="col-auto pl-0 text-right">
                <p class="h4">رقم الهوية:</p>
            </div>
            <div class="col">
                <input type="text" class="form-control" id="id_number" value="{{$renter->id_number}}" disabled />
            </div>
        </div>
        <div class="row m-1">
            <div class="col-auto pl-0 text-right">
                <p class="h4">رقم الجوال:</p>
            </div>
            <div class="col">
                <input type="text" class="form-control" id="phone_number" value="{{$renter->phone_number}}" disabled />
            </div>
        </div>
        <div class="row mt-3" id="controll">

        </div>

        <div class="row txt-master">
            @foreach($renter->contracts as $contract)
                <div class="col-12 balance text-center mt-5">
                    <div class="row">
                        <div class="col">العقد رقم {{$contract->id}} /
                            <a href="/building/{{$contract->apartment->building->id}}" class="txt-master" target="_blank">
                                {{$contract->apartment->building->name}}
                            </a> -
                            <a href="/apartment/{{$contract->apartment->id}}" class="txt-master" target="_blank">
                                {{$contract->apartment->name}}
                            </a>
                        </div>
                        <div class="col-auto text-left">
                            <button type="button" class="btn btn-outline-warning" onclick="show_edit_date({{$contract->id}})">
                            تحرير تواريخ العقد</button>
                            <a href="/add_transaction/contract/{{$contract->id}}" class="btn btn-outline-success">
                            إضافة دفعة</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <p class="txt-slave text-center">تاريخ بداية العقد</p>
                    <p class="text-center">{{Carbon\Carbon::parse($contract->hijri_start_date)->format('Y-m-d')}}</p>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <p class="txt-slave text-center">الموافق</p>
                    <p class="text-center">{{Carbon\Carbon::parse($contract->start_date)->format('Y-m-d')}}</p>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <p class="txt-slave text-center">تاريخ نهاية العقد</p>
                    <p class="text-center">{{Carbon\Carbon::parse($contract->hijri_end_date)->format('Y-m-d')}}</p>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <p class="txt-slave text-center">الموافق</p>
                    <p class="text-center">{{Carbon\Carbon::parse($contract->end_date)->format('Y-m-d')}}</p>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <p class="txt-slave text-center">مدة العقد</p>
                    <p class="text-center">{{$contract->rent_duration}} {{$contract->rent_unit}}</p>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <p class="txt-slave text-center">قيمة العقد</p>
                    <p class="text-center balance">{{number_format($contract->rent_amount)}}</p>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <p class="txt-slave text-center">المتبقي</p>
                    <p class="text-center balance">{{number_format($contract->remaining())}}</p>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <p class="txt-slave text-center">التفاصيل</p>
                    <p class="text-center"><a href="/contract/{{$contract->id}}">انقر هنا</a></p>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endisset
@endsection
