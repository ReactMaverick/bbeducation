<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        p {
            margin: 10px 0px;
        }
    </style>
</head>

<body style="-webkit-print-color-adjust: exact;">

    <div style="border: 3px solid #ededed; background-color: #fff; width: 100%; max-width: 900px; margin: 0 auto;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>

                <tr style="background: #30a1461f">
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 20px">
                                        <img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}"
                                            style="width: 100px" class="CToWUd" data-bit="iit" />
                                    </td>

                                    <td style="padding: 10px 20px; text-align: right">
                                        <p style="color: #489628; font-size: 25px">
                                            <strong>{{ $schoolInvoices->creditNote_status == '-1' ? 'Credit Note' : 'Invoice' }}</strong>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 20px">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 40%; vertical-align: top">
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px;">
                                                            Accounts Department
                                                        </h2>
                                                        <p>{{ $schoolDetail ? $schoolDetail->name_txt : '' }}</p>
                                                        @if ($schoolDetail && $schoolDetail->address1_txt)
                                                            <p>{{ $schoolDetail->address1_txt }}</p>
                                                        @endif
                                                        @if ($schoolDetail && $schoolDetail->address2_txt)
                                                            <p>{{ $schoolDetail->address2_txt }}</p>
                                                        @endif
                                                        @if ($schoolDetail && $schoolDetail->address3_txt)
                                                            <p>{{ $schoolDetail->address3_txt }}</p>
                                                        @endif
                                                        @if ($schoolDetail && $schoolDetail->address4_txt)
                                                            <p>{{ $schoolDetail->address4_txt }}</p>
                                                        @endif
                                                        @if ($schoolDetail && $schoolDetail->postcode_txt)
                                                            <p>{{ $schoolDetail->postcode_txt }}</p>
                                                        @endif
                                                    </td>
                                                    <td style="width: 60%; vertical-align: top">
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                            {{ $companyDetail ? $companyDetail->company_name : '' }}
                                                        </h2>

                                                        @if ($companyDetail && $companyDetail->address1_txt)
                                                            <h2
                                                                style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                                {{ $companyDetail->address1_txt }}
                                                            </h2>
                                                        @endif
                                                        @if ($companyDetail && $companyDetail->address2_txt)
                                                            <h2
                                                                style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                                {{ $companyDetail->address2_txt }}
                                                            </h2>
                                                        @endif
                                                        @if ($companyDetail && $companyDetail->address3_txt)
                                                            <h2
                                                                style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                                {{ $companyDetail->address3_txt }}
                                                            </h2>
                                                        @endif
                                                        @if ($companyDetail && $companyDetail->address4_txt)
                                                            <h2
                                                                style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                                {{ $companyDetail->address4_txt }}
                                                            </h2>
                                                        @endif
                                                        @if ($companyDetail && $companyDetail->address5_txt)
                                                            <h2
                                                                style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                                {{ $companyDetail->address5_txt }}
                                                            </h2>
                                                        @endif
                                                        @if ($companyDetail && $companyDetail->postcode_txt)
                                                            <h2
                                                                style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                                {{ $companyDetail->address1_txt }}
                                                            </h2>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 20px">
                                        <table style="margin-left: auto;" border="0" cellpadding="0" cellspacing="0"
                                            width="60%">
                                            <tbody>
                                                <tr>

                                                    <td style="width: 30%; vertical-align: top">
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                            Company Number:
                                                        </h2>
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                            VAT Registration Number:
                                                        </h2>
                                                        <br />
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                            Invoice Number:
                                                        </h2>
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                            Invoice Date:
                                                        </h2>
                                                    </td>
                                                    <td style="width: 20%; vertical-align: top; text-align: right;">
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                            {{ $companyDetail ? $companyDetail->company_phone : '' }}
                                                        </h2>
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                            {{ $companyDetail ? $companyDetail->vat_registration : '' }}
                                                        </h2>
                                                        <br />
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                            {{ $schoolInvoices->invoice_id }}
                                                        </h2>
                                                        <h2
                                                            style="font-weight: 600; font-size: 18px; margin-bottom: 10px; opacity: 0.5;">
                                                            {{ date('d-m-Y', strtotime($schoolInvoices->invoiceDate_dte)) }}
                                                        </h2>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 20px 17px 10px">
                        <table width="100%"
                            style="border: 1px solid #30a146; border-radius: 10px; padding: 10px 2px;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 20px" width="60%">
                                        <table width="100%">
                                            <thead>
                                                <tr>
                                                    <th
                                                        style="padding-bottom: 5px; border-bottom: 1px solid #30a146; text-align: left; width: 80%;">
                                                        Description
                                                    </th>
                                                    <th
                                                        style="padding-bottom: 5px; border-bottom: 1px solid #30a146; text-align: right; width: 20%;">
                                                        Price
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($invoiceItemList as $key => $invoiceItem)
                                                    <tr>
                                                        <td style="padding-top: 10px; text-align: left">
                                                            {{ $invoiceItem->description_txt }} (
                                                            {{ (int) $invoiceItem->numItems_dec }} Item(s) X
                                                            £{{ (int) $invoiceItem->charge_dec }} )
                                                        </td>
                                                        <td style="padding-top: 10px; text-align: right">
                                                            <span>
                                                                £{{ (int) $invoiceItem->numItems_dec * $invoiceItem->charge_dec }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 0px 17px 20px">
                        <table width="30%"
                            style="border: 1px solid #30a146; border-radius: 10px; padding: 10px 2px; width: 30%; margin-left: auto;">
                            <tbody>
                                <tr>
                                    <td style="padding: 0px 10px" width="60%">
                                        <table width="100%">
                                            <thead></thead>
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="padding: 5px 0px; text-align: left; border-bottom: 1px solid #30a146; width: 80%;">
                                                        Net Value
                                                    </td>
                                                    <td
                                                        style="padding: 5px 0px; text-align: right; border-bottom: 1px solid #30a146; width: 20%;">
                                                        <span> £{{ $schoolInvoices->net_dec }} </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 5px 0px; text-align: left; border-bottom: 1px solid #30a146; width: 80%;">
                                                        VAT @ 20%
                                                    </td>
                                                    <td
                                                        style="padding: 5px 0px; text-align: right; border-bottom: 1px solid #30a146; width: 20%;">
                                                        <span> £{{ $schoolInvoices->vat_dec }} </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 5px 0px; text-align: left; border-bottom: 1px solid #30a146; width: 80%;">
                                                        Gross Value
                                                    </td>
                                                    <td
                                                        style="padding: 5px 0px; text-align: right; border-bottom: 1px solid #30a146; width: 20%;">
                                                        <span> £{{ $schoolInvoices->gross_dec }} </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 20px 0px">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 40%; vertical-align: top">
                                                        <p>
                                                            By paying this invoice I certify that I have
                                                            read and agree to be bound to the TC’s of
                                                            BumbleBee Education
                                                        </p>
                                                        <p style="text-decoration: underline;">
                                                            Payment Terms: Payment within 14 Days of Invoice Date
                                                        </p>
                                                        <p style="text-decoration: underline;">
                                                            Payee Details:
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 0px 20px 20px">
                        <table border="0" cellpadding="0" cellspacing="0" width="40%">
                            <tbody>
                                <tr>
                                    <td style="vertical-align: top">
                                        <p>Payment by BACS:</p>
                                        <p>Account Name:</p>
                                        <p>Account Number:</p>
                                        <p>Sort Code:</p>
                                    </td>
                                    <td style="vertical-align: top">
                                        <p style="text-align: right">&nbsp;</p>
                                        <p style="text-align: right">BumbleBee Education LTD</p>
                                        <p style="text-align: right">90009687</p>
                                        <p style="text-align: right">209561</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table style="padding: 20px; background: #30a1461f;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding:10px 20px">
                                        <a style="margin: 0; color: #30a146; font-size: 16px;"
                                            href="www.bumblebee-education.co.uk">www.bumblebee-education.co.uk</a>
                                    </td>
                                    <td style="padding:10px 20px;text-align:right">
                                        <p style="margin: 0; color: #30a146; font-size: 16px;">
                                            Tel : 0208 4329844 / Fax: 0208432635
                                        </p>

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>


</body>

</html>
