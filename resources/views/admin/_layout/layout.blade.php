<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title>@yield('seo_title') | @lang('Admin')</title>

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{url('/themes/admin/dist/css/adminlte.min.css')}}">
        <!-- Toastr CSS -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/toastr/toastr.min.css')}}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{'/themes/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css'}}">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        @stack('head_links')
    </head> 
    <body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('admin._layout.partials.navbar')

        @include('admin._layout.partials.sidebar')

        @yield('content')

        @include('admin._layout.partials.footer')

    </div>
    <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script type="text/javascript" src="{{url('/themes/admin/plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script type="text/javascript" src="{{url('/themes/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script type="text/javascript" src="{{url('/themes/admin/dist/js/adminlte.min.js')}}"></script>
        <!--Validation Plugin-->
        <script type="text/javascript" src="{{url('/themes/admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/themes/admin/plugins/jquery-validation/additional-methods.min.js')}}"></script>
        <!-- Toastr JS -->
        <script type="text/javascript" src="{{url('/themes/admin/plugins/toastr/toastr.min.js')}}"></script>
        <!-- DataTables -->
        <script type="text/javascript" src="{{url('/themes/admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/themes/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>


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


        @stack('footer_javascript')
    </body>
</html>
