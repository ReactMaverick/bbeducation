@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }

        .date-left-teacher-calendar {
            width: 13%;
        }

        .teacher-calendar-days-text {
            width: 13%;
        }

        .teacher-calendar-days-field3 p {
            text-align: center;
        }

        .teacher-calendar-days-text p {
            /* border-bottom: 1px solid #A0C5E7; */
            padding-bottom: 3px;
        }

        .teacher-calendar-days-sec {
            border: 1px solid #afabab;
            padding-right: 21px;
        }

        .teacher-calendar-table-section {
            padding: 0 5px;
        }

        .calendar-outer-sec:hover {
            cursor: pointer;
        }

        .calendar-section {
            padding: 0 5px;
        }

        .invoice-top-section {
            justify-content: flex-end;
        }

        .finance-contact-icon-sec i {
            font-size: 25px;
        }

        .rejectDiv {
            background-color: #e75943;
            width: 100%;
            min-height: 65px;
            border-radius: 5%;
            border: 1px solid #e75943;
        }

        .rejectDiv p {
            color: #fff;
        }

        .approveDiv {
            background-color: #55e743;
            width: 100%;
            min-height: 65px;
            border-radius: 5%;
            border: 1px solid #55e743;
        }

        .approveDiv p {
            color: #fff;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            <div class="col-md-12 topbar-sec">

                @include('web.finance.finance_header')

                <div class="finance-timesheet-top-total-section">
                    <div class="finance-timesheet-total-section">
                        <div class="timesheet-top-section mb-2">

                            <div class="form-group timesheet-top-input-sec">
                                <form action="{{ url('/finance-timesheets') }}" method="get">
                                    <label for="" class="col-form-label">Timesheets Until</label>
                                    <input type="text" class="datePickerPaste" name="date" id="timesheetDate"
                                        value="{{ date('d/m/Y', strtotime($p_maxDate)) }}">
                                    <button type="submit" class="timesheet-search-btn">Search</button>
                                </form>
                            </div>

                        </div>
                        <div class="finance-timesheet-section">
                            <div class="finance-timesheet-left-sec">

                                <div class="finance-timesheet-contact-first-sec" style="width: 65%;">

                                    <div class="invoice-top-section mb-2">
                                        <div class="finance-contact-icon-sec">
                                            <a style="cursor: pointer" id="reloadBtn" title="Reload timesheets">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </a>
                                        </div>
                                        <div class="invoice-top-btn-sec mr-3">
                                            <button id="selectNoneBtn">Select None</button>
                                        </div>

                                        <div class="invoice-top-btn-sec mr-3">
                                            <button id="selectAllBtn">Select All</button>
                                        </div>
                                        <div class="finance-contact-icon-sec">
                                            <a style="cursor: pointer" class="disabled-link" id="timesheetEditBtn"
                                                title="Edit timesheet">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </div>
                                        <div class="finance-contact-icon-sec">
                                            <a style="cursor: pointer;" class="disabled-link" id="sendToSchoolBttn"
                                                title="Send to school">
                                                <i class="fa-sharp fa-solid fa-paper-plane"></i>
                                            </a>
                                        </div>
                                        <div class="finance-contact-icon-sec">
                                            <a style="cursor: pointer" class="disabled-link" id="timesheetRejectBtn"
                                                title="Reject timesheet">
                                                <i class="fa-sharp fa-solid fa-circle-xmark"></i>
                                            </a>
                                        </div>
                                        <div class="finance-contact-icon-sec">
                                            <a style="cursor: pointer" class="disabled-link" id="timesheetApproveBtn"
                                                title="Approve timesheet">
                                                <i class="fa-solid fa-square-check"></i>
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

                                    <div class="teacher-calendar-days-sec">
                                        <div class="teacher-calendar-days-text">
                                            <p>School</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Teacher</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>{{ date('d M Y', strtotime($weekStartDate)) }}</p>
                                            <p>Monday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day1Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>{{ date('d M Y', strtotime($weekStartDate . ' +1 days')) }}</p>
                                            <p>Tuesday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day2Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>{{ date('d M Y', strtotime($weekStartDate . ' +2 days')) }}</p>
                                            <p>Wednesday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day3Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>{{ date('d M Y', strtotime($weekStartDate . ' +3 days')) }}</p>
                                            <p>Thursday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day4Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>{{ date('d M Y', strtotime($weekStartDate . ' +4 days')) }}</p>
                                            <p>Friday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day5Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Status</p>
                                        </div>
                                    </div>

                                    <input type="hidden" name="" id="timesheetAsnIds" value="{{ $asnIds }}">

                                    <div class="finance-list-text-section">
                                        <div class="teacher-calendar-table-section">

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
                                                <div class="calendar-outer-sec editTimesheetDiv"
                                                    id="editTimesheetDiv{{ $calender->asn_id }}"
                                                    onclick="timesheetRow('{{ $calender->asn_id }}')">
                                                    <div class="calendar-section">
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            <div class="teacher-calendar-days-field3">
                                                                <p>
                                                                    {{ $calender->name_txt }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            <div class="teacher-calendar-days-field3">
                                                                <p>
                                                                    @if ($calender->knownAs_txt == null && $calender->knownAs_txt == '')
                                                                        {{ $calender->firstName_txt . ' ' . $calender->surname_txt }}
                                                                    @else
                                                                        {{ $calender->knownAs_txt . ' ' . $calender->surname_txt }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day1Avail_txt && $calender->day1asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day1LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day1Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day2Avail_txt && $calender->day2asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day2Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day3Avail_txt && $calender->day3asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day3Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day4Avail_txt && $calender->day4asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day4Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day5Avail_txt && $calender->day5asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day5Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($adminApprove == 1)
                                                                <div class="teacher-calendar-days-field3 rejectDiv">
                                                                    <p>
                                                                        Reject
                                                                        @if ($reject_text)
                                                                            ({{ $reject_text }})
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            @elseif($sendToSchool == 1)
                                                                <div class="teacher-calendar-days-field3">
                                                                    <p>Send to school</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3">
                                                                    <p>Pending</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>

                                    <input type="hidden" name="" id="ajaxTimesheetAsnIds" value="">
                                </div>

                                <div class="finance-timesheet-contact-second-sec" style="width: 32%;">
                                    <div class="contact-heading">
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
                                        <table class="table finance-timesheet-page-table" id="">
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
                                                        <td>{{ $timesheetSchool->timesheetDatesRequired_int }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-bottom-text">
                                        <span>Double-click to open the school</span>
                                    </div>
                                </div>
                                <input type="hidden" name="" id="selectedSchoolId" value="">


                                <input type="hidden" name="teacherTimesheetId" id="teacherTimesheetId" value="">
                                <input type="hidden" name="teacherTimesheetStatus" id="teacherTimesheetStatus"
                                    value="">
                                <input type="hidden" name="teacherTimesheetMail" id="teacherTimesheetMail"
                                    value="">
                                <input type="hidden" name="teacherTimesheetPath" id="teacherTimesheetPath"
                                    value="">
                                <input type="hidden" name="docStartDate" id="docStartDate"
                                    value="{{ $weekStartDate }}">
                                <input type="hidden" name="docEndDate" id="docEndDate" value="{{ $weekEndDate }}">

                            </div>

                            <div class="finance-timesheet-left-sec mt-4">

                                <div class="finance-timesheet-contact-first-sec">
                                    <div class="contact-heading">
                                        <div class="contact-heading-text">
                                            <h2>Previous Timesheet list</h2>
                                        </div>
                                    </div>
                                    <div class="finance-timesheet-table-section" style="margin-top: 30px;">
                                        <table class="table finance-timesheet-page-table" id="myTable">
                                            <thead>
                                                <tr class="school-detail-table-heading">
                                                    <th>Teacher</th>
                                                    <th>Date</th>
                                                    <th>Part</th>
                                                    <th>Student</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body-sec" id="teacherListDiv">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-assignment-bottom-text-sec">
                                        <div class="table-bottom-text">
                                            <span>Double-click to open the assignment</span>
                                        </div>

                                        <div class="finance-contact-icon-sec">
                                            <a style="cursor: pointer" class="disabled-link" id="deleteDaysBttn"
                                                title="Remove days from assignment">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                            <a style="cursor: pointer;" class="disabled-link" id="editDaysBttn"
                                                title="Edit days from assignment">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <a style="cursor: pointer" class="disabled-link" id="logTimesheetBtnNew"
                                                title="Log timesheets">
                                                <i class="fa-solid fa-square-check"></i>
                                            </a>
                                            <a style="cursor: pointer" id="reloadTimesheetBtn" title="Reload timesheets">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="" id="asnItemIds" value="">

                                <div class="finance-timesheet-contact-second-sec" style="display: none"
                                    id="teacherTimesheetDiv">
                                    <div class="finance-timesheet-table-section" style="margin-top: 30px;">
                                        <table class="table finance-timesheet-page-table" id="">
                                            <thead>
                                                <tr class="school-detail-table-heading">
                                                    <th>Teacher</th>
                                                    <th>Date</th>
                                                    <th>Part</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body-sec" id="teacherTimesheetTbody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>

                    {{-- <div class="finance-timesheet-right-sec">
                        <div class="finance-timesheet-right-inner-section">
                            <iframe src="https://www.google.com/webhp?igu=1"></iframe>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

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
            } else {
                $('#timesheetApproveBtn').addClass('disabled-link');
                $('#timesheetRejectBtn').addClass('disabled-link');
                $('#timesheetEditBtn').addClass('disabled-link');
                $('#sendToSchoolBttn').addClass('disabled-link');
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
                                        location.reload();
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
            } else {
                $('#deleteDaysBttn').addClass('disabled-link');
                $('#editDaysBttn').addClass('disabled-link');
                $('#logTimesheetBtnNew').addClass('disabled-link');
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

        $(document).on('click', '#ajaxAssignmentEventBtn', function() {
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
                        $('#teacherListDiv').html('');
                        $('#teacherListDiv').html(data.html);
                        if (data.eventId) {
                            $('#selectTeacherRow' + data.eventId).addClass('tableRowActive');
                        }
                        $('#eventEditModal').modal("hide");
                    }
                });
            }
        });
    </script>
@endsection
