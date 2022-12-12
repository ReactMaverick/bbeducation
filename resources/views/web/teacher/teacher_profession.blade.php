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
                    <div class="school-details-first-sec">
                        <div class="details-heading">
                            <h2>Profession</h2>
                            <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
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
                                <!-- <div class="teacher-profession-name-text">
                                            <p>Mr</p>
                                        </div> -->
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
                                    <input type="checkbox" id="" name="" value="1" disabled
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
                                <!-- <div class="teacher-profession-name-text">
                                            <p>Spanish</p>
                                        </div> -->
                            </div>
                        </div>
                    </div>

                    <div class="school-details-second-sec">
                        <div>
                            <div class="details-heading">
                                <h2>Interview</h2>
                                <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                        class="fa-solid fa-pencil"></i></a>
                            </div>

                            <!-- <div class="about-school-section"> -->
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
                                    <p>Interviewed by
                                        {{ $teacherDetail->int_firstName_txt . ' ' . $teacherDetail->int_surname_txt }} on
                                        {{ $teacherDetail->interviewCompletedOn_dtm != null ? date('d-m-Y', strtotime($teacherDetail->interviewCompletedOn_dtm)) : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="school-detail-right-sec">

                    <div class="school-details-contact-second-sec">
                        <div class="contact-heading">
                            <div class="contact-heading-text">
                                <h2>Teaching Subjects</h2>
                            </div>
                            <div class="contact-icon-sec">
                                <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="assignment-finance-table-section">
                            <table class="table school-detail-page-table" id="subjectTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Subject</th>
                                        <th>Main</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($teacherSubjects as $key1 => $subjects)
                                        <tr class="school-detail-table-data editContactRow">
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


                    <div class="school-details-contact-second-sec">
                        <div class="contact-heading">
                            <div class="contact-heading-text">
                                <h2>Qualifications</h2>
                            </div>
                            <div class="contact-icon-sec">
                                <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                    <i class="fa-solid fa-minus"></i>
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
                            <table class="table school-detail-page-table" id="qualificationTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Type</th>
                                        <th>Qualification</th>
                                        <th>QTS</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($teacherQualifications as $key2 => $qualifications)
                                        <tr class="school-detail-table-data editContactRow">
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

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#subjectTable, #qualificationTable').DataTable({
                searching: false,
                paging: false,
                info: false
            });
        });
    </script>
@endsection
