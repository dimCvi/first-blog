@section('seo_title', 'Profile Edit')

@extends('admin._layout.layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('User Profile')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile')</li>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('User profile info')</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form 
                            id="user-form"
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
                                            <input 
                                                type="email" 
                                                name="email"
                                                class="form-control @if($errors->has('email')) is-invalid @endif" 
                                                placeholder="Enter email"
                                                value="{{old('email', $user->email)}}"
                                                
                                            >
                                            @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input 
                                                type="text" 
                                                name="name"
                                                class="form-control @if($errors->has('name')) is-invalid @endif" 
                                                placeholder="Enter name"
                                                value="{{old('name', $user->name)}}"
                                                
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
                                                value="{{old('surname', $user->surname)}}"
                                                
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
                                                    value="{{old('phone', $user->phone)}}"
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
                                                        <img src="{{$user->photo}}" alt=""
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
                                <a href="{{route('admin.users.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
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
            "name": {
                "required": false,
                "maxlength": 70
            },
            "email": {
                "required": false
            },
            "surname": {
                "required": false,
                "maxlength": 70
            },
            "phone": {
                "required": false
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