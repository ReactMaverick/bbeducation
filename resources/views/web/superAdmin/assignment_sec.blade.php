@extends('web.superAdmin.layout')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">
                        <h4 style="text-align: center;border: 2px solid #ddd;">Assignment Section</h4>
                        <div class="school-detail-right-sec">
                            <div class="row my_row_gap">
                                <div class="col-md-4 col-lg-4 col-xl-4 col-12 col-sm-12">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Age Range</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteAgerangeBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#ageRangeAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editAgerangeBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="myTable1">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>#</th>
                                                        <th>Age Range</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($ageRangeList as $key1 => $ageRange)
                                                        <tr class="school-detail-table-data editAgerangeRow"
                                                            onclick="ageRangeRowSelect('{{ $ageRange->description_int }}','{{ $ageRange->description_txt }}')"
                                                            id="editAgerangeRow{{ $ageRange->description_int }}">
                                                            <td>{{ $key1 + 1 }}</td>
                                                            <td>{{ $ageRange->description_txt }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-4 col-xl-4 col-12 col-sm-12">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Subjects</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteSubjectBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#SubjectAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editSubjectBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="myTable2">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>#</th>
                                                        <th>Subject</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($subjectList as $key1 => $subject)
                                                        <tr class="school-detail-table-data editSubjectRow"
                                                            onclick="SubjectRowSelect('{{ $subject->description_int }}','{{ $subject->description_txt }}')"
                                                            id="editSubjectRow{{ $subject->description_int }}">
                                                            <td>{{ $key1 + 1 }}</td>
                                                            <td>{{ $subject->description_txt }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-4 col-xl-4 col-12 col-sm-12">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Year Group</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteYearGrpBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#YearGrpAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editYearGrpBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="myTable3">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>#</th>
                                                        <th>Year Group</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($yearGrList as $key1 => $yearGr)
                                                        <tr class="school-detail-table-data editYearGroupRow"
                                                            onclick="YearGroupRowSelect('{{ $yearGr->description_int }}','{{ $yearGr->description_txt }}')"
                                                            id="editYearGroupRow{{ $yearGr->description_int }}">
                                                            <td>{{ $key1 + 1 }}</td>
                                                            <td>{{ $yearGr->description_txt }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="school-detail-right-sec mt-3">
                            <div class="row my_row_gap">
                                <div class="col-md-4 col-lg-4 col-xl-4 col-12 col-sm-12">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Professional Type</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteProfTypeBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#ProfTypeAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editProfTypeBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="myTable4">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>#</th>
                                                        <th>Professional Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($profTypeList as $key1 => $profType)
                                                        <tr class="school-detail-table-data editProfTypeRow"
                                                            onclick="ProfTypeRowSelect('{{ $profType->description_int }}','{{ $profType->description_txt }}')"
                                                            id="editProfTypeRow{{ $profType->description_int }}">
                                                            <td>{{ $key1 + 1 }}</td>
                                                            <td>{{ $profType->description_txt }}</td>
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
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Age Range Add Modal -->
    <div class="modal fade" id="ageRangeAddModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Age Range</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Age Range</h2>
                    </div>

                    <form action="{{ url('/sysAddAgeRange') }}" method="post" class="form-validate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Age Range</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate" name="age_range"
                                        id="" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Age Range Add Modal -->

    <!-- Age Range Edit Modal -->
    <div class="modal fade" id="ageRangeEditModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Age Range</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Age Range</h2>
                    </div>

                    <form action="{{ url('/sysEditAgeRange') }}" method="post" class="form-validate-2"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="ageId" id="editAgeRangeInt" value="">

                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Age Range</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-2" name="age_range"
                                        id="editAgeRangeName" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Age Range Edit Modal -->

    <!-- Subject Add Modal -->
    <div class="modal fade" id="SubjectAddModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Subject</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Subject</h2>
                    </div>

                    <form action="{{ url('/sysAddSubject') }}" method="post" class="form-validate-3"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Subject</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-3" name="subject"
                                        id="" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Subject Add Modal -->

    <!-- Subject Edit Modal -->
    <div class="modal fade" id="SubjectEditModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Subject</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Subject</h2>
                    </div>

                    <form action="{{ url('/sysEditSubject') }}" method="post" class="form-validate-4"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="subjectId" id="editSubjectInt" value="">

                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Subject</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-4" name="subject"
                                        id="editSubjectName" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Subject Edit Modal -->

    <!-- Year Group Add Modal -->
    <div class="modal fade" id="YearGrpAddModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Year Group</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Year Group</h2>
                    </div>

                    <form action="{{ url('/sysAddYearGrp') }}" method="post" class="form-validate-5"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Year Group</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-5" name="year_group"
                                        id="" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Year Group Add Modal -->

    <!-- Year Group Edit Modal -->
    <div class="modal fade" id="YearGrpEditModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Year Group</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Year Group</h2>
                    </div>

                    <form action="{{ url('/sysEditYearGrp') }}" method="post" class="form-validate-6"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="yearId" id="editYearGrInt" value="">

                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Year Group</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-6" name="year_group"
                                        id="editYearGrName" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Year Group Edit Modal -->

    <!-- Professional Type Add Modal -->
    <div class="modal fade" id="ProfTypeAddModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Professional Type</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Professional Type</h2>
                    </div>

                    <form action="{{ url('/sysAddProfType') }}" method="post" class="form-validate-7"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Professional Type</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-7" name="prof_type"
                                        id="" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Professional Type Add Modal -->

    <!-- Professional Type Edit Modal -->
    <div class="modal fade" id="ProfTypeEditModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Professional Type</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Professional Type</h2>
                    </div>

                    <form action="{{ url('/sysEditProfType') }}" method="post" class="form-validate-8"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="profId" id="editProfTypeInt" value="">

                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Professional Type</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-8" name="prof_type"
                                        id="editProfTypeName" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Professional Type Edit Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable1, #myTable2, #myTable3, #myTable4').DataTable({
                scrollY: '200px',
                paging: false,
                footer: false,
                info: false,
                ordering: false,
                searching: true,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        // For age range
        function ageRangeRowSelect(age_id, age_name) {
            if ($('#editAgerangeRow' + age_id).hasClass('tableRowActive')) {
                $('#editAgeRangeInt').val('');
                $('#editAgeRangeName').val('');
                $('#editAgerangeRow' + age_id).removeClass('tableRowActive');
                $('#deleteAgerangeBttn').addClass('disabled-link');
                $('#editAgerangeBttn').addClass('disabled-link');
            } else {
                $('#editAgeRangeInt').val(age_id);
                $('#editAgeRangeName').val(age_name);
                $('.editAgerangeRow').removeClass('tableRowActive');
                $('#editAgerangeRow' + age_id).addClass('tableRowActive');
                $('#deleteAgerangeBttn').removeClass('disabled-link');
                $('#editAgerangeBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editAgerangeBttn', function() {
            var age_r_id = $('#editAgeRangeInt').val();
            if (age_r_id) {
                $('#ageRangeEditModal').modal("show");
            } else {
                swal("", "Please select one age range.");
            }
        });

        $(document).on('click', '#deleteAgerangeBttn', function() {
            var age_r_id = $('#editAgeRangeInt').val();
            if (age_r_id) {
                swal({
                        title: "",
                        text: "Are you sure you wish to remove this item?",
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
                                    url: "{{ url('sysDeleteAgeRange') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        age_r_id: age_r_id
                                    },
                                    success: function(data) {
                                        swal("", "Record successfully deleted.");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one age range.");
            }
        });
        // For age range

        // For subject
        function SubjectRowSelect(subject_id, sub_name) {
            if ($('#editSubjectRow' + subject_id).hasClass('tableRowActive')) {
                $('#editSubjectInt').val('');
                $('#editSubjectName').val('');
                $('#editSubjectRow' + subject_id).removeClass('tableRowActive');
                $('#deleteSubjectBttn').addClass('disabled-link');
                $('#editSubjectBttn').addClass('disabled-link');
            } else {
                $('#editSubjectInt').val(subject_id);
                $('#editSubjectName').val(sub_name);
                $('.editSubjectRow').removeClass('tableRowActive');
                $('#editSubjectRow' + subject_id).addClass('tableRowActive');
                $('#deleteSubjectBttn').removeClass('disabled-link');
                $('#editSubjectBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editSubjectBttn', function() {
            var sub_id = $('#editSubjectInt').val();
            if (sub_id) {
                $('#SubjectEditModal').modal("show");
            } else {
                swal("", "Please select one subject.");
            }
        });

        $(document).on('click', '#deleteSubjectBttn', function() {
            var sub_id = $('#editSubjectInt').val();
            if (sub_id) {
                swal({
                        title: "",
                        text: "Are you sure you wish to remove this item?",
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
                                    url: "{{ url('sysDeleteSubject') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        sub_id: sub_id
                                    },
                                    success: function(data) {
                                        swal("", "Record successfully deleted.");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one subject.");
            }
        });
        // For subject

        // For year group
        function YearGroupRowSelect(year_id, year_name) {
            if ($('#editYearGroupRow' + year_id).hasClass('tableRowActive')) {
                $('#editYearGrInt').val('');
                $('#editYearGrName').val('');
                $('#editYearGroupRow' + year_id).removeClass('tableRowActive');
                $('#deleteYearGrpBttn').addClass('disabled-link');
                $('#editYearGrpBttn').addClass('disabled-link');
            } else {
                $('#editYearGrInt').val(year_id);
                $('#editYearGrName').val(year_name);
                $('.editYearGroupRow').removeClass('tableRowActive');
                $('#editYearGroupRow' + year_id).addClass('tableRowActive');
                $('#deleteYearGrpBttn').removeClass('disabled-link');
                $('#editYearGrpBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editYearGrpBttn', function() {
            var year_id = $('#editYearGrInt').val();
            if (year_id) {
                $('#YearGrpEditModal').modal("show");
            } else {
                swal("", "Please select one year group.");
            }
        });

        $(document).on('click', '#deleteYearGrpBttn', function() {
            var year_id = $('#editYearGrInt').val();
            if (year_id) {
                swal({
                        title: "",
                        text: "Are you sure you wish to remove this item?",
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
                                    url: "{{ url('sysDeleteYearGrp') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        year_id: year_id
                                    },
                                    success: function(data) {
                                        swal("", "Record successfully deleted.");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one year group.");
            }
        });
        // For year group

        // For Professional Type
        function ProfTypeRowSelect(prof_id, prof_name) {
            if ($('#editProfTypeRow' + prof_id).hasClass('tableRowActive')) {
                $('#editProfTypeInt').val('');
                $('#editProfTypeName').val('');
                $('#editProfTypeRow' + prof_id).removeClass('tableRowActive');
                $('#deleteProfTypeBttn').addClass('disabled-link');
                $('#editProfTypeBttn').addClass('disabled-link');
            } else {
                $('#editProfTypeInt').val(prof_id);
                $('#editProfTypeName').val(prof_name);
                $('.editProfTypeRow').removeClass('tableRowActive');
                $('#editProfTypeRow' + prof_id).addClass('tableRowActive');
                $('#deleteProfTypeBttn').removeClass('disabled-link');
                $('#editProfTypeBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editProfTypeBttn', function() {
            var prof_id = $('#editProfTypeInt').val();
            if (prof_id) {
                $('#ProfTypeEditModal').modal("show");
            } else {
                swal("", "Please select one Professional Type.");
            }
        });

        $(document).on('click', '#deleteProfTypeBttn', function() {
            var prof_id = $('#editProfTypeInt').val();
            if (prof_id) {
                swal({
                        title: "",
                        text: "Are you sure you wish to remove this item?",
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
                                    url: "{{ url('sysDeleteProfType') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        prof_id: prof_id
                                    },
                                    success: function(data) {
                                        swal("", "Record successfully deleted.");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one Professional Type.");
            }
        });
        // For Professional Type
    </script>
@endsection
