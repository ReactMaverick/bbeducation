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

    <div
        style="border: 1px solid #ccc; background-color: #fff; width: 100%; max-width: 900px; margin: 0 auto; padding-top: 50px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 10px 20px;width:20%;text-align: left;">
                                <img src="{{ $mailData['companyDetail'] && $mailData['companyDetail']->company_logo ? asset($mailData['companyDetail']->company_logo) : '' }}"
                                    style="width: 80px;" />
                            </td>
                            <td style="padding: 10px 20px;width:45%; text-align: center;">
                                <p style="color: #2c2b2b; font-size: 20px;">
                                    {{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_name : '' }}</p>
                            </td>
                            <td style="padding: 10px 20px;width:33.33%; text-align: right;">
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
                    <h3 style="margin-bottom: 10px;">Best regards,
                        {{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_name : '' }}</h3>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 10px;border-top: 1px solid #dedede;">
                    <h3 style="margin-bottom: 10px;">*PLEASE DO NOT RESPOND TO THIS EMAIL, THIS EMAIL ADDRESS IS NOT
                        MONITORED.*</h3>
                    @if ($mailData['companyDetail'] && $mailData['companyDetail']->compliance_mail)
                        <p>For any queries, please email <a
                                href="mailto:{{ $mailData['companyDetail'] ? $mailData['companyDetail']->compliance_mail : '' }}"
                                target="_blank">{{ $mailData['companyDetail'] ? $mailData['companyDetail']->compliance_mail : '' }}</a>
                        </p>
                    @endif
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
