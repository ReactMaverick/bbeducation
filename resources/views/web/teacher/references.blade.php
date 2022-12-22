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

            <div class="school-assignment-sec">
                <div class="teacher-reference-section">
                    <div class="assignment-finance-heading-section">
                        <h2>References</h2>
                        <div class="assignment-finance-icon-section">
                            <a style="cursor: pointer;" class="disabled-link" id="receiveReferenceBttn">
                                <i class="fa-solid fa-square-check"></i>
                            </a>
                            <a style="cursor: pointer;" class="disabled-link" id="previewReferenceBttn">
                                <img src="{{ asset('web/company_logo/search-file.png') }}" alt="">
                            </a>
                            <a style="cursor: pointer;" class="disabled-link" id="sendReferenceBttn">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                            <a data-toggle="modal" data-target="#addTeacherReferenceModal" style="cursor: pointer;">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            <a style="cursor: pointer;" class="disabled-link" id="editReferenceBttn">
                                <i class="fa-solid fa-pencil school-edit-icon"></i>
                            </a>
                        </div>

                    </div>
                    <div class="assignment-finance-table-section">
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Employed At</th>
                                    <th>Date From</th>
                                    <th>Date Until</th>
                                    <th>Ref. Sent</th>
                                    <th>No.</th>
                                    <th>Recieved</th>
                                    <th>Valid?</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                @foreach ($referenceList as $key => $reference)
                                <tr class="school-detail-table-data editReferenceRow"
                                    id="editReferenceRow{{ $reference->teacherReference_id }}"
                                    onclick="editReferenceRowSelect({{ $reference->teacherReference_id }})">
                                    <td>{{ $reference->employer_txt }}</td>
                                    <td>{{ $reference->employedFrom_dte != null ? date('d-m-Y', strtotime($reference->employedFrom_dte)) : '' }}
                                    </td>
                                    <td>{{ $reference->employedUntil_dte != null ? date('d-m-Y', strtotime($reference->employedUntil_dte)) : '' }}
                                    </td>
                                    <td>{{ $reference->lastSent_dte != null ? date('d-m-Y', strtotime($reference->lastSent_dte)) : '' }}
                                    </td>
                                    <td>{{ $reference->totalSent_int }}</td>
                                    <td>{{ $reference->receivedOn_dtm != null ? date('d-m-Y', strtotime($reference->receivedOn_dtm)) : '' }}
                                    </td>
                                    <td>
                                        @if ($reference->receivedOn_dtm != null)
                                        @if ($reference->isValid_status == 0)
                                        {{ 'N' }}
                                        @else
                                        {{ 'Y' }}
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <input type="hidden" name="teacherReferenceId" id="teacherReferenceId" value="">

                <div class="assignment-first-sec">
                    <div class="assignment-left-sidebar-section">
                        <div class="references-bottom-sec">
                            <div class="assignment-sidebar-data">
                                <h2>{{ count($referenceList) }}</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Total References</span>
                            </div>
                        </div>
                        <div class="references-bottom-sec">
                            <div class="assignment-sidebar-data2">
                                <h2>0</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Teacher Reference Add Modal -->
