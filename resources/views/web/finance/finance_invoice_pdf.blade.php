<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet"> --}}
    <!-- <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet"> -->
</head>

<body style="-webkit-print-color-adjust: exact;">

    <table style="padding: 15px; background-color: #40A0ED; margin: auto; width: 90%; margin-top: 20px; ">
        <tr style="padding: 15px;">
            <th style="text-align:left; font-size: 40px; font-weight: bold; color: #fff; padding-left: 30px;">
                {{ $schoolInvoices->creditNote_status == '-1' ? 'Credit Note' : 'Invoice' }}
            </th>
            <th style="text-align:right;"><img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}"
                    alt="" style="width: 20%;">
            </th>
        </tr>
    </table>

    <table style="padding: 15px 0; margin: auto; width: 90%; margin-top: 10px;">
        <tr>
            <td style="vertical-align: top; width: 45%;">
                <table>
                    <tr>
                        <td style="text-align:left; color: #333; font-size: 15px; font-weight: bold;">
                            Accounts Department
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:left; color: #333; font-size: 15px; font-weight: 400;">
                            {{ $schoolDetail ? $schoolDetail->name_txt : '' }}
                        </td>
                    </tr>

                    @if ($schoolDetail && $schoolDetail->address1_txt)
                        <tr>
                            <td style="text-align:left; color: #333; font-size: 15px; font-weight: 400;">
                                {{ $schoolDetail->address1_txt }}
                            </td>
                        </tr>
                    @endif

                    @if ($schoolDetail && $schoolDetail->address2_txt)
                        <tr>
                            <td style="text-align:left; color: #333; font-size: 15px; font-weight: 400;">
                                {{ $schoolDetail->address2_txt }}
                            </td>
                        </tr>
                    @endif

                    @if ($schoolDetail && $schoolDetail->address3_txt)
                        <tr>
                            <td style="text-align:left; color: #333; font-size: 15px; font-weight: 400;">
                                {{ $schoolDetail->address3_txt }}
                            </td>
                        </tr>
                    @endif

                    @if ($schoolDetail && $schoolDetail->address4_txt)
                        <tr>
                            <td style="text-align:left; color: #333; font-size: 15px; font-weight: 400;">
                                {{ $schoolDetail->address4_txt }}
                            </td>
                        </tr>
                    @endif

                    @if ($schoolDetail && $schoolDetail->postcode_txt)
                        <tr>
                            <td style="text-align:left; color: #333; font-size: 15px; font-weight: 400;">
                                {{ $schoolDetail->postcode_txt }}
                            </td>
                        </tr>
                    @endif
                </table>
            </td>

            <td style="vertical-align: top; width: 55%;">

                <table>
                    <tr>
                        <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold;">
                            {{ $companyDetail ? $companyDetail->company_name : '' }}
                        </td>
                    </tr>

                    @if ($companyDetail && $companyDetail->address1_txt)
                        <tr>
                            <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold;">
                                {{ $companyDetail->address1_txt }}
                            </td>
                        </tr>
                    @endif

                    @if ($companyDetail && $companyDetail->address2_txt)
                        <tr>
                            <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold;">
                                {{ $companyDetail->address2_txt }}
                            </td>
                        </tr>
                    @endif

                    @if ($companyDetail && $companyDetail->address3_txt)
                        <tr>
                            <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold;">
                                {{ $companyDetail->address3_txt }}
                            </td>
                        </tr>
                    @endif

                    @if ($companyDetail && $companyDetail->address4_txt)
                        <tr>
                            <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold;">
                                {{ $companyDetail->address4_txt }}
                            </td>
                        </tr>
                    @endif

                    @if ($companyDetail && $companyDetail->address5_txt)
                        <tr>
                            <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold;">
                                {{ $companyDetail->address5_txt }}
                            </td>
                        </tr>
                    @endif

                    @if ($companyDetail && $companyDetail->postcode_txt)
                        <tr>
                            <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold;">
                                {{ $companyDetail->postcode_txt }}
                            </td>
                        </tr>
                    @endif
                    <br>
                    <tr>
                        <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold; width: 60%;">
                            Company Number:
                        </td>
                        <td style="text-align:right; color: #afabab; font-size: 13px; font-weight: bold; width: 40%;">
                            {{ $companyDetail ? $companyDetail->company_phone : '' }}</td>
                    </tr>

                    <tr>
                        <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold; width: 60%;">
                            VAT Registration Number:
                        </td>
                        <td style="text-align:right; color: #afabab; font-size: 13px; font-weight: bold; width: 40%;">
                            {{ $companyDetail ? $companyDetail->vat_registration : '' }}</td>
                    </tr>
                    <br>

                    <tr>
                        <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold; width: 60%;">
                            Invoice Number:
                        </td>
                        <td style="text-align:right; color: #afabab; font-size: 13px; font-weight: bold; width: 40%;">
                            {{ $schoolInvoices->invoice_id }}</td>
                    </tr>

                    <tr>
                        <td style="text-align:left; color: #afabab; font-size: 15px; font-weight: bold; width: 60%;">
                            Invoice Date:
                        </td>
                        <td style="text-align:right; color: #afabab; font-size: 13px; font-weight: bold; width: 40%;">
                            {{ date('d-m-Y', strtotime($schoolInvoices->invoiceDate_dte)) }}</td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

    <table style="margin: auto; width: 90%; border-collapse: collapse;">
        <tr style="border: 2px solid #000; background-color: #48A0DC; ">
            <th colspan="2"
                style="text-align:left; color: #fff; font-size: 14px; font-weight: 400; width: 60%; padding: 4px 0 4px 15px;">
                Description</th>
            <!-- <th style="width: 30%;"></th> -->
            <th
                style="text-align:left; color: #fff; font-size: 14px; font-weight: 400; width: 10%; padding: 4px 0 4px 15px;border-left: 2px solid #000;">
                Price</th>
        </tr>

        @foreach ($invoiceItemList as $key => $invoiceItem)
            <tr style="border: 2px solid #000;">
                <td colspan="2"
                    style="text-align:left; color: #000; font-size: 14px; font-weight: 400; width: 60%; padding: 4px 0 4px 15px;">
                    {{ $invoiceItem->description_txt }} ( {{ (int) $invoiceItem->numItems_dec }} Item(s) X
                    £{{ (int) $invoiceItem->charge_dec }} ) </td>
                <td
                    style="text-align:right; color: #000; font-size: 14px; font-weight: 400; width: 10%; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    £{{ (int) $invoiceItem->numItems_dec * $invoiceItem->charge_dec }}</td>
            </tr>
        @endforeach

        <tr>
            <td></td>
            <td
                style="border: 2px solid #000; text-align:left; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; width: 20%; background-color: #48A0DC; ">
                Net Value </td>
            <td
                style="border: 1px solid; text-align:right; color: #000; font-size: 14px; font-weight: 400; width: 10%; padding: 4px 15px 4px 0;border-left: 1px solid #000;">
                £{{ $schoolInvoices->net_dec }}</td>
        </tr>

        <tr>
            <td></td>
            <td
                style="border: 2px solid #000; text-align:left; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; width: 20%; background-color: #48A0DC; ">
                VAT @ 20%</td>
            <td
                style="border: 1px solid; text-align:right; color: #000; font-size: 14px; font-weight: 400; width: 10%; padding: 4px 15px 4px 0;border-left: 1px solid #000;">
                £{{ $schoolInvoices->vat_dec }}</td>
        </tr>
        <tr>
            <td></td>
            <td
                style="border: 2px solid #000; text-align:left; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px; width: 20%; background-color: #48A0DC !important; ">
                Gross Value</td>
            <td
                style="border: 1px solid; text-align:right; color: #000; font-size: 14px; font-weight: 400; width: 10%; padding: 4px 15px 4px 0;border-left: 1px solid #000;">
                £{{ $schoolInvoices->gross_dec }}</td>
        </tr>
    </table>

    <table style="margin-top: 20px; margin-left: 40px;">
        <tr>
            <th style="text-align:left; color: #afabab; font-size: 12px; font-weight: 400;">By paying this invoice I
                certify
                that I have read and agree to be bound to the TC’s of BumbleBee Education</th>
        </tr>

        <tr>
            <th style="text-align:left; color: #afabab; font-size: 14px; font-weight: 400;"><span
                    style="border-bottom: 1px solid #afabab;">Payment Terms: Payment within 14 Days of Invoice
                    Date</span></th>
        </tr>

        <tr>
            <th style="text-align:left; color: #afabab; font-size: 14px; font-weight: 400;"><span
                    style="border-bottom: 1px solid #afabab;">Payee Details:</span></th>
        </tr>
    </table>
    <table style="margin-left: 40px; width: 25%;">

        <tr>
            <th style="text-align:left; color: #afabab; font-size: 14px; font-weight: 400;"><span>Payment by
                    BACS:</span></th>
        </tr>

        <tr>
            <th style="text-align:left; color: #afabab; font-size: 14px; font-weight: 400;"><span>Account Name:</span>
            </th>
            <th style="text-align:right; color: #afabab; font-size: 14px; font-weight: 400;"><span>BumbleBee Education
                    LTD</span></th>
        </tr>
        <tr>
            <th style="text-align:left; color: #afabab; font-size: 14px; font-weight: 400;"><span>Account Number:</span>
            </th>
            <th style="text-align:right; color: #afabab; font-size: 14px; font-weight: 400;"><span>90009687</span></th>
        </tr>
        <tr>
            <th style="text-align:left; color: #afabab; font-size: 14px; font-weight: 400;"><span>Sort Code:</span></th>
            <th style="text-align:right; color: #afabab; font-size: 14px; font-weight: 400;"><span>209561</span></th>
        </tr>
    </table>

    <table style="width: 70%; border-collapse: collapse; margin-left: 40px;">
        <tr>
            <td style="text-align:center; font-size: 14px; font-weight: 400;"><a
                    href="https://bumblebee-education.co.uk/"
                    style="color: #48A0DC; text-decoration: none;">www.bumblebee-education.co.uk </a></td>
            <td style="text-align:center; color: #48A0DC; font-size: 14px; font-weight: 400;"><span>Tel : 0208 4329844 /
                    Fax: 0208432635</span></td>
        </tr>
    </table>

</body>

</html>
