<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('web.common_new.meta')

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
        @include('web.common_new.header_dash')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        {{-- @include('web.common_new.sidebar') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sidebar_none">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @include('web.common_new.footer_dash')

        <!-- Control Sidebar -->
        {{-- <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar --> --}}
    </div>
    <!-- ./wrapper -->

    @include('web.common_new.scripts')
</body>

</html>
