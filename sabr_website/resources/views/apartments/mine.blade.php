@extends('layouts.auth_master')
@section('title', 'إيجاري')
@section('content')
<div class="background">
</div>
<div class="row mt-4" id="apartments">
    <div class="col">
        <div class="row justify-content-center">
            @foreach($apartments as $apartment)
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
            @endforeach
        </div>
    </div>
</div>

@endsection
