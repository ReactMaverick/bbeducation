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

    <table style="padding: 15px; background-color: #40A0ED; margin: auto; width: 90%; margin-top: 50px; ">
        <tr style="padding: 15px;">
            <th style="text-align:left; font-size: 50px; font-weight: bold; color: #fff; padding-left: 30px;">
                Invoice
            </th>
            <th style="text-align:right;"><img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}"
                    alt="" style="width: 20%;">
            </th>
        </tr>
    </table>

    <table style="padding: 15px 0; margin: auto; width: 90%; margin-top: 30px;">
        <tr>
            <td style="vertical-align: top; width: 45%;">
                <table>

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

                </table>

            </td>
        </tr>
    </table>

    <table style="margin: auto; width: 90%; border-collapse: collapse;">
        <tr style="border: 2px solid #000; background-color: #48A0DC; ">
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Invoice No </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Customer </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Invoice Date </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;"> Due
                Date </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Terms </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Memo </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Item ( Product / Service ) </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Item Description </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Item Quantity </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Item Rate </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Item Amount </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Item Tax Code </th>
            <th style="text-align:center; color: #fff; font-size: 14px; font-weight: 400; padding: 4px 0 4px 15px;">
                Item Tax Amount </th>
        </tr>

        @foreach ($invoicesList as $key => $invoices)
            <tr style="border: 2px solid #000;">
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->InvoiceNo }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->Customer }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->InvoiceDate }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->DueDate }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->Terms }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->Memo }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->prodOrService }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->ItemDescription }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->ItemQuantity }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->ItemRate }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->ItemAmount }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->ItemTaxCode }}</td>
                <td
                    style="text-align:center; color: #000; font-size: 14px; font-weight: 400; padding: 4px 15px 4px 0; border-left: 2px solid #000;">
                    {{ $invoices->ItemTaxAmount }}</td>
            </tr>
        @endforeach
    </table>

    <table style="width: 70%; border-collapse: collapse; margin: 20px 0 50px 0;">
        <tr>
            <td style="text-align:center; font-size: 14px; font-weight: 400;"><a href="{{ url('/') }}"
                    style="color: #48A0DC; text-decoration: none;">www.bumblebee-education.co.uk </a></td>
            <td style="text-align:center; color: #48A0DC; font-size: 14px; font-weight: 400;"><span>Tel : 0208 4329844 /
                    Fax: 0208432635</span></td>
        </tr>
    </table>

</body>

</html>
