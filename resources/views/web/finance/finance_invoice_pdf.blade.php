<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@200;300;400;500;600&display=swap');

        * {
            font-family: 'Source Sans 3', sans-serif;
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
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: SourceSansPro;
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
            width: 50%;
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
            width: 50%;
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
            margin-bottom: 10px;
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

        table.heading-right-table tbody td:first-child {
            text-align: left;
            /* width: 80%; */
        }

        table.heading-right-table tbody tr:nth-child(even) {
            background-color: #fff;
        }

        table.heading-right-table tbody tr td {
            padding: 0;
        }

        table#footer-logo {
            width: 100px !important;
            margin-bottom: 10px;
        }

        table#footer-logo tbody tr td {
            text-align: left;
            padding: 0 15px 0 0;
            width: 100px;
        }

        table.heading-right-table1 tbody tr {
            background-color: #fff;
        }

        table.heading-right-table1 tbody tr td {
            padding: 0;
            text-align: left;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="company">
            {{ $schoolInvoices->creditNote_status == '-1' ? 'Credit Note' : 'Invoice' }}
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
                <div class="to">Accounts Department</div>
                <div style="">
                    @if ($schoolDetail && $schoolDetail->name_txt)
                        {{ $schoolDetail->name_txt }} <br>
                    @endif
                    @if ($schoolDetail && $schoolDetail->address1_txt)
                        {{ $schoolDetail->address1_txt }} <br>
                    @endif
                    @if ($schoolDetail && $schoolDetail->address2_txt)
                        {{ $schoolDetail->address2_txt }} <br>
                    @endif
                    @if ($schoolDetail && $schoolDetail->address3_txt)
                        {{ $schoolDetail->address3_txt }} <br>
                    @endif
                    @if ($schoolDetail && $schoolDetail->address4_txt)
                        {{ $schoolDetail->address4_txt }} <br>
                    @endif
                    @if ($schoolDetail && $schoolDetail->postcode_txt)
                        {{ $schoolDetail->postcode_txt }}
                    @endif
                </div>
            </div>
            <div id="invoice">
                <table class="heading-right-table1">
                    <tbody>
                        @if ($companyDetail && $companyDetail->company_name)
                            <tr>
                                <td>
                                    {{ $companyDetail->company_name }}
                                </td>
                            </tr>
                        @endif
                        @if ($companyDetail && $companyDetail->address1_txt)
                            <tr>
                                <td>
                                    {{ $companyDetail->address1_txt }}
                                </td>
                            </tr>
                        @endif
                        @if ($companyDetail && $companyDetail->address2_txt)
                            <tr>
                                <td>
                                    {{ $companyDetail->address2_txt }}
                                </td>
                            </tr>
                        @endif
                        @if ($companyDetail && $companyDetail->address3_txt)
                            <tr>
                                <td>
                                    {{ $companyDetail->address3_txt }}
                                </td>
                            </tr>
                        @endif
                        @if ($companyDetail && $companyDetail->address4_txt)
                            <tr>
                                <td>
                                    {{ $companyDetail->address4_txt }}
                                </td>
                            </tr>
                        @endif
                        @if ($companyDetail && $companyDetail->address5_txt)
                            <tr>
                                <td>
                                    {{ $companyDetail->address5_txt }}
                                </td>
                            </tr>
                        @endif
                        @if ($companyDetail && $companyDetail->postcode_txt)
                            <tr>
                                <td>
                                    {{ $companyDetail->postcode_txt }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <table class="heading-right-table">
                    <tbody>
                        <tr>
                            <td style="padding-top: 10px;">
                                Company Number:
                            </td>
                            <td style="padding-top: 10px;">
                                {{ $companyDetail ? $companyDetail->company_phone : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                VAT Registration Number:
                            </td>
                            <td>
                                {{ $companyDetail ? $companyDetail->vat_registration : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 10px;">
                                Invoice Number:
                            </td>
                            <td style="padding-top: 10px;">
                                {{ $schoolInvoices->invoice_id }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Invoice Date:
                            </td>
                            <td>
                                {{ date('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Authorized By(Name):
                            </td>
                            <td>
                                {{ $schoolInvoices->admin_fname . ' ' . $schoolInvoices->admin_sname }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Authorized By(Email):
                            </td>
                            <td>
                                {{ $schoolInvoices->admin_email }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Approved Date:
                            </td>
                            <td>
                                {{ date('d-m-Y', strtotime($schoolInvoices->invoiceDate_dte)) }}
                                {{ ' ' . date('h:ia', strtotime($schoolInvoices->timestamp_ts)) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="desc">DESCRIPTION</th>
                    <th class=""></th>
                    <th class="qty"></th>
                    <th class=""></th>
                    <th class="unit">PRICE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoiceItemList as $key => $invoiceItem)
                    <tr>
                        <td class="desc">
                            {{ $invoiceItem->description_txt }}
                            @if ($invoiceItem->dayAvail_txt)
                                {{ ' - ' . $invoiceItem->dayAvail_txt }}
                                @if ($invoiceItem->start_tm && $invoiceItem->end_tm)
                                    ( {{ date('h:i a', strtotime($invoiceItem->start_tm)) }} -
                                    {{ date('h:i a', strtotime($invoiceItem->end_tm)) }} )
                                @endif
                            @else
                                ({{ (int) $invoiceItem->numItems_dec }} Item(s) X
                                £{{ (int) $invoiceItem->charge_dec }})
                            @endif
                        </td>
                        <td class=""></td>
                        <td class="qty"></td>
                        <td class="unit"></td>
                        <td class="total">
                            £{{ (int) $invoiceItem->numItems_dec * $invoiceItem->charge_dec }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        <div id="payment-details" class="clearfix">

            <div id="amounts">
                <table>
                    <tbody>
                        <tr>
                            <td>Net Value</td>
                            <td>£{{ $schoolInvoices->net_dec }}</td>
                        </tr>
                        <tr style="background-color: #fff;">
                            <td>VAT @ 20%</td>
                            <td>£{{ $schoolInvoices->vat_dec }}</td>
                        </tr>
                        <tr style="background-color: #5b9cd7;">
                            <td style="color: #fff !important;">Gross Value</td>
                            <td style="color: #fff !important;">£{{ $schoolInvoices->gross_dec }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <footer>
        <div style="text-align: left; width: 100%;">
            <div>By paying this invoice I certify that I have read and agree to be bound to the TC’s
                of
                BumbleBee Education</div>
            <div> <b>Payment Terms:</b> Payment within 14 days of invoice date </div>

            <div style="font-size: 18px; font-weight: 700; margin-top: 20px;">THANK YOU!</div>
            <div><b>Payee Details:</b></div>
            <div>Payment by BACS:</div>
            <div>Account Name: BumbleBee Education LTD</div>
            <div>Account Number: 90009687</div>
            <div>Sort Code: 209561</div>
            <table id="footer-logo">
                <tbody>
                    <tr>
                        <td>
                            <img src="{{ asset('web/images/pdf_img_1.jpg') }}" alt="" width="100px;">
                        </td>
                        <td>
                            <img src="{{ asset('web/images/pdf_img_2.png') }}" alt="" width="100px;">
                        </td>
                        <td>
                            <img src="{{ asset('web/images/pdf_img_3.jpg') }}" alt="" width="100px;">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
