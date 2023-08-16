@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="tab-content dashboard-tab-content" id="myTabContent">
        <div class="assignment-section-col">

            <div class="teacher-all-section">
                <div class="teacher-section">
                    <div class="teacher-page-sec">
                        <h2>Teachers</h2>
                    </div>
                    <div class="teacher-left-sec">
                        <div class="about-teacher">
                            <a href="{{ URL::to('/candidate-search') }}"> <i class="fa-solid fa-magnifying-glass"></i>
                                <p>Find Teacher</p>
                            </a>
                        </div>

                        <div class="about-teacher">
                            <a href="{{ URL::to('/candidate-calendar') }}"> <i class="fa-regular fa-calendar-days"></i>
                                <p>Teacher</p>
                                <p>Calendar</p>
                            </a>
                        </div>

                        <div class="about-teacher">
                            <a style="cursor: pointer" id="addNewTeacherBttn">
                                <i class="fa-solid fa-user"></i>
                                <p>New Teacher</p>
                            </a>
                        </div>

                        {{-- <div class="about-teacher">
                            <a href="#"> <i class="fa-solid fa-file-lines"></i>
                                <p>Pending</p>
                                <p>Documents</p>
                            </a>
                        </div> --}}

                        <div class="about-teacher">
                            <a href="{{ URL::to('/candidate-pending-reference') }}"> <i
                                    class="fa-regular fa-file-lines"></i>
                                <p>Pending</p>
                                <p>References</p>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="teacher-page-table-section">
                    <table class="table teacher-page-table" id="myTable">
                        <thead>
                            <tr class="table-heading">

                                <th><i class="fa-solid fa-star"><span>Favourites</span></i></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-body-sec">
                            @foreach ($fabTeacherList as $key => $fabTeacher)
                                <tr class="table-data" onclick="teacherDetail({{ $fabTeacher->teacher_id }})">
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
                                            {{ date('d-m-Y', strtotime($fabTeacher->lastContact_dte)) }}
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

    <!-- Teacher Add Modal -->
    <div class="modal fade" id="addNewTeacherModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width:100%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add New Teacher</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Add New Teacher</h2>
                </div>

                <form action="{{ url('/newTeacherInsert') }}" method="post" class="form-validate" id="addNewTeacherForm">
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
                                    <input type="text" class="form-control" name="maidenPreviousNames_txt" id=""
                                        value="">
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
                                    <input type="text" class="form-control mb-1" name="address1_txt" id=""
                                        value="">
                                    <input type="text" class="form-control mb-1" name="address2_txt" id=""
                                        value="">
                                    <input type="text" class="form-control mb-1" name="address3_txt" id=""
                                        value="">
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

                                <div class="modal-grid-reference-text">
                                    <a style="cursor: pointer" id="gridReference">Get Grid References</a>
                                </div>
                                <input type="hidden" name="lat_txt" id="latTxt">
                                <input type="hidden" name="lon_txt" id="lonTxt">

                                <div class="modal-input-field">
                                    <label class="form-check-label">Grid References</label>
                                    <h2 id="gridRefHtml"></h2>
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
                                    <label for="">Age Range Specialism</label><span style="color: red;">*</span>
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
                                    <input type="text" class="form-control datePickerPaste" name="NQTCompleted_dte"
                                        id="" value="">
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">Status</label><span style="color: red;">*</span>
                                    <select class="form-control field-validate" name="activeStatus" style="width:100%;">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="modal-side-field mb-2">
                                    <input type="checkbox" class="" name="passwordReset" id="passwordReset"
                                        value="1">
                                    <label class="form-check-label" for="passwordReset">Send password reset link</label>
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
    <!-- Teacher Add Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
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
