{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
@section('content')
    <style>
        .select2 {
            width: 100% !important;
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
                                    <h2>Schools</h2>
                                </div>
                                <div class="teacher-left-sec skd_row dataTables_wrapper">
                                    <div class="about-teacher skd_icon_box small-box bg-info">
                                        <a class="" href="{{ URL::to('/school-search') }}">
                                            <div class="inner text-white">
                                                <p>Find School</p>
                                            </div>
                                            <div class="icon"><i class="fas fa-search"></i></div>
                                        </a>
                                    </div>

                                    <div class="about-teacher skd_icon_box small-box bg-success">
                                        <a data-toggle="modal" data-target="#addNewSchoolModal" style="cursor: pointer">
                                            <div class="inner text-white">
                                                <p>Add New</p>
                                                <p>School</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-school"></i>
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
                                            @foreach ($fabSchoolList as $key => $fabSchool)
                                                <tr class="table-data" onclick="schoolDetail({{ $fabSchool->school_id }})">
                                                    <td>{{ $fabSchool->name_txt }}</td>
                                                    <td>
                                                        @if ($fabSchool->contactSchoolId == null || $fabSchool->contactSchoolId == '')
                                                            No Contact
                                                        @else
                                                            {{ date('d-m-Y', strtotime($fabSchool->lastContact_dte)) }}
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

    <!-- School Add Modal -->
    <div class="modal fade" id="addNewSchoolModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add New School</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add New School</h2>
                    </div>

                    <form action="{{ url('/newSchoolInsert') }}" method="post" class="form-validate" id="addNewSchoolForm">
                        @csrf
                        <div class="modal-input-field-section">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">School Name</label><span
                                            style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate" name="name_txt"
                                            id="" value="">
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

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Postcode</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate" name="postcode_txt"
                                            id="postcodeTxt" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Main Contact Number</label>
                                        <input type="text" class="form-control" name="main_contact_no" id=""
                                            value="">
                                    </div>

                                    <div class="modal-grid-reference-text">
                                        <a class="bg-info bg-opacity-75" style="cursor: pointer" id="gridReference">Get
                                            Grid References</a>
                                    </div>

                                    <div class="modal-input-field">
                                        <label class="form-check-label">Grid References</label>
                                        <input type="hidden" name="lat_txt" id="latTxt">
                                        <input type="hidden" name="lon_txt" id="lonTxt">
                                        <h5 id="gridRefHtml"></h5>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Local Authority/Borough</label><span
                                            style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="la_id">
                                            <option value="">Choose one</option>
                                            @foreach ($laBoroughList as $key2 => $laBorough)
                                                <option value="{{ $laBorough->la_id }}">
                                                    {{ $laBorough->laName_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Age Range</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="ageRange_int">
                                            <option value="">Choose one</option>
                                            @foreach ($ageRangeList as $key3 => $ageRange)
                                                <option value="{{ $ageRange->description_int }}">
                                                    {{ $ageRange->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">School Type</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="type_int">
                                            <option value="">Choose one</option>
                                            @foreach ($schoolTypeList as $key4 => $schoolType)
                                                <option value="{{ $schoolType->description_int }}">
                                                    {{ $schoolType->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Religious Character</label><span
                                            style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="religion_int">
                                            <option value="">Choose one</option>
                                            @foreach ($religiousList as $key5 => $religious)
                                                <option value="{{ $religious->description_int }}">
                                                    {{ $religious->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-input-field">
                                        <label class="form-check-label">Website</label>
                                        <input type="text" class="form-control" name="website_txt" id=""
                                            value="">
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
                            <button type="button" class="btn btn-secondary" id="addNewSchoolBtn">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- School Add Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                pageLength: 25,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        function schoolDetail(school_id) {
            window.location.href = "{{ URL::to('/school-detail') }}" + '/' + school_id;
        }

        $(document).on('click', '#addNewSchoolBtn', function() {
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
                    url: '{{ url('checkSchoolMailExist') }}',
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
                            $('#addNewSchoolForm').submit();
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
