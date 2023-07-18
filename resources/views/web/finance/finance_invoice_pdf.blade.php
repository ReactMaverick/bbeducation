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
            color: #392319;
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
            border: 2px solid #392319;
            padding: 0 20px;
        }

        header {
            padding: 5px 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #AAAAAA;
            position: relative;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 50px;
        }

        #company {
            float: right;
            text-align: right;
            font-size: 20px;
            color: #392319;
            margin-top: 15px;
        }


        /* #details {
            margin-bottom: 20px;
        } */

        #client {
            padding-left: 6px;
            border-left: 6px solid #392319;
            float: left;
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
        }

        #invoice h2 {
            color: #392319;
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
            background-color: #392319;
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
            color: #392319;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #392319;
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
            background-color: #392319;
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
            color: #392319;
            font-size: 14px;
            border-top: 1px solid #392319;
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
            border-left: 6px solid #392319;
            margin-bottom: 20px;
            font-size: 14px;
            width: 50%;
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
            border-top: 1px solid #AAAAAA;
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
            border-bottom: 1px solid #392319 !important;
        }

        #amounts {
            float: right;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}">
        </div>
        <div id="company">
            {{ $schoolInvoices->creditNote_status == '-1' ? 'Credit Note' : 'Invoice' }}
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">{{ $companyDetail ? $companyDetail->company_name : '' }}</div>
                @if ($companyDetail && $companyDetail->address1_txt)
                    <div>
                        {{ $companyDetail->address1_txt }}
                    </div>
                @endif
                @if ($companyDetail && $companyDetail->address2_txt)
                    <div>
                        {{ $companyDetail->address2_txt }}
                    </div>
                @endif
                @if ($companyDetail && $companyDetail->address3_txt)
                    <div>
                        {{ $companyDetail->address3_txt }}
                    </div>
                @endif
                @if ($companyDetail && $companyDetail->address4_txt)
                    <div>
                        {{ $companyDetail->address4_txt }}
                    </div>
                @endif
                @if ($companyDetail && $companyDetail->address5_txt)
                    <div>
                        {{ $companyDetail->address5_txt }}
                    </div>
                @endif
                @if ($companyDetail && $companyDetail->postcode_txt)
                    <div>
                        {{ $companyDetail->address1_txt }}
                    </div>
                @endif

                <div><b>Company Number:</b> {{ $companyDetail ? $companyDetail->company_phone : '' }}</div>
                <div><b>VAT Registration Number:</b> {{ $companyDetail ? $companyDetail->vat_registration : '' }}</div>
            </div>
            <div id="invoice">
                <table cellspacing="2" cellpadding="0"
                    style="border: 1px solid #392319 !important; border-spacing: 5px;width: 270px;"
                    class="heading-right">
                    <thead>
                        <tr>
                            <th>
                                Invoice#
                            </th>
                            <th style="background-color: #fff; margin-left: 5px; color: #392319;">
                                {{ $schoolInvoices->invoice_id }}
                            </th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th>
                                Date
                            </th>
                            <th style="background-color: #fff; margin-left: 5px; color: #392319;">
                                {{ date('d-m-Y', strtotime($schoolInvoices->invoiceDate_dte)) }}
                            </th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th>
                                Authorized By(Name)
                            </th>
                            <th style="background-color: #fff; margin-left: 5px; color: #392319;">
                                {{ $schoolInvoices->admin_fname . ' ' . $schoolInvoices->admin_sname }}
                            </th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th>
                                Authorized By(Email)
                            </th>
                            <th style="background-color: #fff; margin-left: 5px; color: #392319;">
                                {{ $schoolInvoices->admin_email }}
                            </th>
                        </tr>
                    </thead>
                </table>
                <table style="width: 270px; float:right;">
                    <thead>
                        <tr>
                            <th style="text-align: left; border: 1px solid #392319; padding: 5px 10px !important;">
                                Bill To
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: left; border: 1px solid #392319; padding: 5px 10px !important;">
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
                                    {{ $schoolDetail->postcode_txt }} <br>
                                @endif
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
                            {{ $invoiceItem->description_txt }} (
                            {{ (int) $invoiceItem->numItems_dec }} Item(s) X
                            £{{ (int) $invoiceItem->charge_dec }} )
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
            <div id="notices">
                <div class="notice">By paying this invoice I certify that I have read and agree to be bound to the TC’s
                    of
                    BumbleBee Education</div>
                <div> <b>Payment Terms:</b> Payment within 14 Days of Invoice Date </div>

                <div style="font-size: 18px; font-weight: 700; margin-top: 20px;">THANK YOU!</div>
                <div><b>Payee Details:</b></div>
                <div>Payment by BACS: BumbleBee Education</div>
                <div>Account Name: LTD</div>
                <div>Account Number: 90009687</div>
                <div>Sort Code: 209561</div>
            </div>
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
                        <tr style="background-color: #392319;">
                            <td style="color: #fff !important;">Gross Value</td>
                            <td style="color: #fff !important;">£{{ $schoolInvoices->gross_dec }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="footer-logo">
            <img src="{{ asset('web/images/pdf_img_3.jpg') }}" alt="" width="100px;">
            <img src="{{ asset('web/images/pdf_img_2.png') }}" alt="" width="100px;">
            <img src="{{ asset('web/images/pdf_img_1.jpg') }}" alt="" width="100px;">
        </div>

    </main>
    <footer>
        <div style="float: left;"><a href="www.bumblebee-education.co.uk">www.bumblebee-education.co.uk</a></div>
        <div style="float: right;">
            <a href="tel:02084329844">Tel: 0208 4329844</a>
            <a href="fax:0208432635"> / Fax: 0208 432635</a>
        </div>
    </footer>
</body>

</html>
