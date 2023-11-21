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
            $appSchoolId = '';
            if (count($mailData['itemList']) > 0) {
                $appSchoolId = $mailData['itemList'][0]->school_id;
            }
            $asnIdsEnc = base64_encode($mailData['asnIds']);
            $weekStartDateEnc1 = base64_encode($mailData['weekStartDate']);
            $weekEndDateEnc1 = base64_encode($mailData['weekEndDate']);
            $school_idEnc1 = base64_encode($appSchoolId);
            $rUrl1 = url('/school/teacher-timesheet-approve-all') . '/' . $asnIdsEnc . '/' . $school_idEnc1 . '/' . $weekStartDateEnc1 . '/' . $weekEndDateEnc1;
            ?>

            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 10px 20px;">
                                <p>Dear <strong>{{ $mailData['contactDet']->firstName_txt }}
                                        {{ $mailData['contactDet']->surname_txt }},</strong></p>
                                <p>Please check the timesheet(s).</p>
                                {{-- <p>{{ isset($mailData['itemList'][0]) ? $mailData['itemList'][0]->name_txt : '' }}</p> --}}
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
                                            <th>Teacher</th>
                                            <th style="border-left: 1px solid #6fa179;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'])) }}</p>
                                                Monday
                                            </th>
                                            <th style="border-left: 1px solid #6fa179;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +1 days')) }}
                                                </p>
                                                Tuesday
                                            </th>
                                            <th style="border-left: 1px solid #6fa179;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +2 days')) }}
                                                </p>
                                                Wednesday
                                            </th>
                                            <th style="border-left: 1px solid #6fa179;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +3 days')) }}
                                                </p>
                                                Thursday
                                            </th>
                                            <th style="border-left: 1px solid #6fa179;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +4 days')) }}
                                                </p>
                                                Friday
                                            </th>
                                            <th style="border-left: 1px solid #6fa179;">
                                                Approve
                                            </th>
                                            <th style="border-left: 1px solid #6fa179;">
                                                Reject
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mailData['itemList']) > 0)
                                            @foreach ($mailData['itemList'] as $item)
                                                <?php
                                                $asnIdEnc = base64_encode($item->asn_id);
                                                $weekStartDateEnc = base64_encode($mailData['weekStartDate']);
                                                $weekEndDateEnc = base64_encode($mailData['weekEndDate']);
                                                $school_idEnc = base64_encode($item->school_id);
                                                $rUrl = url('/school/teacher-timesheet-approve') . '/' . $asnIdEnc . '/' . $school_idEnc . '/' . $weekStartDateEnc . '/' . $weekEndDateEnc;
                                                ?>
                                                <tr style="border: 1px solid #6fa179;">
                                                    <td style="text-align: center;padding-top: 10px;">
                                                        <span class="label label-primary">
                                                            @if ($item->knownAs_txt == null && $item->knownAs_txt == '')
                                                                {{ $item->firstName_txt . ' ' . $item->surname_txt }}
                                                            @else
                                                                {{ $item->knownAs_txt . ' ' . $item->surname_txt }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $item->day1Avail_txt }}
                                                            {{-- @if ($item->start_tm1 && $item->end_tm1)
                                                                ({{ date('h:i a', strtotime($item->start_tm1)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($item->end_tm1)) }})
                                                            @endif --}}
                                                            @if ($item->start_tm1 && $item->end_tm1)
                                                                ({{ $item->start_tm1 }}
                                                                -
                                                                {{ $item->end_tm1 }})
                                                            @endif
                                                            @if ($item->lunch_time1)
                                                                ({{ $item->lunch_time1 }})
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $item->day2Avail_txt }}
                                                            {{-- @if ($item->start_tm2 && $item->end_tm2)
                                                                ({{ date('h:i a', strtotime($item->start_tm2)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($item->end_tm2)) }})
                                                            @endif --}}
                                                            @if ($item->start_tm2 && $item->end_tm2)
                                                                ({{ $item->start_tm2 }}
                                                                -
                                                                {{ $item->end_tm2 }})
                                                            @endif
                                                            @if ($item->lunch_time2)
                                                                ({{ $item->lunch_time2 }})
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $item->day3Avail_txt }}
                                                            {{-- @if ($item->start_tm3 && $item->end_tm3)
                                                                ({{ date('h:i a', strtotime($item->start_tm3)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($item->end_tm3)) }})
                                                            @endif --}}
                                                            @if ($item->start_tm3 && $item->end_tm3)
                                                                ({{ $item->start_tm3 }}
                                                                -
                                                                {{ $item->end_tm3 }})
                                                            @endif
                                                            @if ($item->lunch_time3)
                                                                ({{ $item->lunch_time3 }})
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $item->day4Avail_txt }}
                                                            {{-- @if ($item->start_tm4 && $item->end_tm4)
                                                                ({{ date('h:i a', strtotime($item->start_tm4)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($item->end_tm4)) }})
                                                            @endif --}}
                                                            @if ($item->start_tm4 && $item->end_tm4)
                                                                ({{ $item->start_tm4 }}
                                                                -
                                                                {{ $item->end_tm4 }})
                                                            @endif
                                                            @if ($item->lunch_time4)
                                                                ({{ $item->lunch_time4 }})
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $item->day5Avail_txt }}
                                                            {{-- @if ($item->start_tm5 && $item->end_tm5)
                                                                ({{ date('h:i a', strtotime($item->start_tm5)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($item->end_tm5)) }})
                                                            @endif --}}
                                                            @if ($item->start_tm5 && $item->end_tm5)
                                                                ({{ $item->start_tm5 }}
                                                                -
                                                                {{ $item->end_tm5 }})
                                                            @endif
                                                            @if ($item->lunch_time5)
                                                                ({{ $item->lunch_time5 }})
                                                            @endif
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
