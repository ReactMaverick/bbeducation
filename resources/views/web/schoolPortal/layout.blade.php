<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('web.schoolPortal.common.meta')

<body class="hold-transition sidebar-mini layout-fixed">
    {{-- <div class="skd_loder_box">
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
    </div> --}}
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('admin_lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div> --}}


        <!-- Navbar -->
        @include('web.schoolPortal.common.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('web.schoolPortal.common.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @include('web.schoolPortal.common.footer')

        <!-- Control Sidebar -->
        {{-- <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar --> --}}
    </div>
    <!-- ./wrapper -->

    @include('web.schoolPortal.common.scripts')
</body>

</html>
