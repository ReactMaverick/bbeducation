<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin_lte/dist/css/adminlte.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Select2 -->

    <!-- jQuery -->
    <script src="{{ asset('admin_lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin_lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('web/images/mymooncloud-logo.png') }}" alt="" style="width: 60%;">
            </div>
            <div class="card-body">
                <p class="login-box-msg">COMMON SCHOOL LOGIN</p>

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

                <form method="POST" action="{{ url('/school/schoolProcessCommonLogin') }}" class="form-validate">
                    @csrf

                    <div class="input-group form-group mb-3">
                        <select class="form-control field-validate" id="select2-ajax" style="width: 100%;"
                            name="selected_school">
                        </select>
                    </div>

                    <div class="input-group form-group mb-3">
                        <input type="text"
                            class="form-control field-validate @error('user_name') is-invalid @enderror" id="user_name"
                            name="user_name" value="{{ old('user_name') }}" autocomplete="user_name" autofocus
                            placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group form-group mb-3">
                        <input type="password"
                            class="form-control field-validate @error('password') is-invalid @enderror" id="password"
                            name="password" autocomplete="current-password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            {{-- <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div> --}}
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                {{-- <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p> --}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin_lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin_lte/dist/js/adminlte.min.js') }}"></script>

    @include('web.schoolPortal.common.scripts')

    <script>
        $(document).ready(function() {
            var select2Input = $('#select2-ajax');
            select2Input.select2({
                placeholder: 'Select School',
                ajax: {
                    url: '{{ url('/school/fetchSchoolAjax') }}',
                    dataType: 'json',
                    delay: 250, // Delay before sending the request
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.school_id,
                                    text: item.name_txt
                                };
                            })
                        };
                    },
                    cache: true
                },
                // maximumSelectionLength: 1, // Allow only one selection
                minimumInputLength: 1 // Trigger the AJAX request after at least 1 character is typed
            });

            select2Input.on('select2:open', function() {
                $('.select2-search__field').focus();
            });

        });
    </script>


</body>

</html>
