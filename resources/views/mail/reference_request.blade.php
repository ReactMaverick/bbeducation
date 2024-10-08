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

    <div style="border: 1px solid #ccc; background-color: #fff; width: 100%; margin: 0 auto; padding-top: 50px;">
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
                                <p style="color: #888; font-size: 25px;"><strong>Reference Request</strong></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <div style="width: 100%; display:block; padding: 10px;">
                        <h2>{{ $mailData['subject'] }}</h2>
                        <p>
                            <strong>Dear {{ $mailData['refereeName'] }},</strong><br>
                        <p>The above-named candidate ({{ $mailData['teacherName'] }}) is being considered for
                            registration with
                            BumbleBee
                            Education Ltd and has indicated
                            that you would be willing to provide a reference.</p>

                        <p>You can complete the reference easily online at the following location: <a
                                href="{{ $mailData['refUrl'] }}" target="_blank">Online Reference Form</a></p>

                        <p>At BumbleBee Education, we strive only to employ staff of the highest calibre and who will
                            have a positive
                            impact
                            on the schools in which we place them. If an applicant is deemed unsuitable, by not meeting
                            certain
                            criteria, we
                            will not continue the registration process. Any information you can give will be treated in
                            the strictest
                            confidence.</p>

                        <p>May I take this opportunity to thank you in advance for any help you are able to give. Your
                            prompt reply
                            would be
                            much appreciated.</p>

                    </div>
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
