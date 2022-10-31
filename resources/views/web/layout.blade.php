<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('web.common.meta')

<body>
    @include('web.common.header')

    @yield('content')
   
    @include('web.common.scripts')
</body>

</html>