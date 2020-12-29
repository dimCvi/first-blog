@section('seo_title', 'Posts')

@extends('admin._layout.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Posts</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active">@lang('Posts')</li>
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
                                <h3 class="card-title">@lang('Search Posts')</h3>
                                <div class="card-tools">
                                    <a href="{{route('admin.posts.add')}}" class="btn btn-success">
                                        <i class="fas fa-plus-square"></i>
                                        @lang('Add a new post')
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
                                        <div class="col-md-1 form-group">
                                            <label>@lang('Featured')</label>
                                            <select class="form-control" name="featured">
                                                <option value="">-- @lang('All') --</option>
                                                <option value="1">@lang('important')</option>
                                                <option value="0">@lang('unimportant')</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>@lang('Author')</label>
                                            <input 
                                                name="author"
                                                type="text" 
                                                class="form-control" 
                                                placeholder="Search by author"
                                            >
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>@lang('Title')</label>
                                            <input 
                                                name="title"
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
                                <h3 class="card-title">All Posts</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered" id="posts-list-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th style="width: 20px">@LANG('Status')</th>
                                            <th style="width: 20px">@LANG('Featured')</th>
                                            <th class="text-center">@LANG('Photo')</th>
                                            <th>@lang('Title')</th>
                                            <th>@lang('Author')</th>
                                            <th>@lang('Views')</th>
                                            <th>@lang('Comments')</th>
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
        @include('admin.posts.partials.disablemodalform')

        @include('admin.posts.partials.featuredmodalform')
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('footer_javascript')
    <script type="text/javascript">
        let postsDataTable = $('#posts-list-table').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{route('admin.posts.datatable')}}",
                "type": "post",
                "data": function(dtData) {
                    dtData["_token"] = "{{csrf_token()}}";
                    dtData["title"] = $('#entities-filter-form [name="title"]').val();
                    dtData["text"] = $('#entities-filter-form [name="text"]').val();
                    dtData["author"] = $('#entities-filter-form [name="author"]').val();
                    dtData["status"] = $('#entities-filter-form [name="status"]').val();
                    dtData["comments"] = $('#entities-filter-form [name="comments"]').val();
                    dtData["featured"] = $('#entities-filter-form [name="featured"]').val();
                }
            },
           
            "columns": [
                {"name": "id", "data": "id", "className": "text-center"},
                {"name": "status", "data": "status", "className": "text-center", "searchable": false, "className": "text-center"},
                {"name": "featured", "data": "featured", "searchable": false, "className": "text-center"},
                {"name": "photo", "data": "photo", "orderable": false, "searchable": false, "className": "text-center"},
                {"name": "title", "data": "title"},
                {"name": "author", "data": "author", "orderable": false},
                {"name": "views", "data": "views"},
                {"name": "comments", "data": "comments", "className": "text-center", "orderable": false},
                {"name": "created_at", "data": "created_at", "searchable": false, "className": "text-center"},
                {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"},
            ]
        });
        
        $('#entities-filter-form').on('change', function(e) {
            e.preventDefault();

            postsDataTable.ajax.reload(null, true);
        });

        $('#posts-list-table').on('click', '[data-action="ban"]', function(e) {
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

                postsDataTable.ajax.reload(null, false);

            }).fail(function () {
                toastr.error("@lang('An error occured while changeing the status')");
            });
        });
        $('#posts-list-table').on('click', '[data-action="change_featured"]', function(e) {
            let id = $(this).attr('data-id');
            let name = $(this).attr('data-name');

            $('#featured-modal [name="id"]').val(id);
            $('#featured-modal').attr('action', $(this).attr('data-route'));
            $('#featured-modal [data-container="name"]').html(name);
        }); 

        $('#featured-modal').on('submit', function (e) {
            e.preventDefault();

            $(this).modal('hide');

            $.ajax({
                "url": $(this).attr('action'),
                "type": $(this).attr('method'),
                "data": $(this).serialize()
            }).done(function (response) {
                toastr.success(response.system_message);

                postsDataTable.ajax.reload(null, false);

            }).fail(function () {
                toastr.error("@lang('An error occured while changeing the status')");
            });
        });
    </script>
@endpush