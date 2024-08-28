@extends('layouts.public-master')
@section('title', 'إعادة تعيين كلمة المرور')
@section('content')
    @csrf
    <div class="container" id="container">
        <div class="row mt-5">
            <h3 class="mt-5 w-100 text-center color-master font-bold">الرجاء تسجيل البريد الالكتروني لإرسال بريد إعادة تعيين كلمة المرور</h3>
            <div class="col-lg-6 col-10 ml-auto mr-auto mt-2 border-b">
                <label for="email" class="float-right">
                    <svg width="2.5rem" height="2.5rem" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                </label>
                <input type="email" id="email" name="email" autocomplete="off"
                    class="" title="البريد الالكتروني"
                    placeholder="example@example.com"/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12 text-center mt-3 ml-auto mr-auto">
                <button type="button" class="btn btn-gold" id="reset_btn">إرسال</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12 text-center ml-auto mr-auto mt-3">
                <div id="result" class="alert alert-success d-none">
                </div>
            </div>
        </div>
        <div class="background">
        </div>
    </div>
@endsection
