@extends('layouts.auth_master')
@section('title', 'إضافة عرض')
@section('content')
<div class="col background">

</div>
    <div class="row justify-content-center">
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 cus-input">
            <label for="caption" class="float-right">
                عنوان العرض
            </label>
            <input type="text" placeholder="عنوان العرض" title="عنوان العرض" name="caption" id="caption" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 cus-input">
            <label for="offer_img" class="float-right">
                *صورة العرض
            </label>
            <input type="file" class="custom-file-input" name="offer_img" id="offer_img" accept="image/*">
            <label class="custom-file-label" for="offer_img" style="margin-top:45px;">اختر صورة العرض</label>
            {{-- <input type="text" placeholder="صورة العرض" title="صورة العرض" name="offer_img" id="offer_img" /> --}}
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 cus-input">
            <label for="description" class="float-right">
                وصف العرض
            </label>
            <input type="text" placeholder="وصف العرض" title="وصف العرض" name="description" id="description" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 cus-input">
            <label for="offer_url" class="float-right">
                رابط العرض
            </label>
            <input type="text" placeholder="رابط العرض" title="رابط العرض" name="offer_url" id="offer_url" />
        </div>
        {{-- <div class="col d-flex flex-wrap align-items-center mt-4 ml-3 col-12">
            <div class="col-auto m-auto input-toggle">
                <label for="active" class="ml-3">تفعيل العرض</label>
                <input type="checkbox" id="active" class="form-check-input"
                    name="active" value=""
                    data-toggle="toggle" data-change="true"
                    data-onstyle="success" data-offstyle="danger"
                    data-style="slow" data-size="lg" onchange="" checked/>
            </div>
        </div> --}}
    </div>
    <div class="row m-4">
        <div class="col-lg-6 col-12 m-auto text-center">
           <button type="button" class="btn btn-success" onclick="add_offer();">إضافة</button>
        </div>
    </div>
@endsection
