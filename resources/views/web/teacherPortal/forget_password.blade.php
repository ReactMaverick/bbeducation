<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed&family=Inter&family=Merriweather:ital,wght@1,300&family=Montserrat:ital,wght@0,400;1,300&family=Raleway:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .forget_pass_btn {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .forget_pass_btn a {
            color: #bb0404;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div id="fullLoader">
        <div class="loadingDiv"></div>
    </div>
    <div class="container-fluid">
        <div class="container login-container">
            <div class="login-row">
                <div class="login-section">
                    <div class="login-page-img">
                        <img src="{{ asset('web/images/mymooncloud-logo.png') }}" alt="">
                    </div>
                    <h2>Forget Password</h2>

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    @if (Session::has('fp_error'))
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            {!! session('fp_error') !!}
                        </div>
                    @endif

                    @if (Session::has('loginSuccess'))
                        <div class="alert alert-success" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            {!! session('loginSuccess') !!}
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/teacher/forgetPasswordSendOtp') }}" class="form-validate">
                        @csrf
                        <div class="form-group row login-form-sec">
                            <label for="" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control email-validate" id="" name="email"
                                    autofocus placeholder="Enter email">
                            </div>
                        </div>

                        <div class="login-button-sec" style="justify-content: center">
                            <button type="submit" class="btn btn-primary" id="fPassBtn">Submit</button>
                        </div>

                        <div class="forget_pass_btn">
                            <span><a href="{{ URL::to('/teacher') }}">Login</a></span>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @include('web.teacherPortal.common.scripts')

    <script>
        $(document).on('click', '#fPassBtn', function() {
            $('#fullLoader').show();
        });
    </script>

</body>

</html>
