<div class="row">
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

<script>
    $(document).ready(function() {
        var SITEURL = "{{ url('/') }}";
        var teacher_id = "{{ $teacher_id }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
                // if (event.allDay === 'true') {
                //     event.allDay = true;
                // } else {
                //     event.allDay = false;
                // }
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
                            if (data) {
                                viewDate = data.date;
                                if (data.status == true) {
                                    viewNote = data.calEventItem.title;
                                    viewEventId = data.calEventItem.link_id;
                                }
                            }
                        }
                    });

                    var calendar_mode1 = $('input[name="calendar_mode1"]:checked').val();
                    if (calendar_mode1 == 'view') {
                        $('#calItemFor').html('');
                        $('#calNotes').html('');
                        $('#calItemFor').html(viewDate);
                        $('#calNotes').html(viewNote.split(':')[1]?viewNote.split(':')[1]:viewNote);
                    }

                    if (calendar_mode1 == 'asnEdit' && viewEventId) {
                        var rUrl2 = '<?php echo url('/assignment-details/'); ?>' + '/' + viewEventId;
                        window.open(rUrl2, '_blank');
                    }

                    // if (calendar_mode1 == 'edit') {
                    //     $.ajax({
                    //         url: SITEURL + "/checkAssignmentEvent/" + asn_id,
                    //         data: {
                    //             event_start: event_start
                    //         },
                    //         type: "POST",
                    //         dataType: "json",
                    //         success: function(data) {
                    //             if (data) {
                    //                 if (data.exist == 'No') {
                    //                     swal("",
                    //                         "You cannot use the edit day mode on an empty date in the calendar."
                    //                     );
                    //                 } else {
                    //                     $('#editEventId').val(data.eventId)
                    //                     $('#AjaxEventEdit').html(data.html);
                    //                     $('#eventEditModal').modal("show");
                    //                 }
                    //             }
                    //             calendar.fullCalendar('unselect');
                    //         }
                    //     });
                    // }
                }
            },
            eventClick: function(event) {
                // var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD");
                console.log(event);
                var calendar_mode1 = $('input[name="calendar_mode1"]:checked').val();
                if (calendar_mode1 == 'view') {
                    var eDate = event.start.format();
                    $('#calItemFor').html('');
                    $('#calNotes').html('');
                    $('#calItemFor').html(moment(eDate).format("ddd DD MMM YYYY"));
                    $('#calNotes').html(event.title.split(':')[1]?event.title.split(':')[1]:event.title);
                }

                if (calendar_mode1 == 'asnEdit' && event.link_id) {
                    var rUrl3 = '<?php echo url('/assignment-details/'); ?>' + '/' + event.link_id;
                    window.open(rUrl3, '_blank');
                }
                // if (calendar_mode1 == 'add') {
                //     $.ajax({
                //         type: "POST",
                //         url: SITEURL + "/updateAssignmentEvent/" + asn_id,
                //         data: {
                //             id: event.id
                //         },
                //         dataType: "json",
                //         success: function(data) {
                //             if (data) {
                //                 if (data.type == 'Delete') {
                //                     calendar.fullCalendar('removeEvents', data
                //                         .eventId);
                //                 } else if (data.type == 'Update') {
                //                     calendar.fullCalendar('removeEvents', data
                //                         .eventItem.id);
                //                     calendar.fullCalendar('renderEvent', {
                //                         id: data.eventItem.id,
                //                         title: data.eventItem.title,
                //                         start: data.eventItem.start,
                //                         editable: false
                //                     }, true);
                //                 }
                //             }
                //         }
                //     });
                // }

                // if (calendar_mode1 == 'edit') {
                //     $.ajax({
                //         url: SITEURL + "/checkAssignmentEvent2/" + asn_id,
                //         data: {
                //             id: event.id
                //         },
                //         type: "POST",
                //         dataType: "json",
                //         success: function(data) {
                //             if (data) {
                //                 if (data.exist == 'No') {
                //                     swal("",
                //                         "You cannot use the edit day mode on an empty date in the calendar."
                //                     );
                //                 } else {
                //                     $('#editEventId').val(data.eventId)
                //                     $('#AjaxEventEdit').html(data.html);
                //                     $('#eventEditModal').modal("show");
                //                 }
                //             }
                //             calendar.fullCalendar('unselect');
                //         }
                //     });
                // }
            }
        });
    });
</script>
