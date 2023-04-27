@extends('web.layout')
@section('content')
    <div class="assignment-section-col">

        <div class="teacher-all-section">
            <div class="finance-section">
                <div class="teacher-page-sec">
                    <h2>Management</h2>
                </div>
                <div class="teacher-left-sec">
                    {{-- <div class="about-finance">
                        <a href="{{ URL::to('/management-user') }}"> <i class="fa-solid fa-magnifying-glass"></i>
                            <p>Open Users</p>
                        </a>
                    </div> --}}

                    <div class="about-finance">
                        <a href="#"> <i class="fa-solid fa-user"></i>
                            <p>Manage Users</p>
                        </a>
                    </div>

                    <div class="about-finance">
                        <a href="{{ URL::to('/management-mailshot') }}"> <i class="fa-solid fa-envelope"></i>
                            <p>Mailshots</p>
                        </a>
                    </div>
                    <div class="about-finance">
                        <a data-toggle="modal" data-target="#studentAddModal" style="cursor: pointer;">
                            <i class="fa-solid fa-people-group"></i>
                            <p>Students</p>
                        </a>
                    </div>

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
                    <div class="about-finance">
                        <a href="#"> <i class="fa-solid fa-chart-line"></i>
                            <p>View Metrics</p>
                        </a>
                    </div>
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

    <!-- Student Add Modal -->
    <div class="modal fade" id="studentAddModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Student Listings</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Add/Edit Students (Double click to edit)</h2>
                </div>

                <div class="modal-input-field-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="finance-list-section mb-2">
                                <div class="finance-list-text-section" style="max-height: 350px; min-height: 350px;">
                                    <div class="finance-list-text">
                                        <table class="table finance-timesheet-page-table" id="">
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
                        <div class="col-md-6 modal-form-right-sec">
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
    <!-- Student Add Modal -->

    <!-- Student Edit Modal -->
    <div class="modal fade" id="studentEditModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width:65%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Student</h4>
                    <button type="button" class="close" id="editStudentClose">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Details</h2>
                </div>

                <form action="{{ url('/studentUpdate') }}" method="post" class="form-validate-2" id="studentEditForm">
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
    <!-- Student Edit Modal -->

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
        }).on("dblclick", function(e) {
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
    </script>
@endsection
