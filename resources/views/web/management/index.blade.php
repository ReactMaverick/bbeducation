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
                                    <h2>Management</h2>
                                </div>
                                <div class="teacher-left-sec skd_row dataTables_wrapper">
                                    <div class="about-teacher skd_icon_box small-box bg-info">
                                        <a data-toggle="modal" data-target="#studentAddModal" style="cursor: pointer;">
                                            <div class="inner text-white">
                                                <p>Students</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="about-teacher skd_icon_box small-box bg-success">
                                        <a data-toggle="modal" data-target="#viewMetricsModal" style="cursor: pointer;">
                                            <div class="inner text-white">
                                                <p>View Metrics</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="about-teacher skd_icon_box small-box bg-primary">
                                        <a href="{{ URL::to('/adminUsers') }}" style="cursor: pointer;">
                                            <div class="inner text-white">
                                                <p>User Management</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="about-teacher skd_icon_box small-box bg-danger">
                                        <a href="{{ URL::to('/companyDetailsEdit') }}" style="cursor: pointer;">
                                            <div class="inner text-white">
                                                <p>Edit Company</p>
                                                <p>Details</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </div>

                                    {{-- <div class="about-finance">
                                                            <a href="{{ URL::to('/adminUsers') }}">
                                                                <p>Manage Users</p>
                                                            </a>
                                                        </div> --}}

                                    {{-- <div class="about-finance">
                                        <a href="{{ URL::to('/management-user') }}"> <i class="fa-solid fa-magnifying-glass"></i>
                                <p>Open Users</p>
                                </a>
                            </div> --}}

                                    {{-- <div class="about-finance">
                                        <a href="#"> <i class="fa-solid fa-user"></i>
                                            <p>Manage Users</p>
                                        </a>
                                    </div>

                                    <div class="about-finance">
                                        <a href="{{ URL::to('/management-mailshot') }}"> <i class="fa-solid fa-envelope"></i>
                            <p>Mailshots</p>
                            </a>
                        </div> --}}
                                    {{-- <div class="about-finance">
                                        <a href="#"> <i class="fa-solid fa-gear"></i>
                                            <p>Assignment</p>
                                            <p>Rates</p>
                                        </a>
                                    </div> --}}
                                    {{-- <div class="about-finance">
                                        <a href="#"> <i class="fa-solid fa-id-badge"></i>
                                            <p>Delete Teacher</p>
                                        </a>
                                    </div> --}}



                                    {{-- <div class="about-finance">
                                        <a href="#"> <i class="fa-solid fa-person"></i>
                                            <p>Export to</p>
                                            <p>Quickbooks</p>
                                        </a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Add Modal -->
    <div class="modal fade" id="studentAddModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Student Listings</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add/Edit Students (Double click to edit)</h2>
                    </div>

                    <div class="modal-input-field-section">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                <div style="text-align: right">
                                    <a style="cursor: pointer;" id="studentDeleteBtn">
                                        <i class="fas fa-trash-alt trash-icon"></i>
                                    </a>
                                </div>

                                <div class="finance-list-section mb-2">
                                    <div class="finance-list-text-section">
                                        <div class="finance-list-text new_scrollbar">
                                            <table class="table table-bordered table-striped" id="">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Name</th>
                                                        <th>Current</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec" id="studentTbody">
                                                    @foreach ($studentList as $key => $student)
                                                        <tr class="school-detail-table-data selectStudentRow"
                                                            id="selectStudentRow{{ $student->student_id }}"
                                                            studentId="{{ $student->student_id }}"
                                                            firstName="{{ $student->firstName_txt }}"
                                                            surname="{{ $student->surname_txt }}"
                                                            isCurrent="{{ $student->isCurrent_ysn }}">
                                                            <td>{{ $student->studentName_txt }}</td>
                                                            <td>{{ $student->isCurrent_txt }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                <form action="{{ url('/studentInsert') }}" method="post" class="form-validate"
                                    id="studentAddForm">
                                    @csrf
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">First Name</label>
                                        <input type="text" class="form-control field-validate" name="firstName_txt"
                                            id="firstName_txt" value="">
                                    </div>

                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Surname</label>
                                        <input type="text" class="form-control field-validate" name="surname_txt"
                                            id="surname_txt" value="">
                                    </div>
                                    <div class="modal-footer calendar-modal-footer">
                                        <button type="button" class="btn btn-secondary" id="studentAddBtn">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Student Add Modal -->

    <!-- Student Edit Modal -->
    <div class="modal fade" id="studentEditModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Student</h4>
                    <button type="button" class="close" id="editStudentClose">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Details</h2>
                    </div>

                    <form action="{{ url('/studentUpdate') }}" method="post" class="form-validate-2"
                        id="studentEditForm">
                        @csrf
                        <input type="hidden" name="student_id" id="editStudentId" value="">

                        <div class="modal-input-field-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">First Name</label>
                                        <input type="text" class="form-control field-validate-2" name="firstName_txt"
                                            id="firstNameEdit" value="">
                                    </div>

                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Surname</label>
                                        <input type="text" class="form-control field-validate-2" name="surname_txt"
                                            id="surnameEdit" value="">
                                    </div>

                                    <div class="modal-side-field">
                                        <label class="form-check-label" for="CurrentId">Current</label>
                                        <input type="checkbox" class="" name="isCurrent_ysn" id="CurrentId"
                                            value="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="editStudentBtn">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" id="editStudentClose">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Student Edit Modal -->

    <!-- View Metrics Modal -->
    <div class="modal fade" id="viewMetricsModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Finance Report</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-chart-line"></i>
                        <h2>Metrics Report</h2>
                    </div>

                    <form action="{{ url('/viewMetricsExport') }}" method="post">
                        @csrf
                        <div class="modal-input-field-section">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="modal-input-field">
                                        <label class="form-check-label">Start Date</label>
                                        <input type="text" class="form-control datePickerPaste" name="start_date"
                                            id="metricStartDate" value="{{ date('d/m/Y', strtotime($startOfMonth)) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-input-field">
                                        <label class="form-check-label">End Date</label>
                                        <input type="text" class="form-control datePickerPaste" name="end_date"
                                            id="metricEndDate" value="{{ date('d/m/Y', strtotime($endOfMonth)) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="metricSubmitBtn">Submit</button>
                        </div>

                        <div class="modal-input-field-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Total Days</p>
                                </div>
                                <div class="col-md-6">
                                    <p id="totalDaysView">{{ $asnSubquery->daysThisPeriod_dec }}</p>
                                </div>

                                <div class="col-md-6">
                                    <p>Teachers Working</p>
                                </div>
                                <div class="col-md-6">
                                    <p id="teacherWorkView">{{ $asnSubquery->teachersWorking_int }}</p>
                                </div>

                                <div class="col-md-6">
                                    <p>School using ( {{ $companyDetail->company_name }} )</p>
                                </div>
                                <div class="col-md-6">
                                    <p id="schoolView">{{ $asnSubquery->schoolsUsing_int }}</p>
                                </div>


                                <div class="col-md-6 mt-3">
                                    <p>Predicted GP</p>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <p>£ <span id="predGpView">{{ $asnSubquery->predictedGP_dec }}</span></p>
                                </div>

                                <div class="col-md-6">
                                    <p>Billed GP</p>
                                </div>
                                <div class="col-md-6">
                                    <p>£ <span id="billGpView">{{ $billedSubquery->actualBilled_dec }}</span></p>
                                </div>

                                <div class="col-md-6">
                                    <p>Total Turnover</p>
                                </div>
                                <div class="col-md-6">
                                    <p>£ <span id="turnoverView">{{ $invoiceSubquery->actualGP_dec }}</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Export</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- View Metrics Modal -->

    <script>
        $(document).on('click', '#studentAddBtn', function() {
            var error = "";
            $(".field-validate").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });

            if (error == "has error") {
                return false;
            } else {
                var form = $("#studentAddForm");
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    success: function(data) {
                        $("#firstName_txt").val('');
                        $("#surname_txt").val('');
                        $("#studentTbody").html('');
                        $("#studentTbody").html(data.html);
                        swal("", "Student added successfully.");
                    }
                });
            }
        });

        var DELAY = 200,
            clicks = 0,
            timer = null;

        $(document).on('click', '.selectStudentRow', function(e) {
            clicks++; //count clicks
            var studentId = $(this).attr('studentId');
            var firstName = $(this).attr('firstName');
            var surname = $(this).attr('surname');
            var isCurrent = $(this).attr('isCurrent');

            $('#editStudentId').val(studentId);
            $('#firstNameEdit').val(firstName);
            $('#surnameEdit').val(surname);
            if (isCurrent == '-1') {
                $('#CurrentId').prop("checked", true);
            }
            if (clicks === 1) {
                timer = setTimeout(function() {
                    // alert("Single Click=>"+teacherId); //perform single-click action
                    $('.selectStudentRow').removeClass('tableRowActive');
                    $('#selectStudentRow' + studentId).addClass('tableRowActive');

                    clicks = 0; //after action performed, reset counter
                }, DELAY);
            } else {
                clearTimeout(timer); //prevent single-click action
                // alert("Double Click=>" + teacherId); //perform double-click action
                $('.selectStudentRow').removeClass('tableRowActive');
                $('#selectStudentRow' + studentId).addClass('tableRowActive');

                clicks = 0; //after action performed, reset counter
            }
        }).on("dblclick", '.selectStudentRow', function(e) {
            e.preventDefault(); //cancel system double-click event
            $('#studentEditModal').modal("show");
        });


        $(document).on('click', '#editStudentClose', function() {
            $('#studentEditModal').modal("hide");
        });

        $(document).on('click', '#editStudentBtn', function(e) {
            e.preventDefault();
            var error = "";
            $(".field-validate-2").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (error == "has error") {
                return false;
            } else {
                var form = $("#studentEditForm");
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    success: function(data) {
                        $("#studentTbody").html('');
                        $("#studentTbody").html(data.html);
                        $('#studentEditModal').modal("hide");
                        swal("", "Student updated successfully.");
                    }
                });
            }
        });

        $(document).on('click', '#studentDeleteBtn', function(e) {
            // e.preventDefault();
            var studentId = $('#editStudentId').val();
            if (studentId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to delete the selected student?",
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
                                    url: "{{ url('studentDelete ') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        studentId: studentId
                                    },
                                    success: function(data) {
                                        $("#studentTbody").html('');
                                        $("#studentTbody").html(data.html);
                                        swal("", "Student deleted successfully.");
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one student.");
            }
        });

        $(document).on('click', '#metricSubmitBtn', function(e) {
            var metricStartDate = $("#metricStartDate").val();
            var metricEndDate = $("#metricEndDate").val();
            if (metricStartDate && metricEndDate) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('viewMetricsAjax ') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        metricStartDate: metricStartDate,
                        metricEndDate: metricEndDate
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data == 'login') {
                            var loginUrl = '<?php echo url('/'); ?>';
                            window.location.assign(loginUrl);
                        } else {
                            $('#totalDaysView').html('');
                            $('#teacherWorkView').html('');
                            $('#schoolView').html('');
                            $('#predGpView').html('');
                            $('#billGpView').html('');
                            $('#turnoverView').html('');

                            $('#totalDaysView').html(data.asnSubquery.daysThisPeriod_dec);
                            $('#teacherWorkView').html(data.asnSubquery.teachersWorking_int);
                            $('#schoolView').html(data.asnSubquery.schoolsUsing_int);
                            $('#predGpView').html(data.asnSubquery.predictedGP_dec);
                            $('#billGpView').html(data.billedSubquery.actualBilled_dec);
                            $('#turnoverView').html(data.invoiceSubquery.actualGP_dec);
                        }
                    }
                });
            } else {
                swal("", "Please enter start date and end date both.");
            }
        });
    </script>
@endsection
