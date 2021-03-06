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
                            <a href="{{ route('dashboard.admins.index') }}" class="nav-link active">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>
                                    @lang('site.admins')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('teachers_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.teachers.index') }}" class="nav-link">
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
                        <h1 class="m-0 text-dark">@lang('site.admins')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.admins.index') }}">@lang('site.admins')</a></li>
                            <li class="breadcrumb-item active">@lang('site.add')</li>
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
                    <h3 class="card-title">@lang('site.add')</h3><br>
                </div>
                <div class="card-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.admins.store') }}" method="POST" enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                        <div class="form-group">
                            <label>@lang('site.first_name')</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.last_name')</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <label>@lang('site.image_profile')</label>
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-2 imgUp">
                                    <div class="imagePreview"></div>
                                    <label class="btn btn-primary button-image">
                                        Upload<input type="file" name="image" class="uploadFile img" value="{{ old('image') }}" accept="image/*" style="width: 0px;height: 0px;overflow: hidden;">
                                    </label>
                                </div><!-- col-2 -->
                            </div><!-- row -->
                        </div><!-- container -->

                        <div class="form-group">

                        </div>

                        <div class="form-group">
                            <label>@lang('site.password')</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.confirm_password')</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <!-- Custom Tabs -->
                        <div class="form-group">
                            <h5 class="mt-4 mb-2">@lang('site.permissions')</h5>
                            <div class="card">
                                <div class="card-header d-flex p-0">
                                    @php
                                        $models = ['users', 'teachers', 'subjects', 'levels', 'terms'];
                                    @endphp
                                    <ul class="nav nav-pills ml-auto p-2">
                                        @foreach($models as $index=>$model)
                                            <li class="nav-item"><a class="nav-link {{ $index == 0 ? 'active' : '' }}" href="#tab_{{ $index }}" data-toggle="tab">@lang('site.' . $model)</a></li>
                                        @endforeach
                                        {{--<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">@lang('site.users')</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">@lang('site.users')</a></li>--}}
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        @foreach($models as $index=>$model)
                                            <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="tab_{{ $index }}">
                                            <div class="row">
                                                @php
                                                    $maps = ['create', 'read', 'update', 'delete'];
                                                @endphp
                                                @foreach($maps as $index1=>$map)
                                                    <div class="form-check col-md-3">
                                                        <input type="checkbox" class="form-check-input" name="permissions[]" value="{{$model . '_' . $map}}" id="exampleCheck{{$index . $index1}}">
                                                        <label class="form-check-label" for="exampleCheck{{$index . $index1}}">@lang('site.' . $map)</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                        {{--<div class="tab-pane" id="tab_2">
                                            <div class="row">
                                                <div class="form-check col-md-3">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="create_users" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">@lang('site.create')</label>
                                                </div>

                                                <div class="form-check col-md-3">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="read_users" id="exampleCheck2">
                                                    <label class="form-check-label" for="exampleCheck2">@lang('site.read')</label>
                                                </div>

                                                <div class="form-check col-md-3">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="update_users" id="exampleCheck3">
                                                    <label class="form-check-label" for="exampleCheck3">@lang('site.update')</label>
                                                </div>

                                                <div class="form-check col-md-3">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="delete_users" id="exampleCheck4">
                                                    <label class="form-check-label" for="exampleCheck4">@lang('site.delete')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_3">
                                            <div class="row">
                                                <div class="form-check col-md-3">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="create_users" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">@lang('site.create')</label>
                                                </div>

                                                <div class="form-check col-md-3">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="read_users" id="exampleCheck2">
                                                    <label class="form-check-label" for="exampleCheck2">@lang('site.read')</label>
                                                </div>

                                                <div class="form-check col-md-3">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="update_users" id="exampleCheck3">
                                                    <label class="form-check-label" for="exampleCheck3">@lang('site.update')</label>
                                                </div>

                                                <div class="form-check col-md-3">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="delete_users" id="exampleCheck4">
                                                    <label class="form-check-label" for="exampleCheck4">@lang('site.delete')</label>
                                                </div>
                                            </div>
                                        </div>--}}
                                        <!-- /.tab-pane -->
                                    </div>
                                </div><!-- /.card-body -->
                            </div>
                        </div>
                        <!-- ./card -->

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
