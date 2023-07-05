@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.assignment.assignment_sidebar')

            <div class="col-md-10 topbar-sec">
                <div class="topbar-Section">
                    <i class="fa-solid fa-crown"></i>
                    <a style="cursor: pointer"> <i class="fa-solid fa-trash trash-icon"></i></a>
                </div>
                <div class="school-finance-right-sec">

                    <div class="assignment-candidate-section">

                        <div class="assignment-candidate-sec">
                            <div class="assignment-candidate-heading-text">
                                <h2>Candidates</h2>
                                {{-- <a href="#"><i class="fa-solid fa-arrows-rotate"></i></a> --}}
                            </div>
                            <div class="form-check assignment-candidate-paid-check">
                                <input type="checkbox" id="showAll" name="showAll" value="1" <?php
                                echo app('request')->input('showall') == 1 ? 'checked' : ''; ?>><br>
                                <label for="showAll">Show All</label>
                            </div>
                        </div>

                        <div class="assignment-candidate-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Distance</th>
                                        <th>Availability</th>
                                        <th>Specialism</th>
                                        <th>Days Here</th>
                                        <th>Age Range</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($candidateList as $key => $candidate)
                                        <tr class="school-detail-table-data selectTeacherRow"
                                            id="selectCandidate{{ $candidate->teacher_id }}"
                                            teacher-id="{{ $candidate->teacher_id }}" isContinuity="1">
                                            <td>
                                                @if ($candidate->knownAs_txt == '' || $candidate->knownAs_txt == null)
                                                    {{ $candidate->firstName_txt }} {{ $candidate->surname_txt }}
                                                @else
                                                    {{ $candidate->knownAs_txt }} {{ $candidate->surname_txt }}
                                                @endif
                                            </td>
                                            <td>{{ $candidate->status_txt }}</td>
                                            <td>{{ $candidate->distance_dec }}</td>
                                            <td>{{ $candidate->availability_dec }}</td>
                                            <td>
                                                <?php
                                                if ($asnDet->subject_int != null || $asnDet->subject_int != '') {
                                                    if ($candidate->subjectTeacherId != null || $candidate->subjectTeacherId != '') {
                                                        echo 'Specialist';
                                                    } else {
                                                        echo 'Supply Cover';
                                                    }
                                                } else {
                                                    if ($asnDet->yearGroup_int != null || $asnDet->yearGroup_int != '') {
                                                        if ($candidate->prefYearGroup_int == $asnDet->yearGroup_int) {
                                                            echo 'Year Group Favourite';
                                                        } else {
                                                            echo 'Qualified';
                                                        }
                                                    } else {
                                                        echo 'Unknown';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>0</td>
                                            <td>{{ $candidate->ageRangeSpecialism_txt }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="assignment-candidate-billing-details-section">
                        <div class="assignment-candidate-billing-section">
                            <div class="assignment-candidate-billing-details-heading">
                                <span>Continuity List</span>
                                {{-- <a href="#"><i class="fa-solid fa-arrows-rotate"></i></a> --}}
                            </div>
                            <div class="assignment-candidate-second-icon-section">
                                <a style="cursor: pointer" class="disabled-link" id="addPreferredBtn">
                                    <i class="fa-solid fa-square-check check-icon"></i>
                                </a>
                                {{-- <a style="cursor: pointer" class="disabled-link" id="deletaPreferredBtn">
                                    <i class="fa-solid fa-xmark cancel-icon"></i>
                                </a> --}}
                            </div>
                        </div>

                        <div class="assignment-candidate-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Days Worked</th>
                                        <th>Preferred</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($continuityList as $key => $continuity)
                                        <tr class="school-detail-table-data selectTeacherRow"
                                            id="selectContinuity{{ $continuity->teacher_id }}"
                                            teacher-id="{{ $continuity->teacher_id }}" isContinuity="2">
                                            <td>
                                                @if ($continuity->knownAs_txt == null || $continuity->knownAs_txt == '')
                                                    {{ $continuity->firstName_txt . ' ' . $continuity->surname_txt }}
                                                @else
                                                    {{ $continuity->firstName_txt . ' (' . $continuity->knownAs_txt . ') ' . $continuity->surname_txt }}
                                                @endif
                                            </td>
                                            <td>{{ $continuity->status_txt }}</td>
                                            <td>{{ $continuity->daysWorked_dec }}</td>
                                            <td>
                                                @if ($continuity->rejectOrPreferred_int == 1)
                                                    {{ 'Preferred' }}
                                                @elseif ($continuity->rejectOrPreferred_int == 2)
                                                    {{ 'Rejected' }}
                                                @else
                                                    {{ '' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="assignment-candidate-billing-section">
                            <div class="assignment-candidate-billing-details-heading">
                                <span>Preferred List</span>
                            </div>
                        </div>

                        <div class="assignment-candidate-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Name</th>
                                        <th>Preferred</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($preferedList as $key => $prefered)
                                        <tr class="school-detail-table-data selectTeacherRow"
                                            id="selectPreferred{{ $prefered->teacher_id }}"
                                            teacher-id="{{ $prefered->teacher_id }}" isContinuity="3">
                                            <td>
                                                @if ($prefered->knownAs_txt == null || $prefered->knownAs_txt == '')
                                                    {{ $prefered->firstName_txt . ' ' . $prefered->surname_txt }}
                                                @else
                                                    {{ $prefered->firstName_txt . ' (' . $prefered->knownAs_txt . ') ' . $prefered->surname_txt }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($prefered->rejectOrPreferred_int == 1)
                                                    {{ 'Preferred' }}
                                                @elseif ($prefered->rejectOrPreferred_int == 2)
                                                    {{ 'Rejected' }}
                                                @else
                                                    {{ '' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="" id="assignTeacherId" value="">
                        <input type="hidden" name="" id="preferTeacherId" value="">

                        <div class="assignment-candidate-check-icon">
                            <a style="cursor: pointer" class="disabled-link" id="teacherAssignBtn" title="Assign Teacher">
                                <i class="fa-solid fa-square-check"></i>
                            </a>
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

        $(document).on('change', '#showAll', function() {
            if ($(this).is(":checked")) {
                filtering(1);
            } else {
                filtering('');
            }
        });

        function filtering(showall) {
            //alert(sort_val);
            var qUrl = ""
            var current_url = window.location.href;
            var base_url = current_url.split("?")[0];
            var hashes = current_url.split("?")[1];
            var hash = hashes.split('&');
            for (var i = 0; i < hash.length; i++) {
                params = hash[i].split("=");
                if (params[0] == 'showall') {
                    params[1] = showall;
                }
                paramJoin = params.join("=");
                qUrl = "" + qUrl + paramJoin + "&";
            }
            if (qUrl != '') {
                qUrl = qUrl.substr(0, qUrl.length - 1);
            }

            var joinUrl = base_url + "?" + qUrl
            window.location.assign(joinUrl);
        }

        var DELAY = 200,
            clicks = 0,
            timer = null;

        $(function() {

            $(document).on("click", ".selectTeacherRow", function(e) {
                    clicks++; //count clicks
                    var teacherId = $(this).attr('teacher-id');
                    var isContinuity = $(this).attr('isContinuity');
                    // alert(teacherId)
                    if (clicks === 1) {
                        timer = setTimeout(function() {
                            // alert("Single Click=>"+teacherId); //perform single-click action
                            $('#assignTeacherId').val('');
                            $('#preferTeacherId').val('');
                            $('#teacherAssignBtn').addClass('disabled-link');
                            $('#addPreferredBtn').addClass('disabled-link');

                            if (isContinuity == 1) {
                                if ($('#selectCandidate' + teacherId).hasClass('tableRowActive')) {
                                    $('#assignTeacherId').val('');
                                    $('#selectCandidate' + teacherId).removeClass('tableRowActive');
                                    $('#teacherAssignBtn').addClass('disabled-link');
                                } else {
                                    $('#assignTeacherId').val(teacherId);
                                    $('.selectTeacherRow').removeClass('tableRowActive');
                                    $('#selectCandidate' + teacherId).addClass('tableRowActive');
                                    $('#teacherAssignBtn').removeClass('disabled-link');
                                }
                            }
                            if (isContinuity == 2) {
                                if ($('#selectContinuity' + teacherId).hasClass('tableRowActive')) {
                                    $('#assignTeacherId').val('');
                                    $('#preferTeacherId').val('');
                                    $('#selectContinuity' + teacherId).removeClass('tableRowActive');
                                    $('#teacherAssignBtn').addClass('disabled-link');
                                    $('#addPreferredBtn').addClass('disabled-link');
                                } else {
                                    $('#assignTeacherId').val(teacherId);
                                    $('#preferTeacherId').val(teacherId);
                                    $('.selectTeacherRow').removeClass('tableRowActive');
                                    $('#selectContinuity' + teacherId).addClass('tableRowActive');
                                    $('#teacherAssignBtn').removeClass('disabled-link');
                                    $('#addPreferredBtn').removeClass('disabled-link');
                                }
                            }
                            if (isContinuity == 3) {
                                if ($('#selectPreferred' + teacherId).hasClass('tableRowActive')) {
                                    $('#assignTeacherId').val('');
                                    $('#selectPreferred' + teacherId).removeClass('tableRowActive');
                                    $('#teacherAssignBtn').addClass('disabled-link');
                                } else {
                                    $('#assignTeacherId').val(teacherId);
                                    $('.selectTeacherRow').removeClass('tableRowActive');
                                    $('#selectPreferred' + teacherId).addClass('tableRowActive');
                                    $('#teacherAssignBtn').removeClass('disabled-link');
                                }
                            }

                            clicks = 0; //after action performed, reset counter
                        }, DELAY);
                    } else {
                        clearTimeout(timer); //prevent single-click action
                        // alert("Double Click=>" + teacherId); //perform double-click action
                        var teacherId = $(this).attr('teacher-id');
                        var isContinuity = $(this).attr('isContinuity');
                        if (isContinuity == 1) {
                            if ($('#selectCandidate' + teacherId).hasClass('tableRowActive')) {
                                $('#assignTeacherId').val('');
                                $('#selectCandidate' + teacherId).removeClass('tableRowActive');
                                $('#teacherAssignBtn').addClass('disabled-link');
                            } else {
                                $('#assignTeacherId').val(teacherId);
                                $('.selectTeacherRow').removeClass('tableRowActive');
                                $('#selectCandidate' + teacherId).addClass('tableRowActive');
                                $('#teacherAssignBtn').removeClass('disabled-link');
                            }
                        }
                        if (isContinuity == 2) {
                            if ($('#selectContinuity' + teacherId).hasClass('tableRowActive')) {
                                $('#assignTeacherId').val('');
                                $('#preferTeacherId').val('');
                                $('#selectContinuity' + teacherId).removeClass('tableRowActive');
                                $('#teacherAssignBtn').addClass('disabled-link');
                                $('#addPreferredBtn').addClass('disabled-link');
                            } else {
                                $('#assignTeacherId').val(teacherId);
                                $('#preferTeacherId').val(teacherId);
                                $('.selectTeacherRow').removeClass('tableRowActive');
                                $('#selectContinuity' + teacherId).addClass('tableRowActive');
                                $('#teacherAssignBtn').removeClass('disabled-link');
                                $('#addPreferredBtn').removeClass('disabled-link');
                            }
                        }
                        if (isContinuity == 3) {
                            if ($('#selectPreferred' + teacherId).hasClass('tableRowActive')) {
                                $('#assignTeacherId').val('');
                                $('#selectPreferred' + teacherId).removeClass('tableRowActive');
                                $('#teacherAssignBtn').addClass('disabled-link');
                            } else {
                                $('#assignTeacherId').val(teacherId);
                                $('.selectTeacherRow').removeClass('tableRowActive');
                                $('#selectPreferred' + teacherId).addClass('tableRowActive');
                                $('#teacherAssignBtn').removeClass('disabled-link');
                            }
                        }

                        clicks = 0; //after action performed, reset counter
                    }
                })
                .on("dblclick", ".selectTeacherRow", function(e) {
                    e.preventDefault(); //cancel system double-click event
                    var teacherId = $(this).attr('teacher-id');
                    var location = "{{ url('/teacher-detail') }}" + '/' + teacherId;
                    window.open(location);
                });
        });

        $(document).on('click', '#addPreferredBtn', function() {
            var preferTeacherId = $('#preferTeacherId').val();
            var SchoolId = "{{ $assignmentDetail->school_id }}";
            if (preferTeacherId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('addAsnPreferredTeacher') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        preferTeacherId: preferTeacherId,
                        SchoolId: SchoolId
                    },
                    success: function(data) {
                        if (data) {
                            location.reload();
                        }
                    }
                });
            } else {
                swal("", "Please select one teacher.");
            }
        });

        $(document).on('click', '#teacherAssignBtn', function() {
            var assignTeacherId = $('#assignTeacherId').val();
            var asn_id = "{{ $asn_id }}";
            if (assignTeacherId) {
                swal({
                        title: "Alert",
                        text: "Do you want to confirm this teacher at the same time?",
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
                                    url: '{{ url('updateAssignmentTeacher') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        assignTeacherId: assignTeacherId,
                                        asn_id: asn_id
                                    },
                                    success: function(data) {
                                        if (data) {
                                            location.reload();
                                        }
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one teacher.");
            }
        });
    </script>
@endsection
