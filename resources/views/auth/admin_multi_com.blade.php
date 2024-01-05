<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Company</title>

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
                        <p class="login-box-msg">Please select one company</p>

                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                <span class="sr-only">Success:</span>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ url('/processMultiCom') }}" method="post"
                            class="reset-password-form-sec form-validate">
                            @csrf
                            <div class="form-group calendar-form-filter">
                                <label for="">Company</label><span style="color: red;">*</span>
                                <select class="form-control field-validate" name="company_id">
                                    <option value="">Choose one</option>
                                    @foreach ($multiComData as $key2 => $company)
                                        <option value="{{ $company->company_id }}">
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6"></div>

                                <!-- /.col -->
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block mrg_ato">Submit</button>
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
    <script src="{!! asset('plugins/sweetalert/sweetalert.min.js') !!}"></script>

    @include('web.common_new.scripts')

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

            $("input[type='radio'].field-validate").each(function() {
                var name = $(this).attr("name");

                if ($("input[name='" + name + "']:checked").length == 0) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });

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
    </script>
</body>

</html>
