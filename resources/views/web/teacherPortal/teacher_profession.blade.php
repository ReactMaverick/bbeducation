@extends('web.teacherPortal.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.teacherPortal.teacher_header')
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

                    <div class="col-md-12 topbar-sec">

                        <div class="school-detail-right-sec">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Profession</h2>
                                        </div>

                                        <div class="about-school-section">
                                            <div class="school-name-section">
                                                <div class="school-heading-text">
                                                    <h2>Candidate Type</h2>
                                                </div>
                                                <div class="teacher-profession-name-text">
                                                    <p>{{ $teacherDetail->professionalType_txt }}</p>
                                                </div>
                                            </div>
                                            <div class="school-name-section">
                                                <div class="school-heading-text">
                                                    <h2>SubType</h2>
                                                </div>
                                                {{-- <div class="teacher-profession-name-text">
                                                    <p>Mr</p>
                                                </div> --}}
                                            </div>
                                            <div class="school-name-section">
                                                <div class="school-heading-text">
                                                    <h2>Age Range</h2>
                                                </div>
                                                <div class="grid-refs-sec">
                                                    <div class="grid-refs-text1">
                                                        <p>{{ $teacherDetail->ageRangeSpecialism_txt }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="school-heading-text">
                                                    <h2>NQT Required</h2>
                                                </div>
                                                <div class="teacher-profession-heading-text">
                                                    <input class="" type="checkbox" id="" name=""
                                                        value="1" disabled
                                                        {{ $teacherDetail->NQTRequired_status == '-1' ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="school-heading-text">
                                                    <h2>NQT Completed</h2>
                                                </div>
                                                <div class="teacher-profession-name-text">
                                                    <p>{{ $teacherDetail->NQTCompleted_dte != null ? date('d-m-Y', strtotime($teacherDetail->NQTCompleted_dte)) : '' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="school-heading-text">
                                                    <h2>TRN</h2>
                                                </div>
                                                <div class="teacher-profession-name-text">
                                                    <p>{{ $teacherDetail->profTRN_txt }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="school-heading-text">
                                                    <h2>Imported Title</h2>
                                                </div>
                                                {{-- <div class="teacher-profession-name-text">
                                                    <p>Spanish</p>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="school-details-second-sec">
                        <div>
                            <div class="details-heading">
                                <h2>Interview</h2>
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
                                    @if ($teacherDetail->int_firstName_txt && $teacherDetail->int_surname_txt && $teacherDetail->interviewCompletedOn_dtm != null)
                                        <p>Interviewed by
                                            {{ $teacherDetail->int_firstName_txt . ' ' . $teacherDetail->int_surname_txt }}
                                            on
                                            {{ $teacherDetail->interviewCompletedOn_dtm != null ? date('d-m-Y', strtotime($teacherDetail->interviewCompletedOn_dtm)) : '' }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div> --}}
                        </div>

                        <div class="school-detail-right-sec">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="contact-heading">
                                            <div class="details-heading">
                                                <h2>Teaching Subjects</h2>
                                            </div>
                                            <div class="contact-icon-sec">
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

                                <div class="col-md-6">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="contact-heading">
                                            <div class="details-heading">
                                                <h2>Qualifications</h2>
                                            </div>
                                            <div class="contact-icon-sec">
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

    <script>
        $(document).ready(function() {
            $('#subjectTable, #qualificationTable').DataTable({
                searching: false,
                paging: false,
                info: false,
                ordering: false
            });
        });
    </script>
@endsection
