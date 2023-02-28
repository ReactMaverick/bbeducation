<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('web.schoolPortal.common.meta')

<body>
    @include('web.schoolPortal.common.header')

    @yield('content')

    @include('web.schoolPortal.common.scripts')
</body>

</html>
