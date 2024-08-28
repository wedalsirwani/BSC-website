@extends('layouts.auth_master')
@section('title', 'رفع طلب')
@section('content')
<div class="background">
</div>
<div class="container">
    <div class="row">
        <div class="clo-12">
            <section class="ftco-section0">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center mb-3">
                            <h2 class="heading-section">طلب صيانة</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex justify-content-center">
                            <div class="col-auto text-right">
                                <p class="h2" id="name">{{$apartment->name}}</p>
                                <p class="txt-slave" id="description">{{$apartment->description}}</p>
                                <p class="txt-slave" id="rent_val">قيمة الايجار: <span class="txt-master" >{{$apartment->rent_val}}</span></p>
                                <p class="txt-slave" id="floor_number">رقم الدور: <span class="txt-master" >{{$apartment->floor_number}}</span></p>
                                <p class="txt-slave" id="room_number">عدد الغرف: <span class="txt-master" >{{$apartment->room_number}}</p>
                                <p class="txt-slave" id="electric_id">رقم حساب عداد الكهرباء: <span class="txt-master" >{{$apartment->electric_id}}</p>
                                <p class="txt-slave" id="distract">الحي: <span class="txt-master" >{{$apartment->building->distract->name}}</p>
                            </div>
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
                        <div class="col text-center mt-2">
                            <p>اضغط على الوقت المناسب لطلب الصانة</p>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-right">
                            <p>نوع الطلب المرفوع</p>
                            <label>
                                <input type="radio" name="request_type" id="eletrical" value="eletrical">
                                    خدمات كهربائية
                            </label>
                            <label>
                            <input type="radio" name="request_type" id="plumbing" value="plumbing">
                            خدمات سباكة</label>

                            <label>
                            <input type="radio" name="request_type" id="move" value="move">
                            نقل أثاث</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-right cus-input">
                            <label for="request_description" class="float-right">
                                التفاصيل
                            </label>
                            <input type="text" placeholder="اكتب وصف الطلب" title="التفاصيل" name="request_description" id="request_description"
                                readonly onfocus="this.removeAttribute('readonly');" autocomplete="off" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center mt-4">
                            <button class="btn btn-primary" onclick="request_maintanance();">ارفع طلب الصيانة</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- <script src="{{ URL::asset('js/jquery.min.js')}}"></script> --}}
    <script src="{{ URL::asset('js/popper.js')}}"></script>
    {{-- <script src="{{ URL::asset('js/bootstrap.min.js')}}"></script> --}}
    <script src="{{ URL::asset('js/main.js')}}"></script>
@endsection
