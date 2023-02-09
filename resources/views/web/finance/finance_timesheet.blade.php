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
                                            <a data-toggle="modal" data-target="#ContactItemAddModal"
                                                style="cursor: pointer;">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </a>
                                            <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                                <i class="fa-solid fa-folder-open"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="finance-list-section">

                                        <div class="finance-list-text-section">
                                            <div class="finance-list-text">
                                                {{-- <ul>
                                                    <li class="timesheet-list-active">New Text Document.txt</li>
                                                </ul> --}}
                                            </div>
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

                            <div class="finance-timesheet-second-table-section">
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

                            <input type="hidden" name="" id="asnItemIds" value="">

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
    </script>
@endsection
