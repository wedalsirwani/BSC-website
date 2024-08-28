@extends('layouts.auth_master')
@section('title', 'الشقق الشاغرة')
@section('content')
<div class="background">
</div>
<div class="row justify-content-center">
    <div class="col-lg-4 col-12 d-flex flex-wrap  ml-3 mt-3 mt-3 cus-input">
        <input type="text" placeholder="اكتب للبحث" title="" name="search" id="search" />
    </div>
    <div class="col-lg-4 col-12 d-flex flex-wrap  ml-3 mt-3 mt-3 cus-input">
        <select class="selectpicker my-select" title="اختر الحي" id="distract"
            data-actions-box="true" data-size="5" multiple data-live-search="true">
            @foreach ($distracts as $distract)
                <option value="{{$distract->id}}">{{$distract->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-auto mt-3 col-12 text-right">
        <button class="btn btn-info px-5 py-4" id="search_btn" onclick="search();">بحث</button>
    </div>
</div>
<div class="row mt-4" id="apartments">
    <div class="col">
        @foreach($availables as $available)
            <div class="row m-5 text-right txt-master">
                <div class="col-auto pl-0">
                    <i class="fas fa-building fa-9x"></i>
                    <span class="circle building-circle"  style="background-color:
                                @if($available->is_avialable())
                                    green
                                @else red
                                @endif;bottom:10px;"></span>
                </div>
                <div class="col-auto">
                    <p class="h2" title="اسم العمارة" id="name">{{$available->name}}</p>
                    <p class="txt-slave" title="الوصف" id="description">{{$available->description}}</p>
                    <p class="txt-slave" title="العنوان" id="address">{{$available->address}}</p>
                    <p class="txt-slave" title="ملاحظات" id="notes">{{$available->notes}}</p>
                </div>
                <div class="col text-left">
                    <input type="hidden" id="building_name" value="{{$available->name}}" />
                    <input type="hidden" id="building_description" value="{{$available->description}}" />
                    <input type="hidden" id="building_address" value="{{$available->address}}" />
                    <input type="hidden" id="building_notes" value="{{$available->notes}}" />
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($available->apartments as $apartment)
                    @if($apartment->is_avialable())
                        <a class="txt-master" href="/apartment/{{$apartment->id}}">
                            <div class="row m-3">
                                <div class="col-auto pl-0  text-right txt-master ">
                                    <i class="fas fa-building" style="font-size: 6rem"></i>
                                </div>
                                <div class="col text-right txt-master ">
                                    <p class="h2" id="name">{{$apartment->name}}</p>
                                    <p class="txt-slave" id="description">{{$apartment->description}}</p>
                                    <p class="txt-slave" id="floor_number">رقم الدور: <span class="txt-master" >{{$apartment->floor_number}}</span></p>
                                    <p class="txt-slave" id="room_number">عدد الغرف: <span class="txt-master" >{{$apartment->room_number}}</p>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
</div>

@endsection
