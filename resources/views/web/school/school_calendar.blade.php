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
                                            <label class="teacher_svg" for="editMode">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                                    x="0" y="0" viewBox="0 0 401.523 401"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    class="">
                                                    <g>
                                                        <path
                                                            d="M370.59 250.973c-5.524 0-10 4.476-10 10v88.789c-.02 16.562-13.438 29.984-30 30H50c-16.563-.016-29.98-13.438-30-30V89.172c.02-16.559 13.438-29.98 30-30h88.79c5.523 0 10-4.477 10-10 0-5.52-4.477-10-10-10H50c-27.602.031-49.969 22.398-50 50v260.594c.031 27.601 22.398 49.968 50 50h280.59c27.601-.032 49.969-22.399 50-50v-88.793c0-5.524-4.477-10-10-10zm0 0"
                                                            fill="#3c0077ad" opacity="1" data-original="#3c0077ad"
                                                            class=""></path>
                                                        <path
                                                            d="M376.629 13.441c-17.574-17.574-46.067-17.574-63.64 0L134.581 191.848a9.997 9.997 0 0 0-2.566 4.402l-23.461 84.7a9.997 9.997 0 0 0 12.304 12.308l84.7-23.465a9.997 9.997 0 0 0 4.402-2.566l178.402-178.41c17.547-17.587 17.547-46.055 0-63.641zM156.37 198.348 302.383 52.332l47.09 47.09-146.016 146.016zm-9.406 18.875 37.62 37.625-52.038 14.418zM374.223 74.676 363.617 85.28l-47.094-47.094 10.61-10.605c9.762-9.762 25.59-9.762 35.351 0l11.739 11.734c9.746 9.774 9.746 25.59 0 35.36zm0 0"
                                                            fill="#3c0077ad" opacity="1" data-original="#3c0077ad"
                                                            class=""></path>
                                                    </g>
                                                </svg>
                                            </label>
                                            <input type="radio" id="editMode" name="calendar_mode" value="edit"
                                                checked>
                                        </div>
                                        <div class="form-check sidebar-mode-check">
                                            <label class="teacher_svg" for="viewMode">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                                    x="0" y="0" viewBox="0 0 512 512"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    class="">
                                                    <g>
                                                        <path
                                                            d="M452 40h-24V0h-40v40H124V0H84v40H60C26.916 40 0 66.916 0 100v352c0 33.084 26.916 60 60 60h392c33.084 0 60-26.916 60-60V100c0-33.084-26.916-60-60-60zm20 412c0 11.028-8.972 20-20 20H60c-11.028 0-20-8.972-20-20V188h432v264zm0-304H40v-48c0-11.028 8.972-20 20-20h24v40h40V80h264v40h40V80h24c11.028 0 20 8.972 20 20v48z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                        <path
                                                            d="M76 230h40v40H76zM156 230h40v40h-40zM236 230h40v40h-40zM316 230h40v40h-40zM396 230h40v40h-40zM76 310h40v40H76zM156 310h40v40h-40zM236 310h40v40h-40zM316 310h40v40h-40zM76 390h40v40H76zM156 390h40v40h-40zM236 390h40v40h-40zM316 390h40v40h-40zM396 310h40v40h-40z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                    </g>
                                                </svg>
                                            </label>
                                            <input type="radio" id="viewMode" name="calendar_mode" value="view">
                                        </div>
                                        <div class="form-check sidebar-mode-check">
                                            <label class="teacher_svg" for="teacherMode">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                                    x="0" y="0" viewBox="0 0 349.2 349.2"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    class="">
                                                    <g>
                                                        <path
                                                            d="m337.6 114.25-139.2-68c-12-6-32.4-6-44.4 0l-142.4 68c-10 4.8-11.6 11.6-11.6 15.2 0 3.6 1.6 10 11.6 15.2l11.6 5.6v64c-7.2 2.8-12.4 10-12.4 18s5.2 15.2 12 18l-18 57.2h50.4l-18-57.2c7.2-2.8 12-10 12-18 0-8.4-5.2-15.2-12.4-18v-57.2l21.2 10.4v83.2c0 1.2.4 2.4 1.2 3.6 2 2.4 39.2 53.2 115.2 53.2s113.2-51.2 114.8-53.2c.8-1.2 1.2-2.4 1.2-3.6v-82.8l47.2-23.2c10-4.8 11.6-11.6 11.6-15.2-.4-3.6-1.6-10.4-11.6-15.2zm-60 134.4c-6.4 8-40.8 46.4-103.2 46.4-62.4 0-96.8-38.4-103.2-46.4v-75.6l82.8 39.6c6 2.8 14 4.4 22 4.4 8.4 0 16.4-1.6 22.4-4.8l79.2-38.8v75.2zm54.4-115.2-48 23.6c-2 0-3.6.8-4.4 2.4l-86.8 42c-8.4 4.4-24.8 4.4-33.6 0l-106.8-51.2 122.8-14.4c3.6-.4 6-3.6 5.6-6.8-.4-3.6-3.6-6-6.8-5.6l-142.4 16.8-14.4-6.8c-3.6-1.6-4.4-3.6-4.4-3.6 0-.4.8-2 4.4-3.6l142.4-68.4c4.4-2 10.4-3.2 16.4-3.2 6.4 0 12.8 1.2 16.8 3.2l139.2 68c3.6 1.6 4.4 3.2 4.4 4 0 0-1.2 2-4.4 3.6z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                    </g>
                                                </svg>
                                            </label>
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
                                                            class="calendar-section skd_image_calender_box new_teacher_calendar_outer2 new_teacher_calendar_outer3 box_8 ">
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
