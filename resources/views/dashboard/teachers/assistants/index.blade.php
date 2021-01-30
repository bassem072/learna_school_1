@extends('dashboard.app')

@section('content')
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{@url('/')}}" class="brand-link">
            <img src="{{asset("dashboard_files/img/AdminLTELogo.png")}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8;">
            <span class="brand-text font-weight-light">@lang('site.panel')</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ auth()->user()->getImagePathAttribute() }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ ucfirst(auth()->user()->first_name) . ' ' . ucfirst(auth()->user()->last_name)}}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="@lang('site.search')" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                @lang('site.home')
                            </p>
                        </a>
                    </li>

                    @if(auth()->user()->hasPermission('users_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.admins.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>
                                    @lang('site.admins')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('teachers_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.teachers.index') }}" class="nav-link active">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>
                                    @lang('site.teachers')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('assistants_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.assistants.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-hands-helping"></i>
                                <p>
                                    @lang('site.assistants')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('subjects_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.subjects.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>
                                    @lang('site.subjects')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('levels_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.levels.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    @lang('site.levels')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('terms_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.terms.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-school"></i>
                                <p>
                                    @lang('site.terms')
                                </p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.assistants')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.teachers.index') }}">@lang('site.teachers')</a></li>
                            <li class="breadcrumb-item active">@lang('site.assistants')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">@lang('site.assistants')<small>{{ $assistants->count() }}</small></h3><br>
                    <h6>{{ $teacher->first_name }}</small></h6>
                    <form action="{{ route('dashboard.assistants.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"  value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if(auth()->user()->hasPermission('assistants_create'))
                                    <a href="{{ route('dashboard.teachers.assistants.create', $teacher->id) }}" class="btn btn-info"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <button class="btn btn-info disabled"><i class="fa fa-plus"></i> @lang('site.add')</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    @if($assistants -> count() > 0)
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.first_name')</th>
                                <th>@lang('site.last_name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.teachers')</th>
                                <th>@lang('site.image_profile')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($assistants as $index=>$assistant)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $assistant->assistant->first_name }}</td>
                                    <td>{{ $assistant->assistant->last_name }}</td>
                                    <td>{{ $assistant->assistant->email }}</td>
                                    <td>{{ $assistant->description }}</td>
                                    <td>{{ $teacher->first_name }}</td>
                                    <td><img src="{{ $assistant->assistant->getImagePathAttribute() }}" alt="@lang('site.image_profile')" style="height: 50px;" class="img-thumbnail"></td>
                                    <td>
                                        @if(auth()->user()->hasPermission('assistants_update'))
                                            <a href="{{ url('dashboard/teachers/'. $teacher->id .'/assistants/' . $assistant->assistant->id . '/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-info disabled">@lang('site.update')</button>
                                        @endif
                                        @if(auth()->user()->hasPermission('assistants_delete'))
                                        <form action="{{ route('dashboard.teachers.assistants.delete', [$teacher->id, $assistant->id]) }}" method="post" style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        </form>
                                        @else
                                            <button class="btn btn-danger disabled">@lang('site.delete')</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $assistants->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
