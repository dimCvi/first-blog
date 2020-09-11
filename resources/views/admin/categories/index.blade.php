@section('seo_title', 'Categories')

@extends('admin._layout.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active">@lang('Categories')</li>
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
                                <h3 class="card-title">@lang('Search Categories')</h3>
                                <div class="card-tools">
                                    <a href="{{route('admin.categories.add')}}" class="btn btn-success">
                                        <i class="fas fa-plus-square"></i>
                                        @lang('Add a new category')
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="entities-filter-form">
                                    <div class="row">
                                        <div class="col-md-1 form-group">
                                            <label>@lang('Priority')</label>
                                            <select class="form-control" name="priority">
                                                <option value="">-- @lang('All') --</option>
                                                <option value="1">@lang('important')</option>
                                                <option value="0">@lang('unimportant')</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>@lang('Header')</label>
                                            <input 
                                                name="header"
                                                type="text" 
                                                class="form-control" 
                                                placeholder="Search by author"
                                            >
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>@lang('Description')</label>
                                            <input 
                                                name="description"
                                                type="text" 
                                                class="form-control" 
                                                placeholder="Search by title"
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
                                <h3 class="card-title">All Categories</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered" id="categories-list-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th style="width: 20px">@LANG('Header')</th>
                                            <th class="text-center">@LANG('Priority')</th>
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
        @include('admin.categories.partials.deletemodalform')

        @include('admin.categories.partials.changeprioritymodalform')
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('footer_javascript')
    <script type="text/javascript">
        let categoriesDataTable = $('#categories-list-table').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{route('admin.categories.datatable')}}",
                "type": "post",
                "data": function(dtData) {
                    dtData["_token"] = "{{csrf_token()}}";
                    dtData["header"] = $('#entities-filter-form [name="header"]').val();
                    dtData["priority"] = $('#entities-filter-form [name="priority"]').val();
                }
            },
           
            "columns": [
                {"name": "id", "data": "id", "className": "text-center"},
                {"name": "header", "data": "header", "className": "text-center", "className": "text-center"},
                {"name": "priority", "data": "priority", "searchable": false, "className": "text-center"},
                {"name": "created_at", "data": "created_at", "searchable": false, "className": "text-center"},
                {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"},
            ]
        });
        
        $('#entities-filter-form').on('change', function(e) {
            e.preventDefault();

            categoriesDataTable.ajax.reload(null, true);
        });

        $('#categories-list-table').on('click', '[data-action="delete"]', function(e) {
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

                categoriesDataTable.ajax.reload(null, false);

            }).fail(function () {
                toastr.error("@lang('An error occured while changeing the status')");
            });
        });
        $('#categories-list-table').on('click', '[data-action="changepriority"]', function(e) {
            let id = $(this).attr('data-id');
            let name = $(this).attr('data-name');

            $('#priority-modal [name="id"]').val(id);
            $('#priority-modal').attr('action', $(this).attr('data-route'));
        }); 

        $('#priority-modal').on('submit', function (e) {
            e.preventDefault();

            $(this).modal('hide');

            $.ajax({
                "url": $(this).attr('action'),
                "type": $(this).attr('method'),
                "data": $(this).serialize()
            }).done(function (response) {
                toastr.success(response.system_message);

                categoriesDataTable.ajax.reload(null, false);

            }).fail(function () {
                toastr.error("@lang('An error occured while changeing the status')");
            });
        });
    </script>
@endpush