{{-- <div style="width: 100%; display:block;">
    <p>
        <strong>Hi!</strong>
    </p><br>
    {!! $mailData['mail_description'] !!}
</div>
<div style="width: 100%; display:block;">
    <p>
        <strong>Sincerely,</strong><br>
        BBEDUCATION
    </p>
</div> --}}
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
                            <td style="padding: 10px 20px;width:33.33%;text-align: left;">
                                <img src="{{ $mailData['companyDetail'] ? asset($mailData['companyDetail']->company_logo) : '' }}"
                                    style="width: 70px;" />
                            </td>
                            <td style="padding: 10px 20px; width:33.33%; text-align: left;">
                                <p style="color: #2c2b2b; font-size: 25px;">
                                    {{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_name : '' }}</p>
                            </td>
                            <td style="padding: 10px 20px; width:33.33%; text-align: left;">
                                <p style="color: #888; font-size: 25px;">Confirmation of Work</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php
            $lUrl = 'https://www.google.com/maps/dir/' . $mailData['teacherAddress'] . '/' . $mailData['schAddress'];
            ?>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 10px 20px;">
                                {!! $mailData['teacher_contnt'] !!}
                                {{-- <p>Dear
                                    <strong>{{ $mailData['teacherDet'] ? $mailData['teacherDet']->firstName_txt . ' ' . $mailData['teacherDet']->surname_txt : '' }},</strong>
                                </p>
                                <p>Bumblebee Education has confirmed the position at
                                    {{ $mailData['schoolDetail'] ? $mailData['schoolDetail']->name_txt : '' }} starting
                                    on
                                    {{ $mailData['minDate'] ? date('d/m/Y', strtotime($mailData['minDate'])) : '' }}
                                    and ending on
                                    {{ $mailData['maxDate'] ? date('d/m/Y', strtotime($mailData['maxDate'])) : '' }}.
                                </p>
                                <p>
                                    The address of the school :
                                    @if ($mailData['schoolDetail'] && $mailData['schoolDetail']->name_txt)
                                        {{ $mailData['schoolDetail']->name_txt }}
                                    @endif
                                    @if ($mailData['schoolDetail'] && $mailData['schoolDetail']->address1_txt)
                                        {{ ', ' . $mailData['schoolDetail']->address1_txt }}
                                    @endif
                                    @if ($mailData['schoolDetail'] && $mailData['schoolDetail']->address2_txt)
                                        {{ ', ' . $mailData['schoolDetail']->address2_txt }}
                                    @endif
                                    @if ($mailData['schoolDetail'] && $mailData['schoolDetail']->address3_txt)
                                        {{ ', ' . $mailData['schoolDetail']->address3_txt }}
                                    @endif
                                    @if ($mailData['schoolDetail'] && $mailData['schoolDetail']->address4_txt)
                                        {{ ', ' . $mailData['schoolDetail']->address4_txt }}
                                    @endif
                                    @if ($mailData['schoolDetail'] && $mailData['schoolDetail']->postcode_txt)
                                        {{ ', ' . $mailData['schoolDetail']->postcode_txt }}
                                    @endif
                                    .
                                </p><br>
                                <p>
                                    You can click this link to get directions <a
                                        href="{{ $lUrl }}">Location</a>
                                </p>
                                <p><b>Please attend with your DBS and ID.</b></p>
                                <p>At the end of every week you will need to complete a timesheet (which you should have
                                    already received from us.) Please take a picture of your timesheet and send it via
                                    WhatsApp to 07772 852 424 at the latest by the Friday of that week.</p>
                                <p>Please call us at Bumblebee if you have any questions</p> --}}
                                <p>
                                    You can click this link to get directions <a href="{{ $lUrl }}">Location</a>
                                </p>
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
                    <p>For any queries, please email <a
                            href="mailto:{{ $mailData['companyDetail'] ? $mailData['companyDetail']->vetting_enquiry_mail : '' }}"
                            target="_blank">{{ $mailData['companyDetail'] ? $mailData['companyDetail']->vetting_enquiry_mail : '' }}</a>
                    </p>
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
