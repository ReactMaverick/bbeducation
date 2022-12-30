@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.assignment.assignment_sidebar')

            <div class="col-md-10 topbar-sec">
                <form action="">
                    <div class="topbar-Section">
                        <i class="fa-solid fa-crown"></i>
                        <a href="#"> <i class="fa-solid fa-trash trash-icon"></i></a>
                    </div>

                    <div class="assignment-detail-right-sec">
                        <div class="filter-section">
                            <div class="filter-group-sec">
                                <div class="form-group assignment-detail-form-group">
                                    <label for="">Age Range</label>
                                    <select id="" class="form-control select2" name="ageRange_int"
                                        style="width:100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($ageRangeList as $key => $ageRange)
                                            <option value="{{ $ageRange->description_int }}"
                                                {{ $assignmentDetail->ageRange_int == $ageRange->description_int ? 'selected' : '' }}>
                                                {{ $ageRange->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group assignment-detail-form-group">
                                    <label for="">Subject</label>
                                    <select id="" class="form-control select2" name="subject_int"
                                        style="width:100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($subjectList as $key => $subject)
                                            <option value="{{ $subject->description_int }}"
                                                {{ $assignmentDetail->subject_int == $subject->description_int ? 'selected' : '' }}>
                                                {{ $subject->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group assignment-detail-form-group">
                                    <label for="">Year Group</label>
                                    <select id="" class="form-control select2" name="yearGroup_int"
                                        style="width:100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($yearGrList as $key => $yearGr)
                                            <option value="{{ $yearGr->description_int }}"
                                                {{ $assignmentDetail->yearGroup_int == $yearGr->description_int ? 'selected' : '' }}>
                                                {{ $yearGr->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group assignment-detail-form-group">
                                    <label for="">Assignment Length</label>
                                    <select id="" class="form-control select2" name="asnLength_int"
                                        style="width:100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($assLengthList as $key => $assLength)
                                            <option value="{{ $assLength->description_int }}"
                                                {{ $assignmentDetail->asnLength_int == $assLength->description_int ? 'selected' : '' }}>
                                                {{ $assLength->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group assignment-detail-form-group">
                                    <label for="">Professional Type</label>
                                    <select id="" class="form-control select2" name="professionalType_int"
                                        style="width:100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($profTypeList as $key => $profType)
                                            <option value="{{ $profType->description_int }}"
                                                {{ $assignmentDetail->professionalType_int == $profType->description_int ? 'selected' : '' }}>
                                                {{ $profType->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group assignment-detail-form-group">
                                    <label for="">Student</label>
                                    <select id="" class="form-control select2" name="student_id"
                                        style="width:100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($studentList as $key => $student)
                                            <option value="{{ $student->student_id }}"
                                                {{ $assignmentDetail->student_id == $student->student_id ? 'selected' : '' }}>
                                                {{ $student->firstName_txt . ' ' . $student->surname_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row filter-input-sec">
                                <div class="form-group filter-input-sec-group col-md-6">
                                    <label for="">Daily Charge</label>
                                    <input type="text" class="form-control assignment-detail-form-control" id=""
                                        placeholder="&#163 130" value="{{ $assignmentDetail->charge_dec }}">
                                </div>

                                <div class="form-group filter-input-sec-group2 col-md-6">
                                    <label for="">Daily Pay</label>
                                    <input type="text" class="form-control assignment-detail-form-control" id=""
                                        placeholder="&#163 80.00" value="{{ $assignmentDetail->cost_dec }}">
                                </div>
                            </div>
                        </div>

                        <div class="assignment-time-table-section">
                            <div class="total-days-section">
                                <div class="days-slider-sec">
                                    <i class="fa-regular fa-calendar-days"></i>
                                </div>

                                <div class="date-section">
                                    <div class="total-days-slider-sec">
                                        <div class="total-days-text">
                                            <div class="assignment-date">
                                                <span>1.41</span>
                                            </div>
                                            <div class="assignment-date-text">
                                                <span>Total Days: 2.41</span>
                                            </div>
                                            <div class="assignment-date2">
                                                <span>1</span>
                                            </div>
                                        </div>
                                        {{-- <div class="total-days-text">
                                            <div class="assignment-date">
                                                <i class="fa-solid fa-caret-left"></i>
                                            </div>
                                            <div class="assignment-date-text">
                                                <span>10 October 2022</span>
                                            </div>
                                            <div class="assignment-date2">
                                                <i class="fa-solid fa-caret-right"></i>
                                            </div>
                                        </div> --}}
                                    </div>

                                    <div id='full_calendar_events'></div>

                                    <div class="row status-section">
                                        <div class="form-group col-md-6 second-filter-sec">
                                            <label for="">Status</label>
                                            <select id="" class="form-control select2" name="status_int"
                                                style="width:100%;">
                                                <option value="">Choose one</option>
                                                @foreach ($assignmentStatusList as $key => $assignmentStatus)
                                                    <option value="{{ $assignmentStatus->description_int }}"
                                                        {{ $assignmentDetail->status_int == $assignmentStatus->description_int ? 'selected' : '' }}>
                                                        {{ $assignmentStatus->description_txt }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 second-filter-sec">
                                            <label for="">First Date</label>
                                            <input type="date" class="form-control" id="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mode-section">
                            <div class="mode-text-sec">
                                <p>Mode</p>
                                <div class="form-check mode-check">
                                    <label for="html"><a href="#"><i class="fa-solid fa-plus"></i></a></label>
                                    <input type="radio" id="html" name="fav_language" value="HTML">
                                </div>
                                <div class="form-check mode-check">
                                    <label for="html"><a href="#"><i
                                                class="fa-solid fa-pencil"></i></a></label>
                                    <input type="radio" id="html" name="fav_language" value="HTML">
                                </div>
                                <div class="form-check mode-check">
                                    <label for="html"><a href="#"><i
                                                class="fa-solid fa-right-long next-arrow-icon"></i></a></label>
                                    <input type="radio" id="html" name="fav_language" value="HTML">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row assignment-notes-sec">
                        <div class="form-group col-md-6 label-heading">
                            <label for="comment">Last Contact re. Assignment</label>
                            <textarea class="form-control" rows="5" id="comment"></textarea>
                        </div>
                        <div class="form-group col-md-6 label-heading">
                            <label for="comment">Assignment Notes</label>
                            <textarea class="form-control" rows="5" id="comment"></textarea>
                        </div>
                    </div>

                    <div class="button-section">
                        <button class="button-1">Candidate Vetting</button>
                        <!-- <button class="button-2">Block Booking -->

                        <button type="button" class="btn btn-primary button-2" data-toggle="modal"
                            data-target="#myModal">
                            Block Booking
                        </button>

                        <button type="button" class="btn btn-primary button-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
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

                <div class="modal-input-field-section">
                    <div class="modal-input-field">
                        <label class="form-check-label">Date</label>
                        <input type="date" class="form-control" name="booked_day" id="booked_day" value="">
                    </div>

                    <div class="form-group calendar-form-filter">
                        <label for="inputState">Part of Day</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>

                    <div class="modal-input-field">
                        <label class="form-check-label">Percentage of a day</label>
                        <input type="number" class="form-control" name="booked_day" id="booked_day" value="">
                    </div>

                    <div class="modal-input-field">
                        <label class="form-check-label">Hours</label>
                        <input type="time" class="form-control" name="booked_day" id="booked_day" value="">
                    </div>

                    <div class="modal-side-field">
                        <label class="form-check-label">Charge</label>
                        <input type="text" class="form-control" name="booked_day" id="booked_day" value="">
                    </div>
                    <div class="modal-side-field second">
                        <label class="form-check-label">Pay</label>
                        <input type="text" class="form-control" name="booked_day" id="booked_day" value="">
                    </div>
                </div>


                <!-- Modal body
                                                    <div class="modal-body">
                                                        Modal body..
                                                    </div> -->

                <!-- Modal footer -->
                <div class="modal-footer calendar-modal-footer">
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Submit</button>
                </div>

            </div>
        </div>
    </div>
    <!-- </button> -->

    <script>
        $(document).ready(function() {
            var SITEURL = "{{ url('/') }}";
            var asn_id = "{{ $asn_id }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#full_calendar_events').fullCalendar({
                editable: true,
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
                events: SITEURL + "/assignment-details/" + asn_id,
                displayEventTime: true,
                // eventColor: '#cdb71e',
                eventTextColor: '#cdb71e',
                eventBackgroundColor: '#db5e5e',
                eventRender: function(event, element, view) {
                    // if (event.allDay === 'true') {
                    //     event.allDay = true;
                    // } else {
                    //     event.allDay = false;
                    // }
                    element.find('span.fc-title').addClass('customClass');
                },
                selectable: true,
                selectHelper: true,
                dragScroll: false,
                unselectAuto: false,
                select: function(event_start, event_end, allDay) {
                    // console.log('event_start ==>', event_start)
                    // console.log('event_end ==>', event_end)

                    // console.log('event_start date ==>', event_start._d.getDate())
                    // console.log('event_end date ==>', event_end._d.getDate() - 1)
                    if ((event_end._d.getDate() - 1) != event_start._d.getDate()) {
                        calendar.fullCalendar('unselect');
                    } else {
                        var event_name = prompt('Event Name:');
                        if (event_name) {
                            var event_start = $.fullCalendar.formatDate(event_start,
                                "Y-MM-DD HH:mm:ss");
                            var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                            $.ajax({
                                url: SITEURL + "/calendar-crud-ajax",
                                data: {
                                    event_name: event_name,
                                    event_start: event_start,
                                    event_end: event_end,
                                    type: 'create'
                                },
                                type: "POST",
                                success: function(data) {
                                    displayMessage("Event created.");
                                    calendar.fullCalendar('renderEvent', {
                                        id: data.id,
                                        title: event_name,
                                        start: event_start,
                                        end: event_end,
                                        allDay: allDay
                                    }, true);
                                    calendar.fullCalendar('unselect');
                                }
                            });
                        }
                    }
                },
                eventDrop: function(event, delta) {
                    var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                    var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                    $.ajax({
                        url: SITEURL + '/calendar-crud-ajax',
                        data: {
                            title: event.event_name,
                            start: event_start,
                            end: event_end,
                            id: event.id,
                            type: 'edit'
                        },
                        type: "POST",
                        success: function(response) {
                            displayMessage("Event updated");
                        }
                    });
                },
                eventClick: function(event) {
                    var eventDelete = confirm("Are you sure?");
                    if (eventDelete) {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/calendar-crud-ajax',
                            data: {
                                id: event.id,
                                type: 'delete'
                            },
                            success: function(response) {
                                calendar.fullCalendar('removeEvents', event.id);
                                displayMessage("Event removed");
                            }
                        });
                    }
                }
            });
        });

        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    </script>
@endsection
