<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/RTL.css').'?'.Carbon\Carbon::now()->timestamp}}" />
        <style>
            *{
                color:#000!important;
            }
            body,html{
                background-color:#fff!important;
                direction:rtl;
            }
            .table-responsive table tr th, .table-responsive table tr td {
                border: 1px solid #000 !important;
                background-color: #fff;
            }
        </style>
        <title>
        كشف حساب شقة ({{$contract->apartment->building->name.' - '.$contract->apartment->name}})
        </title>
    </head>
    <body>
        <div class="container">
            <p class="h3 text-center my-3 font-weight-bold">
                    كشف حساب شقة ({{$contract->apartment->building->name.' - '.$contract->apartment->name}})
            </p>
            <ul class="text-right">
                <li class="text-right h4 font-weight-bold">بيانات المستأجر:</li>
                <div class="row">
                    <p class="h4 font-weight-bold text-right pr-5 d-inline">الاسم:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{$contract->renter->name}}</p>
                </div>
                <div class="row">
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">رقم الهوية الوطنية / رقم هوية مقيم:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{$contract->renter->id_number}}</p>
                </div>
                <div class="row">
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">رقم الجوال:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{$contract->renter->phone_number}}</p>
                </div>
                <li class="text-right h4 font-weight-bold">بيانات الشقة:</li>
                <div class="row">
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">{{$contract->apartment->building->name}}</p>
                    <p class="h4 text-right mr-2 mr-5d-inline-block">
                    - {{$contract->apartment->name}}
                    </p>
                </div>
                <div class="row">
                    <p class="h4 text-right mr-5 d-inline-block">
                    {{$contract->apartment->description}} -</p>
                    <p class="h4 text-right d-inline-block">&nbsp;الدور {{$contract->apartment->floor_number}}</p>
                    <p class="h4 text-right mr-2 d-inline-block">
                    - عدد الغرف {{$contract->apartment->room_number}}</p>
                </div>
                <li class="text-right h4 font-weight-bold">بيانات العقد:</li>
                <div class="row">
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">بداية العقد:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{Carbon\Carbon::parse($contract->start_date)->toDateString()}} م</p>
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">الموافق:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{Carbon\Carbon::parse($contract->hijri_start_date)->toDateString()}} هـ</p>
                </div>
                <div class="row">
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">نهاية العقد:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{Carbon\Carbon::parse($contract->end_date)->toDateString()}} م</p>
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">الموافق:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{Carbon\Carbon::parse($contract->hijri_end_date)->toDateString()}} هـ</p>
                </div>
                <div class="row">
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">قيمة العقد:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{number_format($contract->rent_amount,2)}}</p>
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">المستحق:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{number_format($contract->payable_this_contract(),2)}}</p>
                </div>
                <div class="row">
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">المدفوع:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{number_format($contract->rent_amount-$contract->remaining(),2)}}</p>
                    <p class="h4 font-weight-bold text-right mr-5 d-inline-block">الباقي:</p>
                    <p class="h4 text-right mr-2 d-inline-block">{{number_format($contract->remaining(),2)}}</p>
                </div>
            </ul>
            <div class="row">
                @if($contract->benefits->count()>0)
                    <div class="table-responsive text-center">
                        <p class="h4 text-center w-100 font-weight-bold">تفاصيل الدفعات</p>
                        <table class="table table-striped">
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                <?php $sum_benefits=0;?>
                @if($contract->benefits->count()>0)
                    <div class="table-responsive text-center">
                        <p class="h4 text-center w-100 font-weight-bold">مستحقات أخرى</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>القيمة</th>
                                    <th>البيان</th>
                                    <th>الملاحظات</th>
                                    <th>اسم الموظف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contract->benefits as $index=>$benefit)
                                    <?php $sum_benefits+=$benefit->amount;?>
                                    <tr>
                                        <th>{{++$index}}</th>
                                        <td>{{$benefit->amount}}</td>
                                        <td>{{$benefit->description}}</td>
                                        <td>{{$benefit->notes}}</td>
                                        <td>{{$benefit->User->name}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="col">
                    <span class="d-block text-center font-weight-bold">صافي المستحق</span>
                    <span class="d-block text-center">{{number_format($contract->remaining()+$sum_benefits,2)}}</span>
                </div>
            </div>
        </div>
    </body>
</html>