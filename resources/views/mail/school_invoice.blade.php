<html>

<head>
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            font-family: 'Calibri', sans-serif;
        }
    </style>
</head>

<body>

    <div style="width: 100%; display:block;">
        {{-- <h2>Welcome</h2> --}}
        <p>
            <strong>Dear {{ $mailData['contactDet']->firstName_txt }}
                {{ $mailData['contactDet']->surname_txt }}!</strong>
        </p><br>

        {!! $mailData['temp_description'] !!}
    </div>

    <div style="width: 100%; display:block;">
        <p>
            <strong>Sincerely,</strong><br>
            {{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_name : '' }}
        </p>
    </div>

</body>

</html>
