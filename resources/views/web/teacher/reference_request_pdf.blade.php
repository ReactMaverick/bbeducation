<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reference receive</title>
</head>

<body style="font-family: sans-serif;">
    <div
        style="border: 2px solid #30a14638;background-color: #fff;width:100%;max-width:790px;margin:0 auto;border-radius: 8px;">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <tr style="background: #cfcfcf2e;">
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding:10px 20px">
                                        <img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}"
                                            style="width:100px" class="CToWUd" data-bit="iit">
                                    </td>
                                    <td style="padding:10px 20px;text-align:right">
                                        {{-- <p style="color:#489628;font-size:18px">company name</p> --}}
                                    </td>
                                    <td style="padding:10px 20px;text-align:right">
                                        <p style="color:#489628;font-size:25px">Reference Receive</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 17px">
                        <table width="100%" style="border:1px solid #30a146;border-radius:10px;padding:10px 2px">
                            <tbody>
                                <tr>
                                    <td style="padding:10px 20px" width="60%">
                                        <table width="100%">

                                            <tbody>
                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        REFERENCE REQUEST FOR : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->ref_request_firstname . ' ' . $refReqDetail->ref_request_lastname }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Referee Name : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->your_firstname . ' ' . $refReqDetail->your_lastname }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Referee Position : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->your_location }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Name of Company / Educational Institution : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->institute_name }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Date Employed From : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ date('d/m/Y', strtotime($refReqDetail->employed_from)) }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Date Employed To : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ date('d/m/Y', strtotime($refReqDetail->employed_to)) }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Candidate's Job Title : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->job_title }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Professional Conduct : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->professional_conduct }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Timekeeping : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->timekeeping }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Relationship with colleagues : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->relationship_colleagues }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Are there any substantiated or outstanding disciplinary
                                                        proceedings against this candidate? : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->outstanding_disciplnary }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Do you have any safeguarding concerns about the candidate's
                                                        suitability to work with children? : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ $refReqDetail->work_with_children }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Signature : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        @if ($refReqDetail->signature)
                                                            <img src="{{ asset($refReqDetail->signature) }}"
                                                                alt="" style="width: 50px">
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: baseline;">
                                                    <td
                                                        style="padding:10px;text-align: left; width: 55%;font-weight: 600; font-size: 14px;">
                                                        Date : </td>
                                                    <td style="padding:10px;text-align: right;">
                                                        <span>
                                                            {{ date('d/m/Y', strtotime($refReqDetail->signature_date)) }}
                                                        </span>
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
</body>

</html>
