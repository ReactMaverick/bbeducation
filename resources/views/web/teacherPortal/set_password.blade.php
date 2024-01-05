<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Candidate</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin_lte/dist/css/adminlte.min.css') }}">
    <style>
        .form-group.has-error {
            border-color: #dd4b39 !important;
        }
    </style>
</head>

<body class="hold-transition">
    {{-- <div class="skd_loder_box" id="fullLoader">
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
        <div class="skd_ldr"></div>
    </div> --}}
    <div class="main_box_login">
        <div class="bgimg" style="background-image: url({{ asset('web/images/slider-left-dec.png') }});"></div>

        <div class="loginnavbar">
            <div class="navbar-inner">
                <div class="container">
                    <a href="javascript:void(0)" class="brand new_br">
                        <img class="img-fluid top_logo"
                            src="{{ count($companyDetail) > 0 ? asset($companyDetail[0]->company_logo) : '' }}"
                            alt="" style="width: 50px;">
                        <p class="">{{ count($companyDetail) > 0 ? $companyDetail[0]->company_name : '' }}
                        </p>
                    </a>
                </div>
            </div>
        </div>
        <div class="bgimg1" style="background-image: url({{ asset('web/images/slider-dec.png') }});"></div>
        <div class="login-box">

            <!-- /.login-logo -->
            <div class="card card-outline card-primary new_log_card">
                {{-- <div class="card-header text-center">
                    <img src="{{ asset('web/images/mymooncloud-logo.png') }}" alt="" style="width: 60%;">
                </div> --}}
                <div class="card_box">
                    <div class="card-body">
                        <p class="login-box-msg">Reset Your Password</p>

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

                        <form action="{{ url('/candidate/teacherPasswordUpdate') }}" method="post"
                            class="reset-password-form-sec form-validate">
                            @csrf
                            <input type="hidden" name="teacher_id" value="{{ $teacher_id }}">

                            <div class="input-group form-group mb-3">
                                <div class="input_icon">
                                    <input type="password" class="form-control field-validate" id="password-input-sec"
                                        name="password" placeholder="Password">
                                    <span toggle="#password-input-sec"
                                        class="far fa-eye field-icon toggle-password"></span>
                                </div>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group form-group mb-3">
                                <div class="input_icon">
                                    <input type="password" class="form-control field-validate"
                                        id="confirm-password-input-sec" name="confirm_password"
                                        placeholder="Confirm Password">
                                    <span toggle="#confirm-password-input-sec"
                                        class="far fa-eye field-icon toggle-password"></span>
                                </div>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-6"></div>

                                <div class="col-6">
                                    @if ($teacherDetail)
                                        <button type="submit" class="btn btn-primary btn-block mrg_ato">Submit</button>
                                    @else
                                        <button type="button" class="btn btn-primary btn-block mrg_ato">Submit</button>
                                    @endif
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
    <?php if (Session::has('error')) { ?>
    <script>
        $(document).ready(function() {
            swal(
                'Failed!',
                '<?php echo session('error'); ?>'
            );
        });
    </script>
    <?php } ?>
    <script>
        /******* field validate 1 ********/
        $(document).on('submit', '.form-validate', function(e) {
            var error = "";

            //to validate text field
            $(".field-validate").each(function() {

                if (this.value == '') {

                    $(this).closest(".form-group").addClass('has-error');
                    //$(this).next(".error-content").removeClass('hidden');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                    //$(this).next(".error-content").addClass('hidden');
                }
            });

            if (error == "has error") {
                return false;
            }

        });

        $(document).on('keyup change', '.field-validate', function(e) {

            if (this.value == '') {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }

        });
        /******* field validate 1 ********/
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
