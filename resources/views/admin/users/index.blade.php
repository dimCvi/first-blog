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
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Users</li>
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
                                  <a href="users-form.html" class="btn btn-success">
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
                                        <label>Status</label>
                                        <select class="form-control">
                                            <option>-- All --</option>
                                            <option value="">enabled</option>
                                            <option value="">disabled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" placeholder="Search by email">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Search by name">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" placeholder="Search by phone">
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
                              <table class="table table-bordered">
                                  <thead>                  
                                      <tr>
                                          <th style="width: 10px">#</th>
                                          <th style="width: 20px">@LANG('Status')</th>
                                          <th class="text-center">@LANG('Photo')</th>
                                          <th>@lang('Email')</th>
                                          <th>@lang('Name')</th>
                                          <th>@lang('Phone')</th>
                                          <th class="text-center">@lang('Created At')</th>
                                          <th class="text-center">@lang('Actions')</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($users as $user)
                                          <tr>
                                              <td>{{$user->id}}</td>
                                              <td class="text-center">
                                                  <span class="text-success">enabled</span>
                                              </td>
                                              <td class="text-center">
                                                  <img src="https://via.placeholder.com/200" style="max-width: 80px;">
                                              </td>
                                              <td>
                                                  {{$user->email}}
                                              </td>
                                              <td>
                                                  <strong>{{$user->name}}</strong>
                                              </td>
                                              <td>
                                                  {{$user->phone_number ?: 'N/A'}}
                                              </td>
                                              <td class="text-center">{{$user->created_at}}</td>
                                              <td class="text-center">
                                                  <div class="btn-group">
                                                      <a href="#" class="btn btn-info">
                                                          <i class="fas fa-edit"></i>
                                                      </a>
                                                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#disable-modal">
                                                          <i class="fas fa-minus-circle"></i>
                                                      </button>
                                                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                          <i class="fas fa-trash"></i>
                                                      </button>
                                                  </div>
                                              </td>
                                          </tr>
                                      @endforeach
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

      <div class="modal fade" id="delete-modal">
          <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete User')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure you want to delete user')?</p>
                    <strong></strong>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Cancel')</button>
                    <button type="button" class="btn btn-danger">@lang('Delete')</button>
                </div>
              </div>
              <!-- /.modal-content -->
          </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- /.modal -->
      <div class="modal fade" id="disable-modal">
          <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Disable User')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure you want to disable user')?</p>
                    <strong></strong>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Cancel')</button>
                    <button type="button" class="btn btn-danger">
                      <i class="fas fa-minus-circle"></i>
                      @lang('Disable')
                    </button>
                </div>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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