@extends('layouts.public-master')
@section('title', 'تسجيل الدخول')
@section('content')
    <div class="container mt-5" id="container">
        @csrf
            <h1 class="text-center mt-5"><span class="txt-master">أهلاً بك</span> في {{ config('app.name') }} </h1>
            <div class=" mb-5 pb-5"></div>
            <div class="row m-4">
                <div class="col-lg-6 col-12 ml-auto mr-auto border-b">
                    <label for="email" class="float-right">
                        <svg width="2.5rem" height="2.5rem" viewBox="0 0 16 16" class="bi bi-person-fill txt-master" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                    </label>
                    <input type="email" id="email" class="mt-1" placeholder="example@example.com" />
                </div>
            </div>
            <div class="row m-4">
                <div class="col-lg-6 col ml-auto mr-auto border-b">
                    <label for="password" class="float-right">
                        <svg width="2.5rem" height="2.5rem" viewBox="0 0 16 16" class="bi bi-lock-fill txt-master" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.5 9a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2V9z"/>
                            <path fill-rule="evenodd" d="M4.5 4a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/>
                        </svg>
                    </label>
                    <input type="password" id="password" class="mt-2" placeholder="****************" />
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6 col-12 ml-auto mr-auto">
                    <div class="row p-3">
                        <button class="btn btn-gold col-lg-7 col-12" id="login_btn">تسجيل الدخول</button>
                        <a class="btn btn-slave col-12 col-lg mr-lg-3 mr-0 mt-lg-0 mt-3" href="/register">تسجيل</a>
                        <a href="{{route('reset')}}" class="col-12 mt-2 text-right sec-color">نسيت كلمة المرور؟</a>
                    </div>
                </div>
            </div>
    </div>
@endsection
