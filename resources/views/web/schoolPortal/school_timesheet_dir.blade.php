<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap"
        rel="stylesheet">
    <script src="{{ asset('web/js/jquery.min.js') }}"></script>

    <style>
        .form-group.has-error {
            border-color: #dd4b39 !important;
        }

        .date-left-teacher-calendar {
            width: 13%
        }

        .teacher-timesheet-btn-outer {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 25px;
        }

        .teacher-timesheet-btn-outer .approve-btn {
            background-color: #70AD47;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 5px 15px;
            margin-left: 15px;
        }

        .teacher-timesheet-btn-outer .reject-btn {
            background-color: #ee0000;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 5px 15px;
            margin-left: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="finance-timesheet-contact-first-sec" style="width: 100%;margin-top: 40px">
            <div class="contact-heading mb-2">
                <div class="contact-heading-text">
                    <h2>Teacher Timesheets</h2>
                </div>
            </div>

            <?php
            $day1Amount_total1 = 0;
            $day2Amount_total1 = 0;
            $day3Amount_total1 = 0;
            $day4Amount_total1 = 0;
            $day5Amount_total1 = 0;
            foreach ($calenderList as $key => $cal) {
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

            <div class="">
                <div class="teacher-calendar-table-section">

                    @foreach ($calenderList as $key1 => $calender)
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

        </div>

        @if (count($calenderList) > 0)
            <div class="teacher-timesheet-btn-outer">
                <button class="approve-btn" id="logTimesheetBtn">Approve</button>
                <button class="reject-btn" id="timesheetRejectBtn">Reject</button>
            </div>
        @endif

    </div>
    <div class="container-fluid reset-password-footer-sec">
        <span>© 2023 All Rights Reserved. by <a href="javascript:vid(0);">Bumblebee</a></span>
    </div>
</body>

<script src="{!! asset('plugins/sweetalert/sweetalert.min.js') !!}"></script>
<?php if (Session::has('success')){ ?>
<script>
    $(document).ready(function() {
        swal(
            'Success!',
            '<?php echo session('success'); ?>',
            'success'
        );
    });
</script>
<?php } ?>
<?php if (Session::has('error')) { ?>
<script>
    $(document).ready(function() {
        swal(
            'Failed!',
            '<?php echo session('error'); ?>'
        );
    });
</script>
<?php } ?>

<script>
    $(document).on('click', '#logTimesheetBtn', function() {
        var asnId = "{{ $asnId }}";
        var school_id = "{{ $school_id }}";
        if (asnId) {
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
                                url: '{{ url('/school/logSchoolTimesheetLogDir') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    approveAsnId: asnId,
                                    school_id: school_id,
                                    weekStartDate: "{{ $weekStartDate }}",
                                    weekEndDate: "{{ $plusFiveDate }}"
                                },
                                success: function(data) {
                                    if (data.add == 'Yes') {
                                        var popTxt =
                                            'You have just logged a timesheet for ' + data
                                            .schoolName +
                                            '. Timesheet ID : ' + data.timesheet_id;
                                        swal("", popTxt);
                                    }
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
        var asnId = "{{ $asnId }}";
        var school_id = "{{ $school_id }}";
        if (asnId) {
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
                                url: '{{ url('/school/logSchoolTimesheetRejectDir') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    asnId: asnId,
                                    school_id: school_id,
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
            swal("", "Something went wrong.");
        }
    });
</script>

</html>
