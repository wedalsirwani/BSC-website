@extends('layouts.auth_master')
@section('title', 'سجل الدفعات')
@section('content')
@isset($error)
    <div class="text-center mt-5 alert alert-danger">
        {{ $error }}
    </div>
@else
@if(!request()->route('id'))
<div class="col-12">
    <p class="h3 font-weight-bold w-100 text-center">اختر التاريخ واسم المستخدم للبدء</p>
    <div class="row mt-4">
        <div class="col-lg-3 col-12 mb-3 cus-input">
            <label for="from_date" class="float-right">
                <i class="far fa-calendar-alt txt-master"></i>
            </label>
            <input type="text" placeholder="من تاريخ" title="من تاريخ" name="from_date" id="from_date"
            class="form-control text-center hijri-date-default" autocomplete="off" />
        </div>
        <div class="col-lg-3 col-12 mb-3 cus-input mr-auto">
            <label for="to_date" class="float-right">
                <i class="far fa-calendar-alt txt-master"></i>
            </label>
            <input type="text" placeholder="إلى تاريخ" title="إلى تاريخ" name="to_date" id="to_date"
            class="form-control text-center hijri-date-default" autocomplete="off" />
        </div>
        <div class="col-lg-3 col-12 mb-3 cus-input mr-auto text-center" style="line-height: 2.5rem">
            <select class="selectpicker w-100" title="اختر مستخدم" id="users" data-live-search="true" multiple data-actions-box="true">
                @foreach (App\Http\Controllers\user_controller::all_all() as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 p-0">
            <div class="row mt-3">
                <div class="col-6 text-left"><button class="btn btn-slave mt-3" style="padding:25px 55px;" onclick="search();">بحث</button></div>
                <div class="col-6 text-left"><button class="btn btn-outline-primary mt-3"  style="padding:25px 55px;"  onclick="unapproved();">الدفعات غير المؤكدة</button></div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="table-responsive text-right mt-5">
    <table id="transactions" class="table table-striped table-bordered">
        <?php echo App\Http\Controllers\transaction_controller::print_transactions($transactions); ?>
    </table>
</div>

<div class="background">
</div>
@endif
@endsection
