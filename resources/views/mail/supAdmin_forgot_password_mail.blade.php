<!DOCTYPE html>
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

    <div style="border: 1px solid #ccc; background-color: #fff; width: 100%; max-width: 900px; margin: 0 auto;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr style="background-color: #e0f3fb;">
                            <td style="padding: 10px 20px;width:50%;text-align: left;">
                                <img src="{{ asset('/web/images/mymooncloud-logo.png') }}" style="width: 100px;" />
                            </td>
                            <td style="padding: 10px 20px;width:50%; text-align: right;">
                                <p style="color: #888; font-size: 25px;">Password Reset</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 10px 20px;">
                                <p>Dear <strong>{{ $mailData['userExist']->firstName_txt }}
                                        {{ $mailData['userExist']->surname_txt }},</strong>
                                </p>
                                <p>Your login user name is '{{ $mailData['mail'] }}'</p>
                                <p>Your forgot password OTP is '{{ $mailData['rand_otp'] }}'</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 10px;border-top: 1px solid #dedede;">
                    <h3 style="margin-bottom: 10px;">*PLEASE DO NOT RESPOND TO THIS EMAIL, THIS EMAIL ADDRESS IS NOT
                        MONITORED.*</h3>
                    <p>For support, please email <a href="mailto:sys@mymooncloud.com"
                            target="_blank">sys@mymooncloud.com</a></p>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">

                    </table>
                </td>
            </tr>

        </table>
    </div>

</body>

</html>
