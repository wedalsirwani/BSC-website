@extends('layouts.public-master')
@section('title', 'التسجيل')
@section('content')
        <div class="container mt-5" id="container">
            @csrf
            <h3 class="text-center txt-master">أهلا بك عزيزي</h3>
            <div class="text-center mt-3">
                <p class="font-1-5-rem">الرجاء التسجيل وانتظار موافقة إدارة الموقع</p>
            </div><div class="row justify-content-center">
                <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 border-b">
                    <label for="name" class="float-right">
                        <i class="far fa-user fa-2x txt-master"></i>
                    </label>
                    <input type="text" id="name" class="" placeholder="الاسم" autocomplete="off"/>
                </div>
                <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 border-b">
                    <label for="sex" class="float-right">
                        <i class="fas fa-venus-mars fa-2x txt-master"></i>
                    </label>
                    <select class="selectpicker my-select" title="الجنس" name="sex" id="sex" >
                        <option value="1">ذكر</option>
                        <option value="0">أنثى</option>
                    </select>
                </div>
                <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 border-b">
                    <label for="social_status" class="float-right">
                        <i class="far fa-question-circle fa-2x txt-master"></i>
                    </label>
                    <select class="selectpicker my-select" title="الحالة الاجتماعية" name="social_status" id="social_status" >
                        <option value="0">أعزب</option>
                        <option value="1">متزوج</option>
                    </select>
                </div>
                <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 border-b">
                    <label for="ID" class="float-right">
                        <i class="fas fa-id-card fa-2x txt-master"></i>
                    </label>
                    <input type="text" id="ID" placeholder="رقم الهوية" />
                    <div id="ID_result" class="badge badge-warning text-center mt-2 mb-3 p-2 d-none"
                    ></div>
                </div>
                <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 border-b">
                    <label for="mobile_phone" class="float-right">
                        <i class="fas fa-mobile-alt fa-2x txt-master"></i>
                    </label>
                    <input type="tel" maxlength="10" id="mobile_phone" placeholder="الهاتف الجوال" />
                    <div id="mobile_phone_result" class="badge badge-warning text-center mt-2 mb-3 p-2 d-none"
                    ></div>
                </div>
                <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 border-b">
                    <label for="email" class="float-right">
                        <i class="fas fa-at fa-2x txt-master"></i>
                    </label>
                    <input type="email" id="email" placeholder="البريد الالكتروني" />
                    <div id="email_result" class="badge badge-warning text-center mt-2 mb-3 p-2 d-none"
                    ></div>
                </div>
                <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 border-b">
                    <label for="bank" class="float-right">
                        <i class="fas fa-building fa-2x txt-master"></i>
                    </label>
                    <select class="selectpicker my-select" title="اسم البنك" name="bank" id="bank" data-live-search="true" >
                        @foreach (App\Http\Controllers\bank_controller::all() as $bank)
                            <option value={{$bank->id}}>{{$bank->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 border-b">
                    <label for="account" class="float-right">
                        <i class="fas fa-money-check-alt fa-2x txt-master"></i>
                    </label>
                    <input type="text" id="account" placeholder="الحساب البنكي" />
                    <div id="account_result" class="badge badge-warning text-center mt-2 mb-3 p-2 d-none"
                    ></div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-6 text-center ml-auto mr-auto">
                    <button type="button" class="btn btn-gold col" id="register_btn" onclick="save_user();" >إرسال</button>
                </div>
            </div>
            <div class="col text-center ml-auto mr-auto" style="margin-bottom: 100px">
               <a class="text-light" href="/login"> لديك حساب ؟ سجل الدخول</a>
            </div>
            <div class="background">
            </div>
        </div>
@endsection
