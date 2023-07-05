<div style="width: 100%; display:block;">
    <h2>Welcome</h2>
    <p>
        <strong>Hi {{ $mailData['contactDet']->firstName_txt }} {{ $mailData['contactDet']->surname_txt }}!</strong><br>
    </p>
</div>

<div style="width: 100%;-webkit-print-color-adjust: exact;">
    <table style="padding: 15px; background-color: #40A0ED; margin: auto; width: 90%; margin-top: 50px; ">
        <tr style="padding: 15px;">
            <th style="text-align:left; font-size: 50px; font-weight: bold; color: #fff; padding-left: 30px;">
                Teacher Timesheet
            </th>
            <th style="text-align:right;">
            </th>
        </tr>
    </table>

    <table style="padding: 15px 0; margin: auto; width: 90%; margin-top: 30px;">
        <tr>
            <td style="vertical-align: top; width: 70%;">
                <table>
                    {{-- <tr>
                        <td style="text-align:left; color: #333; font-size: 15px; font-weight: bold;">
                            @if (isset($mailData['itemList'][0]))
                                @if ($mailData['itemList'][0]->knownAs_txt == null && $mailData['itemList'][0]->knownAs_txt == '')
                                    {{ $mailData['itemList'][0]->firstName_txt . ' ' . $mailData['itemList'][0]->surname_txt }}
                                @else
                                    {{ $mailData['itemList'][0]->knownAs_txt . ' ' . $mailData['itemList'][0]->surname_txt }}
                                @endif
                            @else
                                {{ '' }}
                            @endif
                        </td>
                    </tr> --}}

                    <tr>
                        <td style="text-align:left; color: #333; font-size: 15px; font-weight: 400;">
                            {{ isset($mailData['itemList'][0]) ? $mailData['itemList'][0]->name_txt : '' }}
                        </td>
                    </tr>
                </table>
            </td>

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

            <td style="text-align:right; width:15%">
                <a href="{{ $rUrl1 . '?status=approve' }}"
                    style="text-align:center; font-size: 15px; font-weight: 400;background: #40A0ED; padding: 10px 15px; border-radius: 10px; color: #fff; text-decoration: none;">Approve
                    All</a>
            </td>

            <td style="text-align:right; width:15%">
                <a href="{{ $rUrl1 . '?status=reject' }}"
                    style="text-align:center; font-size: 15px; font-weight: 400;background: #40A0ED; padding: 10px 15px; border-radius: 10px; color: #fff; text-decoration: none;">Reject
                    All</a>
            </td>
        </tr>
    </table>

    <table style="margin: auto; width: 90%; border-collapse: collapse;">
        <tr style="border: 2px solid #000; background-color: #48A0DC; ">
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Teacher</th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;border-left: 2px solid #000;">
                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'])) }}</p>
                Monday
            </th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;border-left: 2px solid #000;">
                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +1 days')) }}</p>
                Tuesday
            </th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;border-left: 2px solid #000;">
                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +2 days')) }}</p>
                Wednesday
            </th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;border-left: 2px solid #000;">
                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +3 days')) }}</p>
                Thursday
            </th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;border-left: 2px solid #000;">
                <p>{{ date('d M Y', strtotime($mailData['weekStartDate'] . ' +4 days')) }}</p>
                Friday
            </th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; border-left: 2px solid #000;">
                Approve</th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; border-left: 2px solid #000;">
                Reject</th>
        </tr>

        @if (count($mailData['itemList']) > 0)
            @foreach ($mailData['itemList'] as $item)
                <?php
                $asnIdEnc = base64_encode($item->asn_id);
                $weekStartDateEnc = base64_encode($mailData['weekStartDate']);
                $weekEndDateEnc = base64_encode($mailData['weekEndDate']);
                $school_idEnc = base64_encode($item->school_id);
                $rUrl = url('/school/teacher-timesheet-approve') . '/' . $asnIdEnc . '/' . $school_idEnc . '/' . $weekStartDateEnc . '/' . $weekEndDateEnc;
                ?>
                <tr style="border: 2px solid #000;">
                    <td
                        style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                        @if ($item->knownAs_txt == null && $item->knownAs_txt == '')
                            {{ $item->firstName_txt . ' ' . $item->surname_txt }}
                        @else
                            {{ $item->knownAs_txt . ' ' . $item->surname_txt }}
                        @endif
                    </td>
                    <td
                        style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; border-left: 2px solid #000;">
                        {{ $item->day1Avail_txt }}
                        @if ($item->start_tm1 && $item->end_tm1)
                            ({{ date('h:i a', strtotime($item->start_tm1)) }}
                            -
                            {{ date('h:i a', strtotime($item->end_tm1)) }})
                        @endif
                    </td>
                    <td
                        style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; border-left: 2px solid #000;">
                        {{ $item->day2Avail_txt }}
                        @if ($item->start_tm2 && $item->end_tm2)
                            ({{ date('h:i a', strtotime($item->start_tm2)) }}
                            -
                            {{ date('h:i a', strtotime($item->end_tm2)) }})
                        @endif
                    </td>
                    <td
                        style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; border-left: 2px solid #000;">
                        {{ $item->day3Avail_txt }}
                        @if ($item->start_tm3 && $item->end_tm3)
                            ({{ date('h:i a', strtotime($item->start_tm3)) }}
                            -
                            {{ date('h:i a', strtotime($item->end_tm3)) }})
                        @endif
                    </td>
                    <td
                        style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; border-left: 2px solid #000;">
                        {{ $item->day4Avail_txt }}
                        @if ($item->start_tm4 && $item->end_tm4)
                            ({{ date('h:i a', strtotime($item->start_tm4)) }}
                            -
                            {{ date('h:i a', strtotime($item->end_tm4)) }})
                        @endif
                    </td>
                    <td
                        style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; border-left: 2px solid #000;">
                        {{ $item->day5Avail_txt }}
                        @if ($item->start_tm5 && $item->end_tm5)
                            ({{ date('h:i a', strtotime($item->start_tm5)) }}
                            -
                            {{ date('h:i a', strtotime($item->end_tm5)) }})
                        @endif
                    </td>
                    <td
                        style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                        <a href="{{ $rUrl . '?status=approve' }}">Click Here</a>
                    </td>
                    <td
                        style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                        <a href="{{ $rUrl . '?status=reject' }}">Click Here</a>
                    </td>
                </tr>
            @endforeach
        @endif

    </table>
</div><br>

<div style="width: 100%; display:block;">
    <p>
        <strong>Sincerely,</strong><br>
        BBEDUCATION
    </p>
</div>
