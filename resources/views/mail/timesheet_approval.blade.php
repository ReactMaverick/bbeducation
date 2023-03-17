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
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; width: 30%; padding: 4px 0 4px 15px;">
                Teacher</th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; width: 30%; padding: 4px 0 4px 15px;border-left: 2px solid #000;">
                Date</th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; width: 20%; padding: 4px 0 4px 15px;border-left: 2px solid #000;">
                Part</th>
            <th
                style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; width: 20%; padding: 4px 0 4px 15px; border-left: 2px solid #000;">
                Approve/Reject</th>
        </tr>

        @foreach ($mailData['itemList'] as $key => $item)
            <?php $cnt = count($mailData['itemList']); ?>
            <tr style="border: 2px solid #000;">
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; width: 30%; padding: 4px 0 4px 15px;">
                    @if ($item->knownAs_txt == null && $item->knownAs_txt == '')
                        {{ $item->firstName_txt . ' ' . $item->surname_txt }}
                    @else
                        {{ $item->knownAs_txt . ' ' . $item->surname_txt }}
                    @endif
                </td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; width: 30%; padding: 4px 0 4px 15px; border-left: 2px solid #000;">
                    {{ $item->asnDate_dte }} </td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; width: 20%; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $item->datePart_txt }}</td>
                @if ($key == 0)
                    <td style="text-align:center; color: #000; font-size: 14px; font-weight: 400; width: 20%; padding: 4px 15px 4px 0; border-left: 2px solid #000;"
                        rowspan="{{ $cnt }}">
                        <a href="{{ $mailData['rUrl'] }}">Click Here</a>
                    </td>
                @endif
            </tr>
        @endforeach

    </table>
</div><br>

<div style="width: 100%; display:block;">
    <p>
        <strong>Sincerely,</strong><br>
        BBEDUCATION
    </p>
</div>
