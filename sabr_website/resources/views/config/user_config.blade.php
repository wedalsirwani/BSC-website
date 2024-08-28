@extends('layouts.auth_master')
@section('title', 'إعدادات المستخدم')
@section('content')
<div class="col-6 mt-4 ml-auto mr-auto text-center">
    <label class="" for="fee">اختر طريقة تلقي التنبيهات</label>
    <div class="row">
        <div class="col">
            <input type="checkbox" id="by_email" class="form-check-input"
                        name="by_email" value="mail"
                        data-on="تفعيل" data-off="إيقاف"
                        data-toggle="toggle" data-change="true"
                        data-onstyle="outline-success" data-offstyle="outline-danger"
                        data-style="slow" data-size="sm" onchange="" />
            <label for="by_email">البريد الالكتروني</label>
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
