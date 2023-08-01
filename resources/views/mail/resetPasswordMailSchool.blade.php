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
                            <td style="padding: 10px 20px;">
                                <img src="{{ $mailData['companyDetail'] ? asset($mailData['companyDetail']->company_logo) : '' }}"
                                    style="width: 100px;" />
                            </td>
                            <td style="padding: 10px 20px; text-align: right;">
                                <p style="color: #2c2b2b; font-size: 25px;">
                                    {{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_name : '' }}</p>
                            </td>
                            <td style="padding: 10px 20px; text-align: right;">
                                <p style="color: #888; font-size: 25px;">Acknowledgement Mail</p>
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
                                <p>Hi <strong>{{ $mailData['name_txt'] }},</strong>
                                </p>
                                <p>Your login user name is '{{ $mailData['mail'] }}'.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding: 20px;">
                    <h1 style="font-size: 20px;">Please click the bellow link to reset your login password.</h1>
                    <p style="font-size: 16px;"><a href="{{ $mailData['rUrl'] }}">{{ $mailData['rUrl'] }}</a></p>
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
                    <h3 style="margin-bottom: 10px;">PLEASE DO NOT REPLY TO THIS EMAIL
                        THIS MAILBOX IS NOT MONITORED</h3>
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
