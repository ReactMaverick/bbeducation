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
                    <div class="teacher-calendar-sec">
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
                        <form action="{{ url('/teacher/logTeacherTimesheetAdd') }}" method="post" id="teacherTimesheetForm"
                            style="width: 96%; margin: 0;">
                            @csrf
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
                                        <div class="calendar-section">
                                            <div class="date-left-teacher-calendar">
                                                <div class="teacher-calendar-days-field3">
                                                    <p>
                                                        {{ $calender->name_txt }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="date-left-teacher-calendar">
                                                @if ($calender->day1Avail_txt && $calender->day1Link_id && $calender->day1asnItem_id)
                                                    <div class="{{ $calender->day1LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                        style="cursor: pointer;"
                                                        onclick="calDateClick('edit', '{{ $calender->teacher_id }}', '{{ $calender->day1Link_id }}', '{{ $calender->day1asnItem_id }}', '{{ $calender->school_id }}', '{{ $calender->day1asnDate_dte }}', {{ $calender->submit_status1 }})">
                                                        <p>{{ $calender->day1Avail_txt }}</p>
                                                    </div>
                                                @else
                                                    <div class="teacher-calendar-days-field3"></div>
                                                @endif
                                                <input type="hidden" name="school_id[]"
                                                    value="{{ $calender->day1school_id }}">
                                                <input type="hidden" name="teacher_id[]"
                                                    value="{{ $calender->teacher_id }}">
                                                <input type="hidden" name="asnItem_id[]"
                                                    value="{{ $calender->day1asnItem_id }}">
                                                <input type="hidden" name="asnDate_dte[]"
                                                    value="{{ $calender->day1asnDate_dte }}">
                                                <input type="hidden" name="asn_id[]" value="{{ $calender->day1Link_id }}">
                                            </div>
                                            <div class="date-left-teacher-calendar">
                                                @if ($calender->day2Avail_txt && $calender->day2Link_id && $calender->day2asnItem_id)
                                                    <div class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                        style="cursor: pointer;"
                                                        onclick="calDateClick('edit', '{{ $calender->teacher_id }}', '{{ $calender->day2Link_id }}', '{{ $calender->day2asnItem_id }}', '{{ $calender->school_id }}', '{{ $calender->day2asnDate_dte }}', {{ $calender->submit_status2 }})">
                                                        <p>{{ $calender->day2Avail_txt }}</p>
                                                    </div>
                                                @else
                                                    <div class="teacher-calendar-days-field3"></div>
                                                @endif
                                                <input type="hidden" name="school_id[]"
                                                    value="{{ $calender->day2school_id }}">
                                                <input type="hidden" name="teacher_id[]"
                                                    value="{{ $calender->teacher_id }}">
                                                <input type="hidden" name="asnItem_id[]"
                                                    value="{{ $calender->day2asnItem_id }}">
                                                <input type="hidden" name="asnDate_dte[]"
                                                    value="{{ $calender->day2asnDate_dte }}">
                                                <input type="hidden" name="asn_id[]" value="{{ $calender->day2Link_id }}">
                                            </div>
                                            <div class="date-left-teacher-calendar">
                                                @if ($calender->day3Avail_txt && $calender->day3Link_id && $calender->day3asnItem_id)
                                                    <div class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                        style="cursor: pointer;"
                                                        onclick="calDateClick('edit', '{{ $calender->teacher_id }}', '{{ $calender->day3Link_id }}', '{{ $calender->day3asnItem_id }}', '{{ $calender->school_id }}', '{{ $calender->day3asnDate_dte }}', {{ $calender->submit_status3 }})">
                                                        <p>{{ $calender->day3Avail_txt }}</p>
                                                    </div>
                                                @else
                                                    <div class="teacher-calendar-days-field3"></div>
                                                @endif
                                                <input type="hidden" name="school_id[]"
                                                    value="{{ $calender->day3school_id }}">
                                                <input type="hidden" name="teacher_id[]"
                                                    value="{{ $calender->teacher_id }}">
                                                <input type="hidden" name="asnItem_id[]"
                                                    value="{{ $calender->day3asnItem_id }}">
                                                <input type="hidden" name="asnDate_dte[]"
                                                    value="{{ $calender->day3asnDate_dte }}">
                                                <input type="hidden" name="asn_id[]" value="{{ $calender->day3Link_id }}">
                                            </div>
                                            <div class="date-left-teacher-calendar">
                                                @if ($calender->day4Avail_txt && $calender->day4Link_id && $calender->day4asnItem_id)
                                                    <div class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                        style="cursor: pointer;"
                                                        onclick="calDateClick('edit', '{{ $calender->teacher_id }}', '{{ $calender->day4Link_id }}', '{{ $calender->day4asnItem_id }}', '{{ $calender->school_id }}', '{{ $calender->day4asnDate_dte }}', {{ $calender->submit_status4 }})">
                                                        <p>{{ $calender->day4Avail_txt }}</p>
                                                    </div>
                                                @else
                                                    <div class="teacher-calendar-days-field3"></div>
                                                @endif
                                                <input type="hidden" name="school_id[]"
                                                    value="{{ $calender->day4school_id }}">
                                                <input type="hidden" name="teacher_id[]"
                                                    value="{{ $calender->teacher_id }}">
                                                <input type="hidden" name="asnItem_id[]"
                                                    value="{{ $calender->day4asnItem_id }}">
                                                <input type="hidden" name="asnDate_dte[]"
                                                    value="{{ $calender->day4asnDate_dte }}">
                                                <input type="hidden" name="asn_id[]"
                                                    value="{{ $calender->day4Link_id }}">
                                            </div>
                                            <div class="date-left-teacher-calendar">
                                                @if ($calender->day5Avail_txt && $calender->day5Link_id && $calender->day5asnItem_id)
                                                    <div class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                        style="cursor: pointer;"
                                                        onclick="calDateClick('edit', '{{ $calender->teacher_id }}', '{{ $calender->day5Link_id }}', '{{ $calender->day5asnItem_id }}', '{{ $calender->school_id }}', '{{ $calender->day5asnDate_dte }}', {{ $calender->submit_status5 }})">
                                                        <p>{{ $calender->day5Avail_txt }}</p>
                                                    </div>
                                                @else
                                                    <div class="teacher-calendar-days-field3"></div>
                                                @endif
                                                <input type="hidden" name="school_id[]"
                                                    value="{{ $calender->day5school_id }}">
                                                <input type="hidden" name="teacher_id[]"
                                                    value="{{ $calender->teacher_id }}">
                                                <input type="hidden" name="asnItem_id[]"
                                                    value="{{ $calender->day5asnItem_id }}">
                                                <input type="hidden" name="asnDate_dte[]"
                                                    value="{{ $calender->day5asnDate_dte }}">
                                                <input type="hidden" name="asn_id[]"
                                                    value="{{ $calender->day5Link_id }}">
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            @if (count($calenderList) > 0)
                                @if ($submitExist)
                                    <button type="button" class="btn btn-secondary mt-4"
                                        style="float: right; background-color: #acd6f1">Timesheet Submitted</button>
                                @else
                                    <button type="submit" class="btn btn-secondary mt-4"
                                        style="float: right; background-color: #48A0DC">Submit
                                        Timesheet</button>
                                @endif
                            @endif

                        </form>

                    </div>
                </div>
                {{-- calendar --}}

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

                <form action="{{ url('/teacher/teacherTimesheetUpdate') }}" method="post" class="form-validate"
                    id="ajaxAssignmentEventForm">
                    @csrf

                    <div class="modal-input-field-section">
                        <div id="AjaxEventEdit"></div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn"
                            id="teacherTimesheetDelBtn">Delete</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Event Edit Modal -->

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function calDateClick(type, teacher_id, asn_id, asnItem_id, school_id, asnDate_dte, submit_status) {
            // alert(submit_status)
            if (submit_status && submit_status == 1) {
                swal("",
                    "You cannot edit day as timesheet already submitted."
                );
            } else {
                var SITEURL = "{{ url('/') }}";
                var form = $("#teacherTimesheetForm");
                $.ajax({
                    url: SITEURL + "/teacher/logTeacherTimesheetAddAjax",
                    data: form.serialize(),
                    type: "POST",
                    dataType: "json",
                    async: false,
                    success: function(data) {

                    }
                });

                $.ajax({
                    url: SITEURL + "/teacher/teacherTimesheetEdit",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacher_id: teacher_id,
                        asn_id: asn_id,
                        asnItem_id: asnItem_id,
                        school_id: school_id,
                        asnDate_dte: asnDate_dte
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
            }
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
                                        teacher_timesheet_id: eTeacherTimesheetId
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            }
        });
    </script>
@endsection
