@extends('layouts.auth_master')
@section('title', 'إضافة عمارة')
@section('content')
<div class="background">
</div>
    <div class="row m-4 justify-content-center">
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="name" class="float-right">
                * اسم العمارة
            </label>
            <input type="text" placeholder="اكتب اسم العمارة" title="اسم العمارة" name="name" id="name" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="description" class="float-right">
                وصف العمارة
            </label>
            <input type="text" placeholder="اكتب وصف العمارة" title="وصف العمارة" name="description" id="description" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="address" class="float-right">
                موقع العمارة
            </label>
            <input type="text" placeholder="اكتب موقع العمارة" title="موقع العمارة" name="address" id="address" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="address_url" class="float-right">
                الرابط في خرائط جوجل
            </label>
            <input type="text" placeholder="الرابط في خرائط جوجل" title="الرابط في خرائط جوجل" name="address_url" id="address_url" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="notes" class="float-right">
                ملاحظات
            </label>
            <input type="text" placeholder="ملاحظات" title="ملاحظات" id="notes" autocomplete="none" readonly onfocus="this.removeAttribute('readonly');"/>
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="distract" class="float-right">
                *الحي
            </label>
            <select class="selectpicker my-select" title="اختر الحي" id="distract" data-live-search="true">
                @foreach ($distracts as $distract)
                    <option value="{{$distract->id}}">{{$distract->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row m-4">
        <div class="col-lg-4 col-12 ml-auto mr-auto text-center">
           <button type="button" class="btn btn-success" onclick="add_building();">إضافة</button>
        </div>
    </div>
@endsection
