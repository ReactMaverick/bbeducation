<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
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
            <img src="{{ count($companyDetail) > 0 ? asset($companyDetail[0]->company_logo) : '' }}" alt="">
            <h1>{{ count($companyDetail) > 0 ? $companyDetail[0]->company_name : '' }}</h1>
            <span>Reset Your Password?</span>
            <form action="{{ url('/school/schoolPasswordUpdate') }}" method="post"
                class="reset-password-form-sec form-validate">
                @csrf
                <input type="hidden" name="school_id" value="{{ $school_id }}">
                <div class="form-group reset-password-form-group">
                    <!-- <label for="pwd">Password:</label> -->
                    <input type="password" class="form-control field-validate" name="password" placeholder="Password"
                        id="password-input-sec">
                    <i class="fa-regular fa-eye" id="password-sec-icon"></i>
                </div>

                <div class="form-group reset-password-form-group">
                    <!-- <label for="pwd">Confirm Password:</label> -->
                    <input type="password" class="form-control field-validate" name="confirm_password"
                        placeholder="Confirm Password" id="confirm-password-input-sec">
                    <i class="fa-regular fa-eye" id="confirm-password-sec-icon"></i>

                </div>
                @if ($schoolDetail)
                    <input type="submit" value="Submit">
                @else
                    <input type="button" value="Submit">
                @endif
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

    <script>
        $("body").on('click', '#password-sec-icon', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#password-input-sec");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
    </script>
    <script>
        $("body").on('click', '#confirm-password-sec-icon', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#confirm-password-input-sec");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
    </script>

</body>

</html>
