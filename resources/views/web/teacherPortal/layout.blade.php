<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('web.teacherPortal.common.meta')

<body>
    @include('web.teacherPortal.common.header')

    @yield('content')

    @include('web.teacherPortal.common.scripts')
</body>

</html>
