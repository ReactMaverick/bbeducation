<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vetting Pdf</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet"> --}}
    <!-- <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet"> -->
</head>

<body style="-webkit-print-color-adjust: exact;">

    <table style="padding: 15px; background-color: #40A0ED; margin: auto; width: 90%; margin-top: 50px; ">
        <tr style="padding: 15px;">
            <th style="text-align:left; font-size: 35px; font-weight: bold; color: #fff; padding-left: 30px;">
                Teacher Timesheet
            </th>
            <th style="text-align:right;"><img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}"
                    alt="" style="width: 25%;">
            </th>
        </tr>
    </table>

    <table style="padding: 15px 0; margin: auto; width: 90%; margin-top: 30px;">
        <tr>
            <td style="vertical-align: top; width: 18%;text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    School :
                </span>
            </td>
            <td style="vertical-align: top; width: 82%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $schoolDetail ? $schoolDetail->name_txt : '' }}
                </span>
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

        @foreach ($itemList as $key => $item)
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

    <table style="width: 90%; border-collapse: collapse; margin: 20px 0 50px 0;">
        <tr>
            <td style="text-align:center; font-size: 14px; font-weight: 400;"><a
                    href="https://bumblebee-education.co.uk/"
                    style="color: #48A0DC; text-decoration: none;">www.bumblebee-education.co.uk</a></td>
            <td style="text-align:center; color: #48A0DC; font-size: 14px; font-weight: 400;"><span>Tel : 0208 4329844
                    /
                    Fax: 0208432635</span></td>
        </tr>
    </table>

</body>

</html>
