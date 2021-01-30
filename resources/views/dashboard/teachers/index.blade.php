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
                        <h1 class="m-0 text-dark">@lang('site.teachers')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('site.teachers')</li>
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
                    <h3 class="card-title">@lang('site.teachers')<small>{{ $teachers->total() }}</small></h3><br>
                    <form action="{{ route('dashboard.teachers.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"  value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="stage">
                                        <option value="">@lang('site.select_stage')</option>
                                        @foreach($stages as $stage)
                                            <option value="{{ $stage->id }}" {{ request()->query('stage') == $stage->id ? 'selected' : '' }}>{{ $stage->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="year">
                                        <option value="">@lang('site.select_year')</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year->id }}" {{ request()->query('year') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="section">
                                        <option value="">@lang('site.select_section')</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ request()->query('section') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="education_system">
                                        <option value="">@lang('site.select_education_system')</option>
                                        @foreach($education_systems as $education_system)
                                            <option value="{{ $education_system->id }}" {{ request()->query('education_system') == $education_system->id ? 'selected' : '' }}>{{ $education_system->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if(auth()->user()->hasPermission('teachers_create'))
                                    <a href="{{ route('dashboard.teachers.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <button class="btn btn-info disabled"><i class="fa fa-plus"></i> @lang('site.add')</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    @if($teachers -> count() > 0)
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.assistants')</th>
                                <th>@lang('site.image_profile')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $index=>$teacher)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $teacher->first_name . ' ' . $teacher->last_name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->teacher_profile->description }}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('assistants_read'))
                                            <a href="{{ url('dashboard/teachers/' . $teacher->id . '/assistants') }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> @lang('site.show_assistants')</a>
                                        @else
                                            <button class="btn btn-primary disabled">@lang('site.show_assistants')</button>
                                        @endif
                                    </td>
                                    <td><img src="{{ $teacher->getImagePathAttribute() }}" alt="@lang('site.image_profile')" style="height: 50px;" class="img-thumbnail"></td>
                                    <td>
                                        @if(auth()->user()->hasPermission('teachers_update'))
                                        <a href="{{ url('dashboard/teachers/' . $teacher->id . '/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-info disabled">@lang('site.update')</button>
                                        @endif
                                            <a href="{{ url('dashboard/teachers/' . $teacher->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> @lang('site.show')</a>
                                        @if(auth()->user()->hasPermission('teachers_delete'))
                                        <form action="{{ route('dashboard.teachers.delete', $teacher->id) }}" method="post" style="display: inline-block">
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
                        {{ $teachers->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
