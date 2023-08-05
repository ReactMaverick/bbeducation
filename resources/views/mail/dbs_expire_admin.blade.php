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

    <div style="border: 1px solid #ccc; background-color: #fff; width: 100%; margin: 0 auto; padding-top: 50px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 10px 20px;">
                                <p>Dear,</strong></p>
                                <p>Please check these DBS records, which will expire soon or have already expired.</p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

            <tr>
                <td style="padding: 20px 17px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                        style="border: 1px solid #30a146;">
                        <tr>
                            <td width="100%">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="border: 1px solid #6fa179; background-color: #8dce9a;">
                                            <th style="padding: 5px 0;">Teacher</th>
                                            <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                Certificate
                                            </th>
                                            <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                Date
                                            </th>
                                            <th style="border-left: 1px solid #6fa179; padding: 5px 0;">
                                                Expiry
                                            </th>
                                            <th style="border-left: 1px solid #6fa179; padding: 5px 0;">

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mailData['expiredCertificates']) > 0)
                                            @foreach ($mailData['expiredCertificates'] as $item)
                                                <?php
                                                $rUrl = url('/teacher-documents') . '/' . $item->teacher_id;
                                                
                                                $name = '';
                                                if ($item->knownAs_txt == null && $item->knownAs_txt == '') {
                                                    $name = $item->firstName_txt . ' ' . $item->surname_txt;
                                                } else {
                                                    $name = $item->knownAs_txt . ' ' . $item->surname_txt;
                                                }
                                                
                                                $DBSDate_dte = '';
                                                if ($item->DBSDate_dte) {
                                                    $DBSDate_dte = date('d-m-Y', strtotime($item->DBSDate_dte));
                                                }
                                                $expiry_date = '';
                                                if ($item->expiry_date) {
                                                    $expiry_date = date('d-m-Y', strtotime($item->expiry_date));
                                                }
                                                ?>
                                                <tr style="border: 1px solid #6fa179;">
                                                    <td style="text-align: center;padding-top: 10px;">
                                                        <span class="label label-primary">
                                                            {{ $name }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $item->certificateNumber_txt }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $DBSDate_dte }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <span class="label label-primary">
                                                            {{ $expiry_date }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center;padding-top: 10px;border-left: 1px solid #6fa179;">
                                                        <a href="{{ $rUrl }}">View</a>
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
                <td style="padding: 10px 10px;border-top: 1px solid #dedede;">
                    <h3 style="margin-bottom: 10px;">Thank You</h3>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 10px;border-top: 1px solid #dedede;">
                    <h3 style="margin-bottom: 10px;">PLEASE DO NOT REPLY TO THIS EMAIL
                        THIS MAILBOX IS NOT MONITORED</h3>
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
