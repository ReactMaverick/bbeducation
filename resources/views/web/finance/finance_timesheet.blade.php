@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }

        .date-left-teacher-calendar {
            width: 13%;
        }

        .teacher-calendar-days-text {
            width: 13%;
        }

        .teacher-calendar-days-field3 p {
            text-align: center;
        }

        .teacher-calendar-days-text p {
            /* border-bottom: 1px solid #A0C5E7; */
            padding-bottom: 3px;
        }

        .teacher-calendar-days-sec {
            border: 1px solid #afabab;
            padding-right: 21px;
        }

        .teacher-calendar-table-section {
            padding: 0 5px;
        }

        .calendar-outer-sec:hover {
            cursor: pointer;
        }

        .calendar-section {
            padding: 0 5px;
        }

        .invoice-top-section {
            justify-content: flex-end;
        }

        .finance-contact-icon-sec i {
            font-size: 25px;
        }

        .rejectDiv {
            background-color: #e75943;
            width: 100%;
            min-height: 65px;
            border-radius: 5%;
            border: 1px solid #e75943;
        }

        .rejectDiv p {
            color: #fff;
        }

        .approveDiv {
            background-color: #55e743;
            width: 100%;
            min-height: 65px;
            border-radius: 5%;
            border: 1px solid #55e743;
        }

        .approveDiv p {
            color: #fff;
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

                        </div>
                        <div class="finance-timesheet-section">
                            <div class="finance-timesheet-left-sec">

                                <div class="finance-timesheet-contact-first-sec" style="width: 65%;">

                                    <div class="invoice-top-section mb-2">

                                        <div class="invoice-top-btn-sec mr-3">
                                            <button id="selectNoneBtn">Select None</button>
                                        </div>

                                        <div class="invoice-top-btn-sec mr-3">
                                            <button id="selectAllBtn">Select All</button>
                                        </div>
                                        <div class="finance-contact-icon-sec">
                                            <a style="cursor: pointer" class="disabled-link" id="timesheetEditBtn"
                                                title="Edit timesheet">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </div>
                                        <div class="finance-contact-icon-sec">
                                            <a style="cursor: pointer" class="disabled-link" id="timesheetApproveBtn"
                                                title="Approve timesheet">
                                                <i class="fa-solid fa-square-check"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <?php
                                    $day1Amount_total = 0;
                                    $day2Amount_total = 0;
                                    $day3Amount_total = 0;
                                    $day4Amount_total = 0;
                                    $day5Amount_total = 0;
                                    $asnIdsArr = [];
                                    foreach ($calenderList as $key => $cal) {
                                        $day1Amount_total += $cal->day1Amount_dec;
                                        $day2Amount_total += $cal->day2Amount_dec;
                                        $day3Amount_total += $cal->day3Amount_dec;
                                        $day4Amount_total += $cal->day4Amount_dec;
                                        $day5Amount_total += $cal->day5Amount_dec;
                                        array_push($asnIdsArr, $cal->asn_id);
                                    }
                                    $asnIds = implode(',', $asnIdsArr);
                                    ?>

                                    <div class="teacher-calendar-days-sec">
                                        <div class="teacher-calendar-days-text">
                                            <p>School</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Teacher</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Monday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day1Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Tuesday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day2Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Wednesday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day3Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Thursday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day4Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Friday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day5Amount_total }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Status</p>
                                        </div>
                                    </div>

                                    <input type="hidden" name="" id="timesheetAsnIds" value="{{ $asnIds }}">

                                    <div class="finance-list-text-section">
                                        <div class="teacher-calendar-table-section">

                                            @foreach ($calenderList as $key1 => $calender)
                                                <?php
                                                $adminApprove = 0;
                                                if ($calender->admin_approve1 == 2 || $calender->admin_approve2 == 2 || $calender->admin_approve3 == 2 || $calender->admin_approve4 == 2 || $calender->admin_approve5 == 2) {
                                                    $adminApprove = 1;
                                                }
                                                ?>
                                                <div class="calendar-outer-sec editTimesheetDiv"
                                                    id="editTimesheetDiv{{ $calender->asn_id }}"
                                                    onclick="timesheetRow('{{ $calender->asn_id }}')">
                                                    <div class="calendar-section">
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            <div class="teacher-calendar-days-field3">
                                                                <p>
                                                                    {{ $calender->name_txt }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            <div class="teacher-calendar-days-field3">
                                                                <p>
                                                                    @if ($calender->knownAs_txt == null && $calender->knownAs_txt == '')
                                                                        {{ $calender->firstName_txt . ' ' . $calender->surname_txt }}
                                                                    @else
                                                                        {{ $calender->knownAs_txt . ' ' . $calender->surname_txt }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day1Avail_txt && $calender->day1asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day1LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day1Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day2Avail_txt && $calender->day2asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day2Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day3Avail_txt && $calender->day3asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day3Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day4Avail_txt && $calender->day4asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day4Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($calender->day5Avail_txt && $calender->day5asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day5Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar" style="width: 12%;">
                                                            @if ($adminApprove == 1)
                                                                <div class="teacher-calendar-days-field3 rejectDiv">
                                                                    <p>Reject</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3">
                                                                    <p>Pending</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>

                                    <input type="hidden" name="" id="ajaxTimesheetAsnIds" value="">
                                </div>

                                <div class="finance-timesheet-contact-second-sec" style="width: 32%;">
                                    <div class="contact-heading">
                                        <div class="contact-heading-text">
                                            <h2>Select a file</h2>
                                        </div>
                                        <div class="contact-icon-sec">
                                            <a style="cursor: pointer;" class="disabled-link" id="viewTimesheetBtn"
                                                title="View timesheet">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="finance-list-section">
                                        <div class="finance-list-text-section">
                                            <div class="finance-list-text">
                                                <table class="table finance-timesheet-page-table" id="">
                                                    <thead>
                                                        <tr class="school-detail-table-heading">
                                                            <th>Teacher</th>
                                                            <th>School</th>
                                                            <th>Date</th>
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
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <input type="hidden" name="teacherTimesheetId" id="teacherTimesheetId"
                                                value="">
                                            <input type="hidden" name="teacherTimesheetStatus"
                                                id="teacherTimesheetStatus" value="">
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
                            </div>

                            <div class="finance-timesheet-left-sec mt-5">

                                <div class="finance-timesheet-contact-first-sec">
                                    <?php
                                    $day1Amount_total1 = 0;
                                    $day2Amount_total1 = 0;
                                    $day3Amount_total1 = 0;
                                    $day4Amount_total1 = 0;
                                    $day5Amount_total1 = 0;
                                    foreach ($approvedList as $key => $cal) {
                                        $day1Amount_total1 += $cal->day1Amount_dec;
                                        $day2Amount_total1 += $cal->day2Amount_dec;
                                        $day3Amount_total1 += $cal->day3Amount_dec;
                                        $day4Amount_total1 += $cal->day4Amount_dec;
                                        $day5Amount_total1 += $cal->day5Amount_dec;
                                    }
                                    ?>

                                    <div class="teacher-calendar-days-sec">
                                        <div class="teacher-calendar-days-text">
                                            <p>School</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Teacher</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Monday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day1Amount_total1 }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Tuesday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day2Amount_total1 }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Wednesday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day3Amount_total1 }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Thursday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day4Amount_total1 }}</p>
                                        </div>
                                        <div class="teacher-calendar-days-text">
                                            <p>Friday</p>
                                            <p class="teacher-calendar-bottom-text">{{ $day5Amount_total1 }}</p>
                                        </div>
                                    </div>

                                    <div class="finance-list-text-section">
                                        <div class="teacher-calendar-table-section">

                                            @foreach ($approvedList as $key1 => $calender)
                                                <div class="calendar-outer-sec editApprovTimesheetDiv"
                                                    id="editApprovTimesheetDiv{{ $calender->asn_id }}"
                                                    onclick="timesheetApprovRow('{{ $calender->asn_id }}')">
                                                    <div class="calendar-section">
                                                        <div class="date-left-teacher-calendar">
                                                            <div class="teacher-calendar-days-field3">
                                                                <p>
                                                                    {{ $calender->name_txt }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="date-left-teacher-calendar">
                                                            <div class="teacher-calendar-days-field3">
                                                                <p>
                                                                    @if ($calender->knownAs_txt == null && $calender->knownAs_txt == '')
                                                                        {{ $calender->firstName_txt . ' ' . $calender->surname_txt }}
                                                                    @else
                                                                        {{ $calender->knownAs_txt . ' ' . $calender->surname_txt }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="date-left-teacher-calendar">
                                                            @if ($calender->day1Avail_txt && $calender->day1asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day1LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day1Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar">
                                                            @if ($calender->day2Avail_txt && $calender->day2asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day2Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar">
                                                            @if ($calender->day3Avail_txt && $calender->day3asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day3Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar">
                                                            @if ($calender->day4Avail_txt && $calender->day4asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day4Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                        <div class="date-left-teacher-calendar">
                                                            @if ($calender->day5Avail_txt && $calender->day5asnDate_dte)
                                                                <div
                                                                    class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                    <p>{{ $calender->day5Avail_txt }}</p>
                                                                </div>
                                                            @else
                                                                <div class="teacher-calendar-days-field3"></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                        <input type="hidden" name="" id="approveAsnId" value="">
                                    </div>

                                    <div class="table-assignment-bottom-text-sec">
                                        <div class="table-bottom-text">
                                            {{-- <span>Double-click to open the assignment</span> --}}
                                        </div>

                                        <div class="finance-contact-icon-sec">
                                            {{-- <a style="cursor: pointer" class="disabled-link" id="deleteDaysBttn"
                                                title="Remove days from assignment">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a> --}}
                                            <a style="cursor: pointer;" class="disabled-link" id="sendToSchoolBttn"
                                                title="Send to school">
                                                <i class="fa-sharp fa-solid fa-paper-plane"></i>
                                            </a>
                                            <a style="cursor: pointer" class="disabled-link" id="logTimesheetBtn"
                                                title="Log timesheet">
                                                <i class="fa-solid fa-square-check"></i>
                                            </a>
                                            {{-- <a style="cursor: pointer" id="reloadTimesheetBtn" title="Reload timesheets">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </a> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="finance-timesheet-contact-second-sec" style="display: none;"
                                    id="teacherTimesheetDiv">
                                    <div class="finance-timesheet-table-section" style="margin-top: 0;">
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

    <script>
        function timesheetRow(asn_id) {
            if ($('#editTimesheetDiv' + asn_id).hasClass('timesheetActive')) {
                setIds(asn_id, 'rm');
                $('#editTimesheetDiv' + asn_id).removeClass('timesheetActive');
            } else {
                setIds(asn_id, 'add');
                $('#editTimesheetDiv' + asn_id).addClass('timesheetActive');
            }
        }

        function setIds(asn_id, type) {
            var ItemId = parseInt(asn_id);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#ajaxTimesheetAsnIds').val();
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
            $('#ajaxTimesheetAsnIds').val(ids);
            if (ids) {
                $('#timesheetApproveBtn').removeClass('disabled-link');
                $('#timesheetRejectBtn').removeClass('disabled-link');
                $('#timesheetEditBtn').removeClass('disabled-link');
            } else {
                $('#timesheetApproveBtn').addClass('disabled-link');
                $('#timesheetRejectBtn').addClass('disabled-link');
                $('#timesheetEditBtn').addClass('disabled-link');
            }
        }

        $(document).on('click', '#selectAllBtn', function(event) {
            var timesheetAsnIds = $('#timesheetAsnIds').val();
            if (timesheetAsnIds) {
                var asnIdsArr = timesheetAsnIds.split(",");
                $.each(asnIdsArr, function(index, value) {
                    $('#editTimesheetDiv' + value).addClass('timesheetActive');
                });
                $('#ajaxTimesheetAsnIds').val(timesheetAsnIds);
                $('#timesheetApproveBtn').removeClass('disabled-link');
            }
        });

        $(document).on('click', '#selectNoneBtn', function(event) {
            $('.editTimesheetDiv').removeClass('timesheetActive');
            $('#ajaxTimesheetAsnIds').val('');
            $('#timesheetApproveBtn').addClass('disabled-link');
        });

        $(document).on('click', '#timesheetApproveBtn', function() {
            var asnIds = $('#ajaxTimesheetAsnIds').val();
            if (asnIds) {
                swal({
                        title: "",
                        text: "Are you sure you wish to approve all the selected timesheets?",
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
                                    url: '{{ url('financeTimesheetApprove') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnIds: asnIds,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}"
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#timesheetRejectBtn', function() {
            var asnIds = $('#ajaxTimesheetAsnIds').val();
            if (asnIds) {
                swal({
                        title: "",
                        text: "Are you sure you wish to reject all the selected timesheets?",
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
                                    url: '{{ url('financeTimesheetReject') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnIds: asnIds,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}"
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#timesheetEditBtn', function() {
            var asnIds = $('#ajaxTimesheetAsnIds').val();
            if (asnIds) {
                var idsArr = [];
                idsArr = asnIds.split(',');
                if (idsArr.length == 1) {
                    var location = "{{ url('/assignment-details') }}" + '/' + idsArr[0];
                    window.open(location);
                } else {
                    swal("", "You cannot edit more then one timesheet at a time.");
                }
            } else {
                swal("", "Please select one timesheet.");
            }
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
                // $('#rejectTimesheetBtn').addClass('disabled-link');
                // $('#sendTimesheetBtn').addClass('disabled-link');
                $('#viewTimesheetBtn').addClass('disabled-link');
                // $('#timesheetMailtoBtn').addClass('disabled-link');
            } else {
                $('#teacherTimesheetId').val(teacher_timesheet_id);
                $('#teacherTimesheetStatus').val(status);
                $('#teacherTimesheetMail').val(login_mail);
                $('#teacherTimesheetPath').val(pdf_path);
                $('.selectDocumentRow').removeClass('tableRowActive');
                $('#selectDocumentRow' + teacher_timesheet_id).addClass('tableRowActive');
                // $('#rejectTimesheetBtn').removeClass('disabled-link');
                // $('#sendTimesheetBtn').removeClass('disabled-link');
                $('#viewTimesheetBtn').removeClass('disabled-link');
                // $('#timesheetMailtoBtn').removeClass('disabled-link');
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

        function timesheetApprovRow(asn_id) {
            if ($('#editApprovTimesheetDiv' + asn_id).hasClass('timesheetActive')) {
                $('#approveAsnId').val('');
                $('#editApprovTimesheetDiv' + asn_id).removeClass('timesheetActive');
                $('#sendToSchoolBttn').addClass('disabled-link');
                $('#logTimesheetBtn').addClass('disabled-link');
            } else {
                $('#approveAsnId').val(asn_id);
                $('.editApprovTimesheetDiv').removeClass('timesheetActive');
                $('#editApprovTimesheetDiv' + asn_id).addClass('timesheetActive');
                $('#sendToSchoolBttn').removeClass('disabled-link');
                $('#logTimesheetBtn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#sendToSchoolBttn', function() {
            var approveAsnId = $('#approveAsnId').val();
            if (approveAsnId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to send this timesheet to school?",
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
                                        approveAsnId: approveAsnId,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}"
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#logTimesheetBtn', function() {
            var approveAsnId = $('#approveAsnId').val();
            if (approveAsnId) {
                swal({
                        title: "",
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
                                        approveAsnId: approveAsnId,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}"
                                    },
                                    success: function(data) {
                                        if (data.add == 'Yes') {
                                            $('#sendToSchoolBttn').addClass('disabled-link');
                                            $('#logTimesheetBtn').addClass('disabled-link');
                                            $('#editApprovTimesheetDiv' + approveAsnId)
                                                .remove();
                                            var popTxt =
                                                'You have just logged a timesheet for ' + data
                                                .schoolName +
                                                '. Timesheet ID : ' + data.timesheet_id;
                                            swal("", popTxt);
                                        } else {
                                            location.reload();
                                        }
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });
    </script>
@endsection
