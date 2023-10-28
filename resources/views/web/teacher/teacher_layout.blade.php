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

        <!-- Navbar -->
        @include('web.common_new.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('web.teacher.teacher_sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @include('web.common_new.footer')

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
