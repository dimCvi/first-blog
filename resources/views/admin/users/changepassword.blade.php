<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cubes School | Confirm Password</title>
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
            <a href="#"><b>Cubes</b>School</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">@lang('Change your password').</p>

                <form 
                    id="password_form"
                    method="POST"
                >
                @csrf
                    <div class="input-group mb-3">
                        <input 
                            name="old_password"
                            type="password" 
                            class="form-control @if($errors->has('old_password')) is-invalid @endif" 
                            placeholder="Old Password"
                            value="{{old('password')}}"
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock-open"></span>
                            </div>
                        </div>
                        @include('admin._layout.partials.form_errors', ['fieldName' => 'old_password'])
                    </div>
                    <div class="input-group mb-3">
                        <input 
                            name="password"
                            type="password" 
                            class="form-control @if($errors->has('password')) is-invalid @endif" 
                            placeholder="New Password"
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @include('admin._layout.partials.form_errors', ['fieldName' => 'password'])
                    </div>
                    <div class="input-group mb-3">
                        <input 
                            name="password_confirmation"
                            type="password" 
                            class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" 
                            placeholder="Confirm New Password"
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @include('admin._layout.partials.form_errors', ['fieldName' => 'password_confirmation'])
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">@lang('Confirm Password Change')</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="forgot-password.html">@lang('I forgot my password')</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{url('/themes/admin/plugins/jquery/jquery.min.js')}}"></script>
    <!--Validation Plugin-->
    <script type="text/javascript" src="{{url('/themes/admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/themes/admin/plugins/jquery-validation/additional-methods.min.js')}}"></script>
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


    <script>
        $('#password_form').validate({
            rules: {
                "old_password": {
                    "required": true,
                    "minlength": 7
                },
                "password": {
                    "required": true,
                    "minlength": 7
                },
                "password_confirmation": {
                    "required": true,
                    "minlength": 7
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
            });
    </script>

</body>

</html>