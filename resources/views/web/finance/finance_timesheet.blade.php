{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
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
                    @include('web.finance.finance_header')
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">

                        <div class="finance-timesheet-top-total-section">
                            <div class="finance-timesheet-total-section">
                                <div class="timesheet-top-section">
                                    <div class="form-group timesheet-top-input-sec details-heading">
                                        <form class="finance_timesheets_form" action="{{ url('/finance-timesheets') }}"
                                            method="get">
                                            <label for="" class="col-form-label finance_timesheets_label">Timesheets
                                                Until</label>
                                            <input type="text" class="form-control datePickerPaste" name="date"
                                                id="timesheetDate" value="{{ date('d/m/Y', strtotime($p_maxDate)) }}">
                                            <button type="submit" class="btn btn-secondary">Search</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="finance-timesheet-section">
                                    <div class="finance-timesheet-left-sec">

                                        <div class="row my_row_gap">
                                            <div class="col-md-9 col-lg-9 col-xl-9 col-12 col-sm-12">
                                                <div class="finance-timesheet-contact-first-sec sec_box_edit ">

                                                    <div class="details-heading">
                                                        <div class="contact-heading-text">

                                                        </div>
                                                        <div class="contact-icon-sec">
                                                            <a style="cursor: pointer" id="reloadBtn"
                                                                title="Reload timesheets" class="icon_all">
                                                                <i class="fas fa-sync"></i>
                                                            </a>
                                                            <div class="invoice-top-btn-sec mr-3 icon_all">
                                                                <button class="btn btn-warning btn_nw"
                                                                    id="selectNoneBtn">Select
                                                                    None</button>
                                                            </div>

                                                            <div class="  invoice-top-btn-sec mr-3 icon_all">
                                                                <button class="btn btn-info btn_nw" id="selectAllBtn">Select
                                                                    All</button>
                                                            </div>
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="timesheetDeleteBtn" title="Remove days from assignment">
                                                                <i class="fas fa-trash-alt trash-icon"></i>
                                                            </a>
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="timesheetEditBtn" title="Edit timesheet">
                                                                <i class="fas fa-edit school-edit-icon"></i>
                                                            </a>
                                                            <a style="cursor: pointer;" class="disabled-link icon_all"
                                                                id="sendToSchoolBttn" title="Send to school">
                                                                <i class="fas fa-paper-plane"></i>
                                                            </a>
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="timesheetRejectBtn" title="Reject timesheet">
                                                                <i class="far fa-times-circle"></i>
                                                            </a>

                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="timesheetApproveBtn" title="Approve timesheet">
                                                                <i class="far fa-check-square"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $day1Amount_total = 0;
                                                    $day2Amount_total = 0;
                                                    $day3Amount_total = 0;
                                                    $day4Amount_total = 0;
                                                    $day5Amount_total = 0;
                                                    $asnIdsArr = [];
                                                    foreach ($calenderList as $key => $cal) {
                                                        $day1Amount_total += $cal->day1Amount_dec;
                                                        $day2Amount_total += $cal->day2Amount_dec;
                                                        $day3Amount_total += $cal->day3Amount_dec;
                                                        $day4Amount_total += $cal->day4Amount_dec;
                                                        $day5Amount_total += $cal->day5Amount_dec;
                                                        array_push($asnIdsArr, $cal->asn_id);
                                                    }
                                                    $asnIds = implode(',', $asnIdsArr);
                                                    ?>

                                                    <div class="new_teacher_calendar_outer1 dataTables_wrapper sm_h">
                                                        <div class="new_teacher_wapper">

                                                            <div class="skd_dates_row grid_7 grid_8">
                                                                <div class="teacher-calendar-days-text skd_date f_12">
                                                                    <p>School</p>
                                                                </div>
                                                                <div class="teacher-calendar-days-text skd_date f_12">
                                                                    <p>Teacher</p>
                                                                </div>
                                                                <div class="teacher-calendar-days-text skd_date f_12">
                                                                    <p>{{ date('d M Y', strtotime($weekStartDate)) }}</p>
                                                                    <p>Monday</p>
                                                                    <p class="teacher-calendar-bottom-text">
                                                                        {{ $day1Amount_total }}
                                                                    </p>
                                                                </div>
                                                                <div class="teacher-calendar-days-text skd_date f_12">
                                                                    <p>{{ date('d M Y', strtotime($weekStartDate . ' +1 days')) }}
                                                                    </p>
                                                                    <p>Tuesday</p>
                                                                    <p class="teacher-calendar-bottom-text">
                                                                        {{ $day2Amount_total }}
                                                                    </p>
                                                                </div>
                                                                <div class="teacher-calendar-days-text skd_date f_12">
                                                                    <p>{{ date('d M Y', strtotime($weekStartDate . ' +2 days')) }}
                                                                    </p>
                                                                    <p>Wednesday</p>
                                                                    <p class="teacher-calendar-bottom-text">
                                                                        {{ $day3Amount_total }}
                                                                    </p>
                                                                </div>
                                                                <div class="teacher-calendar-days-text skd_date f_12">
                                                                    <p>{{ date('d M Y', strtotime($weekStartDate . ' +3 days')) }}
                                                                    </p>
                                                                    <p>Thursday</p>
                                                                    <p class="teacher-calendar-bottom-text">
                                                                        {{ $day4Amount_total }}
                                                                    </p>
                                                                </div>
                                                                <div class="teacher-calendar-days-text skd_date f_12">
                                                                    <p>{{ date('d M Y', strtotime($weekStartDate . ' +4 days')) }}
                                                                    </p>
                                                                    <p>Friday</p>
                                                                    <p class="teacher-calendar-bottom-text">
                                                                        {{ $day5Amount_total }}
                                                                    </p>
                                                                </div>
                                                                <div class="teacher-calendar-days-text skd_date f_12">
                                                                    <p>Status</p>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="" id="timesheetAsnIds"
                                                                value="{{ $asnIds }}">

                                                            @foreach ($calenderList as $key1 => $calender)
                                                                <?php
                                                                $adminApprove = 0;
                                                                if ($calender->admin_approve1 == 2 || $calender->admin_approve2 == 2 || $calender->admin_approve3 == 2 || $calender->admin_approve4 == 2 || $calender->admin_approve5 == 2) {
                                                                    $adminApprove = 1;
                                                                }
                                                                
                                                                $sendToSchool = 0;
                                                                if ($calender->send_to_school1 == 1 || $calender->send_to_school2 == 1 || $calender->send_to_school3 == 1 || $calender->send_to_school4 == 1 || $calender->send_to_school5 == 1) {
                                                                    $sendToSchool = 1;
                                                                }
                                                                
                                                                $reject_by_admin = '';
                                                                $reject_by_school = '';
                                                                $reject_text = '';
                                                                if ($adminApprove == 1) {
                                                                    if ($reject_by_admin == '' && $calender->rejected_by_type1 == 'Admin') {
                                                                        $reject_by_admin = 'Admin';
                                                                    }
                                                                    if ($reject_by_admin == '' && $calender->rejected_by_type2 == 'Admin') {
                                                                        $reject_by_admin = 'Admin';
                                                                    }
                                                                    if ($reject_by_admin == '' && $calender->rejected_by_type3 == 'Admin') {
                                                                        $reject_by_admin = 'Admin';
                                                                    }
                                                                    if ($reject_by_admin == '' && $calender->rejected_by_type4 == 'Admin') {
                                                                        $reject_by_admin = 'Admin';
                                                                    }
                                                                    if ($reject_by_admin == '' && $calender->rejected_by_type5 == 'Admin') {
                                                                        $reject_by_admin = 'Admin';
                                                                    }
                                                                
                                                                    if ($reject_by_school == '' && $calender->rejected_by_type1 == 'School') {
                                                                        $reject_by_school = 'School';
                                                                    }
                                                                    if ($reject_by_school == '' && $calender->rejected_by_type2 == 'School') {
                                                                        $reject_by_school = 'School';
                                                                    }
                                                                    if ($reject_by_school == '' && $calender->rejected_by_type3 == 'School') {
                                                                        $reject_by_school = 'School';
                                                                    }
                                                                    if ($reject_by_school == '' && $calender->rejected_by_type4 == 'School') {
                                                                        $reject_by_school = 'School';
                                                                    }
                                                                    if ($reject_by_school == '' && $calender->rejected_by_type5 == 'School') {
                                                                        $reject_by_school = 'School';
                                                                    }
                                                                
                                                                    if ($reject_text == '' && $calender->rejected_text1) {
                                                                        $reject_text = $calender->rejected_text1;
                                                                    }
                                                                    if ($reject_text == '' && $calender->rejected_text2) {
                                                                        $reject_text = $calender->rejected_text2;
                                                                    }
                                                                    if ($reject_text == '' && $calender->rejected_text3) {
                                                                        $reject_text = $calender->rejected_text3;
                                                                    }
                                                                    if ($reject_text == '' && $calender->rejected_text4) {
                                                                        $reject_text = $calender->rejected_text4;
                                                                    }
                                                                    if ($reject_text == '' && $calender->rejected_text5) {
                                                                        $reject_text = $calender->rejected_text5;
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="calendar-section skd_image_calender_box new_teacher_calendar_outer2 new_teacher_calendar_outer3 editTimesheetDiv grid_8"
                                                                    id="editTimesheetDiv{{ $calender->asn_id }}"
                                                                    onclick="timesheetRow('{{ $calender->asn_id }}')">

                                                                    <div
                                                                        class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                        <div
                                                                            class="teacher-calendar-days-field3 field_day_3">
                                                                            <p>
                                                                                {{ $calender->name_txt }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                        <div
                                                                            class="teacher-calendar-days-field3 field_day_3">
                                                                            <p>
                                                                                @if ($calender->knownAs_txt == null && $calender->knownAs_txt == '')
                                                                                    {{ $calender->firstName_txt . ' ' . $calender->surname_txt }}
                                                                                @else
                                                                                    {{ $calender->knownAs_txt . ' ' . $calender->surname_txt }}
                                                                                @endif
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                        @if ($calender->day1Avail_txt && $calender->day1asnDate_dte)
                                                                            <div
                                                                                class="{{ $calender->day1LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                                <p>
                                                                                    {{ $calender->day1Avail_txt }}
                                                                                    {{-- @if ($calender->start_tm1 && $calender->end_tm1)
                                                                                            ({{ date('h:i a', strtotime($calender->start_tm1)) }}
                                                                                            -
                                                                                            {{ date('h:i a', strtotime($calender->end_tm1)) }})
                                                                                        @endif --}}
                                                                                    @if ($calender->lunch_time1)
                                                                                        ({{ $calender->lunch_time1 }})
                                                                                    @endif
                                                                                </p>
                                                                            </div>
                                                                        @else
                                                                            <div class="teacher-calendar-days-field3">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div
                                                                        class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                        @if ($calender->day2Avail_txt && $calender->day2asnDate_dte)
                                                                            <div
                                                                                class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                                <p>
                                                                                    {{ $calender->day2Avail_txt }}
                                                                                    {{-- @if ($calender->start_tm2 && $calender->end_tm2)
                                                                                            ({{ date('h:i a', strtotime($calender->start_tm2)) }}
                                                                                            -
                                                                                            {{ date('h:i a', strtotime($calender->end_tm2)) }})
                                                                                        @endif --}}
                                                                                    @if ($calender->lunch_time2)
                                                                                        ({{ $calender->lunch_time2 }})
                                                                                    @endif
                                                                                </p>
                                                                            </div>
                                                                        @else
                                                                            <div class="teacher-calendar-days-field3">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div
                                                                        class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                        @if ($calender->day3Avail_txt && $calender->day3asnDate_dte)
                                                                            <div
                                                                                class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                                <p>
                                                                                    {{ $calender->day3Avail_txt }}
                                                                                    {{-- @if ($calender->start_tm3 && $calender->end_tm3)
                                                                                            ({{ date('h:i a', strtotime($calender->start_tm3)) }}
                                                                                            -
                                                                                            {{ date('h:i a', strtotime($calender->end_tm3)) }})
                                                                                        @endif --}}
                                                                                    @if ($calender->lunch_time3)
                                                                                        ({{ $calender->lunch_time3 }})
                                                                                    @endif
                                                                                </p>
                                                                            </div>
                                                                        @else
                                                                            <div class="teacher-calendar-days-field3">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div
                                                                        class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                        @if ($calender->day4Avail_txt && $calender->day4asnDate_dte)
                                                                            <div
                                                                                class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                                <p>
                                                                                    {{ $calender->day4Avail_txt }}
                                                                                    {{-- @if ($calender->start_tm4 && $calender->end_tm4)
                                                                                            ({{ date('h:i a', strtotime($calender->start_tm4)) }}
                                                                                            -
                                                                                            {{ date('h:i a', strtotime($calender->end_tm4)) }})
                                                                                        @endif --}}
                                                                                    @if ($calender->lunch_time4)
                                                                                        ({{ $calender->lunch_time4 }})
                                                                                    @endif
                                                                                </p>
                                                                            </div>
                                                                        @else
                                                                            <div class="teacher-calendar-days-field3">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div
                                                                        class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                        @if ($calender->day5Avail_txt && $calender->day5asnDate_dte)
                                                                            <div
                                                                                class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                                <p>
                                                                                    {{ $calender->day5Avail_txt }}
                                                                                    {{-- @if ($calender->start_tm5 && $calender->end_tm5)
                                                                                            ({{ date('h:i a', strtotime($calender->start_tm5)) }}
                                                                                            -
                                                                                            {{ date('h:i a', strtotime($calender->end_tm5)) }})
                                                                                        @endif --}}
                                                                                    @if ($calender->lunch_time5)
                                                                                        ({{ $calender->lunch_time5 }})
                                                                                    @endif
                                                                                </p>
                                                                            </div>
                                                                        @else
                                                                            <div class="teacher-calendar-days-field3">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div
                                                                        class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                        @if ($adminApprove == 1)
                                                                            <div
                                                                                class="teacher-calendar-days-field3 field_day_3 rejectDiv">
                                                                                <p>
                                                                                    Reject
                                                                                    @if ($reject_text)
                                                                                        ({{ $reject_text }})
                                                                                    @endif
                                                                                </p>
                                                                            </div>
                                                                        @elseif($sendToSchool == 1)
                                                                            <div
                                                                                class="teacher-calendar-days-field3 field_day_3">
                                                                                <p>Sent to School</p>
                                                                            </div>
                                                                        @else
                                                                            <div
                                                                                class="teacher-calendar-days-field3 field_day_3">
                                                                                <p>Pending</p>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                            @endforeach

                                                            <input type="hidden" name="" id="ajaxTimesheetAsnIds"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-lg-3 col-xl-3 col-12 col-sm-12">
                                                <div class="finance-timesheet-contact-second-sec sec_box_edit">
                                                    <div class="contact-heading details-heading">
                                                        <div class="contact-heading-text">
                                                            <h2>School List</h2>
                                                        </div>
                                                        {{-- <div class="contact-icon-sec">
                                                            <a style="cursor: pointer;" class="disabled-link" id=""
                                                                title="">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                        </div> --}}
                                                    </div>
                                                    <div class="finance-timesheet-table-section">
                                                        <table class="table table-bordered table-striped" id="myTable1">
                                                            <thead>
                                                                <tr class="school-detail-table-heading">
                                                                    <th>School</th>
                                                                    <th>Days</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-body-sec">
                                                                @foreach ($timesheetSchoolList as $key => $timesheetSchool)
                                                                    <tr class="school-detail-table-data selectSchoolRow"
                                                                        id="selectSchoolRow{{ $timesheetSchool->school_id }}"
                                                                        school-id="{{ $timesheetSchool->school_id }}">
                                                                        <td>{{ $timesheetSchool->schoolName_txt }}</td>
                                                                        <td>{{ $timesheetSchool->timesheetDatesRequired_int }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="table-bottom-text p-2">
                                                        <p>Double-click to open the school</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="" id="selectedSchoolId" value="">

                                        <input type="hidden" name="teacherTimesheetId" id="teacherTimesheetId"
                                            value="">
                                        <input type="hidden" name="teacherTimesheetStatus" id="teacherTimesheetStatus"
                                            value="">
                                        <input type="hidden" name="teacherTimesheetMail" id="teacherTimesheetMail"
                                            value="">
                                        <input type="hidden" name="teacherTimesheetPath" id="teacherTimesheetPath"
                                            value="">
                                        <input type="hidden" name="docStartDate" id="docStartDate"
                                            value="{{ $weekStartDate }}">
                                        <input type="hidden" name="docEndDate" id="docEndDate"
                                            value="{{ $weekEndDate }}">

                                    </div>

                                    <div class="finance-timesheet-left-sec mt-3">
                                        <div class="row my_row_gap">
                                            <div class="col-md-7 col-lg-7 col-xl-7 col-12 col-sm-12">
                                                <div class="finance-timesheet-contact-first-sec sec_box_edit ">
                                                    <div class="contact-heading details-heading">
                                                        <div class="contact-heading-text">
                                                            <h2>Previous Timesheet list</h2>
                                                        </div>
                                                        <div class="contact-icon-sec">
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="deleteDaysBttn" title="Remove days from assignment">
                                                                <i class="fas fa-trash-alt trash-icon"></i>
                                                            </a>
                                                            <a style="cursor: pointer;" class="disabled-link icon_all"
                                                                id="editDaysBttn" title="Edit days from assignment">
                                                                <i class="fas fa-edit school-edit-icon"></i>
                                                            </a>
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="timesheetTeacherRejectBtn" title="Reject Timesheet">
                                                                <i class="far fa-times-circle"></i>
                                                            </a>
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="logTimesheetBtnNew" title="Log timesheets">
                                                                <i class="far fa-check-square"></i>
                                                            </a>
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="timesheetTeacherSendSchoolBtn" title="Send to school">
                                                                <i class="fas fa-paper-plane"></i>
                                                            </a>
                                                            <a style="cursor: pointer" id="reloadTimesheetBtn"
                                                                title="Reload timesheets" class="icon_all">
                                                                <i class="fas fa-sync"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="finance-timesheet-table-section">
                                                        <table class="table table-bordered table-striped" id="myTable2">
                                                            <thead>
                                                                <tr class="school-detail-table-heading">
                                                                    <th>Teacher</th>
                                                                    <th>Date</th>
                                                                    <th>Part</th>
                                                                    {{-- <th>Student</th> --}}
                                                                    <th>Start Time</th>
                                                                    <th>Finish Time</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-body-sec" id="teacherListDiv">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="table-assignment-bottom-text-sec">
                                                        <div class="table-bottom-text p-2">
                                                            <p>Double-click to open the assignment</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="" id="asnItemIds" value="">
                                            </div>

                                            <div class="col-md-5 col-lg-5 col-xl-5 col-12 col-sm-12">
                                                <div class="finance-timesheet-contact-second-sec sec_box_edit"
                                                    id="teacherTimesheetDiv">
                                                    <div class="contact-heading details-heading">
                                                        <div class="contact-heading-text">
                                                            <h2>Candidate Submitted Timesheets</h2>
                                                        </div>
                                                        <div class="contact-icon-sec">
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="logteacherTimeDeleteBtn" title="Remove Timesheet">
                                                                <i class="fas fa-trash-alt trash-icon"></i>
                                                            </a>
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="logteacherTimeRejectBtn" title="Reject Timesheet">
                                                                <i class="far fa-times-circle"></i>
                                                            </a>
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="logteacherTimeApproveBtn" title="Approve Timesheet">
                                                                <i class="far fa-check-square"></i>
                                                            </a>
                                                            <a style="cursor: pointer" class="disabled-link icon_all"
                                                                id="logteacherSendSchoolBtn" title="Send to school">
                                                                <i class="fas fa-paper-plane"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="finance-timesheet-table-section">
                                                        <table class="table table-bordered table-striped" id="myTable3">
                                                            <thead>
                                                                <tr class="school-detail-table-heading">
                                                                    <th>Teacher</th>
                                                                    <th>Date</th>
                                                                    {{-- <th>Part</th> --}}
                                                                    <th>Start Time - Finish Time</th>
                                                                    {{-- <th>End Time</th> --}}
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-body-sec" id="teacherTimesheetTbody">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="" id="logTeacherTimeItemIds"
                                                    value="">
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Edit Modal -->
    <div class="modal fade" id="eventEditModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Working Day</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Assignment Day</h2>
                </div>

                <form method="post" class="form-validate" id="ajaxAssignmentEventForm">
                    @csrf
                    <input type="hidden" name="editEventId" id="editEventId" value="">
                    <input type="hidden" name="max_date" id="" value="{{ $p_maxDate }}">
                    <input type="hidden" name="school_id" id="editSchoolId" value="">

                    <div class="modal-input-field-section">
                        <div id="AjaxEventEdit"></div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-secondary" id="ajaxAssignmentEventBtn">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Event Edit Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable1').DataTable({
                scrollY: '392px',
                paging: false,
                footer: false,
                info: false,
                ordering: false,
                searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
            $('#myTable2').DataTable({
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
            $('#myTable3').DataTable({
                scrollY: '236px',
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

        function timesheetRow(asn_id) {
            if ($('#editTimesheetDiv' + asn_id).hasClass('timesheetActive')) {
                setIds(asn_id, 'rm');
                $('#editTimesheetDiv' + asn_id).removeClass('timesheetActive');
            } else {
                setIds(asn_id, 'add');
                $('#editTimesheetDiv' + asn_id).addClass('timesheetActive');
            }
        }

        function setIds(asn_id, type) {
            var ItemId = parseInt(asn_id);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#ajaxTimesheetAsnIds').val();
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
            $('#ajaxTimesheetAsnIds').val(ids);
            if (ids) {
                $('#timesheetApproveBtn').removeClass('disabled-link');
                $('#timesheetRejectBtn').removeClass('disabled-link');
                $('#timesheetEditBtn').removeClass('disabled-link');
                $('#sendToSchoolBttn').removeClass('disabled-link');
                $('#timesheetDeleteBtn').removeClass('disabled-link');
            } else {
                $('#timesheetApproveBtn').addClass('disabled-link');
                $('#timesheetRejectBtn').addClass('disabled-link');
                $('#timesheetEditBtn').addClass('disabled-link');
                $('#sendToSchoolBttn').addClass('disabled-link');
                $('#timesheetDeleteBtn').addClass('disabled-link');
            }
        }

        $(document).on('click', '#selectAllBtn', function(event) {
            var timesheetAsnIds = $('#timesheetAsnIds').val();
            if (timesheetAsnIds) {
                var asnIdsArr = timesheetAsnIds.split(",");
                $.each(asnIdsArr, function(index, value) {
                    $('#editTimesheetDiv' + value).addClass('timesheetActive');
                });
                $('#ajaxTimesheetAsnIds').val(timesheetAsnIds);
                $('#timesheetApproveBtn').removeClass('disabled-link');
            }
        });

        $(document).on('click', '#selectNoneBtn', function(event) {
            $('.editTimesheetDiv').removeClass('timesheetActive');
            $('#ajaxTimesheetAsnIds').val('');
            $('#timesheetApproveBtn').addClass('disabled-link');
        });

        $(document).on('click', '#timesheetApproveBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            var asnIds = $('#ajaxTimesheetAsnIds').val();
            if (asnIds) {
                swal({
                        title: "",
                        text: "Are you sure you wish to approve all the selected timesheets?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('financeTimesheetApprove') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnIds: asnIds,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}"
                                    },
                                    // success: function(data) {
                                    //     location.reload();
                                    // }
                                    success: function(data) {
                                        $('#fullLoader').hide();
                                        if (data.add == 'Yes') {
                                            $('#sendToSchoolBttn').addClass('disabled-link');
                                            $('#timesheetEditBtn').addClass('disabled-link');
                                            $('#timesheetApproveBtn').addClass('disabled-link');
                                            $('#timesheetRejectBtn').addClass('disabled-link');
                                            $('#timesheetDeleteBtn').addClass('disabled-link');
                                            var arrAsnId = asnIds.split(',');
                                            for (var i = 0; i < arrAsnId.length; i++) {
                                                $('#editTimesheetDiv' + arrAsnId[i])
                                                    .remove();
                                            }
                                            if (data.message) {
                                                var popTxt =
                                                    'You have just logged timesheet for ' + data
                                                    .message;
                                                swal("", popTxt);
                                            }
                                            if (schoolId) {
                                                teacherSubmittedSheet('{{ $p_maxDate }}',
                                                    schoolId);
                                            }
                                        } else {
                                            location.reload();
                                        }
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#timesheetRejectBtn', function() {
            var asnIds = $('#ajaxTimesheetAsnIds').val();
            if (asnIds) {
                swal({
                        title: "",
                        text: "Are you sure you wish to reject all the selected timesheets?",
                        content: {
                            element: 'textarea',
                            attributes: {
                                placeholder: 'Remark',
                                rows: 3
                            }
                        },
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                var remark = $('.swal-content textarea').val();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('financeTimesheetReject') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnIds: asnIds,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}",
                                        remark: remark
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#timesheetDeleteBtn', function() {
            var asnIds = $('#ajaxTimesheetAsnIds').val();
            if (asnIds) {
                swal({
                        title: "",
                        text: "This will remove the assignment items for any highlighted dates. Are you sure you wish to continue?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('financeTimesheetReject') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnIds: asnIds,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}",
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#timesheetEditBtn', function() {
            var asnIds = $('#ajaxTimesheetAsnIds').val();
            if (asnIds) {
                var idsArr = [];
                idsArr = asnIds.split(',');
                if (idsArr.length == 1) {
                    var location = "{{ url('/assignment-details') }}" + '/' + idsArr[0];
                    window.open(location);
                } else {
                    swal("", "You cannot edit more then one timesheet at a time.");
                }
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        function selectDocumentRowSelect(teacher_timesheet_id, status, login_mail, pdf_path) {
            $('#teacherTimesheetTbody').html('');
            $('#teacherTimesheetDiv').css('display', 'none');
            if ($('#selectDocumentRow' + teacher_timesheet_id).hasClass('tableRowActive')) {
                $('#teacherTimesheetId').val('');
                $('#teacherTimesheetStatus').val('');
                $('#teacherTimesheetMail').val('');
                $('#teacherTimesheetPath').val('');
                $('#selectDocumentRow' + teacher_timesheet_id).removeClass('tableRowActive');
                // $('#rejectTimesheetBtn').addClass('disabled-link');
                // $('#sendTimesheetBtn').addClass('disabled-link');
                $('#viewTimesheetBtn').addClass('disabled-link');
                // $('#timesheetMailtoBtn').addClass('disabled-link');
            } else {
                $('#teacherTimesheetId').val(teacher_timesheet_id);
                $('#teacherTimesheetStatus').val(status);
                $('#teacherTimesheetMail').val(login_mail);
                $('#teacherTimesheetPath').val(pdf_path);
                $('.selectDocumentRow').removeClass('tableRowActive');
                $('#selectDocumentRow' + teacher_timesheet_id).addClass('tableRowActive');
                // $('#rejectTimesheetBtn').removeClass('disabled-link');
                // $('#sendTimesheetBtn').removeClass('disabled-link');
                $('#viewTimesheetBtn').removeClass('disabled-link');
                // $('#timesheetMailtoBtn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#viewTimesheetBtn', function() {
            var teacher_timesheet_id = $('#teacherTimesheetId').val();
            if (teacher_timesheet_id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('fetchTeacherSheetById') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacher_timesheet_id: teacher_timesheet_id
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#teacherTimesheetTbody').html('');
                        $('#teacherTimesheetTbody').html(data.html);
                        $('#teacherTimesheetDiv').css('display', 'block');

                        if (data.pdfPath) {
                            var location = data.pdfPath;
                            window.open(location);
                        }
                    }
                });
            } else {
                swal("", "Please select one document.");
            }
        });

        function timesheetApprovRow(asn_id) {
            if ($('#editApprovTimesheetDiv' + asn_id).hasClass('timesheetActive')) {
                setApproveIds(asn_id, 'rm');
                $('#editApprovTimesheetDiv' + asn_id).removeClass('timesheetActive');
            } else {
                setApproveIds(asn_id, 'add');
                $('#editApprovTimesheetDiv' + asn_id).addClass('timesheetActive');
            }
        }

        function setApproveIds(asn_id, type) {
            var ItemId = parseInt(asn_id);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#approveAsnId').val();
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
            $('#approveAsnId').val(ids);
            if (ids) {
                // $('#sendToSchoolBttn').removeClass('disabled-link');
                $('#logTimesheetBtn').removeClass('disabled-link');
            } else {
                // $('#sendToSchoolBttn').addClass('disabled-link');
                $('#logTimesheetBtn').addClass('disabled-link');
            }
        }

        $(document).on('click', '#sendToSchoolBttn', function() {
            var approveAsnId = $('#ajaxTimesheetAsnIds').val();
            if (approveAsnId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to send this timesheet to school?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('sendTimesheetToApproval') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        approveAsnId: approveAsnId,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}"
                                    },
                                    success: function(data) {
                                        if (data.success == 'Yes') {
                                            $('#fullLoader').hide();
                                            swal("", data.message);
                                        } else {
                                            location.reload();
                                        }
                                    }
                                });
                                // $('#fullLoader').hide();
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#logTimesheetBtn', function() {
            var approveAsnId = $('#approveAsnId').val();
            if (approveAsnId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to log this timesheet?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('timesheetAsnItemLog') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        approveAsnId: approveAsnId,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}"
                                    },
                                    success: function(data) {
                                        $('#fullLoader').hide();
                                        if (data.add == 'Yes') {
                                            $('#sendToSchoolBttn').addClass('disabled-link');
                                            $('#logTimesheetBtn').addClass('disabled-link');
                                            var arrAsnId = approveAsnId.split(',');
                                            for (var i = 0; i < arrAsnId.length; i++) {
                                                $('#editApprovTimesheetDiv' + arrAsnId[i])
                                                    .remove();
                                            }
                                            if (data.message) {
                                                var popTxt =
                                                    'You have just logged timesheet for ' + data
                                                    .message;
                                                swal("", popTxt);
                                            }
                                        } else {
                                            location.reload();
                                        }
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#reloadBtn', function() {
            location.reload();
        });

        var DELAY = 200,
            clicks = 0,
            timer = null;

        $(document).on('click', '.selectSchoolRow', function(e) {
            clicks++; //count clicks
            var schoolId = $(this).attr('school-id');
            if (clicks === 1) {
                timer = setTimeout(function() {
                    // alert("Single Click=>"+teacherId); //perform single-click action
                    $('#selectedSchoolId').val('');

                    if ($('#selectSchoolRow' + schoolId).hasClass('tableRowActive')) {
                        $('#selectedSchoolId').val('');
                        $('#selectSchoolRow' + schoolId).removeClass('tableRowActive');
                        fetchTecher('{{ $p_maxDate }}', '');
                    } else {
                        $('#selectedSchoolId').val(schoolId);
                        $('.selectSchoolRow').removeClass('tableRowActive');
                        $('#selectSchoolRow' + schoolId).addClass('tableRowActive');
                        fetchTecher('{{ $p_maxDate }}', schoolId);
                    }
                    clicks = 0; //after action performed, reset counter
                }, DELAY);
            } else {
                clearTimeout(timer); //prevent single-click action
                // alert("Double Click=>" + teacherId); //perform double-click action
                if ($('#selectSchoolRow' + schoolId).hasClass('tableRowActive')) {
                    $('#selectedSchoolId').val('');
                    $('#selectSchoolRow' + schoolId).removeClass('tableRowActive');
                    fetchTecher('{{ $p_maxDate }}', '');
                } else {
                    $('#selectedSchoolId').val(schoolId);
                    $('.selectSchoolRow').removeClass('tableRowActive');
                    $('#selectSchoolRow' + schoolId).addClass('tableRowActive');
                    fetchTecher('{{ $p_maxDate }}', schoolId);
                }

                clicks = 0; //after action performed, reset counter
            }
        }).on("dblclick", '.selectSchoolRow', function(e) {
            e.preventDefault(); //cancel system double-click event
            var schoolId = $(this).attr('school-id');
            var location = "{{ url('/school-detail') }}" + '/' + schoolId;
            window.open(location);
        });

        function fetchTecher(max_date, school_id) {
            $('#teacherListDiv').html('');
            $('#asnItemIds').val('');
            $('#deleteDaysBttn').addClass('disabled-link');
            $('#editDaysBttn').addClass('disabled-link');
            $('#logTimesheetBtnNew').addClass('disabled-link');
            $('#timesheetTeacherRejectBtn').addClass('disabled-link');
            $('#timesheetTeacherSendSchoolBtn').addClass('disabled-link');
            if (school_id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('fetchTeacherById') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        max_date: max_date,
                        school_id: school_id
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#teacherListDiv').html(data.html);
                    }
                });

                teacherSubmittedSheet(max_date, school_id);
            }
        }

        function teacherSubmittedSheet(max_date, school_id) {
            if (school_id && max_date) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('fetchTeacherSheetByIdNew') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        school_id: school_id,
                        max_date: max_date
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#teacherTimesheetTbody').html('');
                        $('#teacherTimesheetTbody').html(data.html);
                        $('#teacherTimesheetDiv').css('display', 'block');
                        $('#logteacherTimeApproveBtn').addClass('disabled-link');
                        $('#logteacherSendSchoolBtn').addClass('disabled-link');
                        $('#logTeacherTimeItemIds').val('');
                    }
                });
            }
        }

        var DELAY1 = 200,
            clicks1 = 0,
            timer1 = null;

        $(document).on('click', '.selectTeacherRow', function(e1) {
            clicks1++; //count clicks
            var asnitemId = $(this).attr('asnitem-id');
            var asnId = $(this).attr('asn-id');
            var teacherId = $(this).attr('teacher-id');
            // var schoolId = $(this).attr('school-id');
            if (clicks1 === 1) {
                timer1 = setTimeout(function() {
                    // alert("Single Click=>"+teacherId); //perform single-click action
                    if ($('#selectTeacherRow' + asnitemId).hasClass('tableRowActive')) {
                        $('#selectTeacherRow' + asnitemId).removeClass('tableRowActive');
                        setIdsNew(asnitemId, 'rm');
                    } else {
                        $('#selectTeacherRow' + asnitemId).addClass('tableRowActive');
                        setIdsNew(asnitemId, 'add');
                    }
                    clicks1 = 0; //after action performed, reset counter
                }, DELAY1);
            } else {
                clearTimeout(timer1); //prevent single-click action
                // alert("Double Click=>" + teacherId); //perform double-click action
                if ($('#selectTeacherRow' + asnitemId).hasClass('tableRowActive')) {
                    $('#selectTeacherRow' + asnitemId).removeClass('tableRowActive');
                    setIdsNew(asnitemId, 'rm');
                } else {
                    $('#selectTeacherRow' + asnitemId).addClass('tableRowActive');
                    setIdsNew(asnitemId, 'add');
                }

                clicks1 = 0; //after action performed, reset counter

                var location = "{{ url('/assignment-details') }}" + '/' + asnId;
                window.open(location);
            }
        }).on("dblclick", '.selectTeacherRow', function(e1) {
            e1.preventDefault(); //cancel system double-click event
            var asnId = $(this).attr('asn-id');
            var location = "{{ url('/assignment-details') }}" + '/' + asnId;
            window.open(location);
        });

        function setIdsNew(asnitem_id, type) {
            var ItemId = parseInt(asnitem_id);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#asnItemIds').val();
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
            $('#asnItemIds').val(ids);
            if (ids) {
                $('#deleteDaysBttn').removeClass('disabled-link');
                $('#editDaysBttn').removeClass('disabled-link');
                $('#logTimesheetBtnNew').removeClass('disabled-link');
                $('#timesheetTeacherRejectBtn').removeClass('disabled-link');
                $('#timesheetTeacherSendSchoolBtn').removeClass('disabled-link');
            } else {
                $('#deleteDaysBttn').addClass('disabled-link');
                $('#editDaysBttn').addClass('disabled-link');
                $('#logTimesheetBtnNew').addClass('disabled-link');
                $('#timesheetTeacherRejectBtn').addClass('disabled-link');
                $('#timesheetTeacherSendSchoolBtn').addClass('disabled-link');
            }
        }

        $(document).on('click', '#reloadTimesheetBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            if (schoolId) {
                fetchTecher('{{ $p_maxDate }}', schoolId);
            }
        });

        $(document).on('click', '#deleteDaysBttn', function() {
            var asnItemIds = $('#asnItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "Alert",
                        text: "This will remove the assignment items for any highlighted dates. Are you sure you wish to continue?",
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
                                    url: '{{ url('timesheetAsnItemDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds
                                    },
                                    async: false,
                                    success: function(data) {
                                        var idsArr = [];
                                        if (asnItemIds) {
                                            idsArr = asnItemIds.split(',');
                                        }
                                        for (var i = 0; i < idsArr.length; i++) {
                                            $('#selectTeacherRow' + idsArr[i]).remove();
                                        }
                                        $('#asnItemIds').val('');
                                        $('#deleteDaysBttn').addClass('disabled-link');
                                        $('#editDaysBttn').addClass('disabled-link');
                                        $('#logTimesheetBtnNew').addClass('disabled-link');
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one item.");
            }
        });

        $(document).on('click', '#editDaysBttn', function() {
            var asnItemIds = $('#asnItemIds').val();
            var idsArr = [];
            var SITEURL = "{{ url('/') }}";
            if (asnItemIds) {
                idsArr = asnItemIds.split(',');
                if (idsArr.length == 1) {
                    // alert(idsArr[0])
                    var schoolId = $('#selectedSchoolId').val();
                    $('#editSchoolId').val(schoolId);
                    $.ajax({
                        url: SITEURL + "/timesheetEditEvent",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: idsArr[0]
                        },
                        type: "POST",
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                if (data.exist == 'Yes') {
                                    $('#editEventId').val(data.eventId)
                                    $('#AjaxEventEdit').html(data.html);
                                    $('#eventEditModal').modal("show");
                                }
                            }
                        }
                    });
                } else {
                    swal("", "You cannot edit more then one item at a time.");
                }
            } else {
                swal("", "Please select one item.");
            }
        });

        $(document).on('click', '#logTimesheetBtnNew', function() {
            var schoolId = $('#selectedSchoolId').val();
            var asnItemIds = $('#asnItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to log this timesheet?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('timesheetAsnItemLogNew') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds,
                                        schoolId: schoolId
                                    },
                                    async: false,
                                    dataType: "json",
                                    success: function(data) {
                                        $('#fullLoader').hide();
                                        if (data.add == 'Yes') {
                                            var idsArr = [];
                                            if (asnItemIds) {
                                                idsArr = asnItemIds.split(',');
                                            }
                                            for (var i = 0; i < idsArr.length; i++) {
                                                $('#selectTeacherRow' + idsArr[i]).remove();
                                            }
                                            $('#asnItemIds').val('');
                                            $('#deleteDaysBttn').addClass('disabled-link');
                                            $('#editDaysBttn').addClass('disabled-link');
                                            $('#logTimesheetBtnNew').addClass('disabled-link');
                                            // $('#selectDocumentRow' + teacher_timesheet_id)
                                            //     .remove();
                                            fetchTecher('{{ $p_maxDate }}', schoolId);
                                            var popTxt =
                                                'You have just logged a timesheet for ' + data
                                                .schoolName +
                                                '. Timesheet ID : ' + data.timesheet_id;
                                            swal("", popTxt);
                                        }
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one item.");
            }
        });

        $(document).on('click', '#timesheetTeacherSendSchoolBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            var asnItemIds = $('#asnItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to send all the selected timesheet(s) to school?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('sendLogTimesheetToSchool') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds,
                                        schoolId: schoolId
                                    },
                                    success: function(data) {
                                        fetchTecher('{{ $p_maxDate }}', schoolId);
                                        $('#fullLoader').hide();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one item.");
            }
        });

        $(document).on('click', '#timesheetTeacherRejectBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            var asnItemIds = $('#asnItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to reject all the selected timesheet(s)?",
                        content: {
                            element: 'textarea',
                            attributes: {
                                placeholder: 'Remark',
                                rows: 3
                            }
                        },
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                var remark = $('.swal-content textarea').val();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('teacherTimesheetReject') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds,
                                        schoolId: schoolId,
                                        remark: remark
                                    },
                                    success: function(data) {
                                        fetchTecher('{{ $p_maxDate }}', schoolId);
                                        $('#fullLoader').hide();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one item.");
            }
        });

        $(document).on('click', '#ajaxAssignmentEventBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            var error = "";
            $(".field-validate").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".number-validate").each(function() {
                if (this.value == '' || isNaN(this.value)) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (error == "has error") {
                return false;
            } else {
                var form = $("#ajaxAssignmentEventForm");
                var SITEURL = "{{ url('/') }}";
                var actionUrl = SITEURL + "/timesheetEventUpdate";
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    asynch: false,
                    success: function(data) {
                        // $('#teacherListDiv').html('');
                        // $('#teacherListDiv').html(data.html);
                        // if (data.eventId) {
                        //     $('#selectTeacherRow' + data.eventId).addClass('tableRowActive');
                        // }
                        fetchTecher('{{ $p_maxDate }}', schoolId);
                        $('#eventEditModal').modal("hide");
                    }
                });
            }
        });

        $(document).on('click', '.selectLogTeacherRow', function() {
            var teacherId = $(this).attr('teacher-id');
            var asnId = $(this).attr('asn-id');
            var timesheetItemId = $(this).attr('timesheet-item-id');
            var schoolId = $(this).attr('school-id');

            if ($('#selectLogTeacherRow' + timesheetItemId).hasClass('tableRowActive')) {
                $('#selectLogTeacherRow' + timesheetItemId).removeClass('tableRowActive');
                setLogTeacherTimeIdsNew(timesheetItemId, 'rm');
            } else {
                $('#selectLogTeacherRow' + timesheetItemId).addClass('tableRowActive');
                setLogTeacherTimeIdsNew(timesheetItemId, 'add');
            }
        });

        function setLogTeacherTimeIdsNew(timesheetItemId, type) {
            var ItemId = parseInt(timesheetItemId);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#logTeacherTimeItemIds').val();
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
            $('#logTeacherTimeItemIds').val(ids);
            if (ids) {
                $('#logteacherTimeApproveBtn').removeClass('disabled-link');
                $('#logteacherSendSchoolBtn').removeClass('disabled-link');
                $('#logteacherTimeRejectBtn').removeClass('disabled-link');
                $('#logteacherTimeDeleteBtn').removeClass('disabled-link');
            } else {
                $('#logteacherTimeApproveBtn').addClass('disabled-link');
                $('#logteacherSendSchoolBtn').addClass('disabled-link');
                $('#logteacherTimeRejectBtn').addClass('disabled-link');
                $('#logteacherTimeDeleteBtn').addClass('disabled-link');
            }
        }

        $(document).on('click', '#logteacherTimeApproveBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            var asnItemIds = $('#logTeacherTimeItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to approve all the selected timesheet(s)?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('teacherItemSheetApprove') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds,
                                        schoolId: schoolId
                                    },
                                    async: false,
                                    dataType: "json",
                                    success: function(data) {
                                        if (schoolId) {
                                            fetchTecher('{{ $p_maxDate }}', schoolId);
                                        }
                                        $('#fullLoader').hide();
                                        if (data.add == 'Yes') {
                                            var idsArr = [];
                                            if (asnItemIds) {
                                                idsArr = asnItemIds.split(',');
                                            }
                                            for (var i = 0; i < idsArr.length; i++) {
                                                $('#selectLogTeacherRow' + idsArr[i]).remove();
                                            }
                                            $('#logTeacherTimeItemIds').val('');
                                            $('#logteacherTimeApproveBtn').addClass(
                                                'disabled-link');
                                            $('#logteacherSendSchoolBtn').addClass('disabled-link');
                                            var popTxt =
                                                'You have just logged a timesheet for ' + data
                                                .schoolName +
                                                '. Timesheet ID : ' + data.timesheet_id;
                                            swal("", popTxt);
                                        }
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one item.");
            }
        });

        $(document).on('click', '#logteacherSendSchoolBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            var asnItemIds = $('#logTeacherTimeItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "",
                        text: "Are you sure you wish to send all the selected timesheet(s) to school?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('sendteacherItemSheetToApproval') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds,
                                        schoolId: schoolId
                                    },
                                    success: function(data) {
                                        // location.reload();
                                        teacherSubmittedSheet('{{ $p_maxDate }}', schoolId);
                                        $('#fullLoader').hide();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#logteacherTimeRejectBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            var asnItemIds = $('#logTeacherTimeItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "",
                        text: "Are you sure you wish to reject all the selected timesheet(s)?",
                        content: {
                            element: 'textarea',
                            attributes: {
                                placeholder: 'Remark',
                                rows: 3
                            }
                        },
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                var remark = $('.swal-content textarea').val();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('teacherItemSheetReject') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds,
                                        schoolId: schoolId,
                                        remark: remark
                                    },
                                    success: function(data) {
                                        // location.reload();
                                        teacherSubmittedSheet('{{ $p_maxDate }}', schoolId);
                                        $('#fullLoader').hide();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#logteacherTimeDeleteBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            var asnItemIds = $('#logTeacherTimeItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "",
                        text: "Are you sure you wish to delete all the selected timesheet(s)?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('teacherItemSheetDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds,
                                        schoolId: schoolId
                                    },
                                    success: function(data) {
                                        // location.reload();
                                        teacherSubmittedSheet('{{ $p_maxDate }}', schoolId);
                                        $('#fullLoader').hide();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });
    </script>
@endsection
