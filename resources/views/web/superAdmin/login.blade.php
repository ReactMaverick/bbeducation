<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin_lte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition">
    <div class="skd_loder_box" id="fullLoader">
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
    </div>
    <div class="main_box_login">
        <div class="bgimg" style="background-image: url({{ asset('web/images/slider-left-dec.png') }});"></div>

        <div class="loginnavbar">
            <div class="navbar-inner">
                <div class="container">
                    <a href="{{ url('/') }}" class="brand">
                        <img class="img-fluid top_logo" src="{{ asset('web/images/logo.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
        <div class="bgimg1" style="background-image: url({{ asset('web/images/slider-dec.png') }});"></div>
        <div class="login-box">

            <!-- /.login-logo -->
            <div class="card card-outline card-primary new_log_card">

                <div class="card_box">
                    <div class="card-body">
                        <p class="login-box-msg">SYSTEM LOGIN</p>

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

                        <form method="POST" action="{{ url('/system-login-attempt') }}" class="form-validate">
                            @csrf
                            <div class="input-group form-group mb-3">
                                <input type="text"
                                    class="form-control field-validate @error('user_name') is-invalid @enderror"
                                    id="user_name" name="user_name" value="{{ old('user_name') }}"
                                    autocomplete="user_name" autofocus placeholder="Username">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group form-group mb-3">
                                <div class="input_icon">
                                    <input type="password"
                                        class="form-control field-validate @error('password') is-invalid @enderror"
                                        id="password" name="password" autocomplete="current-password"
                                        placeholder="Password">
                                    <span toggle="#password" class="far fa-eye field-icon toggle-password"></span>
                                </div>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <a href="{{ url('/systemForgetPassword') }}">Forgot Password ?</a>
                                </div>

                                <!-- /.col -->
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block mrg_ato">Sign In</button>
                                </div>
                                <!-- /.col -->
                            </div>

                        </form>

                    </div>
                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->

        <div class="container-fluid log_footer">
            <span>© {{ date('Y') }} All Rights Reserved. <a href="https://www.reddragonitsolution.com/"
                    target="_blank">Red Dragon IT Solution Ltd</a></span>
        </div>
    </div>


    <!-- jQuery -->
    <script src="{{ asset('admin_lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin_lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin_lte/dist/js/adminlte.min.js') }}"></script>

    @include('web.common_new.scripts')

    <script>
        $(document).on('click', '#loginResetBtn', function() {
            $('#user_name').val('');
            $('#password').val('');
        });

        $(document).on('click', '#loginBtn', function() {
            $('#fullLoader').show();
        });

        $(document).on('click', '.toggle-password', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
                input.attr("autocomplete", "off");
            } else {
                input.attr("type", "password");
                input.attr("autocomplete", "current-password");
            }
        });
    </script>
</body>

</html>
