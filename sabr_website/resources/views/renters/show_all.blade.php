@extends('layouts.auth_master')
@section('title', 'استعراض المستأجرين')
@section('content')
<div class="background">
</div>
<div class="row justify-content-center">
    <div class="col-md-6 col-12 cus-input">
        <input type="text" placeholder="ابحث عن مستأجر" title="اكتب جزء من الاسم أو رقم الهوية أو رقم الإقامة أو رقم الجوال للبحث" name="search" id="search" />
    </div>
    <div class="col-md-auto col-12 text-right">
        <button class="btn btn-info px-5 py-4" id="search_btn">بحث</button>
    </div>
</div>
@isset($renters)
<div class="row my-5" id="renters">
    @foreach($renters as $renter)
        <div class="col-lg-3 col-md-6 col-12 text-center">
            <a href="/renter/{{$renter->id}}" class="pri-color">
                <i class="fas fa-user fa-5x d-block"></i>
                <p class="w-100 text-center h5 mt-3">{{$renter->name}}</p>
            </a>
        </div>
    @endforeach
</div>
@endisset
@endsection