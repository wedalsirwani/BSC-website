@extends('layouts.auth_master')
@section('title', 'كشف حساب')
@section('content')
<div class="background">
</div>
<div class="row m-4">
    <div class="col-lg-6 col-12 ml-auto mr-auto mt-3 cus-input">
        <label for="renter" class="float-right">
            * المستأجر
        </label>
        <select class="selectpicker w-100" title="المستأجر" id="renter" data-live-search="true"
            data-actions-box="true" onchange="renter_changed();">
            <option value="">اختر المستأجر</option>
            @foreach ($renters as $renter)
                <option value="{{$renter->id}}">{{$renter->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 ml-auto mr-auto mt-3 text-center">
        <a href="#" class="btn btn-info" id="summary" target="_blank">
            كشف حساب
        </a>
    </div>
</div>
<div class="row">
    <div class="col">

    </div>
</div>
@endsection
