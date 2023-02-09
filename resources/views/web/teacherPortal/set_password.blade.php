<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

</body>

</html>


<div class="container-fluid reset-password-section">
    <div class="reset-password-form-outer">
        <img src="http://localhost/git/bbeducation/public/web/company_logo/logo.png" alt="">
        <h1>Bumblebee</h1>
        <span>Reset Your Password?</span>
        <form class="reset-password-form-sec">
            <div class="form-group">
                <!-- <label for="pwd">Password:</label> -->
                <input type="password" class="form-control" id="pwd" placeholder="Password">
            </div>

            <div class="form-group">
                <!-- <label for="pwd">Confirm Password:</label> -->
                <input type="password" class="form-control" id="pwd" placeholder="Confirm Password">
            </div>
            <input type="submit" value="Submit">
        </form>
    </div>
    <div class="container-fluid reset-password-footer-sec">
        <span>© 2023 All Rights Reserved. by <a href="#">Bumblebee</a></span>
    </div>
</div>