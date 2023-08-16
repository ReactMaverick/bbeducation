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
</head>

<body>
    <div class="container-fluid">
        <div class="container login-container">
            <div class="login-row">
                <div class="login-section">
                    <div class="login-page-img">
                        <img src="{{ asset('web/images/mymooncloud-logo.png') }}" alt="">
                    </div>
                    <h2>Generate New Password</h2>

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

                        <div class="form-group row login-form-sec">
                            <label for="" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control field-validate" id=""
                                    name="password" autofocus placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row login-form-sec">
                            <label for="" class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control field-validate" id=""
                                    name="confirm_password" autofocus placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="login-button-sec" style="justify-content: center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @include('web.teacherPortal.common.scripts')

</body>

</html>
