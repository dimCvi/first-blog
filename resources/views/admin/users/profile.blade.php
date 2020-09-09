@section('seo_title', 'Profile')

@extends('admin._layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('Your Profile')</h1>
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
                            <h3 class="card-title">@lang('Change your profile info')</h3>
                            <div class="card-tools">
                                <a href="{{route('admin.users.change_password')}}" class="btn btn-outline-warning">
                                    <i class="fas fa-lock-open"></i>
                                    @lang('Change Password')
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form 
                            role="form"
                            id="profile_form"
                            enctype="multipart/form-data"
                            method="POST"
                        >
                        @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">


                                        <div class="form-group">
                                            <label>@lang('Email')</label>
                                            <div><strong>{{auth()->user()->email}}</strong></div>
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input 
                                                type="text" 
                                                name="name"
                                                class="form-control @if($errors->has('name')) is-invalid @endif" 
                                                placeholder="Enter name"
                                                value="{{old('name', auth()->user()->name)}}" 
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
                                                value="{{old('surname', auth()->user()->surname)}}" 
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
                                                    value="{{old('phone', auth()->user()->phone)}}"
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
                                                type="file"
                                                name="photo" 
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
                                                        <img src="{{auth()->user()->photo ?: 'https://picsum.photos/200/300'}}" alt=""
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
<!-- /.content-wrapper -->
@endsection

@push('footer_javascript')
<script>
    $('#profile_form').validate({
        rules: {
            "name": {
                "required": false,
                "max": 255
            },

            "phone": {
                "required": false,
                "numeric": true
            },
            "photo": {
                "required": false,
                "maxlength": 65000
            }
        },
        });


</script>
@endpush