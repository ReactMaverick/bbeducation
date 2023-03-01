<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- font-awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('web/css/all.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap"
        rel="stylesheet">

    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    {{-- <script src="{{ asset('web/js/bootstrap.bundle.min.js') }}"></script> --}}

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/datatables.min.css') }}" />

    <script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTableNew/datatables.min.css') }}" />

    <script type="text/javascript" src="{{ asset('plugins/DataTableNew/datatables.min.js') }}"></script>
    {{-- <script type="text/javascript" charset="utf8" src="{{ asset('plugins/DataTableNew/pdfmake.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('plugins/DataTableNew/vfs_fonts.js') }}"></script> --}}

    <!-- Select2 -->
    <link rel="stylesheet" href="{!! asset('plugins/select2/select2.min.css') !!} ">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

</head>
