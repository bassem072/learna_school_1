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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.teachers.index') }}">@lang('site.teachers')</a></li>
                            <li class="breadcrumb-item active">@lang('site.show')</li>
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
                    <div class="row">
                        <h3 class="card-title">@lang('site.show')</h3><br>
                        <button type="button" class="btn btn-info btn-sm mr-auto" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i></button>
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="{{ route('dashboard.teachers.add_subject', $teacher->id) }}">
                                        @method('POST')
                                        @csrf
                                        <div class="modal-body">
                                            <label for="level"></label>
                                            <select class="form-control" id="level" name="subject_id">
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site.cancel')</button>
                                            <button type="submit" class="btn btn-primary">@lang('site.add')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <h4>@lang('site.subjects')</h4>
                    <div id="accordion">
                        @foreach($teacher->subjects as $i=>$subject)
                            <div class="card">
                                <div class="card-header" id="heading{{ $subject->id }}">
                                    <div class="row">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $subject->id }}" aria-expanded="true" aria-controls="collapse{{ $subject->id }}">
                                                {{ $subject->name }}
                                            </button>
                                        </h5>
                                        <button type="button" class="btn btn-info btn-sm mr-auto" data-toggle="modal" data-target="#subject{{ $subject->id }}"><i class="fa fa-plus"></i></button>
                                        <div class="modal fade" id="subject{{ $subject->id }}" tabindex="-1" role="dialog" aria-labelledby="subject{{ $subject->id }}Title" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post" action="{{ route('dashboard.teachers.add_level', $teacher->id) }}">
                                                        @method('POST')
                                                        @csrf
                                                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                                        <div class="modal-body">
                                                            <label for="level"></label>
                                                            <select class="form-control" id="level" name="level_id">
                                                                @foreach($subject->levels as $level)
                                                                    <option value="{{ $level->id }}">{{ $level->stage->name . ' - ' . $level->year->name . ' - ' . $level->section->name . ' - ' . $level->education_system->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site.cancel')</button>
                                                            <button type="submit" class="btn btn-primary">@lang('site.add')</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapse{{ $subject->id }}" class="collapse show" aria-labelledby="heading{{ $subject->id }}" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="list-group">
                                            @foreach($levels[$i] as $level)
                                                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">{{ $level->stage->name . ' - ' . $level->year->name . ' - ' . $level->section->name . ' - ' . $level->education_system->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection