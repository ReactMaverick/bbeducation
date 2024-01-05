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
                                <p>Dear <strong>{{ $mailData['name'] }},</strong>
                                </p>
                                <p>Timesheet has been rejected by school</p>
                                <p><b>School Name:</b> {{ $mailData['schoolDet']->name_txt }}</p>
                                @if ($mailData['remark'] != '')
                                    <p><b>Reason:</b> {{ $mailData['remark'] }}</p>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="padding: 20px 17px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                        style="border: 1px solid #f90404;">
                        <tr>
                            <td width="100%">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="border: 1px solid #f90404; background-color: #f92a2a;">
                                            <th style="padding: 5px 0;">Teacher</th>
                                            <th style="border-left: 1px solid #f90404; padding: 5px 0;">
                                                Date
                                            </th>
                                            <th style="border-left: 1px solid #f90404; padding: 5px 0;">
                                                Start Time - Finish Time
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mailData['teacherList']) > 0)
                                            @foreach ($mailData['teacherList'] as $item)
                                                <?php
                                                $name = '';
                                                if ($item->knownAs_txt == null && $item->knownAs_txt == '') {
                                                    $name = $item->firstName_txt . ' ' . $item->surname_txt;
                                                } else {
                                                    $name = $item->knownAs_txt . ' ' . $item->surname_txt;
                                                }
                                                
                                                $startTime = '';
                                                if ($item->t_start_tm) {
                                                    $startTime = date('h:i a', strtotime($item->t_start_tm));
                                                }
                                                $endTime = '';
                                                if ($item->t_end_tm) {
                                                    $endTime = date('h:i a', strtotime($item->t_end_tm));
                                                }
                                                
                                                $lunch_time = '';
                                                if ($item->t_lunch_time) {
                                                    $lunch_time = ' ( ' . $item->t_lunch_time . ' )';
                                                }
                                                ?>
                                                <tr style="border: 1px solid #f90404;">
                                                    <td style="text-align: center;padding-top: 10px;">
                                                        <span class="label label-primary">
                                                            {{ $name }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #f90404;">
                                                        <span class="label label-primary">
                                                            {{ $item->asnDate_dte }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #f90404;">
                                                        <span class="label label-primary">
                                                            {{ $item->t_start_tm . ' - ' . $item->t_end_tm . $lunch_time }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
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
                                <p><b>Rejected by</b></p>
                                <p>Name:
                                    {{ $mailData['contactDetNew'] ? $mailData['contactDetNew']->firstName_txt . ' ' . $mailData['contactDetNew']->surname_txt : '' }}
                                </p>
                                <p>Email:
                                    {{ $mailData['contactDetNew'] ? $mailData['contactDetNew']->contactItem_txt : '' }}
                                </p>
                                <p>Date/Time: {{ $mailData['date'] }}</p>
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
                    {{-- <p>For any queries, please email <a href="mailto:Saleem@bbe-edu.co.uk"
                            target="_blank">Saleem@bbe-edu.co.uk</a></p> --}}
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
