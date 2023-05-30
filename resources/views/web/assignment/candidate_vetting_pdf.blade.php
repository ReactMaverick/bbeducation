<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vetting Pdf</title>
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
            <th style="text-align:left; font-size: 35px; font-weight: bold; color: #fff; padding-left: 30px;">
                Vetting Checklist
            </th>
            <th style="text-align:right;"><img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}"
                    alt="" style="width: 25%;">
            </th>
        </tr>
    </table>

    <table style="padding: 15px 0; margin: auto; width: 90%; margin-top: 30px;">
        <tr>
            <td style="vertical-align: top; width: 18%;text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    FAO :
                </span>
            </td>
            <td style="vertical-align: top; width: 82%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->fao_txt }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 18%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Candidate :
                </span>
            </td>
            <td style="vertical-align: top; width: 82%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->candidateName_txt }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 18%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Date of Birth :
                </span>
            </td>
            <td style="vertical-align: top; width: 82%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->dateOfBirth_dte != '' ? date('d/m/Y', strtotime($vettingDetail->dateOfBirth_dte)) : '' }}
                </span>
            </td>
        </tr>
    </table>

    <table style="padding: 15px 0; margin: auto; width: 90%;">
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Identity :
                </span>
            </td>
            <td style="vertical-align: top; width: 40%;text-align:left;">
            </td>
            <td style="vertical-align: top; width: 20%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Date Checked
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Original ID Seen:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->IDType_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->IDSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->IDSeen_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Proof of Address:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->addressType_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->addressSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->addressSeen_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Qualification:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->qualificationType_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->qualificationSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->qualificationSeen_dte)) : '' }}
                </span>
            </td>
        </tr>

        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Reference and Employment History:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%;text-align:left;">
            </td>
            <td style="vertical-align: top; width: 20%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Date Checked
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    References Received:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->referencesReceived_int }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->referencesSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->referencesSeen_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Employment History:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->employmentHistory_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->employmentHistory_dte != '' ? date('d/m/Y', strtotime($vettingDetail->employmentHistory_dte)) : '' }}
                </span>
            </td>
        </tr>

        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Child Protection:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%;text-align:left;">
            </td>
            <td style="vertical-align: top; width: 20%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Date Checked
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    DBS Enhanced Disclosure Number:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->dbsNumber_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->dbsSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->dbsSeen_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    DBS Enhanced Disclosure Date:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->dbsDate_dte != '' ? date('d/m/Y', strtotime($vettingDetail->dbsDate_dte)) : '' }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">

                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Candidate on Update Service:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->updateService_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->updateServiceSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->updateServiceSeen_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    List 99 Check Result:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->list99CheckResult_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->list99Seen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->list99Seen_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    NCTL Check:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->NCTLCheck_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->NCTLSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->NCTLSeen_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Safeguarding Induction:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->safeguardingInduction_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->safeguardingInduction_dte != '' ? date('d/m/Y', strtotime($vettingDetail->safeguardingInduction_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    s128 Management Check:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->s128MgmtCheck_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->s128MgmtCheck_dte != '' ? date('d/m/Y', strtotime($vettingDetail->s128MgmtCheck_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    EEA Restriction Check:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->EEARestrictCheck_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->EEARestrictCheck_dte != '' ? date('d/m/Y', strtotime($vettingDetail->EEARestrictCheck_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Radicalisation Check:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->vetRadical_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->vetRadical_dte != '' ? date('d/m/Y', strtotime($vettingDetail->vetRadical_dte)) : '' }}
                </span>
            </td>
        </tr>

        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Health Declaration:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%;text-align:left;">
            </td>
            <td style="vertical-align: top; width: 20%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Date Checked
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Health Declaration:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->healthDeclaration_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;">
                    {{ $vettingDetail->healthDeclarationSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->healthDeclarationSeen_dte)) : '' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Occupational Health:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->occupationalHealth_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;"></span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Health Issues:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->healthIssues_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;"></span>
            </td>
        </tr>

        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #333; font-size: 15px; font-weight: bold;">
                    Other:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%;text-align:left;">
            </td>
            <td style="vertical-align: top; width: 20%; text-align:left;">
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Right To Work:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->rightToWork_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;"></span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Face to Face Interview Date:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->interviewDate_dte != '' ? date('d/m/Y', strtotime($vettingDetail->interviewDate_dte)) : '' }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;"></span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    NI Number:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->NINumber_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;"></span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Emergency Name/Number:
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->emergencyNameNumber_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;"></span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #5c5a5a; font-size: 15px; font-weight: bold;">
                    Teacher Reference Number (TRN)
                </span>
            </td>
            <td style="vertical-align: top; width: 40%; text-align:left;">
                <span style="color: #000000; font-size: 15px;">
                    {{ $vettingDetail->TRN_txt }}
                </span>
            </td>
            <td style="vertical-align: top;text-align:right; width: 20%;">
                <span style=" color: #000000; font-size: 15px;"></span>
            </td>
        </tr>
    </table>

    <table style="width: 90%; border-collapse: collapse; margin: 20px 0 50px 0;">
        <tr>
            <td style="text-align:center; font-size: 14px; font-weight: 400;"><a
                    href="https://bumblebee-education.co.uk/"
                    style="color: #48A0DC; text-decoration: none;">www.bumblebee-education.co.uk</a></td>
            <td style="text-align:center; color: #48A0DC; font-size: 14px; font-weight: 400;"><span>Tel : 0208 4329844
                    /
                    Fax: 0208432635</span></td>
        </tr>
    </table>

    <table style="padding: 15px; background-color: #40A0ED; margin: auto; width: 90%; margin-top: 50px; ">
        <tr style="padding: 15px;">
            <th style="text-align:left; font-size: 35px; font-weight: bold; color: #fff; padding-left: 30px;">
                Likeness of Candidate
            </th>
            <th style="text-align:right;"><img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}"
                    alt="" style="width: 25%;">
            </th>
        </tr>
    </table>

    <table style="padding: 15px 0; margin: auto; width: 90%; margin-top: 30px;">
        <tr>
            <th style="text-align:center;"><img
                    src="{{ $vettingDetail->imageLocation_txt ? asset($vettingDetail->imageLocation_txt) : '' }}"
                    alt="" style="width: 60%;">
            </th>
        </tr>
        <tr style="text-align:center;">
            <h3 style="color: #5c5a5a;padding: 15px 0; margin: auto;">
                If you require any other information on the above candidate please contact:
            </h3>
        </tr>
        <tr style="text-align:center;">
            <h3 style="color: #48A0DC;padding: 15px 0; margin: auto;">
                admin@bumblebee-education.co.uk
            </h3>
        </tr>
        <tr style="text-align:center;">
            <h3 style="color: #5c5a5a;padding: 15px 0; margin: auto;">
                or call 0208 432 9844
            </h3>
        </tr>
    </table>

    <table style="width: 90%; border-collapse: collapse; margin: 20px 0 50px 0;">
        <tr>
            <td style="text-align:center; font-size: 14px; font-weight: 400;"><a
                    href="https://bumblebee-education.co.uk/"
                    style="color: #48A0DC; text-decoration: none;">www.bumblebee-education.co.uk</a></td>
            <td style="text-align:center; color: #48A0DC; font-size: 14px; font-weight: 400;"><span>Tel : 0208 4329844
                    /
                    Fax: 0208432635</span></td>
        </tr>
    </table>

</body>

</html>
