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

                        <div class="school-assignment-sec">


                            <div class="school-assignment-section sec_box_edit">
                                <div class="school-assignment-contact-heading-text details-heading new_gh">
                                    <h2>Assignments</h2>

                                    <div class="school-assignment-contact-heading">
                                        <div class="school-assignment-contact-search">
                                            <div class="form-check paid-check school-assignment-paid-check">
                                                <div class="school-assignment-contact-checkbox">
                                                    <label class="sg_label" for="includeAll">Include All</label>
                                                    <input type="checkbox" id="includeAll" name="include" value="1"
                                                        <?php
                                                        echo app('request')->input('include') == 1 ? 'checked' : ''; ?>>
                                                </div>

                                                <div class="school-assignment-contact-select-field">
                                                    <div class="school-assignment-contact-select-label">
                                                        <label class="sg_label">Status</label>
                                                    </div>
                                                    <div class="school-assignment-contact-select-option">
                                                        <select id="assignmentStatus" name="status"
                                                            class="form-control nw_formcontrol">
                                                            <option value="">Choose One</option>
                                                            @foreach ($statusList as $key1 => $status)
                                                                <option value="{{ $status->description_int }}"
                                                                    <?php echo app('request')->input('status') == $status->description_int ? 'selected' : ''; ?>>
                                                                    {{ $status->description_txt }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="school-assignment-contact-icon-sec">
                                            <a style="cursor: pointer;" class="disabled-link icon_all"
                                                id="deleteAssignmentBttn">
                                                <i class="fas fa-trash-alt trash-icon"></i>
                                            </a>
                                            <a style="cursor: pointer;" onclick="addAssignment({{ $school_id }})"
                                                title="Add New Assignment" class="icon_all">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                            <a style="cursor: pointer;" class="disabled-link icon_all"
                                                id="editAssignmentBttn">
                                                <i class="fas fa-edit school-edit-icon"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="assignment-finance-table-section">
                                    <table class="table table-bordered table-striped" id="myTable">
                                        <thead>
                                            <tr class="school-detail-table-heading">
                                                <th>Year Group</th>
                                                <th>Status</th>
                                                <th>Type</th>
                                                <th>Days</th>
                                                <th>Teacher</th>
                                                <th>Date</th>
                                                <th>Weekday</th>
                                                <th>Pay</th>
                                                <th>Charge</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body-sec">
                                            @foreach ($assignmentList as $key => $Assignment)
                                                <?php
                                                $yDescription = '';
                                                if (in_array($Assignment->ageRange_int, ['1', '2', '3', '4'])) {
                                                    if ($Assignment->yearGroup_int != null) {
                                                        $yDescription .= $Assignment->yearGroupTxt;
                                                    } else {
                                                        $yDescription .= '';
                                                    }
                                                    if ($Assignment->subject_int != null && $Assignment->yearGroup_int != null) {
                                                        $yDescription .= ' - ';
                                                    } else {
                                                        $yDescription .= '';
                                                    }
                                                    if ($Assignment->subject_int != null) {
                                                        $yDescription .= $Assignment->subjectTxt;
                                                    } else {
                                                        $yDescription .= '';
                                                    }
                                                } else {
                                                    $yDescription .= $Assignment->subjectTxt;
                                                }
                                                
                                                ?>
                                                <tr class="table-data editAssignmentRow"
                                                    id="editAssignmentRow{{ $Assignment->asn_id }}"
                                                    asn-id="{{ $Assignment->asn_id }}">
                                                    <td>
                                                        @if ($yDescription == null || $yDescription == '')
                                                            {{ $Assignment->yearGroup }}
                                                        @else
                                                            {{ $yDescription }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $Assignment->assignmentStatus }}</td>
                                                    <td>{{ $Assignment->assignmentType }}</td>
                                                    <td>{{ $Assignment->days_dec }} {{ $Assignment->type_txt }}</td>
                                                    <td>
                                                        @if ($Assignment->techerFirstname || $Assignment->techerSurname)
                                                            {{ $Assignment->techerFirstname }}
                                                            {{ $Assignment->techerSurname }}
                                                        @else
                                                            No teacher
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($Assignment->asnStartDate_dte)
                                                            {{ date('d M Y', strtotime($Assignment->asnStartDate_dte)) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($Assignment->asnStartDate_dte)
                                                            {{ date('l', strtotime($Assignment->asnStartDate_dte)) }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $Assignment->cost_dec }}</td>
                                                    <td>{{ $Assignment->charge_dec }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <input type="hidden" name="assignmentId" id="assignmentId"
                                value="{{ $schoolDetail->school_id }}">

                            <div class="assignment-first-sec">
                                <div class="assignment-left-sidebar-section">
                                    <div class="row pt-3">
                                        <div class="col-lg-3 col-6">
                                            <div class="references-bottom-sec small-box bg-info">
                                                <div class="inner">
                                                    <h3>{{ $completeCount }}</h3>
                                                    <p>Completed Assignments</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-receipt"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-6">
                                            <div class="references-bottom-sec small-box bg-success">
                                                <div class="inner">
                                                    <h3>{{ $completeCount }}</h3>
                                                    <p>Total Days</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-receipt"></i>
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

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: false,
                pageLength: 25,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        $(document).ready(function() {
            // Single click event for row selection
            $('.editAssignmentRow').on('click', function(event) {
                var asn_id = $(this).attr('asn-id');
                assignmentRowSelect(asn_id);
            });

            // Double click event for opening URL in a new tab
            $('.editAssignmentRow').on('dblclick', function(event) {
                var asn_id = $(this).attr('asn-id');
                assignmentRowSelect(asn_id);

                window.location.href =
                    "{{ URL::to('/assignment-details') }}" + '/' + asn_id;
            });
        });

        function assignmentRowSelect(asn_id) {
            if ($('#editAssignmentRow' + asn_id).hasClass('tableRowActive')) {
                $('#assignmentId').val('');
                $('#editAssignmentRow' + asn_id).removeClass('tableRowActive');
                $('#deleteAssignmentBttn').addClass('disabled-link');
                $('#editAssignmentBttn').addClass('disabled-link');
            } else {
                $('#assignmentId').val(asn_id);
                $('.editAssignmentRow').removeClass('tableRowActive');
                $('#editAssignmentRow' + asn_id).addClass('tableRowActive');
                $('#deleteAssignmentBttn').removeClass('disabled-link');
                $('#editAssignmentBttn').removeClass('disabled-link');
            }
        }

        $(document).on('change', '#includeAll', function() {
            if ($(this).is(":checked")) {
                $('#assignmentStatus').val('');
                filtering(1, '');
            } else {
                $('#assignmentStatus').val(3);
                filtering('', 3);
            }
        });

        $(document).on('change', '#assignmentStatus', function() {
            var assignmentStatus = $(this).val();
            if (assignmentStatus != '') {
                $('#includeAll').prop('checked', false);
                filtering('', assignmentStatus);
            } else {
                $('#includeAll').prop('checked', true);
                filtering(1, '');
            }
        });

        function filtering(include, status) {
            //alert(sort_val);
            var qUrl = ""
            var current_url = window.location.href;
            var base_url = current_url.split("?")[0];
            var hashes = current_url.split("?")[1];
            var hash = hashes.split('&');
            for (var i = 0; i < hash.length; i++) {
                params = hash[i].split("=");
                if (params[0] == 'include') {
                    params[1] = include;
                }
                if (params[0] == 'status') {
                    params[1] = status;
                }
                paramJoin = params.join("=");
                qUrl = "" + qUrl + paramJoin + "&";
            }
            if (qUrl != '') {
                qUrl = qUrl.substr(0, qUrl.length - 1);
            }

            var joinUrl = base_url + "?" + qUrl
            //alert("My favourite sports are: " + joinUrl);
            window.location.assign(joinUrl);
        }

        function addAssignment(school_id) {
            if (school_id) {
                swal({
                        title: "",
                        text: "This will create an assignment tied to the select school.",
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
                                    url: '{{ url('createNewAssignment') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        school_id: school_id
                                    },
                                    success: function(data) {
                                        if (data) {
                                            if (data.login == 'yes') {
                                                if (data.asn_id) {
                                                    window.location.href =
                                                        "{{ URL::to('/assignment-details') }}" + '/' + data
                                                        .asn_id;
                                                }
                                            } else {
                                                window.location.href = "{{ URL::to('/') }}";
                                            }
                                        }
                                    }
                                });
                        }
                    });
            }
        }

        $(document).on('click', '#editAssignmentBttn', function() {
            var assignmentId = $('#assignmentId').val();
            if (assignmentId) {
                window.location.href =
                    "{{ URL::to('/assignment-details') }}" + '/' + assignmentId;
            } else {
                swal("", "Please select one assignment.");
            }
        });

        $(document).on('click', '#deleteAssignmentBttn', function() {
            var assignmentId = $('#assignmentId').val();
            if (assignmentId) {
                schoolAssignmentDelete(assignmentId);
            } else {
                swal("", "Please select one assignment.");
            }
        });

        function schoolAssignmentDelete(asn_id) {
            $.ajax({
                type: 'POST',
                url: '{{ url('checkAsssignmentUsed') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    asn_id: asn_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.exist == 'Yes') {
                        swal("",
                            "You cannot delete this assignment because timesheet(s) or contact logs exist for it.",
                            "warning"
                        );
                    } else {
                        assignmentDeleteAjax(asn_id)
                    }
                }
            });
        }

        function assignmentDeleteAjax(asn_id) {
            swal({
                    title: "",
                    text: "Are you sure you want to completely delete this assignment?",
                    buttons: {
                        Yes: "Yes",
                        cancel: "No"
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "Yes":
                            $('#fullLoader').show();
                            $.ajax({
                                type: 'POST',
                                url: '{{ url('delete_assignment') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    asn_id: asn_id
                                },
                                dataType: "json",
                                success: function(data) {
                                    location.reload();
                                }
                            });
                    }
                });
        }
    </script>
@endsection
