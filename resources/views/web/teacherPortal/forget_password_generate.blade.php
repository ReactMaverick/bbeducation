<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>

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
                        <p class="login-box-msg">GENERATE NEW PASSWORD</p>

                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        @if (Session::has('up_password_error'))
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                {!! session('up_password_error') !!}
                            </div>
                        @endif

                        @if (Session::has('up_password_success'))
                            <div class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                {!! session('up_password_success') !!}
                            </div>
                        @endif

                        <?php
                        $forget_user_id = '';
                        if (Session::has('forget_pass_teacher_id')) {
                            $forget_user_id = session('forget_pass_teacher_id');
                        }
                        ?>

                        <form method="POST" action="{{ url('/candidate/processPassword') }}" class="form-validate">
                            @csrf
                            <input type="hidden" name="forget_user_id" value="{{ $forget_user_id }}">

                            <div class="input-group form-group mb-3">
                                <input type="password" class="form-control field-validate" id=""
                                    name="password" autofocus placeholder="New Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group form-group mb-3">
                                <input type="password" class="form-control field-validate" id=""
                                    name="confirm_password" autofocus placeholder="Confirm Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-6">
                                    <a href="{{ URL::to('/candidate') }}">Sign In</a>
                                </div>

                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block mrg_ato">Submit</button>
                                </div>
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
    <script src="{!! asset('plugins/sweetalert/sweetalert.min.js') !!}"></script>

    @include('web.teacherPortal.common.scripts')

</body>

</html>
