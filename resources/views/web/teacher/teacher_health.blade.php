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
                        <h2>Preferences</h2>
                        <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                class="fa-solid fa-pencil"></i></a>
                    </div>

                    <div class="about-school-section">
                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">Can Drive</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="" name="" value="1" disabled
                                        {{ $teacherDetail->prefDrive_status == '-1' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">Daily Supply</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="" name="" value="1" disabled
                                        {{ $teacherDetail->prefDailySupply_status == '-1' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">Long Term</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="" name="" value="1" disabled
                                        {{ $teacherDetail->prefLongTerm_status == '-1' ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">Early Morning Calls</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="" name="" value="1" disabled
                                        {{ $teacherDetail->prefEarlyMorningCall_status == '-1' ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">SEN Interested</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="" name="" value="1" disabled
                                        {{ $teacherDetail->prefSEN_status == '-1' ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">SEN Experience</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="" name="" value="1" disabled
                                        {{ $teacherDetail->prefSENExperience_status == '-1' ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Max. Distance</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>{{ $teacherDetail->prefDistance_int }}</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Pref. Year Group</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>{{ $teacherDetail->prefYearGroup_int }}</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Ideal job</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>{{ $teacherDetail->prefIdealJob_txt }}</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Other Agencies</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>{{ $teacherDetail->otherAgencies_txt }}</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Current Rate</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>{{ $teacherDetail->currentRate_dec }}</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Previous Schools</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>{{ $teacherDetail->previousSchools_txt }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="teacher-health-second-sec">
                    <div>
                        <div class="details-heading">
                            <h2>Health</h2>
                            <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </div>

                        <!-- <div class="about-school-section"> -->
                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Occupational Health</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>{{ $teacherDetail->occupationalHealth_txt }}</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Health Issues</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>{{ $teacherDetail->healthIssues_txt }}</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Health Decoration Date</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>{{ date("d-m-Y",strtotime($teacherDetail->healthDeclaration_dte)) }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection