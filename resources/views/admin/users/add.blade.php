@section('seo_title', 'Add New User')

@extends('admin._layout.layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">@lang('Users')</a></li>
                        <li class="breadcrumb-item active">@lang('Users Form')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">@lang('User Form')</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form 
                            id="users-form"
                            role="form"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                        @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">


                                        <div class="form-group">
                                            <label>@lang('Email')</label>
                                            <div class="input-group">
                                                <input 
                                                    type="email"
                                                    name="email" 
                                                    class="form-control @if($errors->has('email')) is-invalid @endif" 
                                                    placeholder="Enter email"
                                                >
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        @
                                                    </span>
                                                </div>
                                                @include('admin._layout.partials.form_errors', ['fieldName' => 'email'])
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input 
                                                type="text" 
                                                name="name"
                                                class="form-control @if($errors->has('name')) is-invalid @endif" 
                                                placeholder="Enter name"
                                            >
                                            @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('Surname')</label>
                                            <input 
                                                type="text" 
                                                name="surname"
                                                class="form-control @if($errors->has('surname')) is-invalid @endif" 
                                                placeholder="Enter surname"
                                            >
                                            @include('admin._layout.partials.form_errors', ['fieldName' => 'surname'])
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('Phone')</label>
                                            <div class="input-group">
                                                <input 
                                                    type="text" 
                                                    name="phone"
                                                    class="form-control @if($errors->has('phone')) is-invalid @endif" 
                                                    placeholder="Enter phone"
                                                >
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </span>
                                                </div>
                                                @include('admin._layout.partials.form_errors', ['fieldName' => 'phone'])
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('Choose New Photo')</label>
                                            <input 
                                                name="photo"
                                                type="file" 
                                                class="form-control"
                                            >
                                        </div>
                                    </div>
                                    <div class="offset-md-3 col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Photo')</label>

                                                    <div class="text-right">
                                                        <button type="button" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-remove"></i>
                                                            @lang('Delete Photo')
                                                        </button>
                                                    </div>
                                                    <div class="text-center">
                                                        <img src="https://via.placeholder.com/400x600" alt=""
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('Save')</button>
                                <a href="users-index.html" class="btn btn-outline-secondary">@lang('Cancel')</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection


@push('footer_javascript')
<script>
    $('#user-form').validate({
        rules: {
            "email": {
                "required": true,
                "email": true
            },
            "name": {
                "required": true,
                "maxlength": 70
            },
            "surname": {
                "required": true,
                "maxlength": 70
            },
            "phone": {
                "required": true,
            },
            "photo": {
                "required": false,
                "maxlength": 65000
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
</script>
@endpush