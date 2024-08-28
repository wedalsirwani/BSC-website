@extends('layouts.auth_master')
@section('title', 'دفع عقد إيجار')
@section('content')
    <div class="background">
    </div>
    <div class="row">
        <div class="col">
            <p class="h6 text-right">{{$message}}</p>
            <div class="">
                <input type="hidden" name="contract_id" id="contract_id" value="{{$id}}">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-12 d-flex flex-wrap mt-3 cus-input">
                        <label for="card-number" class="float-right">
                            * رقم البطاقة
                        </label>
                        <input type="text" class="text-center" placeholder="رقم البطاقة" title="رقم البطاقة"
                            name="card-number" id="card-number" value=""
                            readonly onfocus="this.removeAttribute('readonly');"/>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-6 d-flex flex-wrap mt-3 cus-input">
                        <label for="card-expiry" class="float-right">
                            * تاريخ الانتهاء
                        </label>
                        <input type="text" class="text-center" placeholder="تاريخ الانتهاء" title="تاريخ الانتهاء"
                            name="card-expiry" id="card-expiry" value=""
                            readonly onfocus="this.removeAttribute('readonly');"/>
                    </div>
                    <div class="col-lg-3 col-6 d-flex flex-wrap mt-3 cus-input">
                        <label for="cvv" class="float-right">
                            * CVV رقم
                        </label>
                        <input type="text" class="text-center" placeholder="CVV" title="CVV"
                            name="cvv" id="cvv" value=""
                            readonly onfocus="this.removeAttribute('readonly');"/>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-6 mt-3">
                        <button id="pay_btn" class="w-100 btn btn-success">دفع الإيجار</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
