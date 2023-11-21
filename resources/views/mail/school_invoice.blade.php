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
                {{ $mailData['contactDet']->surname_txt }},</strong>
        </p><br>

        {!! $mailData['temp_description'] !!}
    </div>

    <div style="width: 100%; display:block;">
        <p>
            <strong>Best regards,</strong><br>
            <b>Compliance Team</b><br>
            <b>{{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_name : '' }}</b>
        </p>
        @if ($mailData['companyDetail'] && $mailData['companyDetail']->address1_txt)
            <p>{{ $mailData['companyDetail']->address1_txt . ', ' }}</p>
        @endif
        @if ($mailData['companyDetail'] && $mailData['companyDetail']->address2_txt)
            <p>{{ $mailData['companyDetail']->address2_txt . ', ' }}</p>
        @endif
        @if ($mailData['companyDetail'] && $mailData['companyDetail']->address3_txt)
            <p>{{ $mailData['companyDetail']->address3_txt . ', ' }}</p>
        @endif
        @if ($mailData['companyDetail'] && $mailData['companyDetail']->address4_txt)
            <p>{{ $mailData['companyDetail']->address4_txt . ', ' }}</p>
        @endif
        @if ($mailData['companyDetail'] && $mailData['companyDetail']->address5_txt)
            <p>{{ $mailData['companyDetail']->address5_txt . ', ' }}</p>
        @endif
        @if ($mailData['companyDetail'] && $mailData['companyDetail']->postcode_txt)
            <p>{{ $mailData['companyDetail']->postcode_txt . ', ' }}</p>
        @endif
        <p>Telephone:{{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_phone : '' }}</p>
        <p>Head of Compliance Email: <a
                href="mailto:{{ $mailData['companyDetail'] ? $mailData['companyDetail']->compliance_mail : '' }}"
                target="_blank">{{ $mailData['companyDetail'] ? $mailData['companyDetail']->compliance_mail : '' }}</a>
        </p>
        <p>Web: <a href="{{ $mailData['companyDetail'] ? $mailData['companyDetail']->website : '' }}"
                target="_blank">{{ $mailData['companyDetail'] ? $mailData['companyDetail']->website : '' }}</a></p>
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 10px;border-top: 1px solid #dedede;">
                <h3 style="margin-bottom: 10px;">*PLEASE DO NOT RESPOND TO THIS EMAIL, THIS EMAIL ADDRESS IS NOT
                    MONITORED.*</h3>
                <p>Should you have any queries for this invoice, please promptly email <a
                        href="mailto:{{ $mailData['companyDetail'] ? $mailData['companyDetail']->compliance_mail : '' }}"
                        target="_blank">{{ $mailData['companyDetail'] ? $mailData['companyDetail']->compliance_mail : '' }}</a>
                </p>
            </td>
        </tr>
    </table>

</body>

</html>
