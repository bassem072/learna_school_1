<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('site.dashboard')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("dashboard_files/plugins/fontawesome-free/css/all.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset("dashboard_files/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset("dashboard_files/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset("dashboard_files/plugins/jqvmap/jqvmap.min.css")}}">
    <!-- Noty -->
    <link rel="stylesheet" href="{{asset("dashboard_files/plugins/jqvmap/jqvmap.min.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/noty.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/custom.css")}}"/>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("dashboard_files/css/adminlte.min.css")}}">
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{asset("dashboard_files/css/adminlte-rtl-v3.css")}}">
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset("dashboard_files/css/custom.css")}}">
    @endif
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset("dashboard_files/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset("dashboard_files/plugins/daterangepicker/daterangepicker.css")}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset("dashboard_files/plugins/summernote/summernote-bs4.min.css")}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
