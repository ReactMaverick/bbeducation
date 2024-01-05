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

    @php
        $dueInv = 0;
        $overdueInv = 0;
        foreach ($mailData['dueInvoices'] as $Invoices) {
            if (date('Y-m-d', strtotime($Invoices->invoiceDate_dte . ' + 30 days')) > date('Y-m-d')) {
                $dueInv++;
            } else {
                $overdueInv++;
            }
        }
    @endphp

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
                                <p style="color: #888; font-size: 25px;"><strong>Account Summary</strong></p>
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

            @if ($dueInv > 0)
                <tr>
                    <td style="padding: 0px 17px;">
                        <p><b>Due Invoice(s)</b></p>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 0px 17px 20px 17px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="90%"
                            style="border: 1px solid #028222;">
                            <tr>
                                <td width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                            <tr style="border: 1px solid #028222; background-color: #028222;">
                                                <th style="border-left: 1px solid #028222; padding: 5px 0;">
                                                    Invoice Number
                                                </th>
                                                <th style="border-left: 1px solid #028222; padding: 5px 0;">
                                                    Date
                                                </th>
                                                <th style="border-left: 1px solid #028222; padding: 5px 0;">
                                                    Net
                                                </th>
                                                <th style="border-left: 1px solid #028222; padding: 5px 0;">
                                                    Vat
                                                </th>
                                                <th style="border-left: 1px solid #028222; padding: 5px 0;">
                                                    Gross
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($mailData['dueInvoices']) > 0)
                                                @foreach ($mailData['dueInvoices'] as $Invoices)
                                                    @if (date('Y-m-d', strtotime($Invoices->invoiceDate_dte . ' + 30 days')) > date('Y-m-d'))
                                                        <tr style="border: 1px solid #028222;">
                                                            <td
                                                                style="text-align: center;padding-top: 10px;border-left: 1px solid #028222;">
                                                                <span class="label label-primary">
                                                                    {{ $Invoices->invoice_id }}
                                                                </span>
                                                            </td>
                                                            <td
                                                                style="text-align: center;padding-top: 10px;border-left: 1px solid #028222;">
                                                                <span class="label label-primary">
                                                                    {{ date('d M Y', strtotime($Invoices->invoiceDate_dte)) }}
                                                                </span>
                                                            </td>
                                                            <td
                                                                style="text-align: center;padding-top: 10px;border-left: 1px solid #028222;">
                                                                <span class="label label-primary">
                                                                    {{ $Invoices->net_dec }}
                                                                </span>
                                                            </td>
                                                            <td
                                                                style="text-align: center;padding-top: 10px;border-left: 1px solid #028222;">
                                                                <span class="label label-primary">
                                                                    {{ $Invoices->vat_dec }}
                                                                </span>
                                                            </td>
                                                            <td
                                                                style="text-align: center;padding-top: 10px;border-left: 1px solid #028222;">
                                                                <span class="label label-primary">
                                                                    {{ $Invoices->gross_dec }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endif

            @if ($overdueInv > 0)
                <tr>
                    <td style="padding: 0px 17px;">
                        <p><b>Overdue Invoice(s)</b></p>
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
                                                    @if (date('Y-m-d', strtotime($Invoices->invoiceDate_dte . ' + 30 days')) <= date('Y-m-d'))
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
                                                                    {{ date('d M Y', strtotime($Invoices->invoiceDate_dte)) }}
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
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endif

            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 0px 17px 10px 17px;">
                                <p><strong>Total Amount Due</strong></p>
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
                    @if ($mailData['companyDetail'] && $mailData['companyDetail']->address1_txt)
                        <p>{{ $mailData['companyDetail']->address1_txt . ', ' }}</p>
                    @endif
                    @if ($mailData['companyDetail'] && $mailData['companyDetail']->address2_txt)
                        <p>{{ $mailData['companyDetail']->address2_txt . ', ' }}</p>
                    @endif
                    @if ($mailData['companyDetail'] && $mailData['companyDetail']->address3_txt)
                        <p>{{ $mailData['companyDetail']->address3_txt . ', ' }}</p>
                    @endif
                    @if ($mailData['companyDetail'] && $mailData['companyDetail']->address4_txt)
                        <p>{{ $mailData['companyDetail']->address4_txt . ', ' }}</p>
                    @endif
                    @if ($mailData['companyDetail'] && $mailData['companyDetail']->address5_txt)
                        <p>{{ $mailData['companyDetail']->address5_txt . ', ' }}</p>
                    @endif
                    @if ($mailData['companyDetail'] && $mailData['companyDetail']->postcode_txt)
                        <p>{{ $mailData['companyDetail']->postcode_txt . ', ' }}</p>
                    @endif
                    <p>Telephone:{{ $mailData['companyDetail'] ? $mailData['companyDetail']->company_phone : '' }}</p>
                    <p>Email: <a
                            href="mailto:{{ $mailData['companyDetail'] ? $mailData['companyDetail']->finance_query_mail : '' }}"
                            target="_blank">{{ $mailData['companyDetail'] ? $mailData['companyDetail']->finance_query_mail : '' }}</a>
                    </p>
                    <p>Web: <a href="{{ $mailData['companyDetail'] ? $mailData['companyDetail']->website : '' }}"
                            target="_blank">{{ $mailData['companyDetail'] ? $mailData['companyDetail']->website : '' }}</a>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 10px;border-top: 1px solid #dedede;">
                    <h3 style="margin-bottom: 10px;">*PLEASE DO NOT RESPOND TO THIS EMAIL, THIS EMAIL ADDRESS IS NOT
                        MONITORED.*</h3>
                    @if ($mailData['companyDetail'] && $mailData['companyDetail']->finance_query_mail)
                        <p>For any queries, please email <a
                                href="mailto:{{ $mailData['companyDetail'] ? $mailData['companyDetail']->finance_query_mail : '' }}"
                                target="_blank">{{ $mailData['companyDetail'] ? $mailData['companyDetail']->finance_query_mail : '' }}</a>
                        </p>
                    @endif
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
