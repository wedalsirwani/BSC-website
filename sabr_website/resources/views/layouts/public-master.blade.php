<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="cache-control" CONTENT="no-cache">
        <meta http-equiv="Content-Type" content="text/html , charset=UTF-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-select.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap4-toggle.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/sweetalert2.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/RTL.css') }}" />
        <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>
        <link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        @yield('header')
        <title>{{ config('app.name') }} | @yield('title')</title>
    </head>
    <body>
        @yield('content')

        <footer class="footer text-center">
            جميع الحقوق محفوظة {{ config('app.name') }} &copy; {{Carbon\Carbon::now('Asia/Riyadh')->format('Y')}}
        </footer>
        <!-- Bootstrap core JavaScript -->
        <script src="{{url::asset('/js/jquery.min.js')}}"></script>
        <script src="{{url::asset('/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url::asset('/js/bootstrap-select.min.js')}}"></script>
        <script src="{{url::asset('/js/i18n/defaults-ar_AR.min.js')}}"></script>
        <script src="{{url::asset('/js/bootstrap4-toggle.min.js')}}"></script>
        <script src="{{url::asset('/js/jquery.nicescroll.min.js')}}"></script>
        <script src="{{url::asset('/js/sweetalert2.min.js')}}"></script>
        <script src="{{url::asset('/js/myJS.js')}}"></script>
        <script>
        $("body").niceScroll({
            cursorcolor:"#ecc08e"
        });
        </script>
        @yield('scripts')
    </body>
</html>
