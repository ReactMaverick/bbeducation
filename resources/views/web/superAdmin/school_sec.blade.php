@extends('web.superAdmin.layout')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">
                        <h4 style="text-align: center;border: 2px solid #ddd;">School Section</h4>
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
                                                <h2>School Type</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteSchoolTypeBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#SchoolTypeAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editSchoolTypeBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="myTable2">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>#</th>
                                                        <th>School Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($schoolTypeList as $key1 => $schoolType)
                                                        <tr class="school-detail-table-data editSchTypeRow"
                                                            onclick="SchTypeRowSelect('{{ $schoolType->description_int }}','{{ $schoolType->description_txt }}')"
                                                            id="editSchTypeRow{{ $schoolType->description_int }}">
                                                            <td>{{ $key1 + 1 }}</td>
                                                            <td>{{ $schoolType->description_txt }}</td>
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

                    <form action="{{ url('/sysAddSchAgeRange') }}" method="post" class="form-validate"
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

                    <form action="{{ url('/sysEditSchAgeRange') }}" method="post" class="form-validate-2"
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

    <!-- School Type Add Modal -->
    <div class="modal fade" id="SchoolTypeAddModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add School Type</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add School Type</h2>
                    </div>

                    <form action="{{ url('/sysAddSchoolType') }}" method="post" class="form-validate-3"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">School Type</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-3" name="school_type"
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
    <!-- School Type Add Modal -->

    <!-- School Type Edit Modal -->
    <div class="modal fade" id="SchoolTypeEditModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit School Type</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit School Type</h2>
                    </div>

                    <form action="{{ url('/sysEditSchoolType') }}" method="post" class="form-validate-4"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="schoolId" id="editSchTypeInt" value="">

                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">School Type</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-4" name="school_type"
                                        id="editSchTypeName" value="">
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
    <!-- School Type Edit Modal -->

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
                                    url: "{{ url('sysDeleteSchAgeRange') }}",
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

        // For school type
        function SchTypeRowSelect(sch_id, sch_name) {
            if ($('#editSchTypeRow' + sch_id).hasClass('tableRowActive')) {
                $('#editSchTypeInt').val('');
                $('#editSchTypeName').val('');
                $('#editSchTypeRow' + sch_id).removeClass('tableRowActive');
                $('#deleteSchoolTypeBttn').addClass('disabled-link');
                $('#editSchoolTypeBttn').addClass('disabled-link');
            } else {
                $('#editSchTypeInt').val(sch_id);
                $('#editSchTypeName').val(sch_name);
                $('.editSchTypeRow').removeClass('tableRowActive');
                $('#editSchTypeRow' + sch_id).addClass('tableRowActive');
                $('#deleteSchoolTypeBttn').removeClass('disabled-link');
                $('#editSchoolTypeBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editSchoolTypeBttn', function() {
            var sch_id = $('#editSchTypeInt').val();
            if (sch_id) {
                $('#SchoolTypeEditModal').modal("show");
            } else {
                swal("", "Please select one school type.");
            }
        });

        $(document).on('click', '#deleteSchoolTypeBttn', function() {
            var sch_id = $('#editSchTypeInt').val();
            if (sch_id) {
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
                                    url: "{{ url('sysDeleteSchoolType') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        sch_id: sch_id
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
                swal("", "Please select one school type.");
            }
        });
        // For school type
    </script>
@endsection
