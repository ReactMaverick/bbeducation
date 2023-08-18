<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('web.teacherPortal.common.meta')

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
        @include('web.teacherPortal.common.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('web.teacherPortal.common.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @include('web.teacherPortal.common.footer')

        <!-- Control Sidebar -->
        {{-- <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar --> --}}
    </div>
    <!-- ./wrapper -->

    @include('web.teacherPortal.common.scripts')
</body>

</html>
