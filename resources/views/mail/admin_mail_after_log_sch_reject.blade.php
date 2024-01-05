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
                                        <tr style="border: 1px solid #f90404; background-color: #fe2e2e;">
                                            <th>Teacher</th>
                                            <th style="border-left: 1px solid #f90404;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'])) }}</p>
                                                Monday
                                            </th>
                                            <th style="border-left: 1px solid #f90404;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +1 days')) }}
                                                </p>
                                                Tuesday
                                            </th>
                                            <th style="border-left: 1px solid #f90404;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +2 days')) }}
                                                </p>
                                                Wednesday
                                            </th>
                                            <th style="border-left: 1px solid #f90404;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +3 days')) }}
                                                </p>
                                                Thursday
                                            </th>
                                            <th style="border-left: 1px solid #f90404;">
                                                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +4 days')) }}
                                                </p>
                                                Friday
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mailData['itemList']) > 0)
                                            @foreach ($mailData['itemList'] as $calender)
                                                <tr style="border: 1px solid #f90404;">
                                                    <td style="text-align: center;padding-top: 10px;">
                                                        <span class="label label-primary">
                                                            @if ($calender->knownAs_txt == null && $calender->knownAs_txt == '')
                                                                {{ $calender->firstName_txt . ' ' . $calender->surname_txt }}
                                                            @else
                                                                {{ $calender->knownAs_txt . ' ' . $calender->surname_txt }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #f90404;">
                                                        <span class="label label-primary">
                                                            {{ $calender->day1Avail_txt }}
                                                            @if ($calender->start_tm1 && $calender->end_tm1)
                                                                ({{ date('h:i a', strtotime($calender->start_tm1)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($calender->end_tm1)) }})
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #f90404;">
                                                        <span class="label label-primary">
                                                            {{ $calender->day2Avail_txt }}
                                                            @if ($calender->start_tm2 && $calender->end_tm2)
                                                                ({{ date('h:i a', strtotime($calender->start_tm2)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($calender->end_tm2)) }})
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #f90404;">
                                                        <span class="label label-primary">
                                                            {{ $calender->day3Avail_txt }}
                                                            @if ($calender->start_tm3 && $calender->end_tm3)
                                                                ({{ date('h:i a', strtotime($calender->start_tm3)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($calender->end_tm3)) }})
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #f90404;">
                                                        <span class="label label-primary">
                                                            {{ $calender->day4Avail_txt }}
                                                            @if ($calender->start_tm4 && $calender->end_tm4)
                                                                ({{ date('h:i a', strtotime($calender->start_tm4)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($calender->end_tm4)) }})
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #f90404;">
                                                        <span class="label label-primary">
                                                            {{ $calender->day5Avail_txt }}
                                                            @if ($calender->start_tm5 && $calender->end_tm5)
                                                                ({{ date('h:i a', strtotime($calender->start_tm5)) }}
                                                                -
                                                                {{ date('h:i a', strtotime($calender->end_tm5)) }})
                                                            @endif
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
