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

                <div class="row mt-2">
                    <div class="col-md-1">
                        <div class="teacher-calendar-sidebar-section school-calendar-sidebar-section">
                            <div class="form-check sidebar-mode-check">
                                <label for="viewMode1"><i class="fa-solid fa-eye"></i></label>
                                <input type="radio" id="viewMode1" name="calendar_mode1" value="view" checked>
                            </div>
                            <div class="form-check sidebar-mode-check">
                                <label for="addMode1"><i class="fa-solid fa-plus"></i></label>
                                <input type="radio" id="addMode1" name="calendar_mode1" value="add">
                            </div>
                            <div class="form-check sidebar-mode-check">
                                <label for="editMode1"><i class="fa-solid fa-pencil"></i></label>
                                <input type="radio" id="editMode1" name="calendar_mode1" value="edit">
                            </div>
                            <div class="form-check sidebar-mode-check">
                                <label for="asnEditMode1"><i class="fa-regular fa-pen-to-square"></i></label>
                                <input type="radio" id="asnEditMode1" name="calendar_mode1" value="asnEdit">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div id='full_calendar_events'></div>
                    </div>

                    <div class="col-md-3">
                        <div>
                            <label>Calendar Item For</label>
                            <p id="calItemFor"></p>
                        </div>
                        <div>
                            <label>Type</label>
                            <p id="calType"></p>
                        </div>
                        <div>
                            <label>Notes</label>
                            <p id="calNotes"></p>
                        </div>
                        <div>
                            <label>Quick Set</label>
                            <select class="form-control" name="" id="calQuickSet">
                                <option value="">Default - (Cycle)</option>
                                @foreach ($quickList as $key1 => $quick)
                                    <option value="{{ $quick->description_int }}">
                                        {{ $quick->description_txt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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
        $(document).ready(function() {
            var SITEURL = "{{ url('/') }}";
            var teacher_id = "{{ $teacher_id }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var defAsnId = '';
            var calendar = $('#full_calendar_events').fullCalendar({
                editable: false,
                firstDay: 1,
                header: {
                    left: 'prev',
                    center: 'today, title',
                    right: 'next'
                },
                // weekends: [ 0, 6 ],
                fixedWeekCount: false,
                showNonCurrentDates: false,
                fullDay: false,
                events: SITEURL + "/calendarListByTeacher/" + teacher_id,
                displayEventTime: false,
                // eventColor: '#cdb71e',
                eventTextColor: '#fff',
                eventBackgroundColor: '#ffa601',
                eventRender: function(event, element, view) {
                    if (event.reason_int == 2 || event.reason_int == 3) {
                        element.css('background-color', '#37a6ff');
                    } else if (event.reason_int == 4) {
                        element.css('background-color', '#304556');
                    } else if (event.reason_int == 5) {
                        element.css('background-color', '#9ca1a5');
                    } else {
                        element.css('background-color', '#ffa601');
                    }
                    if (event.link_id) {
                        defAsnId = event.link_id;
                    }
                    event.editable = true;
                    element.find('span.fc-title').addClass('customClass');
                },
                selectable: true,
                selectHelper: true,
                dragScroll: false,
                unselectAuto: false,
                droppable: false,
                allDayDefault: false,
                select: function(event_start, event_end, allDay) {
                    if ((event_end._d.getDate() - 1) != event_start._d.getDate()) {
                        calendar.fullCalendar('unselect');
                    } else {
                        var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD");
                        var viewDate = '';
                        var viewNote = '';
                        var viewEventId = '';
                        var asnItem_id = '';
                        var calendarItem_id = '';
                        $.ajax({
                            url: SITEURL + "/teacherEventExist",
                            data: {
                                teacher_id: teacher_id,
                                event_start: event_start
                            },
                            type: "POST",
                            dataType: "json",
                            async: false,
                            success: function(data) {
                                // console.log(data);
                                if (data) {
                                    viewDate = data.date;
                                    if (data.status == true) {
                                        if (data.calEventItem.calendarItem_id) {
                                            viewNote = data.calEventItem.tc_notes_txt;
                                        } else {
                                            viewNote = data.calEventItem.title;
                                        }
                                        viewEventId = data.calEventItem.link_id;
                                        asnItem_id = data.calEventItem.asnItem_id;
                                        calendarItem_id = data.calEventItem.calendarItem_id;
                                    }
                                }
                            }
                        });

                        var calendar_mode1 = $('input[name="calendar_mode1"]:checked').val();
                        if (calendar_mode1 == 'view') {
                            $('#calItemFor').html('');
                            $('#calNotes').html('');
                            $('#calItemFor').html(viewDate);
                            if (viewNote) {
                                $('#calNotes').html(viewNote.split(':')[1] ? viewNote.split(':')[1] :
                                    viewNote);
                            } else {
                                $('#calNotes').html(viewNote);
                            }
                        }

                        if (calendar_mode1 == 'add') {
                            var calQuickSet = $('#calQuickSet').val();
                            $.ajax({
                                url: SITEURL + "/teacherCalEventAdd",
                                data: {
                                    teacher_id: teacher_id,
                                    event_start: event_start,
                                    asnItem_id: asnItem_id,
                                    calendarItem_id: calendarItem_id,
                                    calQuickSet: calQuickSet
                                },
                                type: "POST",
                                dataType: "json",
                                async: false,
                                success: function(data) {
                                    calendar.fullCalendar('refetchEvents');
                                    calendar.fullCalendar('unselect');
                                }
                            });
                        }

                        if (calendar_mode1 == 'asnEdit') {
                            if (viewEventId) {
                                var rUrl2 = '<?php echo url('/assignment-details/'); ?>' + '/' + viewEventId;
                                window.open(rUrl2, '_blank');
                            } else if (defAsnId) {
                                var rUrl2 = '<?php echo url('/assignment-details/'); ?>' + '/' + defAsnId;
                                window.open(rUrl2, '_blank');
                            }
                        }

                        if (calendar_mode1 == 'edit' && calendarItem_id) {
                            $.ajax({
                                url: SITEURL + "/teacherEventEdit",
                                data: {
                                    calendarItem_id: calendarItem_id
                                },
                                type: "POST",
                                dataType: "json",
                                async: false,
                                success: function(data) {
                                    if (data) {
                                        $('#AjaxTeacherCalEvent').html(data.html);
                                        $('#TeacherCalEventEditModal').modal("show");
                                    }
                                }
                            });
                        }
                    }
                },
                eventClick: function(event) {
                    // var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD");
                    // console.log(event);
                    var calendar_mode1 = $('input[name="calendar_mode1"]:checked').val();
                    if (calendar_mode1 == 'view') {
                        var eDate = event.start.format();
                        $('#calItemFor').html('');
                        $('#calNotes').html('');
                        $('#calItemFor').html(moment(eDate).format("ddd DD MMM YYYY"));
                        var viewNote = '';
                        if (event.calendarItem_id) {
                            viewNote = event.tc_notes_txt;
                        } else {
                            viewNote = event.title;
                        }
                        if (viewNote) {
                            $('#calNotes').html(viewNote.split(':')[1] ? viewNote.split(':')[1] :
                                viewNote);
                        } else {
                            $('#calNotes').html(viewNote);
                        }
                    }

                    if (calendar_mode1 == 'asnEdit') {
                        if (event.link_id) {
                            var rUrl3 = '<?php echo url('/assignment-details/'); ?>' + '/' + event.link_id;
                            window.open(rUrl3, '_blank');
                        } else if (defAsnId) {
                            var rUrl3 = '<?php echo url('/assignment-details/'); ?>' + '/' + defAsnId;
                            window.open(rUrl3, '_blank');
                        }
                    }

                    if (calendar_mode1 == 'add') {
                        var calQuickSet = $('#calQuickSet').val();
                        var eDate = event.start.format();
                        $.ajax({
                            url: SITEURL + "/teacherCalEventAdd",
                            data: {
                                teacher_id: teacher_id,
                                event_start: eDate,
                                asnItem_id: event.asnItem_id,
                                calendarItem_id: event.calendarItem_id,
                                calQuickSet: calQuickSet
                            },
                            type: "POST",
                            dataType: "json",
                            async: false,
                            success: function(data) {
                                calendar.fullCalendar('refetchEvents');
                                calendar.fullCalendar('unselect');
                            }
                        });
                    }

                    if (calendar_mode1 == 'edit' && event.calendarItem_id) {
                        $.ajax({
                            url: SITEURL + "/teacherEventEdit",
                            data: {
                                calendarItem_id: event.calendarItem_id
                            },
                            type: "POST",
                            dataType: "json",
                            async: false,
                            success: function(data) {
                                if (data) {
                                    $('#AjaxTeacherCalEvent').html(data.html);
                                    $('#TeacherCalEventEditModal').modal("show");
                                }
                            }
                        });
                    }
                }
            });
        });

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
