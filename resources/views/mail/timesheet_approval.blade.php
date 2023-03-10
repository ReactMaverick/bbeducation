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
            <td style="vertical-align: top; width: 45%;">
                <table>
                    <tr>
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
                    </tr>

                    <tr>
                        <td style="text-align:left; color: #333; font-size: 15px; font-weight: 400;">
                            {{ isset($mailData['itemList'][0]) ? $mailData['itemList'][0]->name_txt : '' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="margin: auto; width: 90%; border-collapse: collapse;">
        <tr style="border: 2px solid #000; background-color: #48A0DC; ">
            <th
                style="text-align:left; color: #fff; font-size: 14px; font-weight: 400; width: 60%; padding: 4px 0 4px 15px;">
                Date</th>
            <!-- <th style="width: 30%;"></th> -->
            <th
                style="text-align:left; color: #fff; font-size: 14px; font-weight: 400; width: 40%; padding: 4px 0 4px 15px;border-left: 2px solid #000;">
                Part</th>
        </tr>

        @foreach ($mailData['itemList'] as $key => $item)
            <tr style="border: 2px solid #000;">
                <td
                    style="text-align:left; color: #000; font-size: 14px; font-weight: 400; width: 60%; padding: 4px 0 4px 15px;">
                    {{ $item->asnDate_dte }} </td>
                <td
                    style="text-align:left; color: #000; font-size: 14px; font-weight: 400; width: 40%; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $item->datePart_txt }}</td>
            </tr>
        @endforeach

    </table>
</div><br>

<div style="width: 100%; display:block;">
    <p>
        Please click the bellow link to approve/reject this timesheet.<br>
        {{ $mailData['rUrl'] }}<br><br>
        <strong>Sincerely,</strong><br>
        BBEDUCATION
    </p>
</div>
