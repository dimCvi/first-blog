@section('seo_title', 'Users')

@extends('admin._layout.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active">@lang('Users')</li>
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
                                <h3 class="card-title">@lang('Search Users')</h3>
                                <div class="card-tools">
                                    <a href="{{route('admin.users.add')}}" class="btn btn-success">
                                        <i class="fas fa-plus-square"></i>
                                        @lang('Add new User')
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="entities-filter-form">
                                    <div class="row">
                                        <div class="col-md-1 form-group">
                                            <label>@lang('Status')</label>
                                            <select class="form-control" name="status">
                                                <option value="">-- @lang('All') --</option>
                                                <option value="1">@lang('enabled')</option>
                                                <option value="0">@lang('disabled')</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>@lang('Email')</label>
                                            <input 
                                                name="email"
                                                type="text" 
                                                class="form-control" 
                                                placeholder="Search by email"
                                            >
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>@lang('Name')</label>
                                            <input 
                                                name="name"
                                                type="text" 
                                                class="form-control" 
                                                placeholder="Search by name"
                                            >
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>@lang('Phone')</label>
                                            <input 
                                                name="phone"
                                                type="text" 
                                                class="form-control" 
                                                placeholder="Search by phone"
                                            >
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Users</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered" id="users-list-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th style="width: 20px">@LANG('Status')</th>
                                            <th class="text-center">@LANG('Photo')</th>
                                            <th>@lang('Email')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Surname')</th>
                                            <th>@lang('Phone')</th>
                                            <th class="text-center">@lang('Created At')</th>
                                            <th class="text-center">@lang('Actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php /*
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td class="text-center">
                                                <span class="@if($user->status == 1) text-success @else text-danger @endif ">
                                                    @if ($user->status == 1)
                                                        enabled
                                                    @else
                                                        disabled
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <img src="{{$user->photo}}" style="max-width: 80px;">
                                            </td>
                                            <td>
                                                <a href="mailto:{{$user->email}}">
                                                    {{$user->email}}
                                                </a>
                                            </td>
                                            <td>
                                                <strong>{{$user->name}}</strong>
                                            </td>
                                            <td>
                                                <strong>{{$user->surname}}</strong>
                                            </td>
                                            <td>
                                                <a href="tel:{{$user->phone}}">
                                                    {{$user->phone}}
                                                </a>
                                            </td>
                                            <td class="text-center">{{$user->created_at}}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    @if ($user->id != auth()->user()->id)
                                                        <a href="{{route('admin.users.edit', ['user' => $user->id])}}" class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-info" 
                                                        data-toggle="modal"
                                                        data-target="#disable-modal"
                                                        
                                                        data-action="ban"
                                                        data-route="{{route('admin.users.ban', ['user' => $user->id])}}"
                                                        data-id="{{$user->id}}"
                                                        data-name="{{$user->name}}"
                                                    >
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        */?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">

                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
        <!-- /.modal -->
        @include('admin.users.partials.disablemodalform')

        <div class="modal fade" id="enable-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enable User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to enable user?</p>
                        <strong></strong>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success">
                            <i class="fas fa-check"></i>
                            Enable
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('footer_javascript')
    <script type="text/javascript">
        let usersDataTable = $('#users-list-table').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{route('admin.users.datatable')}}",
                "type": "post",
                "data": function(dtData) {
                    dtData["_token"] = "{{csrf_token()}}";
                    dtData["name"] = $('#entities-filter-form [name="name"]').val();
                    dtData["email"] = $('#entities-filter-form [name="email"]').val();
                    dtData["phone"] = $('#entities-filter-form [name="phone"]').val();
                    dtData["status"] = $('#entities-filter-form [name="status"]').val();
                }
            },
            "order": [[6, 'DESC']],
            "columns": [
                {"name": "id", "data": "id", "className": "text-center"},
                {"name": "status", "data": "status", "className": "text-center"},
                {"name": "photo", "data": "photo", "orderable": false, "searchable": false, "className": "text-center"},
                {"name": "email", "data": "email"},
                {"name": "name", "data": "name"},
                {"name": "surname", "data": "surname"},
                {"name": "phone", "data": "phone"},
                {"name": "created_at", "data": "created_at", "className": "text-center"},
                {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"}
            ]
        });
        
        $('#entities-filter-form').on('change', function(e) {
            e.preventDefault();

            usersDataTable.ajax.reload(null, true);
        });

        $('#users-list-table').on('click', '[data-action="ban"]', function(e) {
            let id = $(this).attr('data-id');
            let name = $(this).attr('data-name');

            $('#disable-modal [name="id"]').val(id);
            $('#disable-modal').attr('action', $(this).attr('data-route'));
            $('#disable-modal [data-container="name"]').html(name);
        }); 

        $('#disable-modal').on('submit', function (e) {
            e.preventDefault();

            $(this).modal('hide');

            $.ajax({
                "url": $(this).attr('action'),
                "type": $(this).attr('method'),
                "data": $(this).serialize()
            }).done(function (response) {
                toastr.success(response.system_message);

                usersDataTable.ajax.reload(null, false);

            }).fail(function () {
                toastr.error("@lang('An error occured while changeing the status')");
            });
        });
    </script>
@endpush