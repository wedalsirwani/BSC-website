@extends('layouts.auth_master')
@section('title', 'إضافة مستأجر')
@section('content')
<div class="background">
</div>
<div class="row m-4">
    <div class="col-lg-6 col-12 ml-auto mr-auto cus-input">
        <label for="id_number" class="float-right">
            * رقم هوية المستأجر 
        </label>
        <input type="tel" placeholder="اكتب رقم هوية المستأجر" title="رقم هوية المستأجر" id="id_number" maxlength="10" readonly onfocus="this.removeAttribute('readonly');"
/>
    </div>
</div>
<div class="row m-4">
    <div class="col-lg-6 col-12 ml-auto mr-auto cus-input d-none">
        <label for="name" class="float-right">
            * اسم المستأجر 
        </label>
        <input type="text" placeholder="اكتب اسم المستأجر" title="اسم المستأجر" name="name" id="name" />
    </div>
</div>
<div class="row m-4">
    <div class="col-lg-6 col-12 ml-auto mr-auto cus-input d-none">
        <label for="phone" class="float-right">
            * جوال المستأجر 
        </label>
        <input type="tel" placeholder="اكتب جوال المستأجر" title="جوال المستأجر" name="phone" id="phone" maxlength="10" />
    </div>
</div>
<div class="row m-4">
    <div class="col-lg-6 col-12 ml-auto mr-auto cus-input d-none">
        <label for="attachment" class="float-right">
            * هوية المستأجر
        </label>
        <input type="file" class="custom-file-input" id="attachment" accept=".pdf">
        <label class="custom-file-label" for="attachment" style="margin-top:45px;">اختر هوية المستأجر</label>
    </div>
</div>
@endsection