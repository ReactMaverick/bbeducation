@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.school.school_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.school.school_header')

                <div class="school-assignment-sec">


                    <div class="school-assignment-section">
                        <div class="school-assignment-contact-heading-text">
                            <h2>Assignments</h2>
                        </div>
                        <div class="school-assignment-contact-heading">
                            <div class="school-assignment-contact-search">
                                <div class="form-check paid-check school-assignment-paid-check">
                                    <div class="school-assignment-contact-checkbox">
                                        <label for="includeAll">Include All</label>
                                        <input type="checkbox" id="includeAll" name="include" value="1"
                                            <?php
                                            echo app('request')->input('include') == 1 ? 'checked' : ''; ?>>
                                    </div>

                                    <div class="school-assignment-contact-select-field">
                                        <div class="school-assignment-contact-select-label">
                                            <label>Status</label>
                                        </div>
                                        <div class="school-assignment-contact-select-option">
                                            <select id="assignmentStatus" name="status" class="form-control">
                                                <option value="">Choose One</option>
                                                @foreach ($statusList as $key1 => $status)
                                                    <option value="{{ $status->description_int }}" <?php echo app('request')->input('status') == $status->description_int ? 'selected' : ''; ?>>
                                                        {{ $status->description_txt }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="school-assignment-contact-icon-sec">
                                <a style="cursor: pointer;" class="disabled-link" id="deleteAssignmentBttn">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                                <a style="cursor: pointer;" onclick="addAssignment({{ $school_id }})"
                                    title="Add New Assignment">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <a style="cursor: pointer;" class="disabled-link" id="editAssignmentBttn">
                                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                                </a>
                            </div>
                        </div>



                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Year Group</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Days</th>
                                    <th>Teacher</th>
                                    <th>Date</th>
                                    <th>Weekday</th>
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
                                        onclick="assignmentRowSelect({{ $Assignment->asn_id }})"
                                        id="editAssignmentRow{{ $Assignment->asn_id }}">
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
                                                {{ $Assignment->techerFirstname }} {{ $Assignment->techerSurname }}
                                            @else
                                                No teacher
                                            @endif
                                        </td>
                                        <td>
                                            @if ($Assignment->asnStartDate_dte)
                                                {{ date('d-m-Y', strtotime($Assignment->asnStartDate_dte)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($Assignment->asnStartDate_dte)
                                                {{ date('l', strtotime($Assignment->asnStartDate_dte)) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <input type="hidden" name="assignmentId" id="assignmentId" value="{{ $schoolDetail->school_id }}">

                    <div class="assignment-first-sec">
                        <div class="assignment-left-sidebar-section">
                            <div class="school-assignment-sidebar-sec">
                                <div class="assignment-sidebar-data">
                                    <h2>{{ $completeCount }}</h2>
                                </div>
                                <div class="school-assignment-sidebar-sec-text">
                                    <span>Completed Assignments</span>
                                </div>
                            </div>
                            <div class="school-assignment-sidebar-sec">
                                <div class="assignment-sidebar-data2">
                                    <h2>{{ $completeCount }}</h2>
                                </div>
                                <div class="school-assignment-sidebar-sec-text">
                                    <span>Total Days</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: false
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
    </script>
@endsection
