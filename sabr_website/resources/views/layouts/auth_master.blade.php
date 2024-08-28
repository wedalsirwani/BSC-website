<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="cache-control" CONTENT="no-cache">
        <meta http-equiv="Content-Type" content="text/html , charset=UTF-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-select.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap4-toggle.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/sweetalert2.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/datatables.css') }}" />
        @if(str_contains(url()->current(), '/book_appointment/apartment/')
        || str_contains(url()->current(), 'request/apartment'))
            <link rel="stylesheet" href="{{ URL::asset('css/style.css')}}" />
        @endif
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link rel="stylesheet" href="{{ URL::asset('css/RTL.css').'?'.Carbon\Carbon::now()->timestamp}}" />
        {{-- <link rel="stylesheet" href="{{ URL::asset('css/light.css').'?'.Carbon\Carbon::now()->timestamp}}" /> --}}
        <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        @yield('header')
        <title>{{ config('app.name') }} | @yield('title')</title>
    </head>
    <body>
    @auth()
    <input type="hidden" id="Auth_user_id" value="{{Auth()->User()->id}}"/>
    @endauth
    <!--Navbar -->
    <nav class="mb-1 navbar fixed-top navbar-expand-lg navbar-dark background-master lighten-1">
        <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555"
        aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
        <ul class="navbar-nav ml-auto text-right">
            <li class="nav-item">
                <a class="nav-link" href="/"><i class="fab fa-houzz"></i> الرئيسية
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    العمائر
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @auth
                        @if(Auth()->User()->hasRole('admin') || Auth()->User()->hasRole('employee'))
                            <a class="dropdown-item" href="/add_building"><i class="fas fa-plus"></i> إضافة عمارة</a>
                        @endif
                    @endauth
                    <a class="dropdown-item" href="/buildings"><i class="far fa-building"></i> استعراض العمائر</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="loans" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    الشقق
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @auth
                        @if(Auth()->User()->hasRole('admin') || Auth()->User()->hasRole('employee'))
                            <a class="dropdown-item" href="/add_apartment"><i class="fas fa-plus"></i> إضافة شقة</a>
                        @endif
                    @endauth
                    <a class="dropdown-item" href="/apartments"><i class="far fa-building"></i> الشقق الشاغرة</a>
                </div>
            </li>
            @auth
                @if(Auth()->User()->hasRole('admin') || Auth()->User()->hasRole('employee'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            المستأجرون
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            {{-- <a class="dropdown-item" href="/add_renter"><i class="fas fa-plus"></i> إضافة مستأجر</a> --}}
                            <a class="dropdown-item" href="/renters"><i class="fas fa-users"></i> استعراض المستأجرين</a>
                        </div>
                    </li>
                @endif
            @endauth
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="/my_apartments"><i class="fas fa-warehouse"></i> إيجاري
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/requests"><i class="fas fa-tools"></i> طلبات الصيانة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/appointments"><i class="far fa-calendar-check"></i> المواعيد
                    </a>
                </li>
                @if(Auth()->User()->hasAnyRole(["admin","employee"]))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        الدفعات
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @auth
                            @if(Auth()->User()->hasRole('admin') || Auth()->User()->hasRole('employee'))
                                {{-- <a class="dropdown-item" href="/add_transaction"><i class="far fa-file-alt"></i> سند قبض</a> --}}
                                <a class="dropdown-item" href="/show_summary"><i class="far fa-file-alt"></i> كشف حساب</a>
                            @else
                                <a class="dropdown-item" target="_blank" href="/summary/renter/{{Auth()->User()->renter->id}}"><i class="far fa-file-alt"></i> كشف حساب</a>
                            @endif
                        @endauth
                    </div>
                </li>
                @else <li class="nav-item">
                        <a class="nav-link" target="_blank" href="/summary/renter/{{Auth()->User()->renter->id}}"><i class="far fa-file-alt"></i> كشف حساب</a>
                        </a>
                    </li>
                @endif
            @endauth

            @auth @if(Auth()->User()->hasRole('admin'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       الإعدادات
                    </a>
                    <div class="dropdown-menu" id="" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/users">
                            التحكم بالمستخدمين
                        </a>
                        <a class="dropdown-item" href="/roles">
                            صلاحيات المستخدمين
                        </a>
                    </div>
                </li>
                @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notifications_count" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-bell"></i> <span class="badge badge-pill badge-danger">{{count(Auth()->User()->unreadNotifications)}}</span>
                </a>
                <div class="dropdown-menu" id="notifications" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/user_conf">
                        إعدادات التنبيهات
                    </a>
                    <a id="all_as_read" class="dropdown-item" href="#" onclick="make_as_read('0','#');">
                        تعليم الكل كمقروء
                    </a>
                    @forelse (Auth()->User()->unreadNotifications as $notification)
                        @if($notification->type=='App\Notifications\new_register')
                            <a onclick="make_as_read('{{$notification->id}}','/roles');" class="dropdown-item" href="#">
                                قام {{$notification->data['user']}} بالتسجيل في {{config('app.name')}}.
                            </a>
                        @endif
                    @empty
                        <a id="empty" class="dropdown-item" href="#">
                            لا يوجد تنبيهات.
                        </a>
                    @endforelse
                </div>
            </li>   
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> {{Auth()->User()->name}}
                </a>
                @if(Auth::check())
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="" onclick="show_pwd(event);"><i class="fas fa-key"></i> تغيير كلمة المرور</a>
                    <a class="dropdown-item" href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
                </div>
                @endif
            </li>
        </ul>
             @else
             <ul class="navbar-nav ml-auto text-right">
                <li class="nav-item">
                    <a class="nav-link" href="/login">تسجيل الدخول
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">التسجيل
                    </a>
                </li>
             </ul>
        @endauth
        </div>
    </nav>
    <!--/.Navbar -->


        <div class="container mb-5 pb-5" id="container">

            <!-- <form action="" autocomplete="new-password" > -->
                @csrf
                @yield('content')
                <div class="pwd">
                    <div class="col-12 col-md-6  ml-auto mr-auto p-5" style="z-index:99; background-color:#CCC;margin-top:180px">
                        <label class="w-100 text-center" for="pwd111">أدخل كلمة المرور للمتابعة</label>
                        <input type="password" id="pwd111" name="pwd111"  class="text-center form-control"/>
                        <button type="button" class="btn btn-primary mt-5 mb-5" onclick="redirect_to_reset();">متابعة</button>
                        <button type="button" class="btn btn-danger mt-5 mb-5" onclick="$('.pwd').hide();$('.alert.alert-danger').addClass('d-none');">إلغاء</button>
                        <div class="col-12 text-center alert alert-danger d-none">عذراً كلمة المرور خاطئة!!!</div>
                    </div>
                </div>
            <!-- </form> -->
        </div>
        <footer class="footer d-flex justify-content-center">
            <p class="ml-2">{{ config('app.name') }} &copy; {{Carbon\Carbon::now('Asia/Riyadh')->format('Y')}}</p>
            <a href="https://x.com" class="link ml-2" target="_blank"><i class="fab fa-twitter-square"></i></a>
            <a href="https://instagram.com" class="link ml-2" target="_blank"><i class="fab fa-instagram"></i></a>
        </footer>
        <!-- Bootstrap core JavaScript -->
        <script src="{{url::asset('/js/jquery.min.js')}}"></script>
        <script src="{{url::asset('/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url::asset('/js/bootstrap-select.min.js')}}"></script>
        <script src="{{url::asset('/js/i18n/defaults-ar_AR.min.js')}}"></script>
        <script src="{{url::asset('/js/bootstrap4-toggle.min.js')}}"></script>
        <script src="{{url::asset('/js/jquery.nicescroll.min.js')}}"></script>
        <script src="{{url::asset('/js/momentjs.js')}}"></script>
        <script src="{{url::asset('/js/moment-with-locales.js')}}"></script>
        <script src="{{url::asset('/js/moment-hijri.js')}}"></script>
        <script src="{{url::asset('/js/bootstrap-hijri-datepicker.js')}}"></script>
        <script src="{{url::asset('/js/sweetalert2.min.js')}}"></script>
        <script src="{{url::asset('/js/datatables.js')}}"></script>
        <script src="{{url::asset('/js/bootstrap-notify.js')}}"></script>
        <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
        <script src="{{url::asset('/js/myJS.js').'?'.Carbon\Carbon::now()->timestamp}}"></script>
        <script>
            // $("body").niceScroll(
            //         {
            //             cursorcolor:"#f90"
            //         }
            // );
            // $("#notifications").niceScroll();
        </script>
        @yield('scripts')
    </body>
</html>
