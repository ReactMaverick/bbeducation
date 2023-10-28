{{-- @extends('web.layout') --}}
@extends('web.assignment.assignment_layout')
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
                    @include('web.assignment.assignment_header')
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

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">

                        <div class="school-finance-right-sec">
                            <div class="row my_row_gap">
                                <div class="col-md-12 col-lg-7 col-xl-7 col-12 col-sm-12">
                                    <div class="assignment-candidate-section sec_box_edit">

                                        <div class="assignment-candidate-sec details-heading">
                                            <div class="assignment-candidate-heading-text">
                                                <h2>Candidates</h2>
                                                {{-- <a href="#"><i class="fa-solid fa-arrows-rotate"></i></a> --}}
                                            </div>
                                            <div class="form-check assignment-candidate-paid-check">
                                                <input type="checkbox" id="showAll" name="showAll" value="1"
                                                    <?php
                                                    echo app('request')->input('showall') == 1 ? 'checked' : ''; ?>><br>
                                                <label for="showAll">Show All</label>
                                            </div>
                                            <div class="finance_eyes">
                                                <div class="finance-contact-icon-sec" style="display: block">
                                                    <a style="cursor: pointer;" id="seeGoogleDistance"
                                                        title="View Distance">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="assignment-candidate-table-section">
                                            <table class="table table-bordered table-striped" id="myTable">
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
                                                            teacher-id="{{ $candidate->teacher_id }}"
                                                            teacher-lat="{{ $candidate->lat_txt }}"
                                                            teacher-long="{{ $candidate->lon_txt }}" isContinuity="1">
                                                            <td>
                                                                @if ($candidate->knownAs_txt == '' || $candidate->knownAs_txt == null)
                                                                    {{ $candidate->firstName_txt }}
                                                                    {{ $candidate->surname_txt }}
                                                                @else
                                                                    {{ $candidate->knownAs_txt }}
                                                                    {{ $candidate->surname_txt }}
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
                                </div>
                                <div class="col-md-12 col-lg-5 col-xl-5 col-12 col-sm-12">
                                    <div class="assignment-candidate-billing-details-section">
                                        <div class="assignment-candidate-billing-details-section-box1 sec_box_edit">
                                            <div class="assignment-candidate-billing-section details-heading">
                                                <div class="assignment-candidate-billing-details-heading">
                                                    <h2>Continuity List</h2>
                                                    {{-- <a href="#"><i class="fa-solid fa-arrows-rotate"></i></a> --}}
                                                </div>
                                                <div class="assignment-candidate-second-icon-section">
                                                    <a style="cursor: pointer" class="disabled-link" id="addPreferredBtn">
                                                        <i class="far fa-check-circle"></i>
                                                    </a>
                                                    {{-- <a style="cursor: pointer" class="disabled-link" id="deletaPreferredBtn">
                                                        <i class="fa-solid fa-xmark cancel-icon"></i>
                                                    </a> --}}
                                                </div>
                                            </div>

                                            <div class="assignment-candidate-table-section ">
                                                <table class="table table-bordered table-striped" id="myTable1">
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
                                                                teacher-id="{{ $continuity->teacher_id }}"
                                                                teacher-lat="{{ $continuity->lat_txt }}"
                                                                teacher-long="{{ $continuity->lon_txt }}" isContinuity="2">
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
                                        </div>

                                        <div class="assignment-candidate-billing-details-section-box2 sec_box_edit">
                                            <div class="assignment-candidate-billing-section details-heading">
                                                <div class="assignment-candidate-billing-details-heading">
                                                    <h2>Preferred List</h2>
                                                </div>
                                            </div>

                                            <div class="assignment-candidate-table-section">
                                                <table class="table table-bordered table-striped" id="myTable2">
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
                                                                teacher-id="{{ $prefered->teacher_id }}"
                                                                teacher-lat="{{ $prefered->lat_txt }}"
                                                                teacher-long="{{ $prefered->lon_txt }}" isContinuity="3">
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

                                        </div>


                                        <input type="hidden" name="" id="assignTeacherId" value="">
                                        <input type="hidden" name="" id="preferTeacherId" value="">
                                        <input type="hidden" name="" id="candidateLatId" value="">
                                        <input type="hidden" name="" id="candidateLongId" value="">
                                        <input type="hidden" name="" id="schoolLatId" value="{{ $v_schoolLat }}">
                                        <input type="hidden" name="" id="schoolLongId" value="{{ $v_schoolLon }}">


                                    </div>
                                </div>
                            </div>

                            <div class="assignment-candidate-check-icon">
                                <a style="cursor: pointer" class="disabled-link skl_new_check" id="teacherAssignBtn"
                                    title="Assign Teacher">
                                    <span class="svg_icon assignmentComplete">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                            x="0" y="0" viewBox="0 0 512 511" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve" class="">
                                            <g>
                                                <path
                                                    d="M512 256.5c0 50.531-15 99.672-43.375 142.113-3.855 5.77-10.191 8.887-16.645 8.887-3.82 0-7.683-1.09-11.097-3.375-9.184-6.137-11.649-18.559-5.512-27.742C459.336 340.543 472 299.09 472 256.5c0-18.3-2.29-36.477-6.805-54.016-2.754-10.695 3.688-21.601 14.383-24.355 10.703-2.75 21.602 3.687 24.356 14.383C509.285 213.309 512 234.836 512 256.5zM367.734 441.395C334.141 461.742 295.504 472.5 256 472.5c-119.102 0-216-96.898-216-216s96.898-216 216-216c44.098 0 86.5 13.195 122.629 38.16 9.086 6.278 21.543 4 27.824-5.086 6.277-9.086 4.004-21.543-5.086-27.824C358.523 16.148 308.257.5 256 .5 187.621.5 123.332 27.129 74.98 75.48 26.63 123.832 0 188.121 0 256.5s26.629 132.668 74.98 181.02C123.332 485.87 187.621 512.5 256 512.5c46.813 0 92.617-12.758 132.46-36.895 9.45-5.722 12.47-18.02 6.747-27.468-5.727-9.45-18.023-12.465-27.473-6.742zM257.93 314.492c-3.168.125-6.125-1-8.422-3.187l-104.746-99.317c-8.016-7.601-20.676-7.265-28.274.75-7.601 8.016-7.265 20.676.75 28.274l104.727 99.3c9.672 9.196 22.183 14.188 35.441 14.188.711 0 1.422-.016 2.133-.043 14.043-.566 26.941-6.644 36.316-17.117.239-.262.465-.531.688-.809l211.043-262.5c6.922-8.61 5.555-21.199-3.055-28.117-8.605-6.922-21.199-5.555-28.12 3.055L265.78 310.957a11.434 11.434 0 0 1-7.851 3.535zm0 0"
                                                    fill="#000000" opacity="1" data-original="#000000"
                                                    class=""></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    {{-- <div id="distanceModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="mapContainer" style="height: 400px;"></div>
            <div id="drivingDistance"></div>
            <div id="transitDistance"></div>
        </div>
    </div> --}}
    <div class="modal" id="distanceModal" style="background: #02020287;">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">View Distance</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="mapContainer" style="height: 450px;"></div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnb0OgWwplLJkMhPK0JheuRBY-Nw2IyBg&libraries=places">
    </script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                scrollY: '500px', // Set the desired height for the scrolling area
                paging: false, // Disable pagination
                // footer: false, // Remove footer
                info: false, // Disable the info footer
                ordering: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
            $('#myTable1, #myTable2').DataTable({
                scrollY: '150px', // Set the desired height for the scrolling area
                paging: false, // Disable pagination
                // footer: false, // Remove footer
                info: false, // Disable the info footer
                ordering: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
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
                    var candidateLatId = $(this).attr('teacher-lat');
                    var candidateLongId = $(this).attr('teacher-long');
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
                                    $('#candidateLatId').val('');
                                    $('#candidateLongId').val('');
                                    $('#selectCandidate' + teacherId).removeClass('tableRowActive');
                                    $('#teacherAssignBtn').addClass('disabled-link');
                                } else {
                                    $('#assignTeacherId').val(teacherId);
                                    $('#candidateLatId').val(candidateLatId);
                                    $('#candidateLongId').val(candidateLongId);
                                    $('.selectTeacherRow').removeClass('tableRowActive');
                                    $('#selectCandidate' + teacherId).addClass('tableRowActive');
                                    $('#teacherAssignBtn').removeClass('disabled-link');
                                }
                            }
                            if (isContinuity == 2) {
                                if ($('#selectContinuity' + teacherId).hasClass('tableRowActive')) {
                                    $('#assignTeacherId').val('');
                                    $('#preferTeacherId').val('');
                                    $('#candidateLatId').val('');
                                    $('#candidateLongId').val('');
                                    $('#selectContinuity' + teacherId).removeClass('tableRowActive');
                                    $('#teacherAssignBtn').addClass('disabled-link');
                                    $('#addPreferredBtn').addClass('disabled-link');
                                } else {
                                    $('#assignTeacherId').val(teacherId);
                                    $('#preferTeacherId').val(teacherId);
                                    $('#candidateLatId').val(candidateLatId);
                                    $('#candidateLongId').val(candidateLongId);
                                    $('.selectTeacherRow').removeClass('tableRowActive');
                                    $('#selectContinuity' + teacherId).addClass('tableRowActive');
                                    $('#teacherAssignBtn').removeClass('disabled-link');
                                    $('#addPreferredBtn').removeClass('disabled-link');
                                }
                            }
                            if (isContinuity == 3) {
                                if ($('#selectPreferred' + teacherId).hasClass('tableRowActive')) {
                                    $('#assignTeacherId').val('');
                                    $('#candidateLatId').val('');
                                    $('#candidateLongId').val('');
                                    $('#selectPreferred' + teacherId).removeClass('tableRowActive');
                                    $('#teacherAssignBtn').addClass('disabled-link');
                                } else {
                                    $('#assignTeacherId').val(teacherId);
                                    $('#candidateLatId').val(candidateLatId);
                                    $('#candidateLongId').val(candidateLongId);
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
                        var candidateLatId = $(this).attr('teacher-lat');
                        var candidateLongId = $(this).attr('teacher-long');
                        var isContinuity = $(this).attr('isContinuity');
                        if (isContinuity == 1) {
                            if ($('#selectCandidate' + teacherId).hasClass('tableRowActive')) {
                                $('#assignTeacherId').val('');
                                $('#candidateLatId').val('');
                                $('#candidateLongId').val('');
                                $('#selectCandidate' + teacherId).removeClass('tableRowActive');
                                $('#teacherAssignBtn').addClass('disabled-link');
                            } else {
                                $('#assignTeacherId').val(teacherId);
                                $('#candidateLatId').val(candidateLatId);
                                $('#candidateLongId').val(candidateLongId);
                                $('.selectTeacherRow').removeClass('tableRowActive');
                                $('#selectCandidate' + teacherId).addClass('tableRowActive');
                                $('#teacherAssignBtn').removeClass('disabled-link');
                            }
                        }
                        if (isContinuity == 2) {
                            if ($('#selectContinuity' + teacherId).hasClass('tableRowActive')) {
                                $('#assignTeacherId').val('');
                                $('#preferTeacherId').val('');
                                $('#candidateLatId').val('');
                                $('#candidateLongId').val('');
                                $('#selectContinuity' + teacherId).removeClass('tableRowActive');
                                $('#teacherAssignBtn').addClass('disabled-link');
                                $('#addPreferredBtn').addClass('disabled-link');
                            } else {
                                $('#assignTeacherId').val(teacherId);
                                $('#preferTeacherId').val(teacherId);
                                $('#candidateLatId').val(candidateLatId);
                                $('#candidateLongId').val(candidateLongId);
                                $('.selectTeacherRow').removeClass('tableRowActive');
                                $('#selectContinuity' + teacherId).addClass('tableRowActive');
                                $('#teacherAssignBtn').removeClass('disabled-link');
                                $('#addPreferredBtn').removeClass('disabled-link');
                            }
                        }
                        if (isContinuity == 3) {
                            if ($('#selectPreferred' + teacherId).hasClass('tableRowActive')) {
                                $('#assignTeacherId').val('');
                                $('#candidateLatId').val('');
                                $('#candidateLongId').val('');
                                $('#selectPreferred' + teacherId).removeClass('tableRowActive');
                                $('#teacherAssignBtn').addClass('disabled-link');
                            } else {
                                $('#assignTeacherId').val(teacherId);
                                $('#candidateLatId').val(candidateLatId);
                                $('#candidateLongId').val(candidateLongId);
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
                    var candidateLatId = $(this).attr('teacher-lat');
                    var candidateLongId = $(this).attr('teacher-long');
                    $('#candidateLatId').val(candidateLatId);
                    $('#candidateLongId').val(candidateLongId);
                    var location = "{{ url('/candidate-detail') }}" + '/' + teacherId;
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

        $(document).on('click', '#seeGoogleDistance', function() {
            var assignTeacherId = $('#assignTeacherId').val();
            var schoolId = "{{ $schoolId }}";
            if (assignTeacherId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('fetchSchNTeacherAddress') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        schoolId: schoolId,
                        assignTeacherId: assignTeacherId
                    },
                    success: function(data) {
                        // console.log(data);
                        var startAddress = data.schAddress;
                        var destAddress = data.teacherAddress;
                        // Encode addresses for URL
                        var encodedStartAddress = encodeURIComponent(startAddress);
                        var encodedDestAddress = encodeURIComponent(destAddress);
                        // Construct the URL with the parameters
                        var mapUrl = 'https://www.google.com/maps/dir/' + encodedStartAddress + '/' +
                            encodedDestAddress;

                        // Open Google Maps in a new window or tab
                        window.open(mapUrl);
                    }
                });
            } else {
                swal("", "Please select one teacher.");
            }
            // var startLat = parseFloat($('#schoolLatId').val());
            // var startLng = parseFloat($('#schoolLongId').val());
            // var destLat = parseFloat($('#candidateLatId').val());
            // var destLng = parseFloat($('#candidateLongId').val());

            // if (startLat == NaN && startLng == NaN) {
            //     swal("", "Please update school latitude and longitude.");
            // } else if (assignTeacherId == null || assignTeacherId == '') {
            //     swal("", "Please select one teacher.");
            // } else if (destLat == 0 && destLng == 0) {
            //     swal("", "Please update teacher latitude and longitude.");
            // } else {
            //     // Construct the URL with the parameters
            //     var mapUrl = 'https://www.google.com/maps/dir/' + startLat + ',' + startLng + '/' + destLat + ',' +
            //         destLng;

            //     // Open Google Maps in a new window or tab
            //     window.open(mapUrl);
            // }
        });

        $(document).ready(function() {
            $('.close').click(function() {
                $('#distanceModal').hide();
            });
        });
    </script>
@endsection
