@section('seo_title', 'Tags')

@extends('admin._layout.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tags</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active">@lang('Tags')</li>
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
                                <h3 class="card-title">@lang('Search Tags')</h3>
                                <div class="card-tools">
                                    <a href="{{route('admin.tags.add')}}" class="btn btn-success">
                                        <i class="fas fa-plus-square"></i>
                                        @lang('Add a new tag')
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="entities-filter-form">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>@lang('Name')</label>
                                            <input 
                                                name="name"
                                                type="text" 
                                                class="form-control" 
                                                placeholder="Search by name"
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
                                <h3 class="card-title">All Tags</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered" id="tags-list-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th style="width: 20px">@LANG('Name')</th>
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
        @include('admin.tags.partials.deletemodalform')

    </div>
    <!-- /.content-wrapper -->
@endsection

@push('footer_javascript')
    <script type="text/javascript">
        let tagsDataTable = $('#tags-list-table').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{route('admin.tags.datatable')}}",
                "type": "post",
                "data": function(dtData) {
                    dtData["_token"] = "{{csrf_token()}}";
                    dtData["name"] = $('#entities-filter-form [name="name"]').val();
                }
            },
           
            "columns": [
                {"name": "id", "data": "id", "className": "text-center"},
                {"name": "name", "data": "name", "className": "text-center"},
                {"name": "created_at", "data": "created_at", "searchable": false, "className": "text-center"},
                {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"},
            ]
        });
        
        $('#entities-filter-form').on('keyup', function(e) {
            e.preventDefault();

            tagsDataTable.ajax.reload(null, true);
        });

        $('#tags-list-table').on('click', '[data-action="delete"]', function(e) {
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

                tagsDataTable.ajax.reload(null, false);

            }).fail(function () {
                toastr.error("@lang('An error occured while changeing the status')");
            });
        });
        // $('#tags-list-table').on('click', '[data-action="changestatus"]', function(e) {
        //     let id = $(this).attr('data-id');
        //     let name = $(this).attr('data-name');

        //     $('#status-modal [name="id"]').val(id);
        //     $('#status-modal').attr('action', $(this).attr('data-route'));
        // }); 

        // $('#status-modal').on('submit', function (e) {
        //     e.preventDefault();

        //     $(this).modal('hide');

        //     $.ajax({
        //         "url": $(this).attr('action'),
        //         "type": $(this).attr('method'),
        //         "data": $(this).serialize()
        //     }).done(function (response) {
        //         toastr.success(response.system_message);

        //         tagsDataTable.ajax.reload(null, false);

        //     }).fail(function () {
        //         toastr.error("@lang('An error occured while changeing the status')");
        //     });
        // });
    </script>
@endpush