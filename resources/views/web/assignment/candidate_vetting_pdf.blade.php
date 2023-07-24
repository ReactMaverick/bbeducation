<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Vetting</title>
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
            color: #5b9cd7;
            text-decoration: none;
        }

        body {
            position: relative;
            /* width: 21cm;
            height: 500vh; */
            /* height: 29.7cm; */
            size: letter;
            margin: 0;
            /* margin: 0 auto; */
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: SourceSansPro;
            border: 2px solid #5b9cd7;
            padding: 20px 20px 0 20px;
        }

        header {
            padding: 10px 20px;
            margin-bottom: 15px;
            border-bottom: 1px solid #AAAAAA;
            position: relative;
            background-color: #5b9cd7;
        }


        #logo {
            float: right;
            margin-top: 8px;
            width: 33.33%;
            text-align: right;
        }

        #logo img {
            height: 50px;
        }

        #company {
            float: left;
            width: 33.33%;
            text-align: left;
            font-size: 24px;
            color: #fff;
            margin-top: 15px;
        }

        #company-name {
            float: left;
            width: 33.33%;
            text-align: center;
            font-size: 24px;
            color: #fff;
            margin-top: 15px;
        }


        /* #details {
            margin-bottom: 20px;
        } */

        #client {
            padding-left: 6px;
            border-left: 6px solid #5b9cd7;
            float: left;
            width: 40%;
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
            /* width: 55%; */
        }

        #invoice h2 {
            color: #5b9cd7;
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
            border: 1px solid #5b9cd7;
            /* border-radius: 5px; */
            /* border-collapse: collapse; */
            border-spacing: 0;
        }

        table thead {
            /* background-color: #5b9cd7; */
        }


        table th,
        table td {
            color: #5b9cd7;
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
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #5b9cd7;
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
            background-color: #5b9cd7;
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
            color: #5b9cd7;
            font-size: 14px;
            border-top: 1px solid #5b9cd7;
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
            /* padding-right: 10px; */
            border-left: 6px solid #5b9cd7;
            margin-bottom: 20px;
            font-size: 14px;
            width: 55%;
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
            color: #5b9cd7;
            padding: 5px 20px;
            border-bottom: 1px solid #5b9cd7;
        }

        /* thead tr th:last-child {
            text-align: right;
        } */
        thead tr th:first-child {
            background-color: #5b9cd7;
            color: #fff;
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
            text-align: left;
        }

        tbody tr td:last-child {
            text-align: right;
        }

        .heading-right thead tr th {
            border-bottom: 1px solid #5b9cd7 !important;
        }

        #amounts {
            float: right;
        }

        table.header-table {
            width: 40%;
            margin-bottom: 15px;
            border: 1px solid #5b9cd7 !important;
        }

        table.header-table thead tr {
            border: 1px solid #5b9cd7;
        }

        table.header-table thead tr:last-child th {
            border-bottom: 0 !important;
        }

        table.middle-table thead tr th {
            text-align: right;
            background-color: #5b9cd7;
            color: #fff;
        }

        table.middle-table thead tr th:first-child {
            text-align: left !important;
        }

        table.image-table {
            border: 0 !important;
        }

        table.image-table thead tr th {
            background-color: #fff !important;
        }

        table.image-table thead tr th {
            border: 0 !important;
        }

        .header-2 {
            padding: 10px 20px;
            margin-bottom: 15px;
            margin-top: 20px;
            border-bottom: 1px solid #AAAAAA;
            position: relative;
            background-color: #5b9cd7;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="company">
            Vetting Checklist
        </div>
        <div id="company-name">
            {{ $companyDetail ? $companyDetail->company_name : '' }}
        </div>
        <div id="logo">
            <img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}">
        </div>
    </header>
    <main>
        <div class="container">
            <table class="header-table">
                <thead style="text-align: center !important;">
                    <tr>
                        <th style="background-color: #5b9cd7; color: #fff !important;">
                            FAO :
                        </th>
                        <th>
                            {{ $vettingDetail->fao_txt }}
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Candidate :
                        </th>
                        <th>
                            {{ $vettingDetail->candidateName_txt }}
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Date of Birth :
                        </th>
                        <th>
                            {{ $vettingDetail->dateOfBirth_dte != '' ? date('d/m/Y', strtotime($vettingDetail->dateOfBirth_dte)) : '' }}
                        </th>
                    </tr>
                </thead>
            </table>
            <table class="middle-table">
                <thead>
                    <tr>
                        <th>
                            Identity :
                        </th>
                        <th>

                        </th>
                        <th>
                            Date Checked
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Original ID Seen:
                        </td>
                        <td>
                            {{ $vettingDetail->IDType_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->IDSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->IDSeen_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Proof of Address:
                        </td>
                        <td>
                            {{ $vettingDetail->addressType_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->addressSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->addressSeen_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Qualification:
                        </td>
                        <td>
                            {{ $vettingDetail->qualificationType_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->qualificationSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->qualificationSeen_dte)) : '' }}
                        </td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th>
                            Reference and Employment History:
                        </th>
                        <th>

                        </th>
                        <th>
                            Date Checked
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            References Received:
                        </td>
                        <td>
                            {{ $vettingDetail->referencesReceived_int }}
                        </td>
                        <td>
                            {{ $vettingDetail->referencesSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->referencesSeen_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Employment History:
                        </td>
                        <td>
                            {{ $vettingDetail->employmentHistory_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->employmentHistory_dte != '' ? date('d/m/Y', strtotime($vettingDetail->employmentHistory_dte)) : '' }}
                        </td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th>
                            Child Protection:
                        </th>
                        <th>

                        </th>
                        <th>
                            Date Checked
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            DBS Enhanced Disclosure Number:
                        </td>
                        <td>
                            {{ $vettingDetail->dbsNumber_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->dbsSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->dbsSeen_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            DBS Enhanced Disclosure Date:
                        </td>
                        <td>
                            {{ $vettingDetail->dbsDate_dte != '' ? date('d/m/Y', strtotime($vettingDetail->dbsDate_dte)) : '' }}
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            Candidate on Update Service:
                        </td>
                        <td>
                            {{ $vettingDetail->updateService_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->updateServiceSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->updateServiceSeen_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            List 99 Check Result:
                        </td>
                        <td>
                            {{ $vettingDetail->list99CheckResult_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->list99Seen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->list99Seen_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NCTL Check:
                        </td>
                        <td>
                            {{ $vettingDetail->NCTLCheck_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->NCTLSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->NCTLSeen_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Safeguarding Induction:
                        </td>
                        <td>
                            {{ $vettingDetail->safeguardingInduction_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->safeguardingInduction_dte != '' ? date('d/m/Y', strtotime($vettingDetail->safeguardingInduction_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            s128 Management Check:
                        </td>
                        <td>
                            {{ $vettingDetail->s128MgmtCheck_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->s128MgmtCheck_dte != '' ? date('d/m/Y', strtotime($vettingDetail->s128MgmtCheck_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            EEA Restriction Check:
                        </td>
                        <td>
                            {{ $vettingDetail->EEARestrictCheck_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->EEARestrictCheck_dte != '' ? date('d/m/Y', strtotime($vettingDetail->EEARestrictCheck_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Radicalisation Check:
                        </td>
                        <td>
                            {{ $vettingDetail->vetRadical_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->vetRadical_dte != '' ? date('d/m/Y', strtotime($vettingDetail->vetRadical_dte)) : '' }}
                        </td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th>
                            Health Declaration:
                        </th>
                        <th>

                        </th>
                        <th>
                            Date Checked
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Health Declaration:
                        </td>
                        <td>
                            {{ $vettingDetail->healthDeclaration_txt }}
                        </td>
                        <td>
                            {{ $vettingDetail->healthDeclarationSeen_dte != '' ? date('d/m/Y', strtotime($vettingDetail->healthDeclarationSeen_dte)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Occupational Health:
                        </td>
                        <td>
                            {{ $vettingDetail->occupationalHealth_txt }}
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            Health Issues:
                        </td>
                        <td>
                            {{ $vettingDetail->healthIssues_txt }}
                        </td>
                        <td>

                        </td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th>
                            Other:
                        </th>
                        <th>

                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Right To Work:
                        </td>
                        <td>
                            {{ $vettingDetail->rightToWork_txt }}
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            Face to Face Interview Date:
                        </td>
                        <td>
                            {{ $vettingDetail->interviewDate_dte != '' ? date('d/m/Y', strtotime($vettingDetail->interviewDate_dte)) : '' }}
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            NI Number:
                        </td>
                        <td>
                            {{ $vettingDetail->NINumber_txt }}
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            Emergency Name/Number:
                        </td>
                        <td>
                            {{ $vettingDetail->emergencyNameNumber_txt }}
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            Teacher Reference Number (TRN)
                        </td>
                        <td>
                            {{ $vettingDetail->TRN_txt }}
                        </td>
                        <td>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="clearfix header-2">
            <div id="logo">
                <img src="{{ $companyDetail ? asset($companyDetail->company_logo) : '' }}">
            </div>
            <div id="company">
                Likeness of Candidate
            </div>
        </div>
        <div>
            <table class="image-table">
                <thead>
                    <th>

                    </th>
                    <th>
                        <img src="{{ $vettingDetail->imageLocation_txt ? asset($vettingDetail->imageLocation_txt) : '' }}"
                            alt="afsafs" style="border-radius: 50%; width: 200px; height: 200px; object-fit: cover;">

                    </th>
                    <th>

                    </th>
                </thead>
            </table>
        </div>
        <div style="text-align: center; margin-top: 20px; font-size: 20px;">
            <div>
                If you require any other information on the above candidate please contact:
            </div>
            <div style="margin-top: 10px;">
                <a href="mailto:admin@bumblebee-education.co.uk">admin@bumblebee-education.co.uk</a>
            </div>
            <div style="margin-top: 10px;">
                <a href="tel:0208 432 9844">or call 0208 432 9844</a>
            </div>
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
