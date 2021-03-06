<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.index.index')}}" class="brand-link">
        <img src="{{url('/themes/admin/dist/img/AdminLTELogo.png')}}" alt="Cubes School Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">@lang('Cubes School')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            @lang('Pages')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.index.index')}}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Home')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.users.index')}}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Users')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.posts.index')}}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Posts')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.categories.index')}}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Categories')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.sliders.index')}}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Sliders')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.tags.index')}}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Tags')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.comments.index')}}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Comments')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Simple Link
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>