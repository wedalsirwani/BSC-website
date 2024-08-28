@extends('layouts.auth_master')
@section('title', "طلبات الصيانة")
@section('content')
<div class="background">
</div>
<div class="container-fluid text-center">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center w-100">عزيزي {{Auth()->User()->name}} لديك الطلبات التالية</h3>
            <table class="table table-responsive table-striped text-center">
                <thead>
                    <tr>
                        <th>م</th>
                        <th>اسم المستخدم</th>
                        <th>رقم الجوال</th>
                        <th>الحي</th>
                        <th>العمارة</th>
                        <th>الشقة</th>
                        <th>الوصف</th>
                        <th>نوع الطلب</th>
                        <th>حالة الطلب</th>
                        <th>تاريخ ووقت الموعد</th>
                        @if(!Auth()->User()->hasRole("user"))
                            <th>أدوات التحكم</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $index => $request)
                        <tr>
                            <td>{{++$index}}</td>
                            <td>{{$request->user->name}}</td>
                            <td>{{$request->user->renter->phone_number}}</td>
                            <td>{{$request->apartment->building->distract->name}}</td>
                            <td>{{$request->apartment->building->name}}</td>
                            <td>{{$request->apartment->name}}</td>
                            <td>{{$request->request_description}}</td>
                            <td>{{$request->request_type}}</td>
                            <td>{{$request->request_status}}</td>
                            <td>{{explode(" " ,$request->date)[0]}} الساعة {{explode(" " ,$request->date)[1]}}</td>
                            @if(!Auth()->User()->hasRole("user"))
                                <td><button class="btn btn-success" onclick="complate_request(this ,{{$request->id}})" style="color:#000;">انهاء الطلب</button></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
