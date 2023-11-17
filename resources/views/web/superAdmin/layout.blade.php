<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('web.superAdmin.common.meta')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="skd_loder_box" id="fullLoader">
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
    </div>
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('admin_lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
        height="60" width="60">
    </div> --}}


        <!-- Navbar -->
        @include('web.superAdmin.common.header_dash')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        {{-- @include('web.superAdmin.common.sidebar') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sidebar_none">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @include('web.superAdmin.common.footer_dash')

        <!-- Control Sidebar -->
        {{-- <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar --> --}}
    </div>
    <!-- ./wrapper -->

    @include('web.superAdmin.common.scripts')
</body>

</html>
