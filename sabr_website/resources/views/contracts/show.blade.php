@extends('layouts.auth_master')
@section('title', 'إضافة عقد إيجار')
@section('content')
<div class="background">
</div>
    <div class="row m-4 justify-content-center">
        <div class="col-lg-4 col-12 flex-wrap ml-3 mt-3 mt-3 cus-input {{$apartment==null ? 'd-flex' : 'd-none '}}">
            <label for="renter" class="float-right">
                * المستأجر
            </label>
            <select class="selectpicker w-100" title="المستأجر" id="renter" data-live-search="true"
                data-actions-box="true" {{is_array($renters) ? '' : 'disabled'}}>
                @if(is_array($renters))
                    @foreach ($renters as $renter)
                        <option value="{{$renter->id}}">{{$renter->name}}</option>
                    @endforeach
                @else <option value="{{$renters->id}}" selected>{{$renters->name}}</option>
                @endif
            </select>
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="renter" class="float-right">
                * العمارة
            </label>
            <select class="selectpicker w-100" title="العمارة" id="building" data-live-search="true"
                {{is_array($buildings) ? '' : 'disabled'}} data-actions-box="true" >
                @if(is_array($buildings))
                    @foreach ($buildings as $building)
                        <option value="{{$building->id}}">{{$building->name}}</option>
                    @endforeach
                @else <option value="{{$buildings[0]->id}}" selected>{{$buildings[0]->name}}</option>
                @endif
            </select>
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="renter" class="float-right">
                * الشقة
            </label>
            <select class="selectpicker w-100" title="الشقة" id="apartment" data-live-search="true"
                {{$apartment==null ? '' : 'disabled'}} data-actions-box="true" >
                @if($apartment!=null)
                    <option value="{{$apartment->id}}" selected>{{$apartment->name}}</option>
                @endif
            </select>
        </div>
        <div class="col-lg-4 col-12 flex-wrap ml-3 mt-3 mt-3 cus-input {{$apartment==null ? 'd-flex' : 'd-none '}}">
            <label for="rent_duration" class="float-right">
                * مدة الإيجار
            </label>
            <select class="selectpicker w-100" title="مدة الإيجار" id="rent_duration" data-live-search="true"
                {{$apartment==null ? '' : 'disabled'}} data-actions-box="true" data-size="3">
                @if($apartment!=null)
                    <option value="1" selected>1</option>
                @else
                    @for($i=1 ; $i < 31 ; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor
                @endif
            </select>
        </div>
        <div class="col-lg-4 col-12 flex-wrap ml-3 mt-3 mt-3 cus-input {{$apartment==null ? 'd-flex' : 'd-none '}}">
            <label for="rent_unit" class="float-right">
                * الوحدة الزمنية
            </label>
            <select class="selectpicker w-100" title="الوحدة الزمنية" name="rent_unit" id="rent_unit" data-live-search="true"
                {{$apartment==null ? '' : 'disabled'}} data-actions-box="true">
                <option value="ساعة">ساعة</option>
                <option value="يوم">يوم</option>
                <option value="شهر">شهر</option>
                <option value="سنة" {{$apartment==null ? '' : 'selected'}} >سنة</option>
            </select>
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="h_start_date" class="float-right">
                * تاريخ بداية الإيجار
            </label>
            <input type="text" class="hijri-date-input text-center" placeholder="تاريخ بداية الإيجار"
                title="تاريخ بداية الإيجار" name="h_start_date" id="h_start_date" />
        </div>
        <div class="col-lg-4 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="h_end_date" class="float-right">
                * تاريخ نهاية الإيجار
            </label>
            <input type="text" class="hijri-date-input text-center" placeholder="تاريخ نهاية الإيجار"
                disabled title="تاريخ نهاية الإيجار" name="h_end_date" id="h_end_date" />
        </div>
        <div class="col-lg-6 col-12 d-flex flex-wrap ml-3 mt-3 mt-3 cus-input">
            <label for="rent_amount" class="float-right">
                * قيمة الإيجار
            </label>
            <input type="text" class="text-center" placeholder="قيمة الإيجار" title="قيمة الإيجار"
                disabled name="rent_amount" id="rent_amount" value="{{$apartment->rent_val}}"
                readonly onfocus="this.removeAttribute('readonly');"/>
        </div>
        <div class="col-lg-4 col-12 flex-wrap ml-3 mt-3 mt-3 cus-input {{$apartment==null ? 'd-flex' : 'd-none '}}">
            <label for="pay_repeat" class="float-right">
                * استحقاق الدفعات
            </label>
            <select class="selectpicker w-100" title="كل" id="pay_repeat" data-live-search="true"
                {{$apartment==null ? '' : 'disabled'}} data-actions-box="true" data-size="6">
                @for($i=1 ; $i <= 12 ; $i++)
                    @if(12% $i==0)<option value="{{$i}}" {{$i==6?'selected':''}}>{{$i}} شهر</option>@endif
                @endfor
            </select>
        </div>
    </div>
    <div class="row m-4">
        <div class="col-lg-6 col-12 ml-auto mr-auto mt-3 text-center">
            <button type="button" class="btn btn-primary {{$apartment==null ? '' : 'rent' }}"
                id="btn_save">
                {{$apartment==null ? 'حفظ' : 'متابعة للدفع' }}</button>
        </div>
    </div>
@endsection
@section("scripts")
    <script>
        // moment.locale('ar-SA');
        $("#h_start_date").val(moment().format('iYYYY-iM-iD'));
        $("#h_end_date").val(moment().add(1,"iYear").format('iYYYY-iM-iD'));
        $(function(){
            $("#h_start_date").on('dp.change', function (event) {
                $("#h_end_date").val(event.date.add(1, 'iYear').format("iYYYY-iM-iD"));
            });
        });
    </script>
@endsection
