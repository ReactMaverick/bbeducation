<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed&family=Inter&family=Merriweather:ital,wght@1,300&family=Montserrat:ital,wght@0,400;1,300&family=Raleway:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .forget_pass_btn {
        display: flex;
        justify-content: end;
        align-items: center;
        margin-top: 10px;
    }

    .forget_pass_btn a {
        color: #bb0404;
        text-decoration: none;
    }
</style>

<body>
    <div id="fullLoader">
        <div class="loadingDiv"></div>
    </div>
    <div class="container-fluid">
        <div class="container login-container">
            <div class="login-row">
                <div class="login-section" style="width: 60%;">
                    <div class="login-page-img">
                        <img src="{{ asset('web/images/mymooncloud-logo.png') }}" alt="">
                    </div>
                    <h2>CANDIDATE FILE UPLOAD</h2>

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    @if (Session::has('loginError'))
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>
                            {!! session('loginError') !!}
                        </div>
                    @endif

                    @if (Session::has('loginSuccess'))
                        <div class="alert alert-success" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            {!! session('loginSuccess') !!}
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/testTeacherFileUpload') }}" class="form-validate">
                        @csrf
                        <div class="form-group row login-form-sec">
                            <label for="" class="col-sm-3 col-form-label">Local Path</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control field-validate" id="local_path"
                                    name="local_path" value="" autocomplete="" autofocus placeholder="Local Path">
                            </div>
                        </div>
                        <div class="login-button-sec" style="justify-content: right;">
                            <button type="button" class="btn btn-primary" id="fileSubmit">Upload</button>
                        </div>
                    </form>
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>

    @include('web.teacherPortal.common.scripts')

    <script>
        $(document).on('click', '#fileSubmit', function() {
            var local_path = $('#local_path').val();
            if (local_path) {
                $('#fullLoader').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/testTeacherFileUpload') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        local_path: local_path
                    },
                    success: function(data) {
                        console.log(data);
                        $('#fullLoader').hide();
                        swal("", "Files has been upload successfully.");
                    }
                });
            } else {
                swal("", "Please enter local path.");
            }
        });
    </script>

</body>

</html>
