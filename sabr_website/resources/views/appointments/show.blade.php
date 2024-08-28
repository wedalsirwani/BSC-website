@extends('layouts.auth_master')
@section('title', "المواعيد")
@section('content')
<div class="background">
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center w-100">عزيزي {{Auth()->User()->name}} لديك المواعيد التالية</h3>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>م</th>
                        <th>اسم المستخدم</th>
                        <th>رقم الجوال</th>
                        <th>الحي</th>
                        <th>العمارة</th>
                        <th>الشقة</th>
                        <th>تاريخ ووقت الموعد</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $index => $appointment)
                        <tr>
                            <td>{{++$index}}</td>
                            <td>{{$appointment->user->name}}</td>
                            <td>{{$appointment->user->renter->phone_number}}</td>
                            <td>{{$appointment->apartment->building->distract->name}}</td>
                            <td>{{$appointment->apartment->building->name}}</td>
                            <td>{{$appointment->apartment->name}}</td>
                            <td>{{explode(" " ,$appointment->date)[0]}} الساعة {{explode(" " ,$appointment->date)[1]}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
