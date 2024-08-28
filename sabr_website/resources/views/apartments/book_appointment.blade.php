@extends('layouts.auth_master')
@section('header')
    {{-- <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet"> --}}
	{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
	{{-- <link rel="stylesheet" href="{{ URL::asset('css/style.css')}}"> --}}
@endsection
@isset($apartment)
    @section('title', $apartment->name)
@endif
@section('content')
<div class="background">
</div>
<section class="ftco-section0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-3">
                <h2 class="heading-section">حجز موعد</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-6 d-flex justify-content-center">
                    @if(count($files) > 0)
                        <div class="row">
                            @foreach ($files as $i=>$file)
                                <div class="col-lg-6 col-12 p-2">
                                    <img src="{{$file}}" alt="imge{{$i+1}}" class="rounded img-thumbnail" />
                                </div>
                            @endforeach
                        </div>
                    @else <p>لا يوجد صور متاحة</p>
                    @endif
            </div>
            <div class="col-6">
                <div class="calendar calendar-first" id="calendar_first">
                <div class="calendar_header">
                    <button class="switch-month switch-left"> <i class="fa fa-chevron-left"></i></button>
                     <h2></h2>
                    <button class="switch-month switch-right"> <i class="fa fa-chevron-right"></i></button>
                </div>
                <div class="calendar_weekdays"></div>
                <div class="calendar_content"></div>
                </div>
            </div>
            <div class="col-auto text-right">
                <p class="h2" id="name">{{$apartment->name}}</p>
                <p class="txt-slave" id="description">{{$apartment->description}}</p>
                <p class="txt-slave" id="rent_val">قيمة الايجار: <span class="txt-master" >{{$apartment->rent_val}}</span></p>
                <p class="txt-slave" id="floor_number">رقم الدور: <span class="txt-master" >{{$apartment->floor_number}}</span></p>
                <p class="txt-slave" id="room_number">عدد الغرف: <span class="txt-master" >{{$apartment->room_number}}</p>
                <p class="txt-slave" id="electric_id">رقم حساب عداد الكهرباء: <span class="txt-master" >{{$apartment->electric_id}}</p>
                <p class="txt-slave" id="distract">الحي: <span class="txt-master" >{{$apartment->building->distract->name}}</p>
            </div>
            <div class="col text-right">
                <p>اضغط على الوقت لحجز الموعد</p>
                <div class="btn btn-primary">الأوقات</div>
                <div class="btn times btn-secondary" onclick="select_this(this);">9:00</div>
                <div class="btn times btn-secondary" onclick="select_this(this);">9:30</div>
                <div class="btn times btn-secondary" onclick="select_this(this);">10:00</div>
                <div class="btn times btn-secondary" onclick="select_this(this);">10:30</div>
                <div class="btn times btn-secondary" onclick="select_this(this);">11:00</div>
                <div class="btn times btn-secondary" onclick="select_this(this);">11:30</div>
                <div class="btn times btn-secondary" onclick="select_this(this);">12:00</div>
                <div class="btn times btn-secondary" onclick="select_this(this);">12:30</div>
                <input type="hidden" name="selected_date" id="selected_date" />
                <input type="hidden" name="apartment_id" id="apartment_id" value="{{$apartment->id}}" />
                <button class="btn btn-primary" onclick="book_appointment();">حجز الموعد</button>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    {{-- <script src="{{ URL::asset('js/jquery.min.js')}}"></script> --}}
    <script src="{{ URL::asset('js/popper.js')}}"></script>
    {{-- <script src="{{ URL::asset('js/bootstrap.min.js')}}"></script> --}}
    <script src="{{ URL::asset('js/main.js')}}"></script>
@endsection
