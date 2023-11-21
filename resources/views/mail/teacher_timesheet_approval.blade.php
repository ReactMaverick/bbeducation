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
                                <p style="color: #888; font-size: 25px;"><strong>Weekly Timesheet Log</strong></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <?php
            $appSchoolId = $mailData['schoolId'];
            $asnIdsEnc = base64_encode($mailData['asnIds']);
            $school_idEnc1 = base64_encode($appSchoolId);
            $rUrl1 = url('/school/teacher-itemsheet-approve-all') . '/' . $asnIdsEnc . '/' . $school_idEnc1;
            ?>

            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 10px 20px;">
                                <p>Dear <strong>{{ $mailData['contactDet']->firstName_txt }}
                                        {{ $mailData['contactDet']->surname_txt }},</strong></p>
                                <p>Please check the timesheet(s).</p>
                                {{-- <p>{{ isset($mailData['teacherList'][0]) ? $mailData['teacherList'][0]->name_txt : '' }}</p> --}}
                            </td>
                            <td style="padding: 10px 20px; text-align: right;">
                                <a href="{{ $rUrl1 . '?status=approve' }}"
                                    style="text-align:center; font-size: 15px; font-weight: 400;background: #40A0ED; padding: 10px 15px; border-radius: 10px; color: #fff; text-decoration: none;">Approve
                                    All</a>

                                <a href="{{ $rUrl1 . '?status=reject' }}"
                                    style="text-align:center; font-size: 15px; font-weight: 400;background: #f02121; padding: 10px 15px; border-radius: 10px; color: #fff; text-decoration: none;">Reject
                                    All</a>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

            <tr>
                <td style="padding: 20px 17px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                        style="border: 1px solid #30a146;">
                        <tr>
                            <td width="100%">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="border: 1px solid #6fa179; background-color: #8dce9a;">
                                            <th style="padding: 5px 0;">Teacher</th>
                                            <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                Date
                                            </th>
                                            {{-- <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                Part
                                            </th> --}}
                                            {{-- <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                Start Time
                                            </th>
                                            <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                End Time
                                            </th> --}}
                                            <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                Start Time - Finish Time
                                            </th>
                                            <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                Approve
                                            </th>
                                            <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                Reject
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mailData['teacherList']) > 0)
                                            @foreach ($mailData['teacherList'] as $item)
                                                <?php
                                                $asnItemIdEnc = base64_encode($item->timesheet_item_id);
                                                $school_idEnc = base64_encode($item->school_id);
                                                $rUrl = url('/school/teacher-itemsheet-approve-all') . '/' . $asnItemIdEnc . '/' . $school_idEnc;
                                                
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
                                                <tr style="border: 1px solid #6fa179;">
                                                    <td style="text-align: center;padding-top: 10px;">
                                                        <span class="label label-primary">
                                                            {{ $name }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $item->asnDate_dte }}
                                                        </span>
                                                    </td>
                                                    {{-- <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $item->datePart_txt . $lunch_time }}
                                                        </span>
                                                    </td> --}}
                                                    {{-- <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $startTime }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $endTime }}
                                                        </span>
                                                    </td> --}}
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $item->t_start_tm . ' - ' . $item->t_end_tm . $lunch_time }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <a href="{{ $rUrl . '?status=approve' }}">Click Here</a>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <a href="{{ $rUrl . '?status=reject' }}">Click Here</a>
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
                            href="mailto:{{ $mailData['companyDetail'] ? $mailData['companyDetail']->compliance_mail : '' }}"
                            target="_blank">{{ $mailData['companyDetail'] ? $mailData['companyDetail']->compliance_mail : '' }}</a>
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
