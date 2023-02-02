@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.school.school_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.school.school_header')


                <div class="tab-content assignment-tab-content school-calandar">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="teacher-calendar-sidebar-section school-calendar-sidebar-section">
                                <div class="form-check sidebar-mode-check">
                                    <label for="editMode"><i class="fa-regular fa-pen-to-square"></i></label>
                                    <input type="radio" id="editMode" name="calendar_mode" value="edit" checked>
                                </div>
                                <div class="form-check sidebar-mode-check">
                                    <label for="viewMode"><i class="fa-regular fa-calendar-days"></i></label>
                                    <input type="radio" id="viewMode" name="calendar_mode" value="view">
                                </div>
                                <div class="form-check sidebar-mode-check">
                                    <label for="teacherMode"><i class="fa-solid fa-graduation-cap"></i></label>
                                    <input type="radio" id="teacherMode" name="calendar_mode" value="teacher">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-11">
                            <div class="teacher-calendar-slider">
                                <div class="teacher-calendar-table-section">
                                    <div class="total-days-slider-sec">
                                        <div class="total-days-text">
                                            <div class="assignment-date">
                                                <a
                                                    href="{{ URL::to('/school-calendar/' . $school_id . '?date=' . date('Y-m-d', strtotime($weekStartDate . ' -7 days'))) }}">
                                                    <i class="fa-solid fa-caret-left"></i>
                                                </a>
                                            </div>
                                            <div class="teacher-calendar-date-text">
                                                <span>{{ date('D d M Y', strtotime($weekStartDate)) }}</span>
                                            </div>
                                            <div class="assignment-date2">
                                                <a
                                                    href="{{ URL::to('/school-calendar/' . $school_id . '?date=' . date('Y-m-d', strtotime($weekStartDate . ' +7 days'))) }}">
                                                    <i class="fa-solid fa-caret-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="teacher-calendar-days-sec school-calendar-days-sec">
                                        <div class="teacher-calendar-total-days-text school-calendar-total-days-text"></div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Mon</p>
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Tue</p>
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Wed</p>
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Thu</p>
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Fri</p>
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Sat</p>
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Sun</p>
                                        </div>
                                    </div>

                                    @foreach ($calenderList as $key => $calender)
                                        <div class="calendar-section school-calendar-section">
                                            <div class="date-left-teacher-calendar date-left-school-calendar">
                                                <div class="teacher-calendar-days-field3" style="cursor: pointer;"
                                                    onclick="calDateClick('teacher', '{{ $calender->teacher_id }}', '')">
                                                    <p>
                                                        @if ($calender->knownAs_txt == null && $calender->knownAs_txt == '')
                                                            {{ $calender->firstName_txt . ' ' . $calender->surname_txt }}
                                                        @else
                                                            {{ $calender->firstName_txt . ' (' . $calender->knownAs_txt . ') ' . $calender->surname_txt }}
                                                        @endif
                                                    </p>
                                                    <p>{{ $calender->totalDays }} Days</p>
                                                </div>
                                            </div>
                                            <div class="date-left-teacher-calendar date-left-school-calendar">
                                                @if ($calender->day1Avail_txt && $calender->day1Link_id)
                                                    <div class="teacher-calendar-days-field" style="cursor: pointer;"
                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day1Link_id }}')">
                                                        <p>{{ $calender->day1Avail_txt }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="date-left-teacher-calendar date-left-school-calendar">
                                                @if ($calender->day2Avail_txt && $calender->day2Link_id)
                                                    <div class="teacher-calendar-days-field" style="cursor: pointer;"
                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day2Link_id }}')">
                                                        <p>{{ $calender->day2Avail_txt }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="date-left-teacher-calendar date-left-school-calendar">
                                                @if ($calender->day3Avail_txt && $calender->day3Link_id)
                                                    <div class="teacher-calendar-days-field" style="cursor: pointer;"
                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day3Link_id }}')">
                                                        <p>{{ $calender->day3Avail_txt }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="date-left-teacher-calendar date-left-school-calendar">
                                                @if ($calender->day4Avail_txt && $calender->day4Link_id)
                                                    <div class="teacher-calendar-days-field" style="cursor: pointer;"
                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day4Link_id }}')">
                                                        <p>{{ $calender->day4Avail_txt }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="date-left-teacher-calendar date-left-school-calendar">
                                                @if ($calender->day5Avail_txt && $calender->day5Link_id)
                                                    <div class="teacher-calendar-days-field" style="cursor: pointer;"
                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day5Link_id }}')">
                                                        <p>{{ $calender->day5Avail_txt }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="date-left-teacher-calendar date-left-school-calendar">
                                                @if ($calender->day6Avail_txt && $calender->day6Link_id)
                                                    <div class="teacher-calendar-days-field" style="cursor: pointer;"
                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day6Link_id }}')">
                                                        <p>{{ $calender->day6Avail_txt }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="date-left-teacher-calendar date-left-school-calendar">
                                                @if ($calender->day7Avail_txt && $calender->day7Link_id)
                                                    <div class="teacher-calendar-days-field" style="cursor: pointer;"
                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day7Link_id }}')">
                                                        <p>{{ $calender->day7Avail_txt }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Teacher Calendar Modal -->
    <div class="modal fade" id="TeacherCalendarModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section" style="max-width: 90%;">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Teacher Calendar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div id="AjaxTeacherCalendar"></div>

                <div class="modal-footer calendar-modal-footer">
                    <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Teacher Calendar Modal -->

    <!-- Teacher Calendar Event Edit Modal -->
    <div class="modal fade" id="TeacherCalEventEditModal" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section" style="max-width: 50%;">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Calendar Item</h4>
                    <button type="button" class="close" id="EventEditModalClose">&times;</button>
                </div>

                <div id="AjaxTeacherCalEvent"></div>

            </div>
        </div>
    </div>
    <!-- Teacher Calendar Event Edit Modal -->

    <script>
        function calDateClick(type, teacher_id, asn_id) {
            // alert('type->'+type+', teacher->'+teacher_id+', asn->'+asn_id)
            var calendar_mode = $('input[name="calendar_mode"]:checked').val();
            if (calendar_mode == 'edit') {
                if (type == 'teacher') {
                    swal("",
                        "You cannot open a school or assignment using this control. Either change the mode on the working list form or click on a specific day."
                    );
                }
                if (type == 'date' && asn_id) {
                    var rUrl = '<?php echo url('/assignment-details/'); ?>' + '/' + asn_id;
                    window.open(rUrl, '_blank');
                }
            }

            if (calendar_mode == 'view' && teacher_id) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('teacherCalendarList') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacher_id: teacher_id
                    },
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        $('#AjaxTeacherCalendar').html(data.html);
                        $('#TeacherCalendarModal').modal("show");
                    }
                });
            }

            if (calendar_mode == 'teacher') {
                // if (type == 'teacher') {
                //     var rUrl1 = '<?php echo url('/teacher-detail/'); ?>' + '/' + teacher_id;
                //     window.open(rUrl1, '_blank');
                // }
                var rUrl1 = '<?php echo url('/teacher-detail/'); ?>' + '/' + teacher_id;
                window.open(rUrl1, '_blank');
            }
        }

        $(document).on('click', '#EventEditModalClose', function() {
            $('#TeacherCalEventEditModal').modal("hide");
            $('body').addClass('modal-open');
        });

        $(document).on('change', '#part_int_id', function() {
            var part_int_id = $('#part_int_id').val();
            if (part_int_id == 4) {
                $("#start_tm_id").prop('disabled', false);
                $("#end_tm_id").prop('disabled', false);
            } else {
                $("#start_tm_id").val('');
                $("#end_tm_id").val('');
                $("#start_tm_id").prop('disabled', true);
                $("#end_tm_id").prop('disabled', true);
            }
        });

        $(document).on('click', '#TeacherCalEventSaveBtn', function() {
            var form = $("#TeacherCalEventEditForm");
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                dataType: "json",
                async: false,
                success: function(data) {
                    $('#full_calendar_events').fullCalendar('refetchEvents');
                    $('#full_calendar_events').fullCalendar('unselect');
                    $('#TeacherCalEventEditModal').modal("hide");
                    $('body').addClass('modal-open');
                }
            });
        });

        $(document).on('click', '#TeacherCalEventDeleteBtn', function() {
            var form = $("#TeacherCalEventEditForm");
            var SITEURL = "{{ url('/') }}";
            var actionUrl = SITEURL + "/teacherEventDelete";
            swal({
                    title: "",
                    text: "This will DELETE this calendar item. Please click YES if you are certain you wish to remove it.",
                    buttons: {
                        cancel: "No",
                        Yes: "Yes"
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "Yes":
                            $.ajax({
                                type: "POST",
                                url: actionUrl,
                                data: form.serialize(),
                                dataType: "json",
                                async: false,
                                success: function(data) {
                                    $('#full_calendar_events').fullCalendar('refetchEvents');
                                    $('#full_calendar_events').fullCalendar('unselect');
                                    $('#TeacherCalEventEditModal').modal("hide");
                                    $('body').addClass('modal-open');
                                }
                            });
                    }
                });
        });
    </script>
@endsection
