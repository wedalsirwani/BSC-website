@extends('layouts.auth_master')
@section('title', 'العمائر')
@section('content')
<div class="background">
</div>
    
<div class="row mt-5 pt-2" id="buildings">
    @isset($buildings)
        @foreach($buildings as $building)
            <div class="col-lg 4 col col-md-3 col-12 pri-color text-center">
                <a class="txt-master" href="/building/{{$building->id}}" title="{{$building->notes}}">
                    <span class="position-relative" >
                        <i class="fas fa-building fa-7x"></i>
                        <span class="circle small-circle"  style="background-color:
                                @if($building->is_avialable())
                                    green
                                @else red
                                @endif "></span>
                    </span>
                    <p class="h3 mt-3">{{$building->name}}</p>
                </a>
                <p class="txt-slave">{{$building->description}}</p>
                <p class="txt-slave">{{$building->address}}</p>
            </div>
        @endforeach
    @endif
</div>
@endsection
