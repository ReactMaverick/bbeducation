{{-- @extends('web.layout') --}}
@extends('web.teacher.teacher_layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }

        .teacher-document-second-heading-text {
            width: 40%;
        }

        .teacher-document-second-name-text {
            width: 5%;
        }

        .teacher-document-third-name-text {
            width: 55%;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.teacher.teacher_header')
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">

                        <div class="school-detail-right-sec">
                            <div class="row my_row_gap">
                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="teacher-health-first-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Documents</h2>
                                            <a data-toggle="modal" data-target="#editDocumentListModal"
                                                style="cursor: pointer;" class="icon_all"><i
                                                    class="fas fa-edit school-edit-icon"></i></a>
                                        </div>

                                        <div class="teacher-document-first-sec about-school-section row">
                                            <div class="teacher-document-section col-6">
                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">Passport</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->docPassport_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">Driver's Licence</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->docDriversLicence_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">Bank Statement</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->docBankStatement_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">DBS</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->docDBS_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">Disqual. Form</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->docDisqualForm_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">Health Dec.</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->docHealthDec_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="teacher-document-section col-6">
                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">EU Card</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->docEUCard_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">Utility Bill</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->docUtilityBill_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">Telephone Bill</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->docTelephoneBill_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">Benefit Statement</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->docBenefitStatement_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">Credit Card Bill</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->docCreditCardBill_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label for="vehicle1">P45/P60</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->docP45P60_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-heading-text">
                                                        <label>Counsil Tax Bill</label>
                                                    </div>
                                                    <div class="teacher-document-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->docCouncilTax_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="teacher-health-second-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Vetting Details</h2>
                                            <a href="{{ URL::to('/vetting-check-history/' . $teacherDetail->teacher_id) }}"
                                                target="_blank" class="icon_all">Vetting Check History</a>
                                            <a data-toggle="modal" data-target="#editVettingDetModal"
                                                style="cursor: pointer;" class="icon_all"><i
                                                    class="fas fa-edit school-edit-icon"></i></a>
                                        </div>

                                        <div class="teacher-document-first-sec">
                                            <div class="teacher-document-section about-school-section"
                                                style="width: 100%;">
                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">Vetting Update Service</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->vetUpdateService_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->vetUpdateServiceChecked_dte != null ? date('d M Y', strtotime($teacherDetail->vetUpdateServiceChecked_dte)) : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">List 99</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->vetList99Checked_dte != null ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->vetList99Checked_dte != null ? 'Expires on ' . date('d M Y', strtotime($teacherDetail->vetList99Checked_dte . ' +1 years')) : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">Nctl Check</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->vetNCTLChecked_dte != null ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->vetNCTLChecked_dte != null ? 'Expires on ' . date('d M Y', strtotime($teacherDetail->vetNCTLChecked_dte . ' +1 years')) : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                {{-- <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">Disqualification Check</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1" disabled
                                                            {{ $teacherDetail->vetDisqualAssociation_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->vetDisqualAssociation_dte != null ? date('d-m-Y', strtotime($teacherDetail->vetDisqualAssociation_dte)) : '' }}
                                                        </p>
                                                    </div>
                                                </div> --}}

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">Safeguarding Induction</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->safeguardingInduction_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->safeguardingInduction_dte != null ? date('d M Y', strtotime($teacherDetail->safeguardingInduction_dte)) : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">s128 Management Check</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->vets128_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->vets128_dte != null ? date('d M Y', strtotime($teacherDetail->vets128_dte)) : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>EEA Restriction Check</h2>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->vetEEARestriction_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->vetEEARestriction_dte != null ? date('d M Y', strtotime($teacherDetail->vetEEARestriction_dte)) : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>
                                                            Right to Work
                                                            @if ($teacherDetail->rightToWork_txt)
                                                                ({{ $teacherDetail->rightToWork_txt }})
                                                            @endif
                                                        </h2>
                                                    </div>
                                                    {{-- <div class="teacher-document-second-text">
                                                        <p>{{ $teacherDetail->rightToWork_txt }}</p>
                                                    </div> --}}
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->rightToWork_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->rightToWork_dte != null ? date('d M Y', strtotime($teacherDetail->rightToWork_dte)) : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>
                                                            Overseas Police
                                                            @if ($teacherDetail->overseasPolicy_txt)
                                                                ({{ $teacherDetail->overseasPolicy_txt }})
                                                            @endif
                                                        </h2>
                                                    </div>
                                                    {{-- <div class="teacher-document-second-text">
                                                        <p>{{ $teacherDetail->overseasPolicy_txt }}</p>
                                                    </div> --}}
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->overseasPolicy_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->overseasPolicy_dte != null ? date('d M Y', strtotime($teacherDetail->overseasPolicy_dte)) : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                {{-- <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>Redicalisation Check</h2>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1" disabled
                                                            {{ $teacherDetail->vetRadical_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->vetRadical_dte != null ? date('d-m-Y', strtotime($teacherDetail->vetRadical_dte)) : '' }}
                                                        </p>
                                                    </div>
                                                </div> --}}

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>Qualifications Check</h2>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->vetQualification_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>{{ $teacherDetail->vetQualification_dte != null ? date('d M Y', strtotime($teacherDetail->vetQualification_dte)) : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="school-detail-right-sec mt-3">

                            <div class="row my_row_gap">
                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="teacher-document-table-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Filed Documents</h2>
                                            </div>
                                            <div class="contact-icon-sec">

                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteDocumentBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>

                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="documentMailBttn">
                                                    <i class="fas fa-envelope-open-text"></i>
                                                </a>

                                                {{-- <a href="#">
                                                    <i class="fa-solid fa-folder-open"></i>
                                                </a>

                                                <a href="#">
                                                    <img src="{{ asset('web/company_logo/search-file.png') }}" alt="">
                                                </a> --}}
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="viewDocumentBttn">
                                                    <img src="{{ asset('web/company_logo/search-file.png') }}"
                                                        alt="" style="width: 22px;">
                                                </a>

                                                <a data-toggle="modal" data-target="#documentAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editDocumentBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="myTable">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>No.</th>
                                                        {{-- <th>File Name</th> --}}
                                                        <th>Document Type</th>
                                                        <th>File Type</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @if (count($documentList) > 0)
                                                        @foreach ($documentList as $key => $document)
                                                            <tr class="school-detail-table-data editDocumentRow"
                                                                id="editDocumentRow{{ $document->teacherDocument_id }}"
                                                                onclick="documentRowSelect({{ $document->teacherDocument_id }})">
                                                                <td>{{ $key + 1 }}</td>
                                                                {{-- <td>{{ $document->file_name }}</td> --}}
                                                                <td>{{ $document->doc_type_txt }}</td>
                                                                <td>{{ $document->file_type }}</td>
                                                                <td>{{ date('d M Y', strtotime($document->uploadOn_dtm)) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr colspan="5">
                                                            <td>No document found</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <input type="hidden" name="DocumentId" id="DocumentId" value="">
                                </div>

                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="teacher-document-table-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>DBS Records</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteDbsRecordBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="viewDbsRecordBttn">
                                                    <img src="{{ asset('web/company_logo/search-file.png') }}"
                                                        alt="" style="width: 22px;">
                                                </a>
                                                <a data-toggle="modal" data-target="#dbsRecordAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editDbsRecordBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <?php
                                        $dbsExp = '';
                                        $dbsExpText = '';
                                        ?>
                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="dbsTable">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Certificate</th>
                                                        <th>Date</th>
                                                        <th>Expiry</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @if (count($DBS_list) > 0)
                                                        @foreach ($DBS_list as $key => $DBS)
                                                            <?php
                                                            if ($DBS->DBSDate_dte != null) {
                                                                $dateExp = date('d-m-Y', strtotime($DBS->DBSDate_dte . ' +3 years'));
                                                                $tday = date('d-m-Y');
                                                                $dateExp2 = date('d-m-Y', strtotime($dateExp . ' -21 days'));
                                                                if (strtotime($dateExp2) <= strtotime($tday)) {
                                                                    $dbsExp = '1';
                                                                    if ($dbsExpText != '') {
                                                                        $dbsExpText .= ', ';
                                                                    }
                                                                    $dbsExpText .= 'Certificate no ' . $DBS->certificateNumber_txt . ' will expire on ' . $dateExp . '.';
                                                                }
                                                            }
                                                            ?>
                                                            <tr class="school-detail-table-data editDBSRow"
                                                                id="editDBSRow{{ $DBS->DBS_id }}"
                                                                onclick="DBSRowSelect({{ $DBS->DBS_id }})">
                                                                <td>{{ $DBS->certificateNumber_txt }}</td>
                                                                <td>{{ $DBS->DBSDate_dte != null ? date('d M Y', strtotime($DBS->DBSDate_dte)) : '' }}
                                                                </td>
                                                                <td>{{ $DBS->DBSDate_dte != null ? date('d M Y', strtotime($DBS->DBSDate_dte . ' +3 years')) : '' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <input type="hidden" name="DBSId" id="DBSId" value="">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Document List Edit Modal -->
    <div class="modal fade" id="editDocumentListModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Document List</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Document List</h2>
                    </div>

                    <form action="{{ url('/teacherDocumentListUpdate') }}" method="post" class="">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                    {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docPassport_status">Passport</label>
                                        <input type="checkbox" class="" name="docPassport_status"
                                            id="docPassport_status" value="1"
                                            {{ $teacherDetail->docPassport_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docDriversLicence_status">Driver's
                                            Licence</label>
                                        <input type="checkbox" class="" name="docDriversLicence_status"
                                            id="docDriversLicence_status" value="1"
                                            {{ $teacherDetail->docDriversLicence_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docBankStatement_status">Bank
                                            Statement</label>
                                        <input type="checkbox" class="" name="docBankStatement_status"
                                            id="docBankStatement_status" value="1"
                                            {{ $teacherDetail->docBankStatement_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docDBS_status">DBS</label>
                                        <input type="checkbox" class="" name="docDBS_status" id="docDBS_status"
                                            value="1" {{ $teacherDetail->docDBS_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docDisqualForm_status">Disqual. Form</label>
                                        <input type="checkbox" class="" name="docDisqualForm_status"
                                            id="docDisqualForm_status" value="1"
                                            {{ $teacherDetail->docDisqualForm_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docHealthDec_status">Health Dec.</label>
                                        <input type="checkbox" class="" name="docHealthDec_status"
                                            id="docHealthDec_status" value="1"
                                            {{ $teacherDetail->docHealthDec_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docEUCard_status">EU Card</label>
                                        <input type="checkbox" class="" name="docEUCard_status"
                                            id="docEUCard_status" value="1"
                                            {{ $teacherDetail->docEUCard_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docUtilityBill_status">Utility Bill</label>
                                        <input type="checkbox" class="" name="docUtilityBill_status"
                                            id="docUtilityBill_status" value="1"
                                            {{ $teacherDetail->docUtilityBill_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docTelephoneBill_status">Telephone
                                            Bill</label>
                                        <input type="checkbox" class="" name="docTelephoneBill_status"
                                            id="docTelephoneBill_status" value="1"
                                            {{ $teacherDetail->docTelephoneBill_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docBenefitStatement_status">Benefit
                                            Statement</label>
                                        <input type="checkbox" class="" name="docBenefitStatement_status"
                                            id="docBenefitStatement_status" value="1"
                                            {{ $teacherDetail->docBenefitStatement_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docCreditCardBill_status">Credit Card
                                            Bill</label>
                                        <input type="checkbox" class="" name="docCreditCardBill_status"
                                            id="docCreditCardBill_status" value="1"
                                            {{ $teacherDetail->docCreditCardBill_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docP45P60_status">P45/P60</label>
                                        <input type="checkbox" class="" name="docP45P60_status"
                                            id="docP45P60_status" value="1"
                                            {{ $teacherDetail->docP45P60_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docCouncilTax_status">Counsil Tax
                                            Bill</label>
                                        <input type="checkbox" class="" name="docCouncilTax_status"
                                            id="docCouncilTax_status" value="1"
                                            {{ $teacherDetail->docCouncilTax_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Document List Edit Modal -->

    <!-- Vetting Edit Modal -->
    <div class="modal fade" id="editVettingDetModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Vetting</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Vetting</h2>
                    </div>

                    <form action="{{ url('/teacherVettingUpdate') }}" method="post" class="form-validate-5">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                    {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetUpdateService_status">Vetting Update
                                            Service</label>
                                        <input type="checkbox" class="" name="vetUpdateService_status"
                                            id="vetUpdateService_status" value="1"
                                            {{ $teacherDetail->vetUpdateService_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Date Register On Update</label>
                                        <input type="text" class="form-control datePickerPaste "
                                            name="vetUpdateServiceReg_dte" id=""
                                            value="{{ $teacherDetail->vetUpdateServiceReg_dte != null ? date('d/m/Y', strtotime($teacherDetail->vetUpdateServiceReg_dte)) : '' }}">
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetList99Checked_dte">List 99</label>
                                        <input type="checkbox" class="" name="vetList99Checked_dte"
                                            id="vetList99Checked_dte" value="1"
                                            {{ $teacherDetail->vetList99Checked_dte != null ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetNctlExempt_dte">NCTL Exempt</label>
                                        <input type="checkbox" class="" name="vetNctlExempt_dte"
                                            id="vetNctlExempt_dte" value="1"
                                            {{ $teacherDetail->vetNctlExempt_dte != null ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetNCTLChecked_dte">NCTL Check</label>
                                        <input type="checkbox" class="" name="vetNCTLChecked_dte"
                                            id="vetNCTLChecked_dte" value="1"
                                            {{ $teacherDetail->vetNCTLChecked_dte != null ? 'checked' : '' }}>
                                    </div>

                                    {{-- <div class="modal-side-field mb-2">
                                    <label class="form-check-label" for="vetDisqualAssociation_status">Disqualification
                                        Check</label>
                                    <input type="checkbox" class="" name="vetDisqualAssociation_status"
                                        id="vetDisqualAssociation_status" value="1"
                                        {{ $teacherDetail->vetDisqualAssociation_status == '-1' ? 'checked' : '' }}>
                                </div> --}}

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetQualification_status">Qualifications
                                            Check</label>
                                        <input type="checkbox" class="" name="vetQualification_status"
                                            id="vetQualification_status" value="1"
                                            {{ $teacherDetail->vetQualification_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="safeguardingInduction_status">Safeguarding
                                            Induction</label>
                                        <input type="checkbox" class="" name="safeguardingInduction_status"
                                            id="safeguardingInduction_status" value="1"
                                            {{ $teacherDetail->safeguardingInduction_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="modal-side-field">
                                        <label class="form-check-label" for="rightToWork_status">Right to Work</label>
                                        <input type="checkbox" class="" name="rightToWork_status"
                                            id="rightToWork_status" value="1"
                                            {{ $teacherDetail->rightToWork_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group calendar-form-filter rightToWorkDiv"
                                        style="display: {{ $teacherDetail->rightToWork_status == '-1' ? 'block' : 'none' }}">
                                        <select
                                            class="form-control {{ $teacherDetail->rightToWork_status == '-1' ? 'field-validate-5' : '' }}"
                                            name="rightToWork_int" id="rightToWork_int" style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($RTW_list as $key2 => $RTW)
                                                <option value="{{ $RTW->description_int }}"
                                                    {{ $teacherDetail->rightToWork_int == $RTW->description_int ? 'selected' : '' }}>
                                                    {{ $RTW->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group modal-input-field rightToWorkDiv"
                                        style="display: {{ $teacherDetail->rightToWork_status == '-1' ? 'block' : 'none' }}">
                                        <label class="form-check-label">Date Checked</label>
                                        <input type="text" class="form-control datePickerPaste" name="rightToWork_dte"
                                            id="rightToWork_dteId"
                                            value="{{ $teacherDetail->rightToWork_dte != null ? date('d/m/Y', strtotime($teacherDetail->rightToWork_dte)) : '' }}">
                                    </div>

                                    <div class="modal-side-field">
                                        <label class="form-check-label" for="overseasPolicy_status">Overseas
                                            Police</label>
                                        <input type="checkbox" class="" name="overseasPolicy_status"
                                            id="overseasPolicy_status" value="1"
                                            {{ $teacherDetail->overseasPolicy_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group calendar-form-filter OverseasPolisyDiv"
                                        style="display: {{ $teacherDetail->overseasPolicy_status == '-1' ? 'block' : 'none' }}">
                                        <select
                                            class="form-control {{ $teacherDetail->overseasPolicy_status == '-1' ? 'field-validate-5' : '' }}"
                                            name="overseasPolicy_txt" id="overseasPolicy_txt" style="width:100%;">
                                            <option value="">Choose one</option>
                                            <option value="N/A"
                                                {{ $teacherDetail->overseasPolicy_txt == 'N/A' ? 'selected' : '' }}>N/A
                                            </option>
                                            <option value="Clear"
                                                {{ $teacherDetail->overseasPolicy_txt == 'Clear' ? 'selected' : '' }}>Clear
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group modal-input-field OverseasPolisyDiv"
                                        style="display: {{ $teacherDetail->overseasPolicy_status == '-1' ? 'block' : 'none' }}">
                                        <label class="form-check-label">Date Checked</label>
                                        <input type="text" class="form-control datePickerPaste"
                                            name="overseasPolicy_dte" id="overseasPolicy_dteId"
                                            value="{{ $teacherDetail->overseasPolicy_dte != null ? date('d/m/Y', strtotime($teacherDetail->overseasPolicy_dte)) : '' }}">
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vets128_status">s128 Management Check</label>
                                        <input type="checkbox" class="" name="vets128_status" id="vets128_status"
                                            value="1" {{ $teacherDetail->vets128_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetEEARestriction_status">EEA Restriction
                                            Check</label>
                                        <input type="checkbox" class="" name="vetEEARestriction_status"
                                            id="vetEEARestriction_status" value="1"
                                            {{ $teacherDetail->vetEEARestriction_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    {{-- <div class="modal-side-field mb-2">
                                    <label class="form-check-label" for="vetRadical_status">Redicalisation
                                        Check</label>
                                    <input type="checkbox" class="" name="vetRadical_status"
                                        id="vetRadical_status" value="1"
                                        {{ $teacherDetail->vetRadical_status == '-1' ? 'checked' : '' }}>
                                </div> --}}


                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Vetting Edit Modal -->

    <!-- Teacher DBS Add Modal -->
    <div class="modal fade" id="dbsRecordAddModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Teacher DBS</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add DBS</h2>
                    </div>

                    <form action="{{ url('/newTeacherDbsInsert') }}" method="post" class="form-validate">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                    {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Certificate Number</label><span
                                            style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate"
                                            name="certificateNumber_txt" id="" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Certificate Date</label><span
                                            style="color: red;">*</span>
                                        <input type="text" class="form-control datePickerPaste datepaste-validate"
                                            name="DBSDate_dte" id="" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Position Applied For</label>
                                        <input type="text" class="form-control" name="positionAppliedFor_txt"
                                            id="" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Employer Name</label>
                                        <input type="text" class="form-control" name="employerName_txt"
                                            id="" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Registered Body</label>
                                        <input type="text" class="form-control" name="registeredBody_txt"
                                            id="" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-side-field mb-2">
                                        <input type="checkbox" class="" name="dbsWarning_status"
                                            id="dbsWarning_status" value="1">
                                        <label class="form-check-label" for="dbsWarning_status">Flag Warning</label>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Warning Message</label>
                                        <textarea name="dbsWarning_txt" id="dbsWarning_txt" cols="30" rows="3" class="form-control" disabled></textarea>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <input type="checkbox" class="" name="lastCheckedOn" id="lastCheckedOn"
                                            value="1">
                                        <label class="form-check-label" for="lastCheckedOn">Update 'Last Checked On' date
                                            to today's date</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Teacher DBS Add Modal -->

    <!-- Teacher DBS Edit Modal -->
    <div class="modal fade" id="dbsRecordEditModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher DBS</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit DBS</h2>
                    </div>

                    <form action="{{ url('/teacherDbsUpdate') }}" method="post" class="form-validate-2">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                    {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">
                            <input type="hidden" name="editDBSId" id="editDBSId" value="">

                            <div class="row" id="editDbsAjax"></div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Teacher DBS Edit Modal -->

    <!-- Teacher View Edit Modal -->
    <div class="modal fade" id="dbsRecordViewModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">View Teacher DBS</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>View DBS</h2>
                    </div>

                    <div class="modal-input-field-section">
                        <h6>
                            @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                            @else
                                {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                            @endif
                        </h6>

                        <div class="row" id="viewDbsAjax"></div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Teacher DBS View Modal -->

    <!-- Document Add Modal -->
    <div class="modal fade" id="documentAddModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Teacher Document</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Document</h2>
                    </div>

                    <form action="{{ url('/teacherDocumentInsert') }}" method="post" class="form-validate-3"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                    {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="modal-input-field form-group" hidden>
                                        <label class="form-check-label">Document Name</label>
                                        <input type="text" class="form-control" name="file_name" id="fileName"
                                            value="">
                                        <input type="hidden" class="form-control" name="file_name_hidden"
                                            id="docNameHidden" value="">
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Document Type</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate-3 select2" name="type_int"
                                            id="type_int" style="width: 100%;"
                                            onchange="docTypeChange(this.value, this.options[this.selectedIndex].getAttribute('descTxt'))">
                                            <option value="">Choose one</option>
                                            @foreach ($typeList as $key5 => $type)
                                                <option value="{{ $type->description_int }}"
                                                    descTxt="{{ $type->description_txt }}">
                                                    {{ $type->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Upload Document</label><span
                                            style="color: red;">*</span>
                                        <input type="file" class="form-control file-validate-3" name="file"
                                            id="" value=""><span> *Only file type 'jpg', 'png', 'jpeg',
                                            'pdf', 'doc', 'docx', 'txt'</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Document Add Modal -->

    <!-- Document Edit Modal -->
    <div class="modal fade" id="DocumentEditModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Document</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Document</h2>
                    </div>

                    <form action="{{ url('/teacherDocumentUpdate') }}" method="post" class="form-validate-4"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                    {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">
                            <input type="hidden" name="editDocumentId" id="editDocumentId" value="">

                            <div class="row" id="docEditAjax"></div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Document Edit Modal -->

    @if ($dbsExp == '1')
        <script>
            $(document).ready(function() {
                var expText = "{{ $dbsExpText }}";
                swal("DBS Record Expire Soon", expText);
            })
        </script>
        <?php $dbsExp == '2'; ?>
    @endif

    <script>
        $(document).ready(function() {
            $('#myTable,#dbsTable').DataTable({
                scrollY: '300px',
                paging: false,
                footer: false,
                info: false,
                ordering: false,
                searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });

            $("#rightToWork_status").change(function() {
                if ($(this).is(":checked")) {
                    $('.rightToWorkDiv').css('display', 'block');

                    $('#rightToWork_int').addClass('field-validate-5');
                    $('#rightToWork_dteId').addClass('field-validate-5');
                } else {
                    $('.rightToWorkDiv').css('display', 'none');

                    $('#rightToWork_int').closest(".form-group").removeClass('has-error');
                    $('#rightToWork_int').removeClass('field-validate-5');
                    $('#rightToWork_int').val('');

                    $('#rightToWork_dteId').closest(".form-group").removeClass('has-error');
                    $('#rightToWork_dteId').removeClass('field-validate-5');
                    $('#rightToWork_dteId').val('');
                }
            });
            $("#overseasPolicy_status").change(function() {
                if ($(this).is(":checked")) {
                    $('.OverseasPolisyDiv').css('display', 'block');

                    $('#overseasPolicy_txt').addClass('field-validate-5');
                    $('#overseasPolicy_dteId').addClass('field-validate-5');
                } else {
                    $('.OverseasPolisyDiv').css('display', 'none');

                    $('#overseasPolicy_txt').closest(".form-group").removeClass('has-error');
                    $('#overseasPolicy_txt').removeClass('field-validate-5');
                    $('#overseasPolicy_txt').val('');

                    $('#overseasPolicy_dteId').closest(".form-group").removeClass('has-error');
                    $('#overseasPolicy_dteId').removeClass('field-validate-5');
                    $('#overseasPolicy_dteId').val('');
                }
            });
        });

        $("#dbsWarning_status").change(function() {
            if ($(this).is(":checked")) {
                $('#dbsWarning_txt').attr('disabled', false);
            } else {
                $('#dbsWarning_txt').attr('disabled', true);
            }
        });

        function DBSRowSelect(DBS_id) {
            if ($('#editDBSRow' + DBS_id).hasClass('tableRowActive')) {
                $('#DBSId').val('');
                $('#editDBSRow' + DBS_id).removeClass('tableRowActive');
                $('#deleteDbsRecordBttn').addClass('disabled-link');
                $('#viewDbsRecordBttn').addClass('disabled-link');
                $('#editDbsRecordBttn').addClass('disabled-link');
            } else {
                $('#DBSId').val(DBS_id);
                $('.editDBSRow').removeClass('tableRowActive');
                $('#editDBSRow' + DBS_id).addClass('tableRowActive');
                $('#deleteDbsRecordBttn').removeClass('disabled-link');
                $('#viewDbsRecordBttn').removeClass('disabled-link');
                $('#editDbsRecordBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editDbsRecordBttn', function() {
            var DBSId = $('#DBSId').val();
            if (DBSId) {
                $('#editDBSId').val(DBSId);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('teacherDbsRecordEdit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        DBSId: DBSId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#editDbsAjax').html(data.html);
                    }
                });
                $('#dbsRecordEditModal').modal("show");
            } else {
                swal("", "Please select one record.");
            }
        });

        $(document).on('click', '#viewDbsRecordBttn', function() {
            var DBSId = $('#DBSId').val();
            if (DBSId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('teacherDbsRecordView') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        DBSId: DBSId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#viewDbsAjax').html(data.html);
                    }
                });
                $('#dbsRecordViewModal').modal("show");
            } else {
                swal("", "Please select one record.");
            }
        });

        $(document).on('click', '#deleteDbsRecordBttn', function() {
            var DBSId = $('#DBSId').val();
            if (DBSId) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to remove this record?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('teacherDbsRecordDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        DBSId: DBSId
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one record.");
            }
        });

        function documentRowSelect(teacherDocument_id) {
            if ($('#editDocumentRow' + teacherDocument_id).hasClass('tableRowActive')) {
                setIds(teacherDocument_id, 'rm');
                $('#editDocumentRow' + teacherDocument_id).removeClass('tableRowActive');
            } else {
                setIds(teacherDocument_id, 'add');
                $('#editDocumentRow' + teacherDocument_id).addClass('tableRowActive');
            }
        }

        function setIds(teacherDocument_id, type) {
            var ItemId = parseInt(teacherDocument_id);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#DocumentId').val();
            if (asnItemIds) {
                idsArr = asnItemIds.split(',');
            }
            if (type == 'add') {
                idsArr.push(ItemId);
            }
            if (type == 'rm') {
                idsArr = jQuery.grep(idsArr, function(value) {
                    return value != ItemId;
                });
            }
            ids = idsArr.toString();
            $('#DocumentId').val(ids);
            if (ids) {
                $('#deleteDocumentBttn').removeClass('disabled-link');
                $('#editDocumentBttn').removeClass('disabled-link');
                $('#documentMailBttn').removeClass('disabled-link');
                $('#viewDocumentBttn').removeClass('disabled-link');
            } else {
                $('#deleteDocumentBttn').addClass('disabled-link');
                $('#editDocumentBttn').addClass('disabled-link');
                $('#documentMailBttn').addClass('disabled-link');
                $('#viewDocumentBttn').addClass('disabled-link');
            }
        }

        $(document).on('click', '#editDocumentBttn', function() {
            var DocumentId = $('#DocumentId').val();
            if (DocumentId) {
                var idsArr = [];
                idsArr = DocumentId.split(',');
                if (idsArr.length == 1) {
                    $('#editDocumentId').val(idsArr[0]);
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('getTeacherDocDetail') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            DocumentId: idsArr[0]
                        },
                        success: function(data) {
                            //console.log(data);
                            $('#docEditAjax').html(data.html);
                        }
                    });
                    $('#DocumentEditModal').modal("show");
                } else {
                    swal("",
                        "You cannot edit more then one document at a time. Please reduce selection to one item."
                    );
                }
            } else {
                swal("", "Please select one document.");
            }
        });

        $(document).on('click', '#viewDocumentBttn', function() {
            var DocumentId = $('#DocumentId').val();
            if (DocumentId) {
                var idsArr = [];
                idsArr = DocumentId.split(',');
                if (idsArr.length == 1) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('teacherDocumentFetch') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            teacherDocument_id: idsArr[0]
                        },
                        success: function(data) {
                            if (data) {
                                var newWindow = window.open(data, '_blank');
                                newWindow.location.href = data;
                                newWindow.addEventListener('load', function() {
                                    newWindow.location.reload(true);
                                });
                            }
                        }
                    });
                } else {
                    swal("",
                        "You cannot preview more then one document at a time. Please reduce selection to one item."
                    );
                }
            } else {
                swal("", "Please select one document.");
            }
        });

        $(document).on('click', '#deleteDocumentBttn', function() {
            var DocumentId = $('#DocumentId').val();
            if (DocumentId) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to remove the selected file(s)?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('teacherDocumentDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        DocumentId: DocumentId
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one document.");
            }
        });

        // $(document).on('click', '#documentMailBttn', function() {
        //     var DocumentId = $('#DocumentId').val();
        //     if (DocumentId) {
        //         var form = $('<form>', {
        //             action: '{{ url('teacherDocumentMail') }}',
        //             method: 'POST',
        //             target: '_blank' // Open in a new tab or window
        //         }).append($('<input>', {
        //             type: 'hidden',
        //             name: '_token',
        //             value: '{{ csrf_token() }}'
        //         })).append($('<input>', {
        //             type: 'hidden',
        //             name: 'DocumentId',
        //             value: DocumentId
        //         }));

        //         $('body').append(form);
        //         form.submit();
        //     } else {
        //         swal("", "Please select one document.");
        //     }
        // });

        $(document).on('click', '#documentMailBttn', function() {
            var documentId = $('#DocumentId').val();
            if (documentId) {
                $('#fullLoader').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ url('teacherDocumentMail') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        DocumentId: documentId
                    },
                    success: function(data) {
                        if (data) {
                            data.forEach(function(url) {
                                const link = document.createElement('a');
                                link.href = url;
                                link.download = (url).split("/").pop();
                                link.target = '_blank';
                                link.click();
                            });
                        }
                        var subject = '';
                        var body = "";
                        window.location = 'mailto:?subject=';

                        $('#fullLoader').hide();
                    }
                });
            } else {
                swal("", "Please select one document.");
            }
        });


        function docTypeChange(desc_int, description_txt) {
            var txt = $('#fileName').val()
            $('#docNameHidden').val(description_txt)
            if (txt == null || txt == '') {
                $('#fileName').val(description_txt)
            }
        }
    </script>
@endsection
