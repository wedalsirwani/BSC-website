@extends('layouts.auth_master')
@section('title', 'إدارة الصلاحيات')
@section('content')
    <div class="row mt-5">
        <div class="col-12 text-center mt-5">
            <p class="h4">اختر المستخدم لتحديد صلاحياته</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-8 text-center ml-auto mr-auto mt-3 border-b p-0">
            <select class="selectpicker my-select" title="اختر مستخدم" id="users" data-live-search="true">
                @foreach (App\Http\Controllers\user_controller::all() as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" id="roles">
        <div class="col-md-8 col-12 text-center ml-auto mr-auto mt-3 pt-3 bg-master rounded">
            <div class="row">
                @foreach (App\Http\Controllers\role_controller::all() as $role)
                <div class="col-md-6 col-12">
                    <div class="row">
                        <div class="col-auto text-center input-toggle">
                            <input type="checkbox" id="role{{$role->id}}" class="form-check-input"
                                name="role{{$role->id}}" value="{{$role->id}}"
                                data-toggle="toggle" data-change="true"
                                data-onstyle="success" data-offstyle="danger"
                                data-style="slow" data-size="xs" onchange="set_role(this.id);" />
                        </div>
                        <div class="col text-right p-0">
                            <label class="d-inline mr-1" for="role{{$role->id}}">{{$role->title}}</label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 text-center ml-auto mr-auto mt-3">
            <div id="result" class="alert alert-success d-none">
            </div>
        </div>
    </div>
    <div class="background">
    </div>
@endsection
