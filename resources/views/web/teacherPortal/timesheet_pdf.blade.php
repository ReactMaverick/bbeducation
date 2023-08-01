<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Teacher Timesheet</title>
    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@200;300;400;500;600&display=swap'); */

        * {
            font-family: 'Calibri', sans-serif;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5b9cd7;
            text-decoration: none;
        }

        body {
            position: relative;
            /* width: 21cm;
            height: 29.7cm; */
            size: letter;
            margin: 0;
            /* margin: 0 auto; */
            color: #555555;
            background: #FFFFFF;
            /* font-family: Arial, sans-serif; */
            font-size: 14px;
            /* font-family: SourceSansPro; */
            border: 2px solid #5b9cd7;
            padding: 20px 20px 0 20px;
        }

        header {
            padding: 5px 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #AAAAAA;
            position: relative;
            background-color: #5b9cd7;
            padding: 10px 20px;
        }

        #logo {
            float: right;
            margin-top: 8px;
            width: 33.33%;
            text-align: right;
        }

        #logo img {
            height: 50px;
        }

        #company {
            float: left;
            width: 33.33%;
            text-align: left;
            font-size: 24px;
            color: #fff;
            margin-top: 15px;
        }

        #company-name {
            float: left;
            width: 33.33%;
            text-align: center;
            font-size: 24px;
            color: #fff;
            margin-top: 15px;
        }


        /* #details {
            margin-bottom: 20px;
        } */

        #client {
            /* padding-left: 6px;
            border-left: 6px solid #5b9cd7; */
            float: left;
            width: 40%;
        }

        #client .to {
            color: #000;
            font-weight: 600;
            font-size: 14px;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
            width: 55%;
        }

        #invoice h2 {
            color: #5b9cd7;
            font-size: 14px;
            line-height: 1em;
            font-weight: 600;
            margin: 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table thead {
            background-color: #5b9cd7;
        }


        table th,
        table td {
            padding: 20px;
            /* background: #EEEEEE; */
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3 {
            color: #5b9cd7;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #5b9cd7;
        }

        table .desc {
            text-align: left;
            width: 60%;
        }

        table .unit {
            text-align: right;
        }

        table .qty {}

        /* table .total {
        color: #FFFFFF;
        } */

        .gross {
            background-color: #5b9cd7;
            color: #fff !important;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 14px;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 6px 20px;
            background: #FFFFFF;
            font-size: 14px;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #5b9cd7;
            font-size: 14px;
            border-top: 1px solid #5b9cd7;
        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            /* padding-right: 10px; */
            border-left: 6px solid #5b9cd7;
            margin-bottom: 20px;
            font-size: 14px;
            width: 55%;
            float: left;
        }

        #notices .notice {
            font-size: 14px;
        }

        footer {
            color: #777777;
            width: 95%;
            /* height: 30px; */
            position: absolute;
            bottom: 2%;
            /* bottom: 0; */
            /* border-top: 1px solid #AAAAAA; */
            padding: 8px 0;
            text-align: center;
        }

        .bg-grey {
            background-color: #e7eae9;
        }

        .bg-black {
            background-color: #000;
        }

        .bg-white {
            background-color: #fff;
        }

        thead tr th {
            font-weight: 600;
            color: #fff;
            padding: 5px 20px;
        }

        .border-bottom {
            border-bottom: 2px solid #9e9e9e;
        }

        tfoot tr {
            padding-top: 20px;
        }

        .padding-t2 {
            padding-top: 6px;
        }

        .align-left {
            text-align: left !important;
        }

        tbody tr:nth-child(even) {
            background-color: #e7eae9;
        }

        tbody tr td {
            color: #363636;
            padding: 5px 20px;
        }

        .heading-right thead tr th {
            border-bottom: 1px solid #5b9cd7 !important;
        }

        #amounts {
            float: right;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="company">Weekly Timesheet Log
        </div>
        <div id="company-name">
            {{ $companyDetail ? $companyDetail->company_name : '' }}
        </div>
        <div id="logo">
            <img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}">
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">
                    @if ($timesheetDet->knownAs_txt == null && $timesheetDet->knownAs_txt == '')
                        {{ $timesheetDet->firstName_txt . ' ' . $timesheetDet->surname_txt }}
                    @else
                        {{ $timesheetDet->knownAs_txt . ' ' . $timesheetDet->surname_txt }}
                    @endif
                </div>
                <div>{{ $timesheetDet->name_txt }}</div>
                <div>{{ date('d/m/Y', strtotime($weekStartDate)) . ' - ' . date('d/m/Y', strtotime($weekEndDate)) }}
                </div>
            </div>
            <div id="invoice"></div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 15px;">
            <thead>
                <tr>
                    <th class="qty">Date</th>
                    <th class="qty">Start Time</th>
                    <th class="qty">End Time</th>
                    {{-- <th class=""></th> --}}
                    <th class="unit">Part</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itemList as $key => $item)
                    <tr>
                        <td class="qty">
                            {{ $item->asnDate_dte }}
                        </td>
                        <td class="qty">
                            {{ $item->start_tm ? date('h:i a', strtotime($item->start_tm)) : '' }}
                        </td>
                        <td class="qty">
                            {{ $item->end_tm ? date('h:i a', strtotime($item->end_tm)) : '' }}
                        </td>
                        {{-- <td class="unit"></td> --}}
                        <td class="total">
                            {{ $item->datePart_txt }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </main>
    <footer>
        <div style="border-top: 1px solid #AAAAAA; padding-top: 10px;">
            <div style="float: left;">
                <a href="www.bumblebee-education.co.uk">www.bumblebee-education.co.uk</a>
            </div>
            <div style="float: right;">
                <a href="tel:02084329844">Tel: 0208 4329844</a>
                <a href="fax:0208432635"> / Fax: 0208 432635</a>
            </div>
        </div>

    </footer>
</body>

</html>
