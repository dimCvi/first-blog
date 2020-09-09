<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>@yield('seo_title') | @lang('Log in')</title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- Font Awesome -->
            <link rel="stylesheet" href="{{url('/themes/admin/plugins/fontawesome-free/css/all.min.css')}}">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- icheck bootstrap -->
            <link rel="stylesheet" href="{{url('/themes/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
            <!-- Theme style -->
            <link rel="stylesheet" href="{{url('/themes/admin/dist/css/adminlte.min.css')}}">
            <!-- Toastr CSS -->
            <link rel="stylesheet" href="{{url('/themes/admin/plugins/toastr/toastr.min.css')}}">
            <!-- Google Font: Source Sans Pro -->
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        </head>
        <body class="hold-transition login-page">
            <div class="login-box">
                <div class="login-logo">
                    <a href="#"><b>@lang('Cubes')</b>@lang('School')</a>
                </div>

                @yield('content')

            </div>
            <!-- /.login-box -->

            <!-- jQuery -->
            <script src="{{url('/themes/admin/plugins/jquery/jquery.min.js')}}"></script>
            <!-- Bootstrap 4 -->
            <script src="{{url('/themes/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
            <!-- AdminLTE App -->
            <script src="{{url('/themes/admin/dist/js/adminlte.min.js')}}"></script>
            <!-- Toastr JS -->
            <script type="text/javascript" src="{{url('/themes/admin/plugins/toastr/toastr.min.js')}}"></script>
            
            <script type="text/javascript">
                let systemMessage = "{{session()->pull('system_message')}}";
                let warningMessage = "{{session()->pull('warning_message')}}";
    
                if(systemMessage) {
                    toastr.success(systemMessage);
                }
    
                if(warningMessage) {
                    toastr.error(warningMessage);
                }
            </script>

        </body>
    </html>

