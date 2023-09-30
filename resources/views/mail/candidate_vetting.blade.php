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

    <div style="width: 100%; display:block;">
        {{-- <h2>Welcome</h2> --}}
        <p>
            <strong>Dear {{ $mailData['schoolDetail'] ? $mailData['schoolDetail']->name_txt : '' }},</strong>
        </p><br>

        {!! $mailData['mail_description'] !!}
    </div>

    <div style="width: 100%; display:block;">
        <p>
            <strong>Best regards,</strong><br>
            <b>Compliance Team</b><br>
            <b>{{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_name : '' }}</b>
        </p>
        <p>Building 3, North London Business Park</p>
        <p>Oakleigh Road South</p>
        <p>N11 1GN</p>
        <p>Telephone:0208 4329844</p>
        <p>Head of Compliance Email: <a href="mailto:Georgia@bbe-edu.co.uk" target="_blank">Georgia@bbe-edu.co.uk</a></p>
        <p>Web: <a href="www.bumblebee-education.co.uk" target="_blank">www.bumblebee-education.co.uk</a></p>
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 10px;border-top: 1px solid #dedede;">
                <h3 style="margin-bottom: 10px;">*PLEASE DO NOT RESPOND TO THIS EMAIL, THIS EMAIL ADDRESS IS NOT
                    MONITORED.*</h3>
                <p>For any queries, please email our compliance manager, <a href="mailto:Georgia@bbe-edu.co.uk"
                        target="_blank">Georgia@bbe-edu.co.uk</a></p>
            </td>
        </tr>
    </table>

</body>

</html>