<div class="modal fade" id="addTeacherReferenceModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section">
        <div class="modal-content calendar-modal-content" style="width:100%;">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Add Teacher Reference</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="calendar-heading-sec">
                <i class="fa-solid fa-pencil school-edit-icon"></i>
                <h2>Add Teacher Reference</h2>
            </div>

            <form action="{{ url('/newTeacherReferenceInsert') }}" method="post" class="form-validate">
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
                        <div class="col-md-6 modal-col">
                            <div class="form-group calendar-form-filter">
                                <label for="">Reference Type</label><span style="color: red;">*</span>
                                <select class="form-control field-validate" name="referenceType_id" style="width:100%;">
                                    <option value="">Choose one</option>
                                    @foreach ($referenceTypeList as $key1 => $referenceType)
                                    <option value="{{ $referenceType->referenceType_id }}">
                                        {{ $referenceType->title_txt }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group modal-input-field">
                                <label class="form-check-label">School/Establishment/Employer Name</label><span
                                    style="color: red;">*</span>
                                <input type="text" class="form-control field-validate" name="employer_txt" id=""
                                    value="">
                            </div>

                            <div class="modal-input-field">
                                <label class="form-check-label">Address</label>
                                <input type="text" class="form-control mb-1" name="address1_txt" id="" value="">
                                <input type="text" class="form-control mb-1" name="address2_txt" id="" value="">
                                <input type="text" class="form-control mb-1" name="address3_txt" id="" value="">
                                <input type="text" class="form-control" name="addrress4_txt" id="" value="">
                            </div>

                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Postcode</label><span style="color: red;">*</span>
                                <input type="text" class="form-control field-validate" name="postcode_txt" id=""
                                    value="">
                            </div>
                        </div>
                        <div class="col-md-6 modal-col">
                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Referee Name</label><span style="color: red;">*</span>
                                <input type="text" class="form-control field-validate" name="refereeName_txt" id=""
                                    value="">
                            </div>

                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Referee Email</label><span style="color: red;">*</span>
                                <input type="text" class="form-control field-validate" name="refereeEmail_txt" id=""
                                    value="">
                            </div>

                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Employed Fromm</label><span style="color: red;">*</span>
                                <input type="date" class="form-control field-validate" name="employedFrom_dte" id=""
                                    value="">
                            </div>

                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Employed Until</label><span style="color: red;">*</span>
                                <input type="date" class="form-control field-validate" name="employedUntil_dte" id=""
                                    value="">
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
<!-- Teacher Reference Add Modal -->

<!-- Teacher Reference Edit Modal -->
<div class="modal fade" id="editTeacherReferenceModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section">
        <div class="modal-content calendar-modal-content" style="width:100%;">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Edit Teacher Reference</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="calendar-heading-sec">
                <i class="fa-solid fa-pencil school-edit-icon"></i>
                <h2>Edit Teacher Reference</h2>
            </div>

            <form action="{{ url('/newTeacherReferenceUpdate') }}" method="post" class="form-validate-2">
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
                    <input type="hidden" name="teacherReference_id" id="editTeacherReferenceId" value="">

                    <div class="row" id="editReferenceAjax"></div>

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
<!-- Teacher Reference Edit Modal -->

<!-- Teacher Receive Reference Edit Modal -->
<div class="modal fade" id="receiveTeacherReferenceModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section" style="max-width:90%;">
        <div class="modal-content calendar-modal-content" style="width:100%;">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Receive Teacher Reference</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="calendar-heading-sec">
                <i class="fa-solid fa-pencil school-edit-icon"></i>
                <h2>Receive Teacher Reference</h2>
            </div>

            <form action="{{ url('/receiveReferenceUpdate') }}" method="post" class="form-validate-2">
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
                    <input type="hidden" name="teacherReference_id" id="editTeacherReferenceId" value="">

                    <div class="row">
                        <div class="col-md-3 modal-col">
                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Employer Name</label><span style="color: red;">*</span>
                                <input type="text" class="form-control" name="employedUntil_dte" id=""
                                    value="">
                            </div>
                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Referee Name</label><span style="color: red;">*</span>
                                <input type="text" class="form-control" name="employedUntil_dte" id=""
                                    value="">
                            </div>
                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Referee Email</label><span style="color: red;">*</span>
                                <input type="email" class="form-control" name="employedUntil_dte" id=""
                                    value="">
                            </div>
                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Employed From</label><span style="color: red;">*</span>
                                <input type="date" class="form-control" name="employedUntil_dte" id=""
                                    value="">
                            </div>
                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Employed Until</label><span style="color: red;">*</span>
                                <input type="date" class="form-control" name="employedUntil_dte" id=""
                                    value="">
                            </div>
                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Address</label><span style="color: red;">*</span>
                                <input type="text" class="form-control mb-1" name="employedUntil_dte" id=""
                                    value="">
                                    <input type="text" class="form-control mb-1" name="employedUntil_dte" id=""
                                    value="">
                                    <input type="text" class="form-control mb-1" name="employedUntil_dte" id=""
                                    value="">
                                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                                    value="">
                            </div>
                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Postcode</label><span style="color: red;">*</span>
                                <input type="text" class="form-control" name="employedUntil_dte" id=""
                                    value="">
                            </div>

                        </div>
                        <div class="col-md-9 modal-col">
                            <div class="outer-sec pl-3">
                                <span class="top-text">Text Questions</span>

                                <div class="first-outer-sec">
                                    <div class="first-inner-sec">
                                        <div class="first-inner-heading">
                                            <h2>Question</h2>
                                        </div>
                                        <div class="first-inner-heading2">
                                            <h2>Answer</h2>
                                        </div>
                                    </div>
                                    
                                    <div class="first-inner-sec2">
                                        <div class="first-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="first-inner-input2">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>

                                    <div class="first-inner-sec2">
                                        <div class="first-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="first-inner-input2">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>
                                </div>

                                <span class="top-text">Option Questions</span>
                                <div class="first-outer-sec">
                                    <div class="first-inner-sec">
                                        <div class="second-inner-heading">
                                            <h2>Question</h2>
                                        </div>
                                        <div class="second-inner-heading2">
                                            <h2>Poor - Excellent</h2>
                                        </div>
                                        <div class="second-inner-heading3">
                                            <h2>Answer</h2>
                                        </div>
                                    </div>
                                    
                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="second-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>

                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="second-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>

                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="second-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>

                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="second-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>

                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="second-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>
                                </div>

                                <span class="top-text">Yes/No Questions</span>
                                <div class="first-outer-sec">
                                    <div class="first-inner-sec">
                                        <div class="second-inner-heading">
                                            <h2>Question</h2>
                                        </div>
                                        <div class="second-inner-heading2">
                                            <h2>Yes/No</h2>
                                        </div>
                                        <div class="second-inner-heading3">
                                            <h2>Notes</h2>
                                        </div>
                                    </div>
                                    
                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="third-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>

                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="third-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>

                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="third-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>

                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="third-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>

                                    <div class="first-inner-sec2">
                                        <div class="second-inner-input">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                        <div class="third-inner-input2">
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">
                                            </div>
                                            <div class="form-check-inline option-question-form-check">
                                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">
                                            </div>
                                        </div>
                                        
                                        <div class="second-inner-input3">
                                            <input type="text" class="form-control" name="employedUntil_dte" id="" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-bottom-sec">
                                    <div class="form-check reference-check-sec">
                                            <label for="vehicle1">Reference is Valid</label>
                                            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                        </div>
                                        <div class="form-check reference-check-sec">
                                            <label for="vehicle1">Verbal Reference</label>
                                            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                        </div>

                                        <div class="form-group select-feedback-field">
                                            <label for="inputState">Feedback Quality</label>
                                            <select id="inputState" class="form-control">
                                                <option selected>Choose...</option>
                                                <option>...</option>
                                            </select>
                                        </div>
                                </div>
                                    
                                
                            </div>


                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer calendar-modal-footer">
                    <button type="submit" class="btn btn-secondary">Complete</button>

                    <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Save For Later</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Teacher Receive Reference Edit Modal -->

<script>
$(document).ready(function() {
    $('#myTable').DataTable();
});

function editReferenceRowSelect(teacherReference_id) {
    if ($('#editReferenceRow' + teacherReference_id).hasClass('tableRowActive')) {
        $('#teacherReferenceId').val('');
        $('#editReferenceRow' + teacherReference_id).removeClass('tableRowActive');
        $('#receiveReferenceBttn').addClass('disabled-link');
        $('#previewReferenceBttn').addClass('disabled-link');
        $('#sendReferenceBttn').addClass('disabled-link');
        $('#editReferenceBttn').addClass('disabled-link');
    } else {
        $('#teacherReferenceId').val(teacherReference_id);
        $('.editReferenceRow').removeClass('tableRowActive');
        $('#editReferenceRow' + teacherReference_id).addClass('tableRowActive');
        $('#receiveReferenceBttn').removeClass('disabled-link');
        $('#previewReferenceBttn').removeClass('disabled-link');
        $('#sendReferenceBttn').removeClass('disabled-link');
        $('#editReferenceBttn').removeClass('disabled-link');
    }
}

$(document).on('click', '#editReferenceBttn', function() {
    var teacherReferenceId = $('#teacherReferenceId').val();
    if (teacherReferenceId) {
        $('#editTeacherReferenceId').val(teacherReferenceId);
        $.ajax({
            type: 'POST',
            url: '{{ url('teacherReferenceEdit') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                teacherReferenceId: teacherReferenceId
            },
            success: function(data) {
                //console.log(data);
                $('#editReferenceAjax').html(data.html);
            }
        });
        $('#editTeacherReferenceModal').modal("show");
    } else {
        swal("", "Please select one reference.");
    }
});

$(document).on('click', '#receiveReferenceBttn', function() {
    var teacherReferenceId = $('#teacherReferenceId').val();
    if (teacherReferenceId) {
        $('#editTeacherReferenceId').val(teacherReferenceId);
        // $.ajax({
        //     type: 'POST',
        //     url: '{{ url('teacherReferenceEdit') }}',
        //     data: {
        //         "_token": "{{ csrf_token() }}",
        //         teacherReferenceId: teacherReferenceId
        //     },
        //     success: function(data) {
        //         //console.log(data);
        //         $('#editReferenceAjax').html(data.html);
        //     }
        // });
        $('#receiveTeacherReferenceModal').modal("show");
    } else {
        swal("", "Please select one reference.");
    }
});
</script>
@endsection