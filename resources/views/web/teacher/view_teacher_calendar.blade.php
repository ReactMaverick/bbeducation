<div class="row">
    <div class="col-md-12 col-xl-1 col-lg-1 col-12 col-sm-12">
        <div class="teacher-calendar-sidebar-section new_teacher-calendar-sidebar ">
            <div class="form-check sidebar-mode-check">
                <label for="viewMode1"><i class="fas fa-eye"></i></label>
                <input type="radio" id="viewMode1" name="calendar_mode1" value="view" checked>
            </div>
            <div class="form-check sidebar-mode-check">
                <label for="addMode1"><i class="fas fa-plus"></i></label>
                <input type="radio" id="addMode1" name="calendar_mode1" value="add">
            </div>
            <div class="form-check sidebar-mode-check">
                <label for="editMode1"><i class="fas fa-pen-nib"></i></label>
                <input type="radio" id="editMode1" name="calendar_mode1" value="edit">
            </div>
            <div class="form-check sidebar-mode-check">
                <label for="asnEditMode1"><i class="fas fa-edit"></i></label>
                <input type="radio" id="asnEditMode1" name="calendar_mode1" value="asnEdit">
            </div>
        </div>
    </div>

    <div class="col-md-12 col-12 col-lg-8 col-xl-8 col-sm-12">
        <div id='full_calendar_events'></div>
    </div>

    <div class="col-md-12 col-12 col-sm-12 col-xl-3 col-lg-3">
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

<!-- multiple asn Modal -->
<div class="modal fade" id="multipleTeacherAsnModal" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section" style="max-width: 50%;">
        <div class="modal-content calendar-modal-content">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Multiple Teacher Assignment Dates</h4>
                <button type="button" class="close" id="multipleTeacherAsnClose">&times;</button>
            </div>

            <div class="modal-body">
                <div class="col-md-10 mt-4">
                    <table class="table assignment-page-table add-school-teacher-page-table">
                        <thead>
                            <tr class="table-heading add-school-teacher-table">
                                <th>School</th>
                                <th>Day Part</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody class="table-body-sec" id="multipleTeacherAsnTable">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- multiple asn Modal -->

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
                    // element.css('background-color', '#37a6ff');
                    element.addClass('new-event-color-4');
                } else if (event.reason_int == 4) {
                    // element.css('background-color', '#304556');
                    element.addClass('new-event-color-3');
                } else if (event.reason_int == 5) {
                    // element.css('background-color', '#9ca1a5');
                    element.addClass('new-event-color-2');
                } else {
                    // element.css('background-color', '#ffa601');
                    element.addClass('new-event-color-1');
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
            longPressDelay: 1,
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
                    var eAsnList = [];
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
                                    if (data.calEventItem.reason_int == 6) {
                                        viewNote = data.calEventItem.tc_notes_txt;
                                    } else {
                                        if (data.calEventItem.calendarItem_id) {
                                            viewNote = data.calEventItem.tc_notes_txt;
                                        } else {
                                            viewNote = data.calEventItem.title;
                                        }
                                    }
                                    viewEventId = data.calEventItem.link_id;
                                    asnItem_id = data.calEventItem.asnItem_id;
                                    calendarItem_id = data.calEventItem.calendarItem_id;
                                    eAsnList = data.calEventItem.e_asn_list;
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
                        if ((eAsnList).length > 1) {
                            var tableHtml = '';
                            $.each(eAsnList, function(index, value) {
                                var tUrl = "{{ url('/assignment-details') }}" + "/" + value
                                    .asn_id;
                                tableHtml +=
                                    '<tr class="table-data clickable-row" data-url=' +
                                    tUrl +
                                    '> <td>' + value
                                    .name_txt + '</td> <td>' + value.title + '</td> <td>' +
                                    value.yearGroup + '</td> </tr>';
                            });
                            $('#multipleTeacherAsnTable').html(tableHtml);
                            $('#multipleTeacherAsnModal').modal("show");
                        } else {
                            if (viewEventId) {
                                var rUrl2 = '<?php echo url('/assignment-details/'); ?>' + '/' + viewEventId;
                                window.open(rUrl2, '_blank');
                            } else if (defAsnId) {
                                var rUrl2 = '<?php echo url('/assignment-details/'); ?>' + '/' + defAsnId;
                                window.open(rUrl2, '_blank');
                            }
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
                    if (event.reason_int == 6) {
                        viewNote = event.tc_notes_txt;
                    } else {
                        if (event.calendarItem_id) {
                            viewNote = event.tc_notes_txt;
                        } else {
                            viewNote = event.title;
                        }
                    }
                    if (viewNote) {
                        $('#calNotes').html(viewNote.split(':')[1] ? viewNote.split(':')[1] :
                            viewNote);
                    } else {
                        $('#calNotes').html(viewNote);
                    }
                }

                if (calendar_mode1 == 'asnEdit') {
                    if ((event.e_asn_list).length > 1) {
                        var tableHtml = '';
                        $.each(event.e_asn_list, function(index, value) {
                            var tUrl = "{{ url('/assignment-details') }}" + "/" + value
                                .asn_id;
                            tableHtml +=
                                '<tr class="table-data clickable-row" data-url=' + tUrl +
                                '> <td>' + value
                                .name_txt + '</td> <td>' + value.title + '</td> <td>' +
                                value.yearGroup + '</td> </tr>';
                        });
                        $('#multipleTeacherAsnTable').html(tableHtml);
                        $('#multipleTeacherAsnModal').modal("show");
                    } else {
                        if (event.link_id) {
                            var rUrl3 = '<?php echo url('/assignment-details/'); ?>' + '/' + event.link_id;
                            window.open(rUrl3, '_blank');
                        } else if (defAsnId) {
                            var rUrl3 = '<?php echo url('/assignment-details/'); ?>' + '/' + defAsnId;
                            window.open(rUrl3, '_blank');
                        }
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

    $(document).on('click', '#multipleTeacherAsnClose', function() {
        $('#multipleTeacherAsnModal').modal("hide");
        $('body').addClass('modal-open');
    });

    $(document).ready(function() {
        $('#multipleTeacherAsnTable').on('click', '.clickable-row', function() {
            var url = $(this).data('url');
            window.open(url, '_blank');
        });
    });
</script>
