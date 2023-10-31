{{-- @extends('web.layout') --}}
@extends('web.school.school_layout')
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
                    @include('web.school.school_header')
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

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec pt-3">

                        <div class="tab-content assignment-tab-content school-calandar sec_box_edit">
                            <div class="row teacher-calendar-sec5">
                                <div class="col-lg-1 col-md-12 col-xl-1 col-sm-12 col-12">
                                    <div class="teacher-calendar-sidebar-section new_teacher-calendar-sidebar"
                                        style="width: 90%;">
                                        <div class="form-check sidebar-mode-check">
                                            <label for="editMode"><i class="fas fa-edit"></i></label>
                                            <input type="radio" id="editMode" name="calendar_mode" value="edit"
                                                checked>
                                        </div>
                                        <div class="form-check sidebar-mode-check">
                                            <label for="viewMode"><i class="fas fa-calendar-alt"></i></label>
                                            <input type="radio" id="viewMode" name="calendar_mode" value="view">
                                        </div>
                                        <div class="form-check sidebar-mode-check">
                                            <label for="teacherMode"><i class="fas fa-graduation-cap"></i></label>
                                            <input type="radio" id="teacherMode" name="calendar_mode" value="teacher">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12 col-sm-12 col-lg-11 col-xl-11">
                                    <div class="teacher-calendar-slider">
                                        <div class="teacher-calendar-table-section1">
                                            <div class="total-days-slider-sec1">
                                                <div class="total-days-text">
                                                    <div class="assignment-date">
                                                        <a
                                                            href="{{ URL::to('/school-calendar/' . $school_id . '?date=' . date('Y-m-d', strtotime($weekStartDate . ' -7 days'))) }}">
                                                            <i class="fas fa-caret-left"></i>
                                                        </a>
                                                    </div>
                                                    <div class="teacher-calendar-date-text">
                                                        <span>{{ date('D d M Y', strtotime($weekStartDate)) }}</span>
                                                    </div>
                                                    <div class="assignment-date2">
                                                        <a
                                                            href="{{ URL::to('/school-calendar/' . $school_id . '?date=' . date('Y-m-d', strtotime($weekStartDate . ' +7 days'))) }}">
                                                            <i class="fas fa-caret-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="new_teacher_calendar_outer1">
                                                <div class="new_teacher_wapper">
                                                    <div class="skd_dates_row grid_7 grid_8">
                                                        <div class="teacher-calendar-total-days-text skd_date">
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Mon</p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Tue</p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Wed</p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Thu</p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Fri</p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Sat</p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Sun</p>
                                                        </div>
                                                    </div>

                                                    @foreach ($calenderList as $key => $calender)
                                                        <div
                                                            class="calendar-section skd_image_calender_box new_teacher_calendar_outer2 new_teacher_calendar_outer3">
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                <div class="teacher-calendar-days-field3 teacher-calendar-days-field4"
                                                                    style="cursor: pointer;"
                                                                    onclick="calDateClick('teacher', '{{ $calender->teacher_id }}', '')">
                                                                    <div class="calendar_right_sec" style="width: 100%">
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
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day1Avail_txt && $calender->day1Link_id)
                                                                    <div class="teacher-calendar-days-field"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day1Link_id }}')">
                                                                        <p>{{ $calender->day1Avail_txt }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day2Avail_txt && $calender->day2Link_id)
                                                                    <div class="teacher-calendar-days-field"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day2Link_id }}')">
                                                                        <p>{{ $calender->day2Avail_txt }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day3Avail_txt && $calender->day3Link_id)
                                                                    <div class="teacher-calendar-days-field"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day3Link_id }}')">
                                                                        <p>{{ $calender->day3Avail_txt }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day4Avail_txt && $calender->day4Link_id)
                                                                    <div class="teacher-calendar-days-field"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day4Link_id }}')">
                                                                        <p>{{ $calender->day4Avail_txt }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day5Avail_txt && $calender->day5Link_id)
                                                                    <div class="teacher-calendar-days-field"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day5Link_id }}')">
                                                                        <p>{{ $calender->day5Avail_txt }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day6Avail_txt && $calender->day6Link_id)
                                                                    <div class="teacher-calendar-days-field"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day6Link_id }}')">
                                                                        <p>{{ $calender->day6Avail_txt }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day7Avail_txt && $calender->day7Link_id)
                                                                    <div class="teacher-calendar-days-field"
                                                                        style="cursor: pointer;"
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
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Teacher Calendar Modal -->
    <div class="modal fade" id="TeacherCalendarModal">
        <div class="modal-dialog modal-xl modal-dialog-centered calendar-modal-section tab_mob_full">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Teacher Calendar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="AjaxTeacherCalendar" class="skd_calender_new"></div>

                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Teacher Calendar Modal -->

    <!-- Teacher Calendar Event Edit Modal -->
    <div class="modal fade" id="TeacherCalEventEditModal" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Calendar Item</h4>
                    <button type="button" class="close" id="EventEditModalClose">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="AjaxTeacherCalEvent"></div>
                </div>

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
                //     var rUrl1 = '<?php echo url('/candidate-detail/'); ?>' + '/' + teacher_id;
                //     window.open(rUrl1, '_blank');
                // }
                var rUrl1 = '<?php echo url('/candidate-detail/'); ?>' + '/' + teacher_id;
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
