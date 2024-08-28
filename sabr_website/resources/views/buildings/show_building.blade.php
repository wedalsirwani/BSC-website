@extends('layouts.auth_master')
@isset($building)
    @section('title', $building->name)
@endif
@section('content')
<div class="background" id="background">
</div>
<div class="row animate__animated d-none" id="edit">
    <div class="col background show">
        <div class="edit animate__animated">
        </div>
    </div>
</div>
<div class="row pt-2">
    @isset($building)
        <div class="col text-right txt-master">
            <div class="row">
                <div class="col-auto pl-0">
                    <i class="fas fa-building fa-9x"></i>
                    <span class="circle building-circle"  style="background-color:
                                @if($building->is_avialable())
                                    green
                                @else red
                                @endif "></span>
                </div>
                <div class="col-auto">
                    <p class="h2" title="اسم العمارة" id="name">{{$building->name}}</p>
                    <p class="txt-slave" title="الوصف" id="description">{{$building->description}}</p>
                    <p class="txt-slave" title="العنوان" id="address">{{$building->address}}</p>
                    <p class="txt-slave" title="العنوان في خرائط جوجل" id="address_url">
                        @if($building->address_url != null)
                            <a href="{{$building->address_url}}" target="_blank" title="العنوان في خرائط جوجل">اضغط هنا للانتقال للرباط في خرائط جوجل</a>
                        @endif
                    </p>
                    <p class="txt-slave" title="ملاحظات" id="notes">{{$building->notes}}</p>
                    <p class="txt-slave" title="الحي" id="distract">{{$building->distract->name}}</p>

                </div>
                <div class="col text-left">
                    <input type="hidden" id="building_name" value="{{$building->name}}" />
                    <input type="hidden" id="building_description" value="{{$building->description}}" />
                    <input type="hidden" id="building_address" value="{{$building->address}}" />
                    <input type="hidden" id="building_address_url" value="{{$building->address_url}}" />
                    <input type="hidden" id="building_notes" value="{{$building->notes}}" />
                    <input type="hidden" id="distracts" value="{{$distracts}}" />
                    @Auth()
                        @if(Auth()->User()->hasAnyRole(["admin","employee"]))
                            <button type="button" class="btn btn-outline-warning"
                            onclick="show_edit()">
                            تحرير</button>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center mb-5"><p class="h3 txt-slave">الشقق التابعة للعمارة هي:</p></div>
                @foreach($building->apartments as $apartment)
                    <div class="col-md-4 col-12">
                        <a class="txt-master" href="/apartment/{{$apartment->id}}"><p class="h3" title="اسم الشقة"><i class="far fa-building" style="color:
                            @if($apartment->contract()->count() > 0)
                                @if($apartment->contract->is_avialable($apartment->id)) green
                                @else red
                                @endif
                            @else green
                            @endif
                                "></i> {{$apartment->name}}</p>
                        </a>
                        <p class="mr-4" title="الوصف">{{$apartment->description}}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
