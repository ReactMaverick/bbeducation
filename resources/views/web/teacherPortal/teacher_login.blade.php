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
                    <h2>CANDIDATE Login</h2>

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

                    <form method="POST" action="{{ url('/teacher/processLogin') }}" class="form-validate">
                        @csrf
                        <div class="form-group row login-form-sec">
                            <label for="user_name" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text"
                                    class="form-control password-field field-validate @error('user_name') is-invalid @enderror"
                                    id="user_name" name="user_name" value="{{ old('user_name') }}"
                                    autocomplete="user_name" autofocus placeholder="Username">

                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row login-form-sec">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password"
                                    class="form-control password-field field-validate @error('password') is-invalid @enderror"
                                    id="password" name="password" autocomplete="current-password"
                                    placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="login-button-sec">
                            <button type="button" id="loginResetBtn">Reset</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
        $(document).on('click', '#loginResetBtn', function() {
            $('#user_name').val('');
            $('#password').val('');
        });
    </script>

</body>

</html>
