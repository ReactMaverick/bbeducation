<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap"
        rel="stylesheet">
    <script src="{{ asset('web/js/jquery.min.js') }}"></script>

    <style>
        .form-group.has-error {
            border-color: #dd4b39 !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid reset-password-section">
        <div class="reset-password-form-outer">
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
            <span>Enter Your otp for login !</span>
            <form action="{{ url('/super-admin-otp-verify') }}" method="post"
                class="reset-password-form-sec form-validate">
                @csrf
                <div class="form-group reset-password-form-group">
                    <!-- <label for="pwd">Password:</label> -->
                    <input type="number" class="form-control field-validate" name="otp" placeholder="Enter OTP"
                        id="password-input-sec">
                    {{-- <i class="fa-regular fa-eye" id="password-sec-icon"></i> --}}
                </div>


                <input type="submit" value="Submit">
            </form>
        </div>
        <div class="container-fluid reset-password-footer-sec">
            <span>© 2023 All Rights Reserved. by <a href="javascript:vid(0);">Bumblebee</a></span>
        </div>
    </div>

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
    </script>



</body>

</html>
