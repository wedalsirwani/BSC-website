@extends('layouts.public-master')
@section('title', 'تعيين كلمة المرور')
@section('content')
    <div class="container" id="container">
        @csrf
        @isset($name)
        <input type="hidden" id="email" value="{{$email}}" />
        <div class="col-lg-6 col-12 ml-auto mr-auto mt-5">
            <h3 class="text-center">أهلاً وسهلاً بك يا <span class="txt-master">{{$name}}</span></h3>
            <div class="text-center mt-3">
                <p>نأمل أن تكون بصحة وعافية الرجاء تعيين كلمة المرور للمتابعة</p>
            </div>
            <div class="row m-4">
                <div class="col-12 ml-auto mr-auto mt-3 cus-input">
                    <label for="amount" class="float-right">
                    <i class="fas fa-key txt-master"></i>
                    </label>
                    <input type="password" class="form-control text-center" id="password" placeholder="أدخل كلمة المرور تكرماً" />
                    <div id="pwd_error" class="d-none alert alert-danger mt-2"></div>
                </div>
            </div>
            
            <div class="row m-4">
                <div class="col-12 ml-auto mr-auto mt-3 cus-input">
                    <label for="amount" class="float-right">
                    <i class="fas fa-key txt-master"></i>
                    </label>
                    <input type="password" class="form-control text-center" id="re_password" placeholder="أدخل تأكيد كلمة المرور تكرماً" />
                    <div id="re_pwd_error" class="d-none alert alert-danger mt-2"></div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-center ml-auto mr-auto">
                    <button type="button" class="btn btn-gold" id="set_pwd_btn" disabled >متابعة</button>
                </div>
            </div>
            @endif
            <div class="background">
            </div>
            @isset($error)
                <div class="alert alert-danger m-auto text-center">
                    {{ $error }}<br/>
                </div>
            @endif
        </div>
    </div>
@endsection
