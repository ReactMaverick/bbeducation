@extends('web.teacherPortal.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.teacherPortal.teacher_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.teacherPortal.teacher_header')

                {{-- calendar --}}
                <div class="school-detail-right-sec">
                    <div class="teacher-calendar-sec" style="display: block;">
                        {{-- <div class="teacher-calendar-sidebar-section" style="height: auto">
                            <div class="form-check sidebar-mode-check">
                                <label for="addMode"><i class="fa-solid fa-plus"></i></label>
                                <input type="radio" id="addMode" name="calendar_mode" value="add" checked>
                            </div>
                            <div class="form-check sidebar-mode-check">
                                <label for="editMode"><i class="fa-solid fa-pencil"></i></label>
                                <input type="radio" id="editMode" name="calendar_mode" value="edit">
                            </div>
                        </div> --}}

                        <div class="teacher-calendar-slider">
                            <div class="teacher-calendar-table-section">
                                <div class="total-days-slider-sec">
                                    <div class="total-days-text">
                                        <div class="assignment-date">
                                            <a
                                                href="{{ URL::to('/teacher/timesheet?date=' . date('Y-m-d', strtotime($weekStartDate . ' -7 days'))) }}">
                                                <i class="fa-solid fa-caret-left"></i>
                                            </a>
                                        </div>
                                        <div class="teacher-calendar-date-text">
                                            <span>{{ date('D d M Y', strtotime($weekStartDate)) }}</span>
                                        </div>
                                        <div class="assignment-date2">
                                            <a
                                                href="{{ URL::to('/teacher/timesheet?date=' . date('Y-m-d', strtotime($weekStartDate . ' +7 days'))) }}">
                                                <i class="fa-solid fa-caret-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $day1Amount_total = 0;
                                $day2Amount_total = 0;
                                $day3Amount_total = 0;
                                $day4Amount_total = 0;
                                $day5Amount_total = 0;
                                $submitStat = 0;
                                foreach ($calenderList as $key => $cal) {
                                    $day1Amount_total += $cal->day1Amount_dec;
                                    $day2Amount_total += $cal->day2Amount_dec;
                                    $day3Amount_total += $cal->day3Amount_dec;
                                    $day4Amount_total += $cal->day4Amount_dec;
                                    $day5Amount_total += $cal->day5Amount_dec;
                                }
                                ?>

                                <div class="teacher-calendar-days-sec">
                                    <div class="teacher-calendar-total-days-text">
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Monday</p>
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Tuesday</p>
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Wednesday</p>
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Thursday</p>
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Friday</p>
                                    </div>
                                </div>

                                @foreach ($calenderList as $key1 => $calender)
                                    <form action="{{ url('/teacher/logTeacherTimesheetAdd') }}" method="post"
                                        id="teacherTimesheetForm_{{ $calender->teacher_id }}_{{ $calender->school_id }}_{{ $calender->asn_id }}"
                                        style="width: 100%; margin: 0;">
                                        @csrf

                                        <input type="hidden" name="teacher_timesheet_id"
                                            value="{{ $calender->teacher_timesheet_id }}">
                                        <input type="hidden" name="asnId" value="{{ $calender->asn_id }}">
                                        <input type="hidden" name="school_id" value="{{ $calender->school_id }}">
                                        <input type="hidden" name="teacher_id" value="{{ $calender->teacher_id }}">
                                        <input type="hidden" name="weekStartDate" value="{{ $weekStartDate }}">
                                        <input type="hidden" name="weekEndDate" value="{{ $weekEndDate }}">

                                        <div class="calendar-outer-sec">
                                            <div class="calendar-section">
                                                <div class="date-left-teacher-calendar">
                                                    <div class="teacher-calendar-days-field3">
                                                        <p>
                                                            {{ $calender->name_txt }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if (
                                                        $calender->day1Avail_txt &&
                                                            $calender->day1asnDate_dte &&
                                                            $calender->teacher_timesheet_id &&
                                                            $calender->timesheet_item_id1)
                                                        <div class="{{ $calender->day1LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                            style="cursor: pointer;"
                                                            onclick="calDateClick('edit', '{{ $calender->day1asnDate_dte }}', {{ $calender->submit_status }}, {{ $calender->reject_status }}, {{ $calender->asn_id }}, '{{ $calender->timesheet_item_id1 }}')">
                                                            <p>{{ $calender->day1Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3" style="cursor: pointer;"
                                                            onclick="addNewItem('{{ $calender->teacher_timesheet_id }}', '{{ $calender->teacher_id }}', '{{ $calender->school_id }}', '{{ date('d-m-Y', strtotime($weekStartDate)) }}', {{ $calender->submit_status }}, {{ $calender->asn_id }}, '{{ $calender->day1asnItem_id }}')">
                                                        </div>
                                                    @endif
                                                    <input type="hidden" name="asnItem_id[]"
                                                        value="{{ $calender->day1asnItem_id }}">
                                                    <input type="hidden" name="asnDate_dte[]"
                                                        value="{{ $calender->day1asnDate_dte }}">
                                                    <input type="hidden" name="asn_id[]"
                                                        value="{{ $calender->day1Link_id }}">
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if (
                                                        $calender->day2Avail_txt &&
                                                            $calender->day2asnDate_dte &&
                                                            $calender->teacher_timesheet_id &&
                                                            $calender->timesheet_item_id2)
                                                        <div class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                            style="cursor: pointer;"
                                                            onclick="calDateClick('edit', '{{ $calender->day2asnDate_dte }}', {{ $calender->submit_status }}, {{ $calender->reject_status }}, {{ $calender->asn_id }}, '{{ $calender->timesheet_item_id2 }}')">
                                                            <p>{{ $calender->day2Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3" style="cursor: pointer;"
                                                            onclick="addNewItem('{{ $calender->teacher_timesheet_id }}', '{{ $calender->teacher_id }}', '{{ $calender->school_id }}', '{{ date('d-m-Y', strtotime($weekStartDate . ' +1 days')) }}', {{ $calender->submit_status }}, {{ $calender->asn_id }}, '{{ $calender->day2asnItem_id }}')">
                                                        </div>
                                                    @endif
                                                    <input type="hidden" name="asnItem_id[]"
                                                        value="{{ $calender->day2asnItem_id }}">
                                                    <input type="hidden" name="asnDate_dte[]"
                                                        value="{{ $calender->day2asnDate_dte }}">
                                                    <input type="hidden" name="asn_id[]"
                                                        value="{{ $calender->day2Link_id }}">
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if (
                                                        $calender->day3Avail_txt &&
                                                            $calender->day3asnDate_dte &&
                                                            $calender->teacher_timesheet_id &&
                                                            $calender->timesheet_item_id3)
                                                        <div class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                            style="cursor: pointer;"
                                                            onclick="calDateClick('edit', '{{ $calender->day3asnDate_dte }}', {{ $calender->submit_status }}, {{ $calender->reject_status }}, {{ $calender->asn_id }}, '{{ $calender->timesheet_item_id3 }}')">
                                                            <p>{{ $calender->day3Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3" style="cursor: pointer;"
                                                            onclick="addNewItem('{{ $calender->teacher_timesheet_id }}', '{{ $calender->teacher_id }}', '{{ $calender->school_id }}', '{{ date('d-m-Y', strtotime($weekStartDate . ' +2 days')) }}', {{ $calender->submit_status }}, {{ $calender->asn_id }}, '{{ $calender->day3asnItem_id }}')">
                                                        </div>
                                                    @endif
                                                    <input type="hidden" name="asnItem_id[]"
                                                        value="{{ $calender->day3asnItem_id }}">
                                                    <input type="hidden" name="asnDate_dte[]"
                                                        value="{{ $calender->day3asnDate_dte }}">
                                                    <input type="hidden" name="asn_id[]"
                                                        value="{{ $calender->day3Link_id }}">
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if (
                                                        $calender->day4Avail_txt &&
                                                            $calender->day4asnDate_dte &&
                                                            $calender->teacher_timesheet_id &&
                                                            $calender->timesheet_item_id4)
                                                        <div class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                            style="cursor: pointer;"
                                                            onclick="calDateClick('edit', '{{ $calender->day4asnDate_dte }}', {{ $calender->submit_status }}, {{ $calender->reject_status }}, {{ $calender->asn_id }}, '{{ $calender->timesheet_item_id4 }}')">
                                                            <p>{{ $calender->day4Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3" style="cursor: pointer;"
                                                            onclick="addNewItem('{{ $calender->teacher_timesheet_id }}', '{{ $calender->teacher_id }}', '{{ $calender->school_id }}', '{{ date('d-m-Y', strtotime($weekStartDate . ' +3 days')) }}', {{ $calender->submit_status }}, {{ $calender->asn_id }}, '{{ $calender->day4asnItem_id }}')">
                                                        </div>
                                                    @endif
                                                    <input type="hidden" name="asnItem_id[]"
                                                        value="{{ $calender->day4asnItem_id }}">
                                                    <input type="hidden" name="asnDate_dte[]"
                                                        value="{{ $calender->day4asnDate_dte }}">
                                                    <input type="hidden" name="asn_id[]"
                                                        value="{{ $calender->day4Link_id }}">
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if (
                                                        $calender->day5Avail_txt &&
                                                            $calender->day5asnDate_dte &&
                                                            $calender->teacher_timesheet_id &&
                                                            $calender->timesheet_item_id5)
                                                        <div class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                            style="cursor: pointer;"
                                                            onclick="calDateClick('edit', '{{ $calender->day5asnDate_dte }}', {{ $calender->submit_status }}, {{ $calender->reject_status }}, {{ $calender->asn_id }}, '{{ $calender->timesheet_item_id5 }}')">
                                                            <p>{{ $calender->day5Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3" style="cursor: pointer;"
                                                            onclick="addNewItem('{{ $calender->teacher_timesheet_id }}', '{{ $calender->teacher_id }}', '{{ $calender->school_id }}', '{{ date('d-m-Y', strtotime($weekStartDate . ' +4 days')) }}', {{ $calender->submit_status }}, {{ $calender->asn_id }}, '{{ $calender->day5asnItem_id }}')">
                                                        </div>
                                                    @endif
                                                    <input type="hidden" name="asnItem_id[]"
                                                        value="{{ $calender->day5asnItem_id }}">
                                                    <input type="hidden" name="asnDate_dte[]"
                                                        value="{{ $calender->day5asnDate_dte }}">
                                                    <input type="hidden" name="asn_id[]"
                                                        value="{{ $calender->day5Link_id }}">
                                                </div>
                                            </div>
                                            <div class="calendar-section">
                                                <div class="col-md-6">
                                                    @if ($calender->reject_status == 1)
                                                        <p class="mt-3">Status: Rejected by admin</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-6"
                                                    style="display: flex; justify-content: flex-end; padding: 0;">
                                                    @if ($calender->reject_status == 1)
                                                        <button type="submit" class="btn btn-secondary mt-3 mr-2"
                                                            style="float: right; background-color: #48A0DC">Resubmit
                                                            Timesheet</button>
                                                    @endif

                                                    @if ($calender->teacher_timesheet_id)
                                                        {{-- @if ($calender->submit_status)
                                                            <button type="button" class="btn btn-secondary mt-3"
                                                                style="float: right; background-color: #acd6f1">Timesheet
                                                                Submitted</button>
                                                        @else
                                                            <button type="submit" class="btn btn-secondary mt-3"
                                                                style="float: right; background-color: #48A0DC">Submit
                                                                Timesheet</button>
                                                        @endif --}}
                                                        <button type="submit" class="btn btn-secondary mt-3"
                                                            style="float: right; background-color: #48A0DC">Submit
                                                            Timesheet</button>
                                                    @else
                                                        <button type="button" class="btn btn-secondary mt-3"
                                                            style="float: right; background-color: #acd6f1">Submit
                                                            Timesheet</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endforeach

                            </div>
                        </div>





                    </div>
                </div>
                {{-- calendar --}}

            </div>
        </div>
    </div>

    <!-- Event Add Modal -->
    <div class="modal fade" id="eventAddModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width: 70%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Working Day</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Add Assignment Day</h2>
                </div>

                <form action="{{ url('/teacher/teacherTimesheetAddNew') }}" method="post" class="form-validate-2"
                    id="eventAddForm">
                    @csrf

                    <input type="hidden" name="teacher_timesheet_id" id="addTeacherTimesheetId" value="">
                    <input type="hidden" name="teacher_asn_id" id="addTeacherAsnId" value="">
                    <input type="hidden" name="teacher_asn_item_id" id="addTeacherAsnItemId" value="">
                    <input type="hidden" name="school_id" id="addSchoolId" value="">
                    <input type="hidden" name="teacher_id" id="addTeacherId" value="">
                    <input type="hidden" name="asnDate_dte" id="addAsnDate" value="">

                    <div class="modal-input-field-section">
                        <div class="row">
                            <div class="col-md-6 form-group modal-input-field">
                                <label class="form-check-label">Date</label>
                                <p id="asnDateHtml"></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group modal-input-field">
                                <label class="form-check-label">From</label>
                                <input type="text" class="form-control field-validate-2" name="start_tm"
                                    id="workStartTime" value="">
                            </div>

                            <div class="col-md-6 form-group modal-input-field">
                                <label class="form-check-label">To</label>
                                <input type="text" class="form-control field-validate-2" name="end_tm"
                                    id="workEndTime" value="">
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-secondary" id="eventAddBtn">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Event Add Modal -->


    <!-- Event Edit Modal -->
    <div class="modal fade" id="eventEditModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width: 70%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Working Day</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Assignment Day</h2>
                </div>

                <form action="{{ url('/teacher/teacherTimesheetUpdate') }}" method="post" class="form-validate"
                    id="ajaxAssignmentEventForm">
                    @csrf

                    <div class="modal-input-field-section">
                        <div id="AjaxEventEdit"></div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-secondary" id="eventEditBtn">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn"
                            id="teacherTimesheetDelBtn">Delete</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Event Edit Modal -->

    <script>
        $(document).on('change', '#dayPart_int_add', function() {
            var dayPart_int = this.value;
            if (dayPart_int == 4) {
                $('#hours_dec_add').addClass('number-validate-2');
            } else {
                $('#hours_dec_add').removeClass('number-validate-2');
                $('#hours_dec_add').closest(".form-group").removeClass('has-error');
            }
        });

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#workStartTime, #workEndTime').timepicker({
                timeFormat: 'h:i a',
                'step': 60,
                'forceRoundTime': true
            });
        });

        function calDateClick(type, asnDate_dte, submit_status, reject_status, asn_id, timesheet_item_id) {
            // alert(reject_status)
            // if (submit_status && submit_status == 1) {
            //     swal("",
            //         "You cannot edit day as timesheet already submitted."
            //     );
            // } else {
            var SITEURL = "{{ url('/') }}";
            $.ajax({
                url: SITEURL + "/teacher/teacherTimesheetEdit",
                data: {
                    "_token": "{{ csrf_token() }}",
                    asnDate_dte: asnDate_dte,
                    timesheet_item_id: timesheet_item_id,
                    asn_id: asn_id
                },
                type: "POST",
                dataType: "json",
                success: function(data) {
                    if (data.exist == 'Yes') {
                        $('#AjaxEventEdit').html(data.html);
                        $('#eventEditModal').modal("show");
                    }
                }
            });
            // }
        }

        $(document).on('click', '#teacherTimesheetDelBtn', function() {
            var eTeacherTimesheetId = $("#eTeacherTimesheetId").val();
            if (eTeacherTimesheetId) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to remove this item?",
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
                                    url: '{{ url('/teacher/teacherTimesheetDelete') }}',
                                    data: {
                                        timesheet_item_id: eTeacherTimesheetId
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            }
        });

        function addNewItem(teacher_timesheet_id, teacher_id, school_id, asn_date, submit_status, asn_id, asnItem_id) {
            // alert(submit_status)
            // if (submit_status) {
            //     swal("",
            //         "You cannot add day as timesheet already submitted."
            //     );
            // } else {
            $("#asnDateHtml").html(asn_date);
            $("#addTeacherAsnId").val(asn_id);
            $("#addTeacherAsnItemId").val(asnItem_id);
            $("#addTeacherTimesheetId").val(teacher_timesheet_id);
            $("#addSchoolId").val(school_id);
            $("#addTeacherId").val(teacher_id);
            $("#addAsnDate").val(asn_date);

            $('#eventAddModal').modal('show');
            // }
        }

        function timeToInt(time) {
            var arr = time.match(/^(0?[1-9]|1[012]):([0-5][0-9])( )([APap][mM])$/);
            // console.log(arr)
            if (arr == null) return -1;

            if (arr[4].toUpperCase() == 'PM') {
                arr[1] = parseInt(arr[1]) + 12;
            }
            // return parseInt(arr[1] * 100) + parseInt(arr[2]);
            return time;
        }

        $(document).on('click', '#eventAddBtn', function() {
            var error = "";
            var start = timeToInt($('#workStartTime').val());
            var end = timeToInt($('#workEndTime').val());
            $(".field-validate-2").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (start == -1) {
                error = "has error";
                swal("", "Please enter valid start time.");
            } else if (end == -1) {
                error = "has error";
                swal("", "Please enter valid end time.");
            } else if (moment(start, 'hh:mm a') > moment(end, 'hh:mm a')) {
                error = "has error";
                swal("", "Start time should be lower than end time.");
            }
            if (error == "has error") {
                return false;
            } else {
                $('#eventAddForm').submit()
            }
        });

        $(document).on('click', '#eventEditBtn', function() {
            var error = "";
            var start = timeToInt($('#workStartTimeEdit').val());
            var end = timeToInt($('#workEndTimeEdit').val());
            $(".field-validate").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (start == -1) {
                error = "has error";
                swal("", "Please enter valid start time.");
            } else if (end == -1) {
                error = "has error";
                swal("", "Please enter valid end time.");
            } else if (moment(start, 'hh:mm a') > moment(end, 'hh:mm a')) {
                error = "has error";
                swal("", "Start time should be lower than end time.");
            }
            if (error == "has error") {
                return false;
            } else {
                $('#ajaxAssignmentEventForm').submit()
            }
        });
    </script>
@endsection
