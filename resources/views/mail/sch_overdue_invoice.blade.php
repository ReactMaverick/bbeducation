<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            font-family: 'Calibri', sans-serif;
        }
    </style>
</head>

<body>

    <div style="border: 1px solid #ccc; background-color: #fff; width: 60%; margin: 0 auto; padding-top: 50px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 10px 20px; width:20%;">
                                <img src="{{ $mailData['companyDetail'] ? asset($mailData['companyDetail']->company_logo) : '' }}"
                                    style="width: 100px;" />
                            </td>
                            <td style="padding: 10px 20px; text-align: left; width:45%;">
                                <p style="color: #2c2b2b; font-size: 25px;">
                                    {{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_name : '' }}</p>
                            </td>
                            <td style="padding: 10px 20px; text-align: left;">
                                <p style="color: #888; font-size: 25px;"><strong>Overdue Invoices</strong></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 10px 20px 0px 20px;">
                                <p>Dear <strong>{{ $mailData['contactDet']->firstName_txt }}
                                        {{ $mailData['contactDet']->surname_txt }},</strong></p>
                                {!! $mailData['mail_description'] !!}
                                <p>Please check the invoice(s).</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="padding: 0px 17px 20px 17px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="90%"
                        style="border: 1px solid #d80202;">
                        <tr>
                            <td width="100%">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="border: 1px solid #d80202; background-color: #d80202;">
                                            <th style="border-left: 1px solid #d80202; padding: 5px 0;">
                                                Invoice Number
                                            </th>
                                            <th style="border-left: 1px solid #d80202; padding: 5px 0;">
                                                Date
                                            </th>
                                            <th style="border-left: 1px solid #d80202; padding: 5px 0;">
                                                Net
                                            </th>
                                            <th style="border-left: 1px solid #d80202; padding: 5px 0;">
                                                Vat
                                            </th>
                                            <th style="border-left: 1px solid #d80202; padding: 5px 0;">
                                                Gross
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mailData['dueInvoices']) > 0)
                                            @foreach ($mailData['dueInvoices'] as $Invoices)
                                                <tr style="border: 1px solid #d80202;">
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #d80202;">
                                                        <span class="label label-primary">
                                                            {{ $Invoices->invoice_id }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #d80202;">
                                                        <span class="label label-primary">
                                                            {{ date('d-m-Y', strtotime($Invoices->invoiceDate_dte)) }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #d80202;">
                                                        <span class="label label-primary">
                                                            {{ $Invoices->net_dec }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #d80202;">
                                                        <span class="label label-primary">
                                                            {{ $Invoices->vat_dec }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #d80202;">
                                                        <span class="label label-primary">
                                                            {{ $Invoices->gross_dec }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 0px 17px 10px 17px;">
                                <p><strong>Total Amount Overdue</strong></p>
                                <p>
                                    <b>Net : </b>
                                    @if ($mailData['invoiceOverdueCal']->net_dec)
                                        <span>£
                                            {{ number_format((float) $mailData['invoiceOverdueCal']->net_dec, 2, '.', ',') }}
                                        </span>
                                    @endif
                                </p>
                                <p>
                                    <b>Vat : </b>
                                    @if ($mailData['invoiceOverdueCal']->vat_dec)
                                        <span>£
                                            {{ number_format((float) $mailData['invoiceOverdueCal']->vat_dec, 2, '.', ',') }}
                                        </span>
                                    @endif
                                </p>
                                <p>
                                    <b>Gross : </b>
                                    @if ($mailData['invoiceOverdueCal']->gross_dec)
                                        <span>£
                                            {{ number_format((float) $mailData['invoiceOverdueCal']->gross_dec, 2, '.', ',') }}
                                        </span>
                                    @endif
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="padding: 10px 10px;border-top: 1px solid #dedede;">
                    <p>
                        <strong>Best regards,</strong><br>
                        <b>Finance Team</b><br>
                        <b>{{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_name : '' }}</b>
                    </p>
                    <p>Building 3, North London Business Park</p>
                    <p>Oakleigh Road South</p>
                    <p>N11 1GN</p>
                    <p>Telephone: 0208 4329844</p>
                    <p>Email: <a href="mailto:finance@bbe-edu.co.uk" target="_blank">finance@bbe-edu.co.uk</a></p>
                    <p>Web: <a href="www.bumblebee-education.co.uk" target="_blank">www.bumblebee-education.co.uk</a>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 10px;border-top: 1px solid #dedede;">
                    <h3 style="margin-bottom: 10px;">*PLEASE DO NOT RESPOND TO THIS EMAIL, THIS EMAIL ADDRESS IS NOT
                        MONITORED.*</h3>
                    <p>For any queries, please email <a href="mailto:finance@bbe-edu.co.uk"
                            target="_blank">finance@bbe-edu.co.uk</a></p>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">

                    </table>
                </td>
            </tr>

        </table>
    </div>

</body>

</html>
