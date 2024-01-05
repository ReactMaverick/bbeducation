{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="tab-content dashboard-tab-content" id="myTabContent">
        <div class="assignment-section-col">

            <div class="teacher-all-section pt-3">
                <div class="container-fluid">
                    <div class="row gap_50 justify-content-around">
                        <div class="col-md-6 pr-5 pl-2 mob_pr_0">
                            <div class="teacher-section skd_new_edit">
                                <div class="teacher-page-sec skd_new_edit_heading details-heading">
                                    <h2>Teachers</h2>
                                </div>
                                <div class="teacher-left-sec skd_row dataTables_wrapper">
                                    <div class="about-teacher skd_icon_box small-box bg-info">
                                        <a class="" href="{{ URL::to('/candidate-search') }}">
                                            <div class="inner text-white">
                                                <p>Find Teacher</p>
                                            </div>
                                            <div class="icon"><i class="fas fa-search"></i></div>
                                        </a>
                                    </div>

                                    <div class="about-teacher skd_icon_box small-box bg-success">
                                        <a class="" href="{{ URL::to('/candidate-calendar') }}">
                                            <div class="inner text-white">
                                                <p>Teacher</p>
                                                <p>Calendar</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="about-teacher skd_icon_box small-box bg-warning">
                                        <a class="" style="cursor: pointer" id="addNewTeacherBttn">
                                            <div class="inner text-white">
                                                <p>New Teacher</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="about-teacher skd_icon_box small-box bg-danger">
                                        <a class="" href="{{ URL::to('/candidate-pending-reference') }}">
                                            <div class="inner text-white">
                                                <p>Pending</p>
                                                <p>References</p>
                                            </div>

                                            <div class="icon">
                                                <i class="far fa-file-alt"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-5 mr-2 px-5 topbar-sec mob_p_0">
                            <div class="sec_box_edit">
                                <div class="teacher-page-table-section">
                                    <table class="table table-bordered table-striped" id="myTable">
                                        <thead>
                                            <tr class="table-heading">
                                                <th><i class="fas fa-star"><span>Favourites</span></i></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body-sec">
                                            @foreach ($fabTeacherList as $key => $fabTeacher)
                                                <tr class="table-data"
                                                    onclick="teacherDetail({{ $fabTeacher->teacher_id }})">
                                                    <td>
                                                        @if ($fabTeacher->knownAs_txt == '' || $fabTeacher->knownAs_txt == null)
                                                            {{ $fabTeacher->firstName_txt }} {{ $fabTeacher->surname_txt }}
                                                        @else
                                                            {{ $fabTeacher->knownAs_txt }} {{ $fabTeacher->surname_txt }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($fabTeacher->contactTeacherId == null || $fabTeacher->contactTeacherId == '')
                                                            No Contact
                                                        @else
                                                            {{ date('d M Y', strtotime($fabTeacher->lastContact_dte)) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teacher Add Modal -->
    <div class="modal fade" id="addNewTeacherModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add New Teacher</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add New Teacher</h2>
                    </div>

                    <form action="{{ url('/newTeacherInsert') }}" method="post" class="form-validate"
                        id="addNewTeacherForm">
                        @csrf
                        <div class="modal-input-field-section">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group calendar-form-filter">
                                        <label for="">Title</label>
                                        <select class="form-control" name="title_int" style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($titleList as $key1 => $title)
                                                <option value="{{ $title->description_int }}">
                                                    {{ $title->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">First Name</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate" name="firstName_txt"
                                            id="" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Surname</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate" name="surname_txt"
                                            id="" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Known As (nickname/preferred name)</label>
                                        <input type="text" class="form-control" name="knownAs_txt" id=""
                                            value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Maiden (or previous) Name</label>
                                        <input type="text" class="form-control" name="maidenPreviousNames_txt"
                                            id="" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Middle Name</label>
                                        <input type="text" class="form-control" name="middleNames_txt" id=""
                                            value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Email-id</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control email-validate" name="login_mail"
                                            id="loginMailId" value="">
                                    </div>

                                    <div class="modal-input-field">
                                        <label class="form-check-label">Address</label>
                                        <input type="text" class="form-control mb-1" name="address1_txt"
                                            id="" value="">
                                        <input type="text" class="form-control mb-1" name="address2_txt"
                                            id="" value="">
                                        <input type="text" class="form-control mb-1" name="address3_txt"
                                            id="" value="">
                                        <input type="text" class="form-control" name="address4_txt" id=""
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Postcode</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate" name="postcode_txt"
                                            id="postcodeTxt" value="">
                                    </div>

                                    <div class="modal-grid-reference-text ">
                                        <a class="bg-info bg-opacity-75" style="cursor: pointer" id="gridReference">Get
                                            Grid
                                            References</a>
                                    </div>
                                    <input type="hidden" name="lat_txt" id="latTxt">
                                    <input type="hidden" name="lon_txt" id="lonTxt">

                                    <div class="modal-input-field">
                                        <label class="form-check-label">Grid References</label>
                                        <h5 id="gridRefHtml"></h5>
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Nationality</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="nationality_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($nationalityList as $key2 => $nationality)
                                                <option value="{{ $nationality->description_int }}">
                                                    {{ $nationality->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Date of Birth</label><span
                                            style="color: red;">*</span>
                                        <input type="text" class="form-control datePickerPaste datepaste-validate"
                                            name="DOB_dte" id="" value="">
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Candidate Type</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="professionalType_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($candidateList as $key4 => $candidate)
                                                <option value="{{ $candidate->description_int }}">
                                                    {{ $candidate->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Age Range Specialism</label><span
                                            style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="ageRangeSpecialism_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($specialismList as $key5 => $specialism)
                                                <option value="{{ $specialism->description_int }}">
                                                    {{ $specialism->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="NQTRequired_status">NQT Year Required</label>
                                        <input type="checkbox" class="" name="NQTRequired_status"
                                            id="NQTRequired_status" value="1">
                                    </div>

                                    <div class="modal-input-field">
                                        <label class="form-check-label">NQT Year Completed</label>
                                        <input type="text" class="form-control datePickerPaste"
                                            name="NQTCompleted_dte" id="" value="">
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Status</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate" name="activeStatus"
                                            style="width:100%;">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <input type="checkbox" class="" name="passwordReset" id="passwordReset"
                                            value="1">
                                        <label class="form-check-label" for="passwordReset">Send password reset
                                            link</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="addNewTeacherBtn">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Teacher Add Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                // pageLength: 25,
                scrollY: '600px',
                paging: false,
                footer: false,
                info: false,
                ordering: false,
                // searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        function teacherDetail(teacher_id) {
            window.location.href = "{{ URL::to('/candidate-detail') }}" + '/' + teacher_id;
        }

        $(document).on('click', '#addNewTeacherBttn', function() {
            swal({
                    title: "Alert",
                    text: "Please click YES below to confirm that you want to create a new teacher record.",
                    buttons: {
                        cancel: "No",
                        Yes: "Yes"
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "Yes":
                            $('#addNewTeacherModal').modal("show");
                    }
                });
        });

        $(document).on('click', '#addNewTeacherBtn', function() {
            var error = "";
            $(".field-validate").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".email-validate").each(function() {
                var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                if (this.value != '' && validEmail.test(this.value)) {
                    $(this).closest(".form-group").removeClass('has-error');

                } else {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                }
            });
            $(".datepaste-validate").each(function() {
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
                var loginMailId = $('#loginMailId').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ url('checkTeacherMailExist') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        loginMail: loginMailId
                    },
                    async: false,
                    success: function(data) {
                        if (data == 'Yes') {
                            swal(
                                'Failed!',
                                'Email-id already exist.'
                            );
                        } else {
                            $('#addNewTeacherForm').submit();
                        }
                    }
                });
            }
        });

        $(document).on('click', '#gridReference', function() {
            var postcodeTxt = $('#postcodeTxt').val();
            if (postcodeTxt) {
                postcodeTxt = postcodeTxt.replace(/\s/g, '');
                $.ajax({
                    type: 'POST',
                    url: '{{ url('getGridReference') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        postcodeTxt: postcodeTxt
                    },
                    async: false,
                    success: function(data) {
                        $('#latTxt').val('');
                        $('#lonTxt').val('');
                        $('#gridRefHtml').html('');
                        if (data) {
                            $('#latTxt').val(data.lat);
                            $('#lonTxt').val(data.long);
                            $('#gridRefHtml').html(data.lat + ', ' + data.long);
                        }
                    }
                });
            } else {
                swal("", "Please enter postcode.");
            }
        });
    </script>
@endsection
