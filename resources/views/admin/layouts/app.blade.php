<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | {{ __('trans.dashboard') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.css') }}">
    <!-- Theme style -->
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    @endif

    @stack('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('admin.layouts.partials._nav')
    @include('admin.layouts.partials._sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $pageName ?? __('trans.dashboard') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('trans.home')</a></li>
                            <li class="breadcrumb-item active">{{ $pageName ?? __('trans.dashboard') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('adminlte') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte') }}/js/adminlte.min.js"></script>
<script src="{{ asset('adminlte/js/custom.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "{{ __('trans.choose') }}"
        });
    });
</script>
<script>
    $( function() {
        $( ".datepicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
        });
    } );
</script>
@stack('js')
</body>
</html>
