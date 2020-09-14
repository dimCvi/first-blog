@section('seo_title', 'Sliders')

@extends('admin._layout.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sliders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active">@lang('Sliders')</li>
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
                                <h3 class="card-title">@lang('Search Sliders')</h3>
                                <div class="card-tools">
                                    <a href="{{route('admin.sliders.add')}}" class="btn btn-success">
                                        <i class="fas fa-plus-square"></i>
                                        @lang('Add a new slider')
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
                                            <label>@lang('Header')</label>
                                            <input 
                                                name="header"
                                                type="text" 
                                                class="form-control" 
                                                placeholder="Search by header"
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
                                <h3 class="card-title">All Sliders</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered" id="sliders-list-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th style="width: 20px">@LANG('Header')</th>
                                            <th class="text-center">@LANG('Status')</th>
                                            <th class="text-center">@LANG('URL')</th>
                                            <th class="text-center">@LANG('Photo')</th>
                                            <th class="text-center">@lang('Created At')</th>
                                            <th class="text-center">@lang('Actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
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
        @include('admin.sliders.partials.deletemodalform')

        @include('admin.sliders.partials.changestatusmodalform')
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('footer_javascript')
    <script type="text/javascript">
        let slidersDataTable = $('#sliders-list-table').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{route('admin.sliders.datatable')}}",
                "type": "post",
                "data": function(dtData) {
                    dtData["_token"] = "{{csrf_token()}}";
                    dtData["header"] = $('#entities-filter-form [name="header"]').val();
                    dtData["status"] = $('#entities-filter-form [name="status"]').val();
                    dtData["url"] = $('#entities-filter-form [name="url"]').val();
                }
            },
           
            "columns": [
                {"name": "id", "data": "id", "className": "text-center"},
                {"name": "header", "data": "header", "className": "text-center"},
                {"name": "status", "data": "status", "searchable": false, "className": "text-center"},
                {"name": "url", "data": "url", "searchable": false, "className": "text-center", "orderable": false},
                {"name": "photo", "data": "photo", "orderable": false, "searchable": false, "className": "text-center"},
                {"name": "created_at", "data": "created_at", "searchable": false, "className": "text-center"},
                {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"},
            ]
        });
        
        $('#entities-filter-form').on('change', function(e) {
            e.preventDefault();

            slidersDataTable.ajax.reload(null, true);
        });

        $('#sliders-list-table').on('click', '[data-action="delete"]', function(e) {
            let id = $(this).attr('data-id');
            let name = $(this).attr('data-name');

            $('#delete-modal [name="id"]').val(id);
            $('#delete-modal').attr('action', $(this).attr('data-route'));
        }); 

        $('#delete-modal').on('submit', function (e) {
            e.preventDefault();

            $(this).modal('hide');

            $.ajax({
                "url": $(this).attr('action'),
                "type": $(this).attr('method'),
                "data": $(this).serialize()
            }).done(function (response) {
                toastr.success(response.system_message);

                slidersDataTable.ajax.reload(null, false);

            }).fail(function () {
                toastr.error("@lang('An error occured while changeing the status')");
            });
        });
        $('#sliders-list-table').on('click', '[data-action="changestatus"]', function(e) {
            let id = $(this).attr('data-id');
            let name = $(this).attr('data-name');

            $('#status-modal [name="id"]').val(id);
            $('#status-modal').attr('action', $(this).attr('data-route'));
        }); 

        $('#status-modal').on('submit', function (e) {
            e.preventDefault();

            $(this).modal('hide');

            $.ajax({
                "url": $(this).attr('action'),
                "type": $(this).attr('method'),
                "data": $(this).serialize()
            }).done(function (response) {
                toastr.success(response.system_message);

                slidersDataTable.ajax.reload(null, false);

            }).fail(function () {
                toastr.error("@lang('An error occured while changeing the status')");
            });
        });
    </script>
@endpush