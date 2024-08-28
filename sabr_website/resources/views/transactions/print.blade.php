<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html , charset=utf-8" >
        <script src="{{URL::asset('/js/Tafqeet.js')}}"></script>
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/animate.css') }}" />
        <link rel="shortcut icon" type="image/png" href="a/images/favicon.png"/>
        <link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('css/RTL.css') }}" />
        <title>دفعة رقم {{$transaction->id}}</title>
        <style>
            body{
                background-color: #fff;
                /*A5 dimensions */
                width: 320mm !important;
                height: 130mm !important;
                margin: 0!important;
                background-image:url("/imgs/receipt.jpg");
                background-repeat: no-repeat;
                background-size: 220mm 130mm !important; 
                background-position: right top;
}
            }
            .color-red{
                color:red;
            }
            
            @page
            {
                /* size: A5 landscape !important;  auto is the initial value */
                size: 220mm 130mm !important;
                margin: 0!important;
                /* landscape */
                /* this affects the margin in the printer settings */
            }
        </style>
    </head>
    <body style="@if(!isset($preview))
            background-image:unset;
            @endif
            ">
        <div class="container text-right">
            <div class="row">
                <div class="col-auto font-weight-bold" style="margin-right:20mm; margin-top:32mm;">
                {{number_format($transaction->amount, 0,".",",")}}
                </div>
                <div class="col">
                    <div class="container">
                        <div class="row">
                            <div class="col-auto font-weight-bold" style="margin-right:40mm; margin-top:28.40mm;">
                                {{Carbon\Carbon::parse($transaction->hijri_transaction_date)->format('Y-m-d')}}
                            </div>
                            <div class="col font-weight-bold" style="margin-right:5mm; margin-top:28.40mm;">
                                {{Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d')}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col font-weight-bold" style="margin-right:65mm; margin-top:-3mm; font-size:2rem">
                                {{$transaction->id}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col font-weight-bold" style="margin-right:43mm; margin-top: -1mm">
                    {{$transaction->contract->renter->name}}
                </div>
            </div>
            <div class="row">
                <div class="col font-weight-bold" style="margin-right:43mm; margin-top: 6mm">
                    <script>document.write(tafqeet({{$transaction->amount}}))</script> ريال فقط لا غير
                </div>
            </div>
            <div class="row">
                <div class="col font-weight-bold" style="margin-right:43mm; margin-top: 6mm">
                    <script>document.write(tafqeet({{$transaction->amount}}))</script> ريال فقط لا غير
                </div>
            </div>
            <div class="row">
                <div class="col font-weight-bold" style="margin-right:36mm; margin-top: 4.5mm">
                    {{$transaction->description}}
                </div>
            </div>
            <div class="row" style="height:10mm;">
                <div class="col font-weight-bold" style="margin-right:6mm; margin-top: 4.5mm">
                    {{$transaction->notes}}
                </div>
            </div>
            <div class="row">
                <div class="col font-weight-bold" style="margin-right:22.5mm; margin-top: 14.5mm">
                    {{$transaction->User->name}}
                </div>
            </div>
        </div>
        <!-- <div class="container">
            <table class="table table-bordered table-striped mt-5">
                <tr>
                    <th>
                        <p class="h1 font-weight-bold text-right d-inline-block float-right pri-color">عقارات بكر صبر</p>
                        <p class="h3 text-left font-weight-bold d-inline-block float-left color-red">سند قبض</p>
                    </th>
                </tr>
                <tr>
                    <td class="d-flex" style="justify-content: space-between;">
                        <p class="h4 text-right">المبلغ <span class="color-red">{{$transaction->amount}}</span> ريال</p>
                        <p class="h4">التاريخ 
                        <span class="color-red" >{{Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y')}}</span></p>
                        <p class="h4 text-left">الرقم <span class="color-red">{{$transaction->id}}</span></p>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <p class="h2 text-right">استلمنا من المكرم <span class="color-red">{{$transaction->contract->renter->name}}</span>
                        مبلغ وقدره <span class="color-red">{{$transaction->amount}}</span> ريال سعودي فقط لا غير.</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="h2 text-right">استُلِمَت
                        @if($transaction->recevied_by =="cach")نقداً
                        @elseif($transaction->recevied_by =="transfer")تحويل
                        @else شيك
                        @endif
                        بتاريخ <span class="color-red">{{Carbon\Carbon::parse($transaction->hijri_transaction_date)->format('d-m-Y')}}</span>
                        الموافق <span class="color-red">{{Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y')}}</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="h2 text-right">وذلك مقابل <span class="color-red">{{$transaction->description}}</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="h2 text-right">الملاحظات <span class="color-red">{{$transaction->notes}}</span></p>
                    </td>
                </tr>
                 <tr>
                    <td  class="d-flex" style="justify-content: space-around;">
                        <p class="h4">المستلم</p>
                    
                        <p class="h4 text-center">محرر السند<br /><br /><span class="color-red">{{$transaction->user->name}}</span></p>
                    
                        <p class="h4">المدير</p>
                    </td>
                </tr>   
            </table> -->
        </div>
        @isset($preview)
            <div class="text-center mt-4"><a href="/print-transaction/{{$transaction->id}}" class="mt-5 btn btn-secondary btnprn">طباعة<a/></div>
        @endif
        <script src="{{url::asset('/js/jquery.min.js')}}"></script>
        <script src="{{url::asset('/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url::asset('/js/jquery.printPage.js')}}"></script>
        <script src="{{url::asset('/js/myJS.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('a.btnprn').printPage();
            });
        </script>

    </body>
</html>