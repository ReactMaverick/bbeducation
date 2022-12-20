@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.teacher.teacher_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.teacher.teacher_header')

                <div class="school-detail-right-sec">
                    <div class="teacher-health-first-sec">
                        <div class="details-heading">
                            <h2>Documents</h2>
                            <a data-toggle="modal" data-target="#editDocumentListModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </div>

                        <div class="teacher-document-first-sec">
                            <div class="teacher-document-section">
                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">Passport</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docPassport_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">Driver's Licence</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docDriversLicence_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">Bank Statement</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docBankStatement_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">DBS</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docDBS_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">Disqual. Form</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docDisqualForm_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">Health Dec.</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docHealthDec_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="teacher-document-section">
                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">EU Card</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docEUCard_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">Utility Bill</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docUtilityBill_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">Telephone Bill</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docTelephoneBill_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">Benefit Statement</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docBenefitStatement_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">Credit Card Bill</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docCreditCardBill_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label for="vehicle1">P45/P60</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docP45P60_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-heading-text">
                                        <label>Counsil Tax Bill</label>
                                    </div>
                                    <div class="teacher-document-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->docCouncilTax_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="teacher-health-second-sec">
                        <div class="details-heading">
                            <h2>Vetting Details</h2>
                            <a data-toggle="modal" data-target="#editVettingDetModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </div>

                        <div class="teacher-document-first-sec">
                            <div class="teacher-document-section">
                                <div class="school-name-section">
                                    <div class="teacher-document-second-heading-text">
                                        <label for="vehicle1">Vetting Update Service</label>
                                    </div>
                                    <div class="teacher-document-second-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->vetUpdateService_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                    <div class="teacher-document-third-name-text">
                                        <p>{{ $teacherDetail->vetUpdateServiceChecked_dte != null ? date('d-m-Y', strtotime($teacherDetail->vetUpdateServiceChecked_dte)) : '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="school-name-section">
                                    <div class="teacher-document-second-heading-text">
                                        <label for="vehicle1">List 99</label>
                                    </div>
                                    <div class="teacher-document-second-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->vetList99Checked_dte != null ? 'checked' : '' }}>
                                    </div>
                                    <div class="teacher-document-third-name-text">
                                        <p>{{ $teacherDetail->vetList99Checked_dte != null ? 'Expires on ' . date('d-m-Y', strtotime($teacherDetail->vetList99Checked_dte . ' +1 years')) : '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="school-name-section">
                                    <div class="teacher-document-second-heading-text">
                                        <label for="vehicle1">Nctl Check</label>
                                    </div>
                                    <div class="teacher-document-second-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->vetNCTLChecked_dte != null ? 'checked' : '' }}>
                                    </div>
                                    {{-- <div class="teacher-document-third-name-text">
                                        <p>Expires on 13-06-2017</p>
                                    </div> --}}
                                </div>

                                <div class="school-name-section">
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
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-second-heading-text">
                                        <label for="vehicle1">Safeguarding Induction</label>
                                    </div>
                                    <div class="teacher-document-second-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->safeguardingInduction_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                    <div class="teacher-document-third-name-text">
                                        <p>{{ $teacherDetail->safeguardingInduction_dte != null ? date('d-m-Y', strtotime($teacherDetail->safeguardingInduction_dte)) : '' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-second-heading-text">
                                        <label for="vehicle1">s128 Management Check</label>
                                    </div>
                                    <div class="teacher-document-second-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->vets128_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                    <div class="teacher-document-third-name-text">
                                        <p>{{ $teacherDetail->vets128_dte != null ? date('d-m-Y', strtotime($teacherDetail->vets128_dte)) : '' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-second-heading-text">
                                        <h2>EEA Restriction Check</h2>
                                    </div>
                                    <div class="teacher-document-second-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->vetEEARestriction_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                    <div class="teacher-document-third-name-text">
                                        <p>{{ $teacherDetail->vetEEARestriction_dte != null ? date('d-m-Y', strtotime($teacherDetail->vetEEARestriction_dte)) : '' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-second-heading-text">
                                        <h2>Right to Work</h2>
                                    </div>
                                    <div class="teacher-document-second-text">
                                        <p>{{ $teacherDetail->rightToWork_txt }}</p>
                                    </div>
                                </div>

                                <div class="school-name-section">
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
                                </div>

                                <div class="school-name-section">
                                    <div class="teacher-document-second-heading-text">
                                        <h2>Qualifications Check</h2>
                                    </div>
                                    <div class="teacher-document-second-name-text">
                                        <input type="checkbox" id="" name="" value="1" disabled
                                            {{ $teacherDetail->vetQualification_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                    <div class="teacher-document-third-name-text">
                                        <p>{{ $teacherDetail->vetQualification_dte != null ? date('d-m-Y', strtotime($teacherDetail->vetQualification_dte)) : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="school-detail-right-sec">

                    <div class="teacher-document-table-sec">
                        <div class="contact-heading">
                            <div class="contact-heading-text">
                                <h2>Filed Documents</h2>
                            </div>
                            <div class="contact-icon-sec">

                                <a href="#">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>

                                <a href="#">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>

                                <a href="#">
                                    <i class="fa-solid fa-folder-open"></i>
                                </a>

                                <a href="#">
                                    <img src="{{ asset('web/company_logo/search-file.png') }}" alt="">
                                </a>

                                <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="assignment-finance-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Type</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    <tr class="school-detail-table-data editContactRow">
                                        <td></td>
                                        <td>Y</td>
                                    </tr>
                                    <tr class="school-detail-table-data editContactRow">
                                        <td></td>
                                        <td>N</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="teacher-document-table-sec">
                        <div class="contact-heading">
                            <div class="contact-heading-text">
                                <h2>DBS Records</h2>
                            </div>
                            <div class="contact-icon-sec">
                                <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                    <img src="{{ asset('web/company_logo/search-file.png') }}" alt="">
                                </a>
                                <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="assignment-finance-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Certificate</th>
                                        <th>Date</th>
                                        <th>Expiry</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>BA</td>
                                        <td>Primary Education</td>
                                        <td>N</td>
                                    </tr>
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>MA</td>
                                        <td>Physical Activity, Health & Sports Training</td>
                                        <td>Y</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Document List Edit Modal -->
        <div class="modal fade" id="editDocumentListModal">
            <div class="modal-dialog modal-dialog-centered calendar-modal-section">
                <div class="modal-content calendar-modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header calendar-modal-header">
                        <h4 class="modal-title">Edit Teacher Document List</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="calendar-heading-sec">
                        <i class="fa-solid fa-pencil school-edit-icon"></i>
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
                                        <label class="form-check-label" for="docDriversLicence_status">Driver's Licence</label>
                                        <input type="checkbox" class="" name="docDriversLicence_status"
                                            id="docDriversLicence_status" value="1"
                                            {{ $teacherDetail->docDriversLicence_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docBankStatement_status">Bank Statement</label>
                                        <input type="checkbox" class="" name="docBankStatement_status"
                                            id="docBankStatement_status" value="1"
                                            {{ $teacherDetail->docBankStatement_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docDBS_status">DBS</label>
                                        <input type="checkbox" class="" name="docDBS_status"
                                            id="docDBS_status" value="1"
                                            {{ $teacherDetail->docDBS_status == '-1' ? 'checked' : '' }}>
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
                                        <label class="form-check-label" for="docTelephoneBill_status">Telephone Bill</label>
                                        <input type="checkbox" class="" name="docTelephoneBill_status" id="docTelephoneBill_status"
                                            value="1" {{ $teacherDetail->docTelephoneBill_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docBenefitStatement_status">Benefit Statement</label>
                                        <input type="checkbox" class="" name="docBenefitStatement_status"
                                            id="docBenefitStatement_status" value="1"
                                            {{ $teacherDetail->docBenefitStatement_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="docCreditCardBill_status">Credit Card Bill</label>
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
                                        <label class="form-check-label" for="docCouncilTax_status">Counsil Tax Bill</label>
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
        <!-- Document List Edit Modal -->

        <!-- Vetting Edit Modal -->
        <div class="modal fade" id="editVettingDetModal">
            <div class="modal-dialog modal-dialog-centered calendar-modal-section">
                <div class="modal-content calendar-modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header calendar-modal-header">
                        <h4 class="modal-title">Edit Teacher Vetting</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="calendar-heading-sec">
                        <i class="fa-solid fa-pencil school-edit-icon"></i>
                        <h2>Edit Vetting</h2>
                    </div>

                    <form action="{{ url('/teacherVettingUpdate') }}" method="post" class="">
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
                                        <label class="form-check-label" for="vetUpdateService_status">Vetting Update Service</label>
                                        <input type="checkbox" class="" name="vetUpdateService_status"
                                            id="vetUpdateService_status" value="1"
                                            {{ $teacherDetail->vetUpdateService_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Date Register On Update</label>
                                        <input type="date" class="form-control" name="vetUpdateServiceChecked_dte"
                                            id="" value="{{ date("Y-m-d",strtotime($teacherDetail->vetUpdateServiceChecked_dte)) }}">
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

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetDisqualAssociation_status">Disqualification Check</label>
                                        <input type="checkbox" class="" name="vetDisqualAssociation_status"
                                            id="vetDisqualAssociation_status" value="1"
                                            {{ $teacherDetail->vetDisqualAssociation_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="safeguardingInduction_status">Safeguarding Induction</label>
                                        <input type="checkbox" class="" name="safeguardingInduction_status"
                                            id="safeguardingInduction_status" value="1"
                                            {{ $teacherDetail->safeguardingInduction_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Right to Work</label>
                                        <select class="form-control select2" name="rightToWork_int"  style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($RTW_list as $key2 => $RTW)
                                                <option value="{{ $RTW->description_int }}" {{ $teacherDetail->rightToWork_int == $RTW->description_int ? 'selected' : '' }} >
                                                    {{ $RTW->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vets128_status">s128 Management Check</label>
                                        <input type="checkbox" class="" name="vets128_status" id="vets128_status"
                                            value="1" {{ $teacherDetail->vets128_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetEEARestriction_status">EEA Restriction Check</label>
                                        <input type="checkbox" class="" name="vetEEARestriction_status"
                                            id="vetEEARestriction_status" value="1"
                                            {{ $teacherDetail->vetEEARestriction_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetRadical_status">Redicalisation Check</label>
                                        <input type="checkbox" class="" name="vetRadical_status"
                                            id="vetRadical_status" value="1"
                                            {{ $teacherDetail->vetRadical_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="vetQualification_status">Qualifications Check</label>
                                        <input type="checkbox" class="" name="vetQualification_status"
                                            id="vetQualification_status" value="1"
                                            {{ $teacherDetail->vetQualification_status == '-1' ? 'checked' : '' }}>
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
        <!-- Vetting Edit Modal -->

    @endsection
