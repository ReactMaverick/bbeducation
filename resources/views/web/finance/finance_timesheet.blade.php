@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            <div class="col-md-12 topbar-sec">

                @include('web.finance.finance_header')

                <div class="finance-timesheet-top-total-section">
                    <div class="finance-timesheet-total-section">
                        <div class="timesheet-top-section mb-2">

                            <div class="form-group timesheet-top-input-sec">
                                <form action="{{ url('/finance-timesheets') }}" method="get">
                                    <label for="" class="col-form-label">Timesheets Until</label>
                                    <input type="date" name="date" id="timesheetDate" value="{{ $p_maxDate }}">
                                    <button type="submit" class="timesheet-search-btn">Search</button>
                                </form>
                            </div>

                            {{-- <div class="timesheet-process-btn">
                                <button>S:\Timesheet To Process</button>
                            </div> --}}
                        </div>
                        <div class="finance-timesheet-section">
                            <div class="finance-timesheet-left-sec">

                                <div class="finance-timesheet-contact-first-sec">
                                    <div class="contact-heading">
                                        <div class="contact-heading-text">
                                            <h2>Select a file</h2>
                                        </div>
                                        <div class="contact-icon-sec">
                                            <a style="cursor: pointer;" class="disabled-link" id="timesheetMailtoBtn"
                                                title="Mail Timesheet">
                                                <i class="fa-solid fa-envelope"></i>
                                            </a>
                                            <a style="cursor: pointer;" class="disabled-link" id="rejectTimesheetBtn"
                                                title="Reject Timesheet">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            </a>
                                            <a style="cursor: pointer;" class="disabled-link" id="sendTimesheetBtn"
                                                title="Send for approval">
                                                <i class="fa-solid fa-paper-plane"></i>
                                            </a>
                                            <a style="cursor: pointer;" class="disabled-link" id="viewTimesheetBtn"
                                                title="View timesheet">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a id="reloadBtn" style="cursor: pointer;" title="Reload">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="finance-list-section">
                                        <div class="finance-list-text-section">
                                            <div class="finance-list-text">
                                                {{-- <ul>
                                                    <li class="timesheet-list-active">New Text Document.txt</li>
                                                </ul> --}}
                                                <table class="table finance-timesheet-page-table" id="">
                                                    <thead>
                                                        <tr class="school-detail-table-heading">
                                                            <th>Teacher</th>
                                                            <th>School</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-body-sec">
                                                        @foreach ($documentList as $key => $document)
                                                            <tr class="school-detail-table-data selectDocumentRow"
                                                                id="selectDocumentRow{{ $document->teacher_timesheet_id }}"
                                                                onclick="selectDocumentRowSelect({{ $document->teacher_timesheet_id }}, '{{ $document->approve_by_school }}', '{{ $document->login_mail }}', '{{ $document->pdf_path }}')">
                                                                <td>
                                                                    @if ($document->knownAs_txt == null && $document->knownAs_txt == '')
                                                                        {{ $document->firstName_txt . ' ' . $document->surname_txt }}
                                                                    @else
                                                                        {{ $document->knownAs_txt . ' ' . $document->surname_txt }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $document->name_txt }}</td>
                                                                <td>({{ date('d/m/Y', strtotime($weekStartDate)) . '-' . date('d/m/Y', strtotime($weekEndDate)) }})
                                                                </td>
                                                                <td>
                                                                    @if ($document->approve_by_school == 1)
                                                                        {{ 'Send For Approval' }}
                                                                    @elseif ($document->approve_by_school == 2)
                                                                        {{ 'Approve' }}
                                                                    @elseif ($document->approve_by_school == 3)
                                                                        {{ 'Not Approve' }}
                                                                    @else
                                                                        {{ '--' }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <input type="hidden" name="teacherTimesheetId" id="teacherTimesheetId"
                                                value="">
                                            <input type="hidden" name="teacherTimesheetStatus" id="teacherTimesheetStatus"
                                                value="">
                                            <input type="hidden" name="teacherTimesheetMail" id="teacherTimesheetMail"
                                                value="">
                                            <input type="hidden" name="teacherTimesheetPath" id="teacherTimesheetPath"
                                                value="">
                                            <input type="hidden" name="docStartDate" id="docStartDate"
                                                value="{{ $weekStartDate }}">
                                            <input type="hidden" name="docEndDate" id="docEndDate"
                                                value="{{ $weekEndDate }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="finance-timesheet-contact-second-sec">
                                    <div class="finance-timesheet-table-section">
                                        <table class="table finance-timesheet-page-table" id="">
                                            <thead>
                                                <tr class="school-detail-table-heading">
                                                    <th>School</th>
                                                    <th>Days</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body-sec">
                                                @foreach ($timesheetSchoolList as $key => $timesheetSchool)
                                                    <tr class="school-detail-table-data selectSchoolRow"
                                                        id="selectSchoolRow{{ $timesheetSchool->school_id }}"
                                                        school-id="{{ $timesheetSchool->school_id }}">
                                                        <td>{{ $timesheetSchool->schoolName_txt }}</td>
                                                        <td>{{ $timesheetSchool->timesheetDatesRequired_int }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-bottom-text">
                                        <span>Double-click to open the school</span>
                                    </div>
                                </div>
                                <input type="hidden" name="" id="selectedSchoolId" value="">
                            </div>

                            <div class="finance-timesheet-left-sec">

                                <div class="finance-timesheet-contact-first-sec">
                                    <div class="finance-timesheet-table-section" style="margin-top: 30px;">
                                        <table class="table finance-timesheet-page-table" id="myTable">
                                            <thead>
                                                <tr class="school-detail-table-heading">
                                                    <th>Teacher</th>
                                                    <th>Date</th>
                                                    <th>Part</th>
                                                    <th>Student</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body-sec" id="teacherListDiv">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-assignment-bottom-text-sec">
                                        <div class="table-bottom-text">
                                            <span>Double-click to open the assignment</span>
                                        </div>

                                        <div class="finance-contact-icon-sec">
                                            <a style="cursor: pointer" class="disabled-link" id="deleteDaysBttn"
                                                title="Remove days from assignment">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                            <a style="cursor: pointer;" class="disabled-link" id="editDaysBttn"
                                                title="Edit days from assignment">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <a style="cursor: pointer" class="disabled-link" id="logTimesheetBtn"
                                                title="Log timesheets">
                                                <i class="fa-solid fa-square-check"></i>
                                            </a>
                                            <a style="cursor: pointer" id="reloadTimesheetBtn" title="Reload timesheets">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="" id="asnItemIds" value="">

                                <div class="finance-timesheet-contact-second-sec" style="display: none"
                                    id="teacherTimesheetDiv">
                                    <div class="finance-timesheet-table-section" style="margin-top: 30px;">
                                        <table class="table finance-timesheet-page-table" id="">
                                            <thead>
                                                <tr class="school-detail-table-heading">
                                                    <th>Teacher</th>
                                                    <th>Date</th>
                                                    <th>Part</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body-sec" id="teacherTimesheetTbody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>

                    {{-- <div class="finance-timesheet-right-sec">
                        <div class="finance-timesheet-right-inner-section">
                            <iframe src="https://www.google.com/webhp?igu=1"></iframe>
                        </div>
                    </div> --}}
                </div>
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

                <form method="post" class="form-validate" id="ajaxAssignmentEventForm">
                    @csrf
                    <input type="hidden" name="editEventId" id="editEventId" value="">
                    <input type="hidden" name="max_date" id="" value="{{ $p_maxDate }}">
                    <input type="hidden" name="school_id" id="editSchoolId" value="">

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

    <script>
        var DELAY = 200,
            clicks = 0,
            timer = null;

        $(function() {

            $(".selectSchoolRow").on("click", function(e) {
                    clicks++; //count clicks
                    var schoolId = $(this).attr('school-id');
                    if (clicks === 1) {
                        timer = setTimeout(function() {
                            // alert("Single Click=>"+teacherId); //perform single-click action
                            $('#selectedSchoolId').val('');

                            if ($('#selectSchoolRow' + schoolId).hasClass('tableRowActive')) {
                                $('#selectedSchoolId').val('');
                                $('#selectSchoolRow' + schoolId).removeClass('tableRowActive');
                                fetchTecher('{{ $p_maxDate }}', '');
                            } else {
                                $('#selectedSchoolId').val(schoolId);
                                $('.selectSchoolRow').removeClass('tableRowActive');
                                $('#selectSchoolRow' + schoolId).addClass('tableRowActive');
                                fetchTecher('{{ $p_maxDate }}', schoolId);
                            }
                            clicks = 0; //after action performed, reset counter
                        }, DELAY);
                    } else {
                        clearTimeout(timer); //prevent single-click action
                        // alert("Double Click=>" + teacherId); //perform double-click action
                        if ($('#selectSchoolRow' + schoolId).hasClass('tableRowActive')) {
                            $('#selectedSchoolId').val('');
                            $('#selectSchoolRow' + schoolId).removeClass('tableRowActive');
                            fetchTecher('{{ $p_maxDate }}', '');
                        } else {
                            $('#selectedSchoolId').val(schoolId);
                            $('.selectSchoolRow').removeClass('tableRowActive');
                            $('#selectSchoolRow' + schoolId).addClass('tableRowActive');
                            fetchTecher('{{ $p_maxDate }}', schoolId);
                        }

                        clicks = 0; //after action performed, reset counter
                    }
                })
                .on("dblclick", function(e) {
                    e.preventDefault(); //cancel system double-click event
                    var schoolId = $(this).attr('school-id');
                    var location = "{{ url('/school-detail') }}" + '/' + schoolId;
                    window.open(location);
                });

        });

        function fetchTecher(max_date, school_id) {
            $('#teacherListDiv').html('');
            $('#asnItemIds').val('');
            $('#deleteDaysBttn').addClass('disabled-link');
            $('#editDaysBttn').addClass('disabled-link');
            $('#logTimesheetBtn').addClass('disabled-link');
            if (school_id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('fetchTeacherById') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        max_date: max_date,
                        school_id: school_id
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#teacherListDiv').html(data.html);
                    }
                });
            }
        }

        var DELAY1 = 200,
            clicks1 = 0,
            timer1 = null;

        $(document).on('click', '.selectTeacherRow', function(e1) {
            clicks1++; //count clicks
            var asnitemId = $(this).attr('asnitem-id');
            var asnId = $(this).attr('asn-id');
            var teacherId = $(this).attr('teacher-id');
            // var schoolId = $(this).attr('school-id');
            if (clicks1 === 1) {
                timer1 = setTimeout(function() {
                    // alert("Single Click=>"+teacherId); //perform single-click action
                    if ($('#selectTeacherRow' + asnitemId).hasClass('tableRowActive')) {
                        $('#selectTeacherRow' + asnitemId).removeClass('tableRowActive');
                        setIds(asnitemId, 'rm');
                    } else {
                        $('#selectTeacherRow' + asnitemId).addClass('tableRowActive');
                        setIds(asnitemId, 'add');
                    }
                    clicks1 = 0; //after action performed, reset counter
                }, DELAY1);
            } else {
                clearTimeout(timer1); //prevent single-click action
                // alert("Double Click=>" + teacherId); //perform double-click action
                if ($('#selectTeacherRow' + asnitemId).hasClass('tableRowActive')) {
                    $('#selectTeacherRow' + asnitemId).removeClass('tableRowActive');
                    setIds(asnitemId, 'rm');
                } else {
                    $('#selectTeacherRow' + asnitemId).addClass('tableRowActive');
                    setIds(asnitemId, 'add');
                }

                clicks1 = 0; //after action performed, reset counter

                var location = "{{ url('/assignment-details') }}" + '/' + asnId;
                window.open(location);
            }
        });
        // .on("dblclick", function(e1) {
        //     e1.preventDefault(); //cancel system double-click event
        //     var asnId = $(this).attr('asn-id');
        //     var location = "{{ url('/assignment-details') }}" + '/' + asnId;
        //     window.open(location);
        // });

        function setIds(asnitem_id, type) {
            var ItemId = parseInt(asnitem_id);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#asnItemIds').val();
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
            $('#asnItemIds').val(ids);
            if (ids) {
                $('#deleteDaysBttn').removeClass('disabled-link');
                $('#editDaysBttn').removeClass('disabled-link');
                $('#logTimesheetBtn').removeClass('disabled-link');
            } else {
                $('#deleteDaysBttn').addClass('disabled-link');
                $('#editDaysBttn').addClass('disabled-link');
                $('#logTimesheetBtn').addClass('disabled-link');
            }
        }

        $(document).on('click', '#deleteDaysBttn', function() {
            var asnItemIds = $('#asnItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "Alert",
                        text: "This will remove the assignment items for any highlighted dates. Are you sure you wish to continue?",
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
                                    url: '{{ url('timesheetAsnItemDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds
                                    },
                                    async: false,
                                    success: function(data) {
                                        var idsArr = [];
                                        if (asnItemIds) {
                                            idsArr = asnItemIds.split(',');
                                        }
                                        for (var i = 0; i < idsArr.length; i++) {
                                            $('#selectTeacherRow' + idsArr[i]).remove();
                                        }
                                        $('#asnItemIds').val('');
                                        $('#deleteDaysBttn').addClass('disabled-link');
                                        $('#editDaysBttn').addClass('disabled-link');
                                        $('#logTimesheetBtn').addClass('disabled-link');
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one item.");
            }
        });

        $(document).on('click', '#editDaysBttn', function() {
            var asnItemIds = $('#asnItemIds').val();
            var idsArr = [];
            var SITEURL = "{{ url('/') }}";
            if (asnItemIds) {
                idsArr = asnItemIds.split(',');
                if (idsArr.length == 1) {
                    // alert(idsArr[0])
                    var schoolId = $('#selectedSchoolId').val();
                    $('#editSchoolId').val(schoolId);
                    $.ajax({
                        url: SITEURL + "/timesheetEditEvent",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: idsArr[0]
                        },
                        type: "POST",
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                if (data.exist == 'Yes') {
                                    $('#editEventId').val(data.eventId)
                                    $('#AjaxEventEdit').html(data.html);
                                    $('#eventEditModal').modal("show");
                                }
                            }
                        }
                    });
                } else {
                    swal("", "You cannot edit more then one item at a time.");
                }
            } else {
                swal("", "Please select one item.");
            }
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
                var SITEURL = "{{ url('/') }}";
                var actionUrl = SITEURL + "/timesheetEventUpdate";
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    asynch: false,
                    success: function(data) {
                        $('#teacherListDiv').html('');
                        $('#teacherListDiv').html(data.html);
                        if (data.eventId) {
                            $('#selectTeacherRow' + data.eventId).addClass('tableRowActive');
                        }
                        $('#eventEditModal').modal("hide");
                    }
                });
            }
        });

        $(document).on('click', '#logTimesheetBtn', function() {
            var teacher_timesheet_id = $('#teacherTimesheetId').val();
            // var docStartDate = $('#docStartDate').val();
            // var docEndDate = $('#docEndDate').val();
            var schoolId = $('#selectedSchoolId').val();
            if (teacher_timesheet_id) {
                var asnItemIds = $('#asnItemIds').val();
                if (asnItemIds) {
                    swal({
                            title: "Alert",
                            text: "Are you sure you wish to log this timesheet?",
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
                                        url: '{{ url('timesheetAsnItemLog') }}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            asnItemIds: asnItemIds,
                                            teacher_timesheet_id: teacher_timesheet_id,
                                            // docStartDate: docStartDate,
                                            // docEndDate: docEndDate,
                                            schoolId: schoolId
                                        },
                                        async: false,
                                        dataType: "json",
                                        success: function(data) {
                                            if (data.add == 'Yes') {
                                                var idsArr = [];
                                                if (asnItemIds) {
                                                    idsArr = asnItemIds.split(',');
                                                }
                                                for (var i = 0; i < idsArr.length; i++) {
                                                    $('#selectTeacherRow' + idsArr[i]).remove();
                                                }
                                                $('#asnItemIds').val('');
                                                $('#deleteDaysBttn').addClass('disabled-link');
                                                $('#editDaysBttn').addClass('disabled-link');
                                                $('#logTimesheetBtn').addClass('disabled-link');
                                                $('#selectDocumentRow' + teacher_timesheet_id)
                                                    .remove();
                                                var popTxt =
                                                    'You have just logged a timesheet for ' + data
                                                    .schoolName +
                                                    '. Timesheet ID : ' + data.timesheet_id;
                                                swal("", popTxt);
                                            }
                                        }
                                    });
                            }
                        });
                } else {
                    swal("", "Please select one item.");
                }
            } else {
                swal("", "Please select teacher timesheet document.");
            }
        });

        $(document).on('click', '#reloadBtn', function() {
            location.reload();
        });

        function selectDocumentRowSelect(teacher_timesheet_id, status, login_mail, pdf_path) {
            $('#teacherTimesheetTbody').html('');
            $('#teacherTimesheetDiv').css('display', 'none');
            if ($('#selectDocumentRow' + teacher_timesheet_id).hasClass('tableRowActive')) {
                $('#teacherTimesheetId').val('');
                $('#teacherTimesheetStatus').val('');
                $('#teacherTimesheetMail').val('');
                $('#teacherTimesheetPath').val('');
                $('#selectDocumentRow' + teacher_timesheet_id).removeClass('tableRowActive');
                $('#rejectTimesheetBtn').addClass('disabled-link');
                $('#sendTimesheetBtn').addClass('disabled-link');
                $('#viewTimesheetBtn').addClass('disabled-link');
                $('#timesheetMailtoBtn').addClass('disabled-link');
            } else {
                $('#teacherTimesheetId').val(teacher_timesheet_id);
                $('#teacherTimesheetStatus').val(status);
                $('#teacherTimesheetMail').val(login_mail);
                $('#teacherTimesheetPath').val(pdf_path);
                $('.selectDocumentRow').removeClass('tableRowActive');
                $('#selectDocumentRow' + teacher_timesheet_id).addClass('tableRowActive');
                $('#rejectTimesheetBtn').removeClass('disabled-link');
                $('#sendTimesheetBtn').removeClass('disabled-link');
                $('#viewTimesheetBtn').removeClass('disabled-link');
                $('#timesheetMailtoBtn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#viewTimesheetBtn', function() {
            var teacher_timesheet_id = $('#teacherTimesheetId').val();
            if (teacher_timesheet_id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('fetchTeacherSheetById') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacher_timesheet_id: teacher_timesheet_id
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#teacherTimesheetTbody').html('');
                        $('#teacherTimesheetTbody').html(data.html);
                        $('#teacherTimesheetDiv').css('display', 'block');

                        if (data.pdfPath) {
                            var location = data.pdfPath;
                            window.open(location);
                        }
                    }
                });
            } else {
                swal("", "Please select one document.");
            }
        });

        $(document).on('click', '#rejectTimesheetBtn', function() {
            var teacher_timesheet_id = $('#teacherTimesheetId').val();
            if (teacher_timesheet_id) {
                swal({
                        title: "",
                        text: "Are you sure you wish to reject this timesheet?",
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
                                    url: '{{ url('rejectTeacherSheet') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        teacher_timesheet_id: teacher_timesheet_id
                                    },
                                    success: function(data) {
                                        //console.log(data);
                                        $('#teacherTimesheetTbody').html('');
                                        $('#teacherTimesheetDiv').css('display', 'none');

                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#sendTimesheetBtn', function() {
            var teacher_timesheet_id = $('#teacherTimesheetId').val();
            var teacherTimesheetStatus = $('#teacherTimesheetStatus').val();
            if (teacher_timesheet_id) {
                if (teacherTimesheetStatus == 1) {
                    swal("", "Timesheet already send to the school.");
                } else if (teacherTimesheetStatus == 2) {
                    swal("", "School is approved the timesheet. You cannot resend this timesheet.");
                } else {
                    swal({
                            title: "",
                            text: "Are you sure you wish to send this timesheet to school for approval?",
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
                                        url: '{{ url('sendTimesheetToApproval') }}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            teacher_timesheet_id: teacher_timesheet_id
                                        },
                                        success: function(data) {
                                            //console.log(data);
                                            $('#teacherTimesheetTbody').html('');
                                            $('#teacherTimesheetDiv').css('display', 'none');

                                            location.reload();
                                        }
                                    });
                            }
                        });
                }
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#reloadTimesheetBtn', function() {
            var schoolId = $('#selectedSchoolId').val();
            if (schoolId) {
                fetchTecher('{{ $p_maxDate }}', schoolId);
            }
        });

        $(document).on('click', '#timesheetMailtoBtn', function(event) {
            event.preventDefault();
            var login_mail = $('#teacherTimesheetMail').val();
            var loginMail = '';
            if (login_mail) {
                loginMail = login_mail;
            } else {
                loginMail = 'demo@gmail.com';
            }
            var path = $('#teacherTimesheetPath').val();
            var pdfPath = '';
            if (path) {
                pdfPath = "<?php echo asset('/'); ?>" + path;
            }
            var subject = 'Approve the timesheet';
            if (loginMail) {
                window.location = 'mailto:' + loginMail + '?subject=' + subject + '&body=&attachment=' + pdfPath;
            }
            // alert('mailto:' + login_mail + '?subject=' + subject + '&body=&attachment=' + pdfPath)
        });
    </script>
@endsection
