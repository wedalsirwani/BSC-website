@extends('layouts.auth_master')
@section('title', 'عقد إيجار رقم '.$contract->id)
@section('content')
<div class="background">
    @if($contract->pay_repeat == 0)
        <script>document.querySelector('div.background').style.display = "flex";</script>
        <div class="container">
            <div class="row">
                <div class="col-12 bg-white pt-5 pb-5 mb-5 bordered rounded" style="margin-top:150px;">
                    <label class="w-100 text-center">الرجاء اختيار استحقاق الدفعات</label>
                    <div class="ml-auto mr-auto mt-3 cus-input">
                        <label for="pay_repeat" class="float-right">
                            * استحقاق الدفعات 
                        </label>
                        <select class="selectpicker w-100" title="كل" id="pay_repeat" data-live-search="true" 
                            data-actions-box="true" data-size="6">
                            @for($i=1 ; $i <= 12 ; $i++)
                                @if(12% $i==0)<option value="{{$i}}">{{$i}} شعر</option>@endif
                            @endfor
                        </select>
                    </div>
                    <div class="col-12 text-center mt-5 ">
                        <button class="btn btn-success" onclick="save_pay_repeat();">حفظ</button>
                        <!-- <button class="btn btn-danger" onclick="hide_pay_repeat();">إلغاء</button> -->
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="row">
    <h1 class="w-100 txt-master text-center mb-5">العقد رقم {{$contract->id}}</h1>
    <div class="col-md-6 col-12">
        <div class="row text-right txt-bold">
            <div class="col-12">
                <p class="txt-master txt-bold">
                    بيانات المستأجر
                </p>
            </div>
            <div class="row mr-4">
                <div class="col-12">
                    <p>الاسم</p>
                    <p class="txt-master mr-3">
                        {{$contract->renter->name}}
                    </p>
                </div>
                <div class="col-12">
                    <p>رقم الهوية الوطنية / رقم هوية مقيم</p>
                    <p class="txt-master mr-3">
                        {{$contract->renter->id_number}}
                    </p>
                </div>
                <div class="col-12">
                    <p>رقم الجوال: <span class="txt-master">{{$contract->renter->phone_number}}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="row text-right">
            <div class="col-12">
                <p class="txt-master txt-bold">
                    بيانات الشقة
                </p>
            </div>
            <div class="col-auto pl-0">        
                <i class="fas fa-building txt-master" style="font-size: 12rem"></i>
            </div>
            <div class="col-auto txt-bold"> 
                <p class="h2 txt-bold txt-master">
                    <a href="/building/{{$contract->apartment->building->id}}" class="txt-master" target="_blank">
                        {{$contract->apartment->building->name}}
                    </a> - 
                    <a href="/apartment/{{$contract->apartment->id}}" class="txt-master" target="_blank">
                        {{$contract->apartment->name}}
                    </a>
                    
                </p>
                <p class="txt-slave">{{$contract->apartment->description}}</p>
                <p class="txt-slave">رقم الدور: <span class="txt-master" >{{$contract->apartment->floor_number}}</span></p>
                <p class="txt-slave">عدد الغرف: <span class="txt-master" >{{$contract->apartment->room_number}}</p>
                <p class="txt-slave">رقم حساب عداد الكهرباء: <span class="txt-master" >{{$contract->apartment->electric_id}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-12 mt-5">
        <p class="txt-slave text-right txt-bold">تاريخ بداية العقد</p>
        <p class="text-right txt-master txt-bold">{{Carbon\Carbon::parse($contract->hijri_start_date)->format('Y-m-d')}}</p>
    </div>
    <div class="col-md-3 col-12 mt-5">
        <p class="txt-slave text-right txt-bold">الموافق</p>
        <p class="text-right txt-master txt-bold">{{Carbon\Carbon::parse($contract->start_date)->format('Y-m-d')}}</p>
    </div>
    <div class="col-md-3 col-12 mt-5">
        <p class="txt-slave text-right txt-bold">تاريخ نهاية العقد</p>
        <p class="text-right txt-master txt-bold">{{Carbon\Carbon::parse($contract->hijri_end_date)->format('Y-m-d')}}</p>
    </div>
    <div class="col-md-3 col-12 mt-5">
        <p class="txt-slave text-right txt-bold">الموافق</p>
        <p class="text-right txt-master txt-bold">{{Carbon\Carbon::parse($contract->end_date)->format('Y-m-d')}}</p>
    </div>
    <div class="col-md-3 col-12">
        <p class="txt-slave text-right txt-bold">مدة العقد</p>
        <p class="text-right txt-master txt-bold">{{$contract->rent_duration}} {{$contract->rent_unit}}</p>
    </div>
    <div class="col-md-3 col-12">
        <p class="txt-slave text-right txt-bold">قيمة العقد</p>
        <p class="text-right txt-master balance">{{number_format($contract->rent_amount)}}</p>
    </div>
    <div class="col-md-3 col-12">
        <p class="txt-slave text-right txt-bold">استحقاق الدفعات</p>
        <p class="text-right txt-master txt-bold">كل {{$contract->pay_repeat}} شهر</p>
    </div>
    <div class="col-md-3 col-12">
        <p class="txt-slave text-right txt-bold">المتبقي</p>
        <p class="text-right txt-master balance">{{number_format($contract->remaining())}}</p>
    </div>
    <div class="col-md-3 col-12">
        <p class="txt-slave text-right txt-bold">المستحق</p>
        <p class="text-right txt-master balance">{{number_format($contract->payable(),2)}}</p>
    </div>
    <div class="col-md-3 col-12 text-right">
        <p class="txt-slave text-right txt-bold"></p>
        @if($contract->remaining() > 0)
            <a href="/add_transaction/contract/{{$contract->id}}" class="text-right txt-master balance">إضافة دفعة</a>
        @endif
    </div>
    <div class="col-md-3 col-12 text-right">
        <p class="txt-slave text-right txt-bold"></p>
        <a href="/summary/contract/{{$contract->id}}" target="_blank" class="text-right txt-master balance">كشف حساب</a>
    </div>
    <div class="col-md-3 col-12 text-right">
        <p class="txt-slave text-right txt-bold"></p>
        <a href="/add_amount/contract/{{$contract->id}}" target="_blank" class="text-right txt-master balance">إضافة مستحقات</a>
    </div>
</div>
<div class="row">
    <div class="table-responsive text-center mt-5">
        <table class="table table-striped" id="transactions">
            <thead>
                <tr>
                    <th>م</th>
                    <th>الدفعة</th>
                    <th>تاريخها</th>
                    <th>الموافق</th>
                    <th>البيان</th>
                    <th>طريقة الاستلام</th>
                    <th>الملاحظات</th>
                    <th>اسم الموظف</th>
                    <th>تاريخ الإنشاء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contract->transactions as $index=>$transaction)
                    <tr>
                        <th>{{++$index}}</th>
                        <td>{{$transaction->amount}}</td>
                        <td>{{Carbon\Carbon::parse($transaction->hijri_transaction_date)->format('Y-m-d')}}</td>
                        <td>{{Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d')}}</td>
                        <td>{{$transaction->description}}</td>
                        <td>
                            @if($transaction->received_by == 'cach')
                            كاش
                            @elseif($transaction->received_by == 'transfer')
                            تحويل
                            @else شيك
                            @endif
                        </td>
                        <td>{{$transaction->notes}}</td>
                        <td>{{$transaction->User->name}}</td>
                        <td title="{{$transaction->created_at->toTimeString()}}">{{$transaction->created_at->toDateString()}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection