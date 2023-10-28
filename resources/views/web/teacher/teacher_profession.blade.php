{{-- @extends('web.layout') --}}
@extends('web.teacher.teacher_layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
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
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Profession</h2>
                                            <a data-toggle="modal" data-target="#professionEditModal"
                                                style="cursor: pointer;" class="icon_all"><i
                                                    class="fas fa-edit school-edit-icon"></i></a>
                                        </div>

                                        <div class="about-school-section">
                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>Candidate Type</h2>
                                                </div>
                                                <div class="teacher-profession-name-text">
                                                    <p>{{ $teacherDetail->professionalType_txt }}</p>
                                                </div>
                                            </div>
                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>SubType</h2>
                                                </div>
                                            </div>
                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>Age Range</h2>
                                                </div>
                                                <div class="grid-refs-sec">
                                                    <div class="grid-refs-text1">
                                                        <p>{{ $teacherDetail->ageRangeSpecialism_txt }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <label for="">NQT Required</label>
                                                </div>
                                                <div class="teacher-profession-heading-text">
                                                    <input type="checkbox" id="" name="" value="1"
                                                        disabled
                                                        {{ $teacherDetail->NQTRequired_status == '-1' ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>NQT Completed</h2>
                                                </div>
                                                <div class="teacher-profession-name-text">
                                                    <p>{{ $teacherDetail->NQTCompleted_dte != null ? date('d-m-Y', strtotime($teacherDetail->NQTCompleted_dte)) : '' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>TRN</h2>
                                                </div>
                                                <div class="teacher-profession-name-text">
                                                    <p>{{ $teacherDetail->profTRN_txt }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>Imported Title</h2>
                                                </div>
                                                {{-- <div class="teacher-profession-name-text">
                                                    <p>Spanish</p>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Interview</h2>
                                            <a data-toggle="modal" data-target="#interviewEditModal"
                                                style="cursor: pointer;" class="icon_all"><i
                                                    class="fas fa-edit school-edit-icon"></i></a>
                                        </div>

                                        <div class="about-school-section">
                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>Notes</h2>
                                                </div>
                                                <div class="teacher-profession-headnameing-text">
                                                    <p>{{ $teacherDetail->interviewNotes_txt }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>Interview Quality</h2>
                                                </div>
                                                <div class="teacher-profession-name-text">
                                                    <p>{{ $teacherDetail->interviewQuality_txt }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>Language Skills</h2>
                                                </div>
                                                <div class="teacher-profession-name-text">
                                                    <p>{{ $teacherDetail->interviewLanguageSkills_txt }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-profession-heading-text">
                                                    <h2>Interview Details</h2>
                                                </div>
                                                <div class="teacher-profession-name-text">
                                                    @if (
                                                        $teacherDetail->int_firstName_txt &&
                                                            $teacherDetail->int_surname_txt &&
                                                            $teacherDetail->interviewCompletedOn_dtm != null)
                                                        <p>Interviewed by
                                                            {{ $teacherDetail->int_firstName_txt . ' ' . $teacherDetail->int_surname_txt }}
                                                            on
                                                            {{ $teacherDetail->interviewCompletedOn_dtm != null ? date('d-m-Y', strtotime($teacherDetail->interviewCompletedOn_dtm)) : '' }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="school-detail-right-sec  mt-3">
                            <div class="row my_row_gap">
                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Teaching Subjects</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a data-toggle="modal" data-target="#teachingSubjectAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editTeachingSubjectBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="subjectTable">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Subject</th>
                                                        <th>Main</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($teacherSubjects as $key1 => $subjects)
                                                        <tr class="school-detail-table-data editSubjectRow"
                                                            id="editSubjectRow{{ $subjects->teacherSubject_id }}"
                                                            onclick="teachingSubjectRowSelect({{ $subjects->teacherSubject_id }})">
                                                            <td>{{ $subjects->subject_txt }}</td>
                                                            <td>
                                                                @if ($subjects->isMain_status == -1)
                                                                    {{ 'Y' }}
                                                                @else
                                                                    {{ 'N' }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <input type="hidden" name="" id="teacherSubjectId" value="">
                                </div>

                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Qualifications</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="deleteQualificationBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#addTeacherQualificationModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editQualificationBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="qualificationTable">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Type</th>
                                                        <th>Qualification</th>
                                                        <th>QTS</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($teacherQualifications as $key2 => $qualifications)
                                                        <tr class="school-detail-table-data editQualificationRow"
                                                            id="editQualificationRow{{ $qualifications->qualification_id }}"
                                                            onclick="qualificationRowSelect({{ $qualifications->qualification_id }})">
                                                            <td>{{ $qualifications->subType_txt }}</td>
                                                            <td>{{ $qualifications->title_txt }}</td>
                                                            <td>
                                                                @if ($qualifications->givesQTS_status == -1)
                                                                    {{ 'Y' }}
                                                                @else
                                                                    {{ 'N' }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <input type="hidden" name="" id="teacherQualificationId" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Profession Edit Modal -->
    <div class="modal fade" id="professionEditModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Professional Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Professional Details</h2>
                    </div>

                    <form action="{{ url('/teacherProfessionUpdate') }}" method="post" class="form-validate">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group calendar-form-filter">
                                        <label for="">Candidate Type</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="professionalType_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($candidateList as $key4 => $candidate)
                                                <option value="{{ $candidate->description_int }}"
                                                    {{ $teacherDetail->professionalType_int == $candidate->description_int ? 'selected' : '' }}>
                                                    {{ $candidate->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Age Range</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="ageRangeSpecialism_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($agerangeList as $key5 => $agerange)
                                                <option value="{{ $agerange->description_int }}"
                                                    {{ $teacherDetail->ageRangeSpecialism_int == $agerange->description_int ? 'selected' : '' }}>
                                                    {{ $agerange->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="NQTRequired_status">NQT Year Required</label>
                                        <input type="checkbox" class="" name="NQTRequired_status"
                                            id="NQTRequired_status" value="1"
                                            {{ $teacherDetail->NQTRequired_status == '-1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="modal-input-field">
                                        <label class="form-check-label">NQT Year Completed</label>
                                        <input type="text" class="form-control datePickerPaste"
                                            name="NQTCompleted_dte" id=""
                                            value="{{ $teacherDetail->NQTCompleted_dte != null ? date('d/m/Y', strtotime($teacherDetail->NQTCompleted_dte)) : '' }}">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Teacher Reference Number</label>
                                        <input type="text" class="form-control" name="profTRN_txt" id=""
                                            value="{{ $teacherDetail->profTRN_txt }}">
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
    <!-- Profession Edit Modal -->

    <!-- Interview Edit Modal -->
    <div class="modal fade" id="interviewEditModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Interview</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Interview</h2>
                    </div>

                    <form action="{{ url('/teacherInterviewUpdate') }}" method="post" class="">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group calendar-form-filter">
                                        <label for="">Interview Quality</label>
                                        <select class="form-control select2" name="interviewQuality_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($interviewQualityList as $key4 => $interviewQuality)
                                                <option value="{{ $interviewQuality->description_int }}"
                                                    {{ $teacherDetail->interviewQuality_int == $interviewQuality->description_int ? 'selected' : '' }}>
                                                    {{ $interviewQuality->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Language Skills</label>
                                        <select class="form-control select2" name="interviewLanguageSkills_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($languageSkillList as $key5 => $languageSkill)
                                                <option value="{{ $languageSkill->description_int }}"
                                                    {{ $teacherDetail->interviewLanguageSkills_int == $languageSkill->description_int ? 'selected' : '' }}>
                                                    {{ $languageSkill->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-input-field">
                                        <label class="form-check-label">Interviewed Date</label>
                                        <input type="text" class="form-control datePickerPaste"
                                            name="interviewCompletedOn_dtm" id=""
                                            value="{{ $teacherDetail->interviewCompletedOn_dtm != null ? date('d/m/Y', strtotime($teacherDetail->interviewCompletedOn_dtm)) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Notes</label>
                                        <textarea name="interviewNotes_txt" id="" cols="30" rows="5" class="form-control">{{ $teacherDetail->interviewNotes_txt }}</textarea>
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
    <!-- Interview Edit Modal -->

    <!-- Teacher Subject Add Modal -->
    <div class="modal fade" id="teachingSubjectAddModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Teacher Subject</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Subject</h2>
                    </div>

                    <form action="{{ url('/teachingSubjectInsert') }}" method="post" class="form-validate-2"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group calendar-form-filter">
                                        <label for="">Subject</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate-2 select2" name="subject_id"
                                            id="" style="width: 100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($subjectList as $key1 => $subjects)
                                                <option value="{{ $subjects->description_int }}">
                                                    {{ $subjects->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="isMain_status">Main Subject</label>
                                        <input type="checkbox" class="" name="isMain_status" id="isMain_status"
                                            value="1">
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
    <!-- Teacher Subject Add Modal -->

    <!-- Teacher Subject Edit Modal -->
    <div class="modal fade" id="teachingSubjectEditModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Subject</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Subject</h2>
                    </div>

                    <form action="{{ url('/teachingSubjectUpdate') }}" method="post" class="form-validate-3"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">
                            <input type="hidden" name="teacherSubjectIdEdit" id="teacherSubjectIdEdit" value="">

                            <div class="row" id="teachingSubjectEditAjax"></div>
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
    <!-- Teacher Subject Edit Modal -->

    <!-- Teacher Qualification Add Modal -->
    <div class="modal fade" id="addTeacherQualificationModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Teacher Qualification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Qualification</h2>
                    </div>

                    <form action="{{ url('/teacherQualificationInsert') }}" method="post" class="form-validate-4">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group calendar-form-filter">
                                        <label for="">Qualification Type</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate-4" name="type_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($typeList as $key1 => $type)
                                                <option value="{{ $type->description_int }}">
                                                    {{ $type->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">subtype</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate-4" name="subType_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($subTypeList as $key1 => $subType)
                                                <option value="{{ $subType->description_int }}">
                                                    {{ $subType->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Title</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate-4" name="title_txt"
                                            id="" value="">
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="givesQTS_status">Gives QTS</label>
                                        <input type="checkbox" class="" name="givesQTS_status"
                                            id="givesQTS_status" value="1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Awarding Body</label>
                                        <input type="text" class="form-control" name="awardingBody_txt"
                                            id="" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Qualification Date</label>
                                        <input type="text" class="form-control datePickerPaste" name="qualified_dte"
                                            id="" value="">
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
    <!-- Teacher Qualification Add Modal -->

    <!-- Teacher Qualification Edit Modal -->
    <div class="modal fade" id="editTeacherQualificationModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Qualification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Qualification</h2>
                    </div>

                    <form action="{{ url('/teacherQualificationUpdate') }}" method="post" class="form-validate-5">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">
                            <input type="hidden" name="qualification_id" id="teacherQualificationIdEdit"
                                value="">

                            <div class="row" id="teacherQualificationEditAjax"></div>

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
    <!-- Teacher Qualification Edit Modal -->

    <script>
        $(document).ready(function() {
            $('#subjectTable, #qualificationTable').DataTable({
                scrollY: '200px',
                paging: false,
                footer: false,
                info: false,
                ordering: false,
                searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        function teachingSubjectRowSelect(teacherSubject_id) {
            if ($('#editSubjectRow' + teacherSubject_id).hasClass('tableRowActive')) {
                $('#teacherSubjectId').val('');
                $('#editSubjectRow' + teacherSubject_id).removeClass('tableRowActive');
                $('#editTeachingSubjectBttn').addClass('disabled-link');
            } else {
                $('#teacherSubjectId').val(teacherSubject_id);
                $('.editSubjectRow').removeClass('tableRowActive');
                $('#editSubjectRow' + teacherSubject_id).addClass('tableRowActive');
                $('#editTeachingSubjectBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editTeachingSubjectBttn', function() {
            var teacherSubjectId = $('#teacherSubjectId').val();
            if (teacherSubjectId) {
                $('#teacherSubjectIdEdit').val(teacherSubjectId);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('teachingSubjectEdit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacherSubjectId: teacherSubjectId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#teachingSubjectEditAjax').html(data.html);
                    }
                });
                $('#teachingSubjectEditModal').modal("show");
            } else {
                swal("", "Please select one subject.");
            }
        });

        function qualificationRowSelect(qualification_id) {
            if ($('#editQualificationRow' + qualification_id).hasClass('tableRowActive')) {
                $('#teacherQualificationId').val('');
                $('#editQualificationRow' + qualification_id).removeClass('tableRowActive');
                $('#editQualificationBttn').addClass('disabled-link');
                $('#deleteQualificationBttn').addClass('disabled-link');
            } else {
                $('#teacherQualificationId').val(qualification_id);
                $('.editQualificationRow').removeClass('tableRowActive');
                $('#editQualificationRow' + qualification_id).addClass('tableRowActive');
                $('#editQualificationBttn').removeClass('disabled-link');
                $('#deleteQualificationBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editQualificationBttn', function() {
            var teacherQualificationId = $('#teacherQualificationId').val();
            if (teacherQualificationId) {
                $('#teacherQualificationIdEdit').val(teacherQualificationId);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('teacherQualificationEdit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacherQualificationId: teacherQualificationId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#teacherQualificationEditAjax').html(data.html);
                    }
                });
                $('#editTeacherQualificationModal').modal("show");
            } else {
                swal("", "Please select one qualification.");
            }
        });

        $(document).on('click', '#deleteQualificationBttn', function() {
            var teacherQualificationId = $('#teacherQualificationId').val();
            if (teacherQualificationId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to remove this qualification?",
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
                                    url: '{{ url('teacherQualificationDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        teacherQualificationId: teacherQualificationId
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one qualification.");
            }
        });
    </script>
@endsection
