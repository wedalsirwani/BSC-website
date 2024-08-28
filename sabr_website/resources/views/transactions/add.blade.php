@extends('layouts.auth_master')
@section('title', 'تحرير سند قبض')
@section('content')
<div class="row">
    <div class="col-lg-6 col-12 ml-auto mr-auto mt-3 cus-input">
        <label for="renter" class="float-right">
            * اختر المستأجر
        </label>
        <select class="selectpicker w-100" title="اختر المستأجر" id="renter" data-live-search="true" data-actions-box="true" data-size="5"
            @if($contract != null) disabled @endif>
            @foreach ($renters as $renter)
                <option value="{{$renter->id}}"
                    @if($contract != null)
                        @if($renter->id == $contract->renter_id)
                            selected
                        @endif
                    @endif
                    >{{$renter->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-12 ml-auto mr-auto mt-3 cus-input">
        <label for="apartment" class="float-right">
            * اختر الشقة
        </label>
        <select class="selectpicker w-100" title="اختر الشقة" id="apartment" data-live-search="true" data-actions-box="true"
            @if($contract != null) disabled @endif>
            @if($contract != null)<option value="{{$contract->apartment->id}}" selected>{{$contract->apartment->building->name}} - {{$contract->apartment->name}}</option>
            @endif
        </select>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-12 ml-auto mr-auto mt-3 cus-input">
        <label for="amount" class="float-right">
            <i class="fas fa-dollar-sign txt-master"></i>
        </label>
        <input type="tel" placeholder="مبلغ الدفعة" title="مبلغ الدفعة" name="amount" id="amount" />
    </div>
</div>
<div class="row mt-3">
    <div class="col-lg-6 col-12 ml-auto mr-auto">
        <div class="row">
            <div class="col-md-7 ml-md-4 col-12 ml-auto mr-auto cus-input">
                <label for="h_transaction_date" class="float-right">
                    <i class="far fa-calendar-alt txt-master"></i>
                </label>
                <input type="text" class="hijri-date-input" placeholder="تاريخ الدفعة" title="تاريخ الدفعة" name="h_transaction_date" id="h_transaction_date" />
            </div>
            <div class="col-md col-12 mt-md-0 mt-4 ml-auto mr-auto cus-input">
                <label for="transaction_date" class="float-right">
                    <i class="far fa-calendar-alt txt-master"></i>
                </label>
                <input type="text" placeholder="الموافق" title="الموافق" name="transaction_date" readonly id="transaction_date" />
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-12 ml-auto mr-auto mt-3 cus-input">
        <label for="description" class="float-right">
            <i class="fas fa-info txt-master"></i>
        </label>
        <input type="text" placeholder="بيان الدفعة" title="بيان الدفعة" name="description" id="description" />
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-12 ml-auto mr-auto mt-3 cus-input">
    <label for="received_by" class="float-right">
        <i class="fas fa-wallet txt-master ml-3"></i> استلمت
    </label>
    <select class="selectpicker w-100" title="استلمت" id="received_by">
        <option value="cach">كاش</option>
        <option value="transfer">تحويل</option>
        <option value="check">شيك</option>
    </select>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-12 ml-auto mr-auto mt-3 cus-input">
        <label for="notes" class="float-right">
            <i class="far fa-sticky-note txt-master"></i>
        </label>
        <input type="text" placeholder="ملاحظات" title="ملاحظات" name="notes" id="notes" readonly onfocus="this.removeAttribute('readonly');"
 />
    </div>
</div>
<div class="row mt-3">
    <div class="col-lg-6 col-12 text-center ml-auto mr-auto p-0">
        <button type="button" class="btn btn-gold col p-3 mb-5" id="add_transaction_btn" >حفظ</button>
    </div>
</div>
<div class="background">
</div>
@endsection
@section('scripts')

<script>
</script>
@endsection