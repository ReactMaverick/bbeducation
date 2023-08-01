@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.assignment.assignment_sidebar')

            <div class="col-md-10 topbar-sec">
                @include('web.assignment.assignment_header')

                <form action="{{ url('/assignmentDetailUpdate') }}" method="post">
                    @csrf

                    <input type="hidden" name="assignmentId" id="" value="{{ $asn_id }}">

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
                                        style="width:100%;"
                                        onchange="changeProfType('{{ $assignmentDetail->school_id }}', this.value)">
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
                                    <input type="text" class="form-control assignment-detail-form-control"
                                        id="asnDailyCharge" name="charge_dec" placeholder=""
                                        value="{{ $assignmentDetail->charge_dec ? $assignmentDetail->charge_dec : '' }}">
                                </div>

                                <div class="form-group filter-input-sec-group2 col-md-6">
                                    <label for="">Daily Pay</label>
                                    <input type="text" class="form-control assignment-detail-form-control" id=""
                                        name="cost_dec" placeholder="" value="{{ $assignmentDetail->cost_dec }}">
                                </div>
                            </div>
                        </div>

                        <div class="assignment-time-table-section">
                            <div class="total-days-section">
                                <div class="days-slider-sec">
                                    <a style="cursor: pointer" id=""
                                        onclick="goFirstAsnDate('<?php echo $assignmentDetail->asnStartDate_dte; ?>')" title="">
                                        <i class="fa-regular fa-calendar-days"></i>
                                    </a>
                                </div>

                                <div class="date-section">
                                    <div class="total-days-slider-sec">
                                        <div class="total-days-text">
                                            <div class="assignment-date">
                                                <span id="prevDaySpan">
                                                    @if ($prevDays && $prevDays->previousDays > 0)
                                                        {{ $prevDays->previousDays }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="assignment-date-text">
                                                <span>Total Days: {{ $assignmentDetail->daysThisWeek }}</span>
                                            </div>
                                            <div class="assignment-date2">
                                                <span id="nextDaySpan">
                                                    @if ($nextDays && $nextDays->nDays > 0)
                                                        {{ $nextDays->nDays }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
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
                                            <input type="text" class="form-control" id=""
                                                name="firstDate_dte"
                                                value="{{ $assignmentDetail->firstDate_dte ? $assignmentDetail->firstDate_dte : '' }}"
                                                readonly>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mode-section">
                            <div class="mode-text-sec mode_text_outer">
                                <p>Mode</p>
                                <div class="form-check mode-check mode_check_inner">
                                    <label for="addMode" class="add_days_btn check_btn_active">
                                        Add Days
                                        <!-- <i class="fa-solid fa-plus"></i> -->
                                    </label>
                                    <input type="radio" id="addMode" name="assignment_mode" value="add" checked>
                                </div>
                                <div class="form-check mode-check mode_check_inner">
                                    <label for="editMode" class="edit_days_btn">
                                        Edit Days
                                        <!-- <i class="fa-solid fa-pencil"></i> -->
                                    </label>
                                    <input type="radio" id="editMode" name="assignment_mode" value="edit">
                                </div>
                                <div class="form-check mode-check mode_check_inner">
                                    <label for="enterMode" id="unblockLabel" class="unblock_days_btn">
                                        Unblock Booking
                                        <!-- <i class="fa-solid fa-right-long next-arrow-icon"></i> -->
                                    </label>
                                    <input type="radio" id="enterMode" name="assignment_mode" value="unblock">
                                </div>

                                <div class="button-section btn_sec_outer">

                                    <button type="button" class="btn btn-primary button-2 block_days_btn"
                                        id="blockBookingBtnId">
                                        Block Booking
                                    </button>

                                    <button type="button"
                                        class="button-1 candidate_vetting_days_btn {{ $assignmentDetail->teacher_id ? '' : 'disableCandVetting' }}"
                                        {{ $assignmentDetail->teacher_id ? '' : 'disabled' }}
                                        onclick="candidateVetting({{ $asn_id }}, '{{ $assignmentDetail->teacher_id }}', '{{ $assignmentDetail->techerFirstname . ' ' . $assignmentDetail->techerSurname }}')">Candidate
                                        Vetting</button>

                                    <button type="submit" class="btn btn-primary button-3 check_save_btn">
                                        Save
                                        <img src="{{ asset('web/images/checkmark.png') }}" alt=""
                                            class="checkmark_img" />
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="row assignment-notes-sec">
                        {{-- <div class="form-group col-md-6 label-heading">
                            <label for="">Last Contact re. Assignment</label>
                            <textarea class="form-control" rows="5" id="" name=""></textarea>
                        </div> --}}
                        <div class="form-group col-md-6 label-heading">
                            <label for="">Assignment Notes</label>
                            <textarea class="form-control" rows="5" id="" name="notes_txt">{{ $assignmentDetail->notes_txt }}</textarea>
                        </div>
                    </div>

                    {{-- <div class="button-section">
                        <button type="button"
                            class="button-1 {{ $assignmentDetail->teacher_id ? '' : 'disableCandVetting' }}"
                            {{ $assignmentDetail->teacher_id ? '' : 'disabled' }}
                            onclick="candidateVetting({{ $asn_id }}, '{{ $assignmentDetail->teacher_id }}', '{{ $assignmentDetail->techerFirstname . ' ' . $assignmentDetail->techerSurname }}')">Candidate
                            Vetting</button>

                        <button type="button" class="btn btn-primary button-2" id="blockBookingBtnId">
                            Block Booking
                        </button>

                        <button type="submit" class="btn btn-primary button-3">Save</button>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>

    <!-- Block Booking Modal -->
    <div class="modal fade" id="blockBookingModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Block Date Booking</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Create a block of dates for an assignment</h2>
                </div>

                <form action="{{ url('/addBlockBooking') }}" method="post" class="form-validate-2"
                    id="addBlockBookingForm">
                    @csrf
                    <input type="hidden" name="assignmentId" id="" value="{{ $asn_id }}">

                    <div class="modal-input-field-section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Start Date</label>
                                    <input type="text" class="form-control datePickerPaste datepaste-validate-2"
                                        name="blockStartDate" id="blockStartDate" value="">
                                </div>
                            </div>
                            <div class="col-md-6 modal-form-right-sec">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">End Date</label>
                                    <input type="text" class="form-control datePickerPaste datepaste-validate-2"
                                        name="blockEndDate" id="blockEndDate" value="">
                                </div>
                            </div>

                            <input type="hidden" name="blockDays" id="blockDays" value="">

                            <div class="col-md-12" style="padding-right: 0">
                                <div class="block_booking">
                                    <div class="block_booking_inr_div">
                                        <div class="date_calendar_top_sec">
                                            <span>Monday</span>
                                        </div>
                                        <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Mon', event)">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="block_booking_inr_div">
                                        <div class="date_calendar_top_sec">
                                            <span>Tuesday</span>
                                        </div>
                                        <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Tue', event)">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="block_booking_inr_div">
                                        <div class="date_calendar_top_sec">
                                            <span>Wednesday</span>
                                        </div>
                                        <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Wed', event)">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="block_booking_inr_div">
                                        <div class="date_calendar_top_sec">
                                            <span>Thursday</span>
                                        </div>
                                        <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Thu', event)">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="block_booking_inr_div">
                                        <div class="date_calendar_top_sec">
                                            <span>Friday</span>
                                        </div>
                                        <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Fri', event)">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="block_booking_inr_div">
                                        <div class="date_calendar_top_sec">
                                            <span>Saturday</span>
                                        </div>
                                        <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Sat', event)">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="block_booking_inr_div">
                                        <div class="date_calendar_top_sec">
                                            <span>Sunday</span>
                                        </div>
                                        <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Sun', event)">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Part Of Day</label>
                                    <select class="form-control field-validate-2" name="blockDayPart" id="blockDayPart">
                                        <option value="">Choose one</option>
                                        @foreach ($dayPartList as $key1 => $dayPart)
                                            <option value="{{ $dayPart->description_int }}">
                                                {{ $dayPart->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 modal-form-right-sec">
                                <div class="form-group modal-input-field" id="blockHourDiv" style="display: none;">
                                    <label class="form-check-label">Hours</label>
                                    <input type="text" class="form-control" name="blockHour" id="blockHour"
                                        value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group modal-input-field" id="blockBookingStartTimeDiv"
                                    style="display: none;" hidden>
                                    <label class="form-check-label">Start Time</label>
                                    <input type="text" class="form-control" name="start_tm"
                                        id="blockBookingStartTime" value="">
                                </div>
                            </div>
                            <div class="col-md-6 modal-form-right-sec">
                                <div class="form-group modal-input-field" id="blockBookingEndTimeDiv"
                                    style="display: none;" hidden>
                                    <label class="form-check-label">Finish Time</label>
                                    <input type="text" class="form-control" name="end_tm" id="blockBookingEndTime"
                                        value="">
                                </div>
                            </div>

                            <div class="col-md-12 modal-form-right-sec">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Mins taken for lunch</label>
                                    <input type="text" class="form-control" name="lunch_time" id=""
                                        value="">
                                </div>
                            </div>

                            <div class="col-md-12 modal-form-right-sec">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Note</label>
                                    <textarea class="form-control" rows="2" id="" name="event_note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-secondary" id="addBlockBookingBtn">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Block Booking Modal -->

    <!-- Unblock Booking Modal -->
    <div class="modal fade" id="unblockBookingModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width:65%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">UnBlock Date Booking</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Enter unblock dates</h2>
                </div>

                <form action="{{ url('/unBlockBooking') }}" method="post" class="form-validate-3"
                    id="unblockBookingBtnForm">
                    @csrf
                    <input type="hidden" name="assignmentId" id="" value="{{ $asn_id }}">

                    <div class="modal-input-field-section">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Start Date</label>
                                    <input type="text" class="form-control datePickerPaste datepaste-validate-3"
                                        name="unblockStartDate" id="unblockStartDate" value="">
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">End Date</label>
                                    <input type="text" class="form-control datePickerPaste datepaste-validate-3"
                                        name="unblockEndDate" id="unblockEndDate" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-secondary" id="unblockBookingBtn">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Unblock Booking Modal -->

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

                <form action="{{ url('/ajaxAssignmentEventUpdate') }}" method="post" class="form-validate"
                    id="ajaxAssignmentEventForm">
                    @csrf
                    <input type="hidden" name="editEventId" id="editEventId" value="">

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

    <!-- Candidate Vetting Modal -->
    <div class="modal fade" id="candidateVettingModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section cand-vetting-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Candidate Vetting</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div id="candidateVetAjax"></div>

            </div>
        </div>
    </div>
    <!-- Candidate Vetting Modal -->

    <script src="//cdn.ckeditor.com/4.4.7/standard-all/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/4.4.7/standard-all/adapters/jquery.js"></script>
    <script>
        // Use the document as the parent element for event delegation
        // jQuery(document).ready(function($) {
        //     // Initialize CKEditor when the modal is shown
        //     $('#candidateVettingModal').on('shown.bs.modal', function() {
        //         $('#school_contnt').ckeditor({
        //             toolbar: [],
        //         });

        //         const teacherHtml = $('#teacher_contnt').val();
        //         // console.log(teacherHtml);
        //         const editor = CKEDITOR.replace('teacher_contnt', {
        //             toolbar: [],
        //         });
        //         editor.setData(teacherHtml);
        //     });
        // });
    </script>

    <script>
        $(document).ready(function() {
            $('input[name="assignment_mode"]').change(function() {
                // Remove the class from all labels
                $('.mode-check label').removeClass('check_btn_active');

                // Add the class to the label of the checked radio button
                if ($(this).is(':checked')) {
                    $(this).siblings('label').addClass('check_btn_active');
                }
            });
        });


        $(document).ready(function() {
            $('#blockBookingStartTime, #blockBookingEndTime').timepicker({
                // timeFormat: 'h:i a',
                // 'step': 30,
                // 'forceRoundTime': true,
                autocomplete: true
            });
        });

        $(document).ready(function() {
            var SITEURL = "{{ url('/') }}";
            var asn_id = "{{ $asn_id }}";
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
                events: SITEURL + "/assignment-details/" + asn_id,
                displayEventTime: false,
                // eventColor: '#cdb71e',
                eventTextColor: '#fff',
                eventBackgroundColor: '#48A0DC',
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
                    var AddEvntSts = 'No';
                    var start = moment(event_start);
                    var end = moment(event_end);

                    var lastDayOfMonth = start.clone().endOf('month').date();
                    if (start.date() == lastDayOfMonth) {
                        AddEvntSts = 'Yes';
                    } else if ((event_end._d.getDate() - 1) != event_start._d.getDate()) {
                        AddEvntSts = 'No';
                    } else {
                        AddEvntSts = 'Yes';
                    }
                    // console.log('event_start ==>', event_start)
                    // console.log('event_end ==>', event_end)

                    // console.log('event_start date ==>', event_start._d.getDate())
                    // console.log('event_end date ==>', event_end._d.getDate())
                    if (AddEvntSts == 'No') {
                        calendar.fullCalendar('unselect');
                    } else {
                        // var event_name = prompt('Event Name:');
                        // var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                        var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD");
                        var assignment_mode = $('input[name="assignment_mode"]:checked').val();
                        if (assignment_mode == 'add') {
                            $.ajax({
                                url: SITEURL + "/insertAssignmentEvent/" + asn_id,
                                data: {
                                    event_start: event_start
                                },
                                type: "POST",
                                dataType: "json",
                                success: function(data) {
                                    if (data) {
                                        // if (data.type == 'Delete') {
                                        //     calendar.fullCalendar('removeEvents', data
                                        //         .eventId);
                                        // } else if (data.type == 'Add') {
                                        //     calendar.fullCalendar('renderEvent', {
                                        //         id: data.eventItem.id,
                                        //         title: data.eventItem.title,
                                        //         start: data.eventItem.start,
                                        //         editable: false
                                        //     }, true);
                                        // } else if (data.type == 'Update') {
                                        //     calendar.fullCalendar('removeEvents', data
                                        //         .eventItem.id);
                                        //     calendar.fullCalendar('renderEvent', {
                                        //         id: data.eventItem.id,
                                        //         title: data.eventItem.title,
                                        //         start: data.eventItem.start,
                                        //         editable: false
                                        //     }, true);
                                        // }
                                        calendar.fullCalendar('refetchEvents');
                                    }
                                    calendar.fullCalendar('unselect');
                                }
                            });
                        }

                        if (assignment_mode == 'edit') {
                            $.ajax({
                                url: SITEURL + "/checkAssignmentEvent/" + asn_id,
                                data: {
                                    event_start: event_start
                                },
                                type: "POST",
                                dataType: "json",
                                success: function(data) {
                                    if (data) {
                                        if (data.exist == 'No') {
                                            swal("",
                                                "You cannot use the edit day mode on an empty date in the calendar."
                                            );
                                        } else {
                                            $('#editEventId').val(data.eventId)
                                            $('#AjaxEventEdit').html(data.html);
                                            $('#eventEditModal').modal("show");
                                        }
                                    }
                                    calendar.fullCalendar('unselect');
                                }
                            });
                        }
                    }
                },
                // eventDrop: function(event, delta) {
                //     var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                //     var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                //     $.ajax({
                //         url: SITEURL + '/calendar-crud-ajax',
                //         data: {
                //             title: event.event_name,
                //             start: event_start,
                //             end: event_end,
                //             id: event.id,
                //             type: 'edit'
                //         },
                //         type: "POST",
                //         success: function(response) {

                //         }
                //     });
                // },
                eventClick: function(event) {
                    // var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD");
                    var assignment_mode = $('input[name="assignment_mode"]:checked').val();
                    if (assignment_mode == 'add') {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + "/updateAssignmentEvent/" + asn_id,
                            data: {
                                id: event.id
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data) {
                                    // if (data.type == 'Delete') {
                                    //     calendar.fullCalendar('removeEvents', data
                                    //         .eventId);
                                    // } else if (data.type == 'Update') {
                                    //     calendar.fullCalendar('removeEvents', data
                                    //         .eventItem.id);
                                    //     calendar.fullCalendar('renderEvent', {
                                    //         id: data.eventItem.id,
                                    //         title: data.eventItem.title,
                                    //         start: data.eventItem.start,
                                    //         editable: false
                                    //     }, true);
                                    // }
                                    calendar.fullCalendar('refetchEvents');
                                }
                            }
                        });
                    }

                    if (assignment_mode == 'edit') {
                        $.ajax({
                            url: SITEURL + "/checkAssignmentEvent2/" + asn_id,
                            data: {
                                id: event.id
                            },
                            type: "POST",
                            dataType: "json",
                            success: function(data) {
                                if (data) {
                                    if (data.exist == 'No') {
                                        swal("",
                                            "You cannot use the edit day mode on an empty date in the calendar."
                                        );
                                    } else {
                                        $('#editEventId').val(data.eventId)
                                        $('#AjaxEventEdit').html(data.html);
                                        $('#eventEditModal').modal("show");
                                    }
                                }
                                calendar.fullCalendar('unselect');
                            }
                        });
                    }
                }
            });
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
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            if (data.status == 'success') {
                                // $("#full_calendar_events").fullCalendar('removeEvents', data
                                //     .eventId);
                                // $("#full_calendar_events").fullCalendar('renderEvent', {
                                //     id: data.eventItem.id,
                                //     title: data.eventItem.title,
                                //     start: data.eventItem.start,
                                //     editable: false
                                // }, true);
                                $("#full_calendar_events").fullCalendar('refetchEvents');
                                date = moment(data.eventItem.start, "YYYY-MM-DD");
                                $("#full_calendar_events").fullCalendar('gotoDate', date);

                                $('#eventEditModal').modal("hide");
                            }
                        }
                    }
                });
            }
        });

        function goFirstAsnDate(asnStartDate_dte) {
            if (asnStartDate_dte) {
                date = moment(asnStartDate_dte, "YYYY-MM-DD");
                $("#full_calendar_events").fullCalendar('gotoDate', date);

                var SITEURL = "{{ url('/') }}";
                var asn_id = "{{ $asn_id }}";
                $.ajax({
                    type: "POST",
                    url: SITEURL + "/prevNextEvent/" + asn_id,
                    data: {
                        Date: asnStartDate_dte
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#prevDaySpan').html('');
                            $('#nextDaySpan').html('');
                            if (data.prevDays) {
                                $('#prevDaySpan').html(data.prevDays.previousDays);
                            }
                            if (data.nextDays) {
                                $('#nextDaySpan').html(data.nextDays.nDays);
                            }
                        }
                    }
                });
            }
        }

        $(document).on('change', '#blockDayPart', function() {
            var blockDayPart = this.value;
            $('#blockBookingStartTime').val('');
            $('#blockBookingEndTime').val('');
            if (blockDayPart == 4) {
                $('#blockHour').addClass('number-validate-2');
                $('#blockHourDiv').show();

                // $('#blockBookingStartTime').addClass('field-validate-2');
                // $('#blockBookingStartTimeDiv').show();
                // $('#blockBookingEndTime').addClass('field-validate-2');
                // $('#blockBookingEndTimeDiv').show();
            } else {
                $('#blockHour').val('');
                $('#blockHour').removeClass('number-validate-2');
                $('#blockHour').closest(".form-group").removeClass('has-error');
                $('#blockHourDiv').hide();

                // $('#blockBookingStartTime').removeClass('field-validate-2');
                // $('#blockBookingStartTime').closest(".form-group").removeClass('has-error');
                // $('#blockBookingStartTimeDiv').hide();
                // $('#blockBookingEndTime').removeClass('field-validate-2');
                // $('#blockBookingEndTime').closest(".form-group").removeClass('has-error');
                // $('#blockBookingEndTimeDiv').hide();
            }
        });

        $(document).on('change', '#blockBookingStartTime, #blockBookingEndTime', function() {
            var startTime = $('#blockBookingStartTime').val();
            var endTime = $('#blockBookingEndTime').val();
            $('#blockHour').val('');
            if (startTime, endTime) {
                // var currentDate = new Date();
                // var startDate = new Date(currentDate.toDateString() + ' ' + startTime);
                // var endDate = new Date(currentDate.toDateString() + ' ' + endTime);
                // var timeDiff = endDate - startDate;
                // var hoursDiff = timeDiff / (1000 * 60 * 60);
                var start = parseTime(startTime);
                var end = parseTime(endTime);
                // Calculate the time difference in hours
                var hoursDiff = (end - start) / 1000 / 60 / 60;

                $('#blockHour').val(hoursDiff);
            }
        });

        function parseTime(time) {
            var parts = time.match(/(\d+):(\d+)(am|pm)/);
            var hours = parseInt(parts[1]);
            var minutes = parseInt(parts[2]);

            if (parts[3] === "pm" && hours !== 12) {
                hours += 12;
            } else if (parts[3] === "am" && hours === 12) {
                hours = 0;
            }
            return new Date(0, 0, 0, hours, minutes);
        }

        $(document).on('click', '#blockBookingBtnId', function() {
            var CurrentDateObj = new Date();
            date = moment(CurrentDateObj, "YYYY-MM-DD");
            $("#full_calendar_events").fullCalendar('gotoDate', date);
            $('#blockBookingModal').modal('show');
        });

        $(document).on('click', '#addBlockBookingBtn', function() {
            var error = "";
            $(".field-validate-2").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".number-validate-2").each(function() {
                if (this.value == '' || isNaN(this.value)) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".datepaste-validate-2").each(function() {
                var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
                if (this.value == '' || !dateRegex.test(this.value)) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (error == "has error") {
                return false;
            } else {
                var form = $("#addBlockBookingForm");
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        if (data) {
                            if (data.status == 'success') {
                                // location.reload();
                                $.each(data.IdArray, function(val1, text1) {
                                    $("#full_calendar_events").fullCalendar('removeEvents',
                                        text1);
                                });
                                var DateObj = new Date(data.firstDate);
                                var months = DateObj.getMonth();
                                var CurrentDateObj = new Date();
                                var CurrentMonths = CurrentDateObj.getMonth();
                                // if (months == CurrentMonths) {
                                //     $.each(data.eventItemArr, function(val, text) {
                                //         $("#full_calendar_events").fullCalendar('renderEvent', {
                                //             id: text.id,
                                //             title: text.title,
                                //             start: text.start,
                                //             editable: false
                                //         }, true);
                                //     });
                                // }
                                $("#full_calendar_events").fullCalendar('refetchEvents');

                                if (data.firstDate) {
                                    date = moment(data.firstDate, "YYYY-MM-DD");
                                    $("#full_calendar_events").fullCalendar('gotoDate', date);
                                }

                                $('#blockBookingModal').modal('hide');
                            }
                        }
                    }
                });
            }
        });

        $('input[type=radio][name=assignment_mode]').change(function() {
            if (this.value == 'unblock') {
                var CurrentDateObj = new Date();
                date = moment(CurrentDateObj, "YYYY-MM-DD");
                $("#full_calendar_events").fullCalendar('gotoDate', date);
                $('#unblockBookingModal').modal('show');
            }
        });

        $(document).on('click', '#unblockLabel', function() {
            var CurrentDateObj = new Date();
            date = moment(CurrentDateObj, "YYYY-MM-DD");
            $("#full_calendar_events").fullCalendar('gotoDate', date);
            $('#unblockBookingModal').modal('show');
        });

        $(document).on('click', '#unblockBookingBtn', function() {
            var error = "";
            $(".field-validate-3").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".datepaste-validate-3").each(function() {
                var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
                if (this.value == '' || !dateRegex.test(this.value)) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (error == "has error") {
                return false;
            } else {
                var form = $("#unblockBookingBtnForm");
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        if (data) {
                            if (data.status == 'success') {
                                // location.reload();
                                // $.each(data.IdArray, function(val1, text1) {
                                //     $("#full_calendar_events").fullCalendar('removeEvents',
                                //         text1);
                                // });
                                $("#full_calendar_events").fullCalendar('refetchEvents');

                                if (data.firstDate) {
                                    date = moment(data.firstDate, "YYYY-MM-DD");
                                    $("#full_calendar_events").fullCalendar('gotoDate', date);
                                }

                                $('#unblockBookingModal').modal('hide');
                            }
                        }
                    }
                });
            }
        });

        $(document).on('click', '.fc-prev-button, .fc-next-button', function() {
            var getDate = $('#full_calendar_events').fullCalendar('getDate');
            var Date = getDate.format();
            var SITEURL = "{{ url('/') }}";
            var asn_id = "{{ $asn_id }}";
            $.ajax({
                type: "POST",
                url: SITEURL + "/prevNextEvent/" + asn_id,
                data: {
                    Date: Date
                },
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#prevDaySpan').html('');
                        $('#nextDaySpan').html('');
                        if (data.prevDays) {
                            $('#prevDaySpan').html(data.prevDays.previousDays);
                        }
                        if (data.nextDays) {
                            $('#nextDaySpan').html(data.nextDays.nDays);
                        }
                    }
                }
            });
        });

        function candidateVetting(asn_id, teacher_id, candidateName) {
            if (asn_id && teacher_id) {
                var vetting_id = '';
                $.ajax({
                    type: 'POST',
                    url: '{{ url('checkVettingExist') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        asn_id: asn_id,
                        teacher_id: teacher_id
                    },
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        if (data.exist == "Yes" && data.vetting_id) {
                            vetting_id = data.vetting_id;
                        }
                    }
                });

                if (vetting_id) {
                    swal({
                            title: "",
                            text: "A vetting already exists for this teacher and assignment would you like to open it? Clicking No will create a new vetting",
                            buttons: {
                                Yes: "Yes",
                                No: "No",
                                cancel: "Cancel"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "Yes":
                                    // alert('yes');
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('createCandidateVetting') }}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            asn_id: asn_id,
                                            vetting_id: vetting_id,
                                            newVetting: "No"
                                        },
                                        success: function(data) {
                                            if (data) {
                                                $('#candidateVetAjax').html(data.html);
                                                $('#candidateVettingModal').modal("show");
                                            }
                                        }
                                    });
                                    break;
                                case "No":
                                    // alert('No');
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('createCandidateVetting') }}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            asn_id: asn_id,
                                            vetting_id: vetting_id,
                                            newVetting: "Yes"
                                        },
                                        success: function(data) {
                                            if (data) {
                                                $('#candidateVetAjax').html(data.html);
                                                $('#candidateVettingModal').modal("show");
                                            }
                                        }
                                    });
                                    break;
                            }
                        });
                } else {
                    swal({
                            title: "",
                            text: "This will manually create a vetting request for the candidate " + candidateName +
                                " (automatically done on school confirmation) continue anyway?",
                            buttons: {
                                cancel: "No",
                                Yes: "Yes"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "Yes":
                                    // alert('yes')
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('createCandidateVetting') }}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            asn_id: asn_id,
                                            vetting_id: vetting_id,
                                            newVetting: "Yes"
                                        },
                                        success: function(data) {
                                            if (data) {
                                                $('#candidateVetAjax').html(data.html);
                                                $('#candidateVettingModal').modal("show");
                                            }
                                        }
                                    });
                            }
                        });
                }
            }
        }

        $(document).on('click', '#candVettingEditBtn', function() {
            // var error = "";
            // $(".vetting-field-validate").each(function() {
            //     if (this.value == '') {
            //         $(this).closest(".form-group").addClass('has-error');
            //         error = "has error";
            //     } else {
            //         $(this).closest(".form-group").removeClass('has-error');
            //     }
            // });
            // if (error == "has error") {
            //     return false;
            // } else {
            var form = $("#candVettingEditForm");
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                dataType: "json",
                async: false,
                success: function(data) {
                    if (data) {
                        $('#candidateVetAjax').html(data.html);
                    }
                }
            });
            // }
        });

        function changeProfType(school_id, type) {
            // alert(school_id + ',' + type)
            if (school_id && type) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('changeAsnProfType') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        school_id: school_id,
                        type: type
                    },
                    success: function(data) {
                        $('#asnDailyCharge').val(data.rate);
                    }
                });
            }
        }

        function selectWeekDay(day) {
            if (day == 'Mon' || day == 'Tue' || day == 'Wed' || day == 'Thu' || day == 'Fri' || day == 'Sat' || day ==
                'Sun') {
                var element = $(event.target).closest('.date_calendar_bottom_sec');

                if (element.hasClass('date_calendar_bottom_sec_active')) {
                    setDays(day, 'rm');
                    element.removeClass('date_calendar_bottom_sec_active');
                } else {
                    setDays(day, 'add');
                    element.addClass('date_calendar_bottom_sec_active');
                }
            }
        }

        function setDays(day, type) {
            var ItemId = day;
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#blockDays').val();
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
            $('#blockDays').val(ids);
        }
    </script>
@endsection
