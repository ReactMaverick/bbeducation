<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
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
            /* position: relative; */
            /* width: 21cm;
            height: 29.7cm; */
            size: letter;
            margin: 0;
            /* margin: 0 auto; */
            color: #555555;
            background: #FFFFFF;
            /* font-family: Arial, sans-serif; */
            font-size: 11px;
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
            width: 30%;
            text-align: right;
        }

        #logo img {
            height: 50px;
        }

        #company {
            float: left;
            width: 30%;
            text-align: left;
            font-size: 20px;
            color: #fff;
            margin-top: 15px;
        }

        #company-name {
            float: left;
            width: 40%;
            text-align: center;
            font-size: 20px;
            color: #fff;
            margin-top: 15px;
        }

        #details {
            margin-bottom: 10px;
        }

        #client {
            /* padding-left: 6px;
            border-left: 6px solid #5b9cd7; */
            float: left;
            width: 50%;
        }

        #client .to {
            color: #000;
            font-weight: 600;
            font-size: 11px;
        }

        h2.name {
            font-size: 11px;
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
            font-size: 11px;
            line-height: 1em;
            font-weight: 600;
            margin: 0;
        }

        #invoice .date {
            font-size: 11px;
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
            font-size: 11px;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 11px;
            background: #5b9cd7;
        }

        table .desc {
            text-align: left;
            width: 80%;
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
            font-size: 11px;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 6px 20px;
            background: #FFFFFF;
            font-size: 11px;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #5b9cd7;
            font-size: 11px;
            border-top: 1px solid #5b9cd7;
        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 11px;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            /* padding-right: 10px; */
            border-left: 6px solid #5b9cd7;
            margin-bottom: 20px;
            font-size: 11px;
            width: 55%;
            float: left;
        }

        #notices .notice {
            font-size: 11px;
        }

        /* main {
            margin-bottom: 20%;
        } */

        footer {

            color: #777777;
            width: 95%;
            /* height: 30%; */
            position: absolute;
            bottom: 0%;
            /* bottom: 0; */
            /* border-top: 1px solid #AAAAAA; */
            padding: 8px 0;
            text-align: center;
            /* background: #000; */
            margin-bottom: 20px;
        }

        .footer2 {
            color: #777777;
            width: 95%;
            position: absolute;
            bottom: 0%;
            padding: 8px 0;
            text-align: center;
            margin-bottom: 20px;
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

        .page-break {
            page-break-before: always;
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

    @php
        if (count($invoiceItemList) < 25 && count($invoiceItemList) > 15) {
            $itemsPerPage = count($invoiceItemList) - 1;
        } else {
            $itemsPerPage = 25;
        }
        $totalItems = count($invoiceItemList);
        $numPages = ceil($totalItems / $itemsPerPage);
        $currentPage = 0;
    @endphp

    @for ($page = 1; $page <= $numPages; $page++) @php $currentPage++; @endphp
        <main>
            @if ($page == 1)
                <div id="details" class="clearfix">
                    <div id="client">
                        <div class="to">Accounts Department </div>
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
                                <tr>
                                    <td>
                                        @if ($companyDetail && $companyDetail->address1_txt)
                                            {{ $companyDetail->address1_txt . ', ' }} <br>
                                        @endif
                                        @if ($companyDetail && $companyDetail->address2_txt)
                                            {{ $companyDetail->address2_txt . ', ' }} <br>
                                        @endif
                                        @if ($companyDetail && $companyDetail->address3_txt)
                                            {{ $companyDetail->address3_txt . ', ' }} <br>
                                        @endif
                                        @if ($companyDetail && $companyDetail->address4_txt)
                                            {{ $companyDetail->address4_txt . ', ' }} <br>
                                        @endif
                                        @if ($companyDetail && $companyDetail->address5_txt)
                                            {{ $companyDetail->address5_txt . ', ' }} <br>
                                        @endif
                                        @if ($companyDetail && $companyDetail->postcode_txt)
                                            {{ $companyDetail->postcode_txt . ', ' }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="heading-right-table">
                            <tbody>
                                <tr>
                                    <td>
                                        Company Number:
                                    </td>
                                    <td>
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
                                    <td style="padding-top: 5px;">
                                        Invoice Number:
                                    </td>
                                    <td style="padding-top: 5px;">
                                        {{ $schoolInvoices->invoice_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Invoice Date:
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($schoolInvoices->invoiceDate_dte)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Authorized By(Name):
                                    </td>
                                    <td>
                                        {{-- {{ $schoolInvoices->admin_fname . ' ' . $schoolInvoices->admin_sname }} --}}
                                        {{ $contactDet ? $contactDet->firstName_txt . ' ' . $contactDet->surname_txt : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Authorized By(Email):
                                    </td>
                                    <td>
                                        {{-- {{ $schoolInvoices->admin_email }} --}}
                                        {{ $contactDet ? $contactDet->contactItem_txt : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Approved Date:
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($schoolInvoices->invoiceDate_dte)) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th class="desc">DESCRIPTION</th>
                        <th class="unit">PRICE</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $start = ($page - 1) * $itemsPerPage;
                        $end = min($page * $itemsPerPage, $totalItems);
                    @endphp
                    @for ($i = $start; $i < $end; $i++)
                        <tr>
                            <td class="desc">
                                {{ $invoiceItemList[$i]->description_txt }}
                                @if ($invoiceItemList[$i]->dayAvail_txt)
                                    {{ ' - ' . $invoiceItemList[$i]->dayAvail_txt }}
                                    @if ($invoiceItemList[$i]->start_tm && $invoiceItemList[$i]->end_tm)
                                        ( {{ $invoiceItemList[$i]->start_tm }} -
                                        {{ $invoiceItemList[$i]->end_tm }} )
                                    @endif
                                @else
                                    ({{ $invoiceItemList[$i]->numItems_dec }} Item(s) X
                                    £{{ $invoiceItemList[$i]->charge_dec }})
                                @endif
                            </td>
                            <td class="total">
                                £{{ number_format($invoiceItemList[$i]->numItems_dec * $invoiceItemList[$i]->charge_dec, 2, '.', '') }}
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            @if ($page == $currentPage && $currentPage < $numPages)
                <div class="footer2">
                    <div style="width: 100%;">
                        <div> <b>Continued.. </b> Page {{ $page }} of {{ $numPages }}</div>
                    </div>
                </div>
            @endif

            <!-- Add a page break for all pages except the last one -->
            @if ($page < $numPages)
                <div class="page-break">
                </div>
            @endif

            @if ($page == $numPages)
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
            @endif
        </main>
    @endfor

    <footer>
        <div style="text-align: left; width: 100%;">
            <div>{{ $companyDetail ? $companyDetail->terms_and_condition : '' }}</div>
            <div> <b>Payment Terms:</b> {{ $companyDetail ? $companyDetail->payment_terms : '' }}</div>

            {{-- <div style="font-size: 18px; font-weight: 700; margin-top: 20px;">THANK YOU!</div> --}}
            <div style="margin-top: 10px;"><b>Payee Details:</b></div>
            <div>Payment by {{ $companyDetail ? $companyDetail->pref_payment_method : '' }}:</div>
            <div>Account Name: {{ $companyDetail ? $companyDetail->account_name : '' }}</div>
            <div>Account Number: {{ $companyDetail ? $companyDetail->account_number : '' }}</div>
            <div>Sort Code: {{ $companyDetail ? $companyDetail->sort_code : '' }}</div>
            <table id="footer-logo">
                <tbody>
                    <tr>
                        @if ($comFooterLogos && count($comFooterLogos) > 0)
                            @foreach ($comFooterLogos as $comFooterLogo)
                                <td>
                                    <img src="{{ asset($comFooterLogo->path . $comFooterLogo->image_name) }}"
                                        alt="" width="100px;">
                                </td>
                            @endforeach
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="border-top: 1px solid #AAAAAA; padding-top: 10px;">
            <div style="float: left;">
                <a
                    href="{{ $companyDetail ? $companyDetail->website : '' }}">{{ $companyDetail ? $companyDetail->website : '' }}</a>
            </div>
            <div style="float: right;">
                <a href="tel:02084329844">Tel: {{ $companyDetail ? $companyDetail->company_phone : '' }}</a>
                {{-- <a href="fax:0208432635"> / Fax: 0208 432635</a> --}}
            </div>
        </div>

    </footer>

</body>

</html>
