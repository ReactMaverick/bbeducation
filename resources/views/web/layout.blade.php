<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('web.common.meta')

<body>
    <div id="fullLoader">
        <div class="loadingDiv"></div>
    </div>

    @include('web.common.header')

    @yield('content')

    @include('web.common.scripts')
</body>

</html>
