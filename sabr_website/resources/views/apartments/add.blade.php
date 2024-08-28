@extends('layouts.auth_master')
@section('title', 'إضافة شقة')
@section('content')
<div class="background">
</div>

    <div class="row justify-content-center">
        <div class="col-lg-4 col-12 d-flex flex-wrap  ml-3 mt-3 cus-input">
            <label for="buildings" class="float-right">
                * اختر العمارة
            </label>
            <select class="selectpicker w-100" title="اختر العمارة" id="buildings" data-live-search="true" data-actions-box="true">
                @foreach ($buildings as $building)
                    <option value="{{$building->id}}">{{$building->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap  ml-3 mt-3 cus-input">
            <label for="name" class="float-right">
                * اسم الشقة
            </label>
            <input type="text" placeholder="اكتب اسم الشقة" title="اسم الشقة" name="name" id="name" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap  ml-3 mt-3 cus-input">
            <label for="description" class="float-right">
                وصف الشقة
            </label>
            <input type="text" placeholder="اكتب وصف الشقة" title="وصف الشقة" name="description" id="description" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap   ml-3 mt-3 cus-input">
            <label for="floor_number" class="float-right">
                رقم الدور
            </label>
            <input type="text" placeholder="اكتب رقم الدور" title="رقم الدور" name="floor_number" id="floor_number" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap  ml-3 mt-3 cus-input">
            <label for="room_number" class="float-right">
                عدد الغرف
            </label>
            <input type="text" placeholder="اكتب عدد الغرف" title="عدد الغرف" name="room_number" id="room_number" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap  ml-3 mt-3 cus-input">
            <label for="electric_id" class="float-right">
                رقم حساب الكهرباء
            </label>
            <input type="text" placeholder="اكتب رقم حساب الكهرباء" title="رقم حساب الكهرباء" id="electric_id" readonly onfocus="this.removeAttribute('readonly');"
                autocomplete="new-pawword" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap  ml-3 mt-3 cus-input">
            <label for="attachments" class="float-right">صور الشقة</label>
            <input type="file" class="custom-file-input"
                id="attachments" accept="image/*" multiple autocomplete="off" readonly="readonly">
            <label class="custom-file-label" for="attachments" style="margin-top:45px;">اختر صور الشقة</label>
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap  ml-3 mt-3 cus-input">
            <label for="rent_val" class="float-right">
                *قيمة الإيجار
            </label>
            <input type="text" placeholder="اكتب قيمة الإيجار" title="قيمة الإيجار" id="rent_val" readonly onfocus="this.removeAttribute('readonly');"
                autocomplete="new-pawword" />
        </div>
    </div>
    <div class="row m-4">
        <div class="col-lg-4 col-12 ml-auto mr-auto text-center">
           <button type="button" class="btn btn-success" onclick="add_apartment();">إضافة</button>
        </div>
    </div>
@endsection
