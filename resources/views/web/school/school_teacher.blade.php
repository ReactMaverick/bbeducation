{{-- @extends('web.layout') --}}
@extends('web.school.school_layout')
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
                    @include('web.school.school_header')
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

                        <div class="school-assignment-sec">
                            <div class="school-assignment-section sec_box_edit">
                                <div class="teacher-list-section details-heading">
                                    <div class="school-teacher-heading-text">
                                        <h2>Teachers</h2>
                                    </div>
                                    <div class="contact-icon-sec">
                                        <a style="cursor: pointer" class="disabled-link icon_all"
                                            id="deleteSchoolTeacherBttn">
                                            <i class="fas fa-trash-alt trash-icon"></i>
                                        </a>
                                        <a data-toggle="modal" data-target="#schoolTeacherAddModal" style="cursor: pointer;"
                                            class="icon_all">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                        <a style="cursor: pointer;" class="disabled-link icon_all"
                                            id="editSchoolTeacherBttn">
                                            <i class="fas fa-edit school-edit-icon"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row my_row_gap">
                                    <div class="col-md-8 col-lg-8 col-xl-8 col-12 col-sm-12">
                                        <div class="teacher-list-page-table">
                                            <table class="table table-bordered table-striped" id="myTable">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Teacher ID</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Days Worked</th>
                                                        <th>Pref/Reject</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($teacherList as $key => $teacher)
                                                        <tr class="school-detail-table-data editTeacherRow"
                                                            id="editTeacherRow{{ $teacher->schoolTeacherList_id }}"
                                                            onclick="editTeacherRowSelect({{ $teacher->schoolTeacherList_id }})">
                                                            <td>{{ $teacher->teacher_id }}</td>
                                                            <td>
                                                                @if ($teacher->knownAs_txt == null || $teacher->knownAs_txt == '')
                                                                    {{ $teacher->firstName_txt . ' ' . $teacher->surname_txt }}
                                                                @else
                                                                    {{ $teacher->firstName_txt . ' (' . $teacher->knownAs_txt . ') ' . $teacher->surname_txt }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $teacher->status_txt }}</td>
                                                            <td>{{ $teacher->daysWorked_dec }}</td>
                                                            <td>
                                                                @if ($teacher->rejectOrPreferred_int == 1)
                                                                    {{ 'Preferred' }}
                                                                @elseif ($teacher->rejectOrPreferred_int == 2)
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
                                    <div class="col-md-2 col-lg-2 col-xl-2 col-12 col-sm-12">
                                        <input type="hidden" name="editTeacherId" id="editTeacherId" value="">
                                        <input type="hidden" name="editSchoolId" id="editSchoolId"
                                            value="{{ $schoolDetail->school_id }}">

                                        <div class="preferred-list-sec about-school-section">
                                            <div class="form-check list-form-check">
                                                <input type="radio" id="AllId" name="rejectOrPreferred" value="all"
                                                    <?php
                                                    echo app('request')->input('status') == 'all' ? 'checked' : ''; ?>>
                                                <label for="AllId">All</label>
                                            </div>
                                            <div class="form-check list-form-check">
                                                <input type="radio" id="PreferredId" name="rejectOrPreferred"
                                                    value="preferred" <?php
                                                    echo app('request')->input('status') == 'preferred' ? 'checked' : ''; ?>>
                                                <label for="PreferredId">Preferred</label>
                                            </div>
                                            <div class="form-check list-form-check">
                                                <input type="radio" id="RejectedId" name="rejectOrPreferred"
                                                    value="rejected" <?php
                                                    echo app('request')->input('status') == 'rejected' ? 'checked' : ''; ?>>
                                                <label for="RejectedId">Rejected</label>
                                            </div>
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

    <!-- School Teacher Add Modal -->
    <div class="modal fade" id="schoolTeacherAddModal">
        <div class="modal-dialog modal-xl modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add School Teacher</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-xl-8 col-12 col-sm-12">
                            <div class="school-search-section add-school-search-section details-heading">
                                <div class="school-search-field add-school-search-field">
                                    <h2>Teacher</h2>
                                </div>
                                <div class="about-school-section5">
                                    <label class="sg_label" for="">Search For</label>
                                    <input type="text" class="form-control section5_input" id="searchTeacherKey"
                                        name="searchTeacherKey" value="">
                                </div>
                            </div>
                            <div class="assignment-finance-table-section mt-3">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="school-detail-table-heading">
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Days Here</th>
                                            <th>Specialism</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body-sec" id="searchTeacherView">
                                        <tr class="table-data">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-xl-4 col-12 col-sm-12">
                            <div class="calendar-heading-sec" style="align-items: baseline;">
                                <i class="fas fa-edit school-edit-icon"></i>
                                <h2>Add Teacher Addition</h2>
                            </div>

                            <form action="{{ url('/schoolTeacherInsert') }}" method="post" class="form-validate"
                                id="schoolTeacherAddForm">
                                @csrf
                                <div class="modal-input-field-section">
                                    <p>{{ $schoolDetail->name_txt }}</p>
                                    {{-- <h6>ID</h6>
                                        <h6>{{ $schoolDetail->school_id }}</h6> --}}
                                    <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">
                                    <input type="hidden" name="searchTeacherId" id="searchTeacherId" value="">

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Reason for List Addition</label>
                                        <select class="form-control field-validate" name="rejectOrPreferred_int">
                                            <option value="">Choose one</option>
                                            <option value="1">Preferred</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Notes</label>
                                        <textarea name="notes_txt" id="" cols="30" rows="5" class="form-control"></textarea>
                                    </div>

                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer calendar-modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        id="schoolTeacherAddBtn">Submit</button>

                                    <button type="button" class="btn btn-danger cancel-btn"
                                        data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- School Teacher Add Modal -->

    <!-- School Teacher Edit Modal -->
    <div class="modal fade" id="schoolTeacherEditModal">
        <div class="modal-dialog modal-xl modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit School Teacher</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="{{ url('/schoolTeacherUpdate') }}" method="post" class="form-validate-2"
                        id="schoolTeacherEditForm">
                        @csrf
                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">
                        <input type="hidden" name="editSchoolTeacherId" id="editSchoolTeacherId" value="">

                        <div class="row" id="schoolteacherAjax"></div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- School Teacher Edit Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                // scrollY: '300px',
                // paging: false,
                // footer: false,
                // info: false,
                // ordering: false,
                // searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });

            $('input[type=radio][name=rejectOrPreferred]').change(function() {
                var status = this.value;
                var qUrl = ""
                var current_url = window.location.href;
                var base_url = current_url.split("?")[0];
                var hashes = current_url.split("?")[1];
                var hash = hashes.split('&');
                for (var i = 0; i < hash.length; i++) {
                    params = hash[i].split("=");
                    if (params[0] == 'status') {
                        params[1] = status;
                    }
                    paramJoin = params.join("=");
                    qUrl = "" + qUrl + paramJoin + "&";
                }
                if (qUrl != '') {
                    qUrl = qUrl.substr(0, qUrl.length - 1);
                }
                var joinUrl = base_url + "?" + qUrl;
                window.location.assign(joinUrl);
            });
        });

        $(document).on('keyup', '#searchTeacherKey', function() {
            var searchTeacherKey = $(this).val();
            var school_id = '<?php echo $schoolDetail->school_id; ?>';
            if (searchTeacherKey.length > 3) {
                $('#searchTeacherId').val('');
                $.ajax({
                    type: 'POST',
                    url: '{{ url('searchTeacherList') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        searchTeacherKey: searchTeacherKey,
                        school_id: school_id
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data == 'login') {
                            var loginUrl = '<?php echo url('/'); ?>';
                            window.location.assign(loginUrl);
                        } else {
                            $('#searchTeacherView').html(data.html);
                        }
                    }
                });
            }
        });

        function searchTeacherRowSelect(teacher_id) {
            if ($('#searchTeacherRow' + teacher_id).hasClass('tableRowActive')) {
                $('#searchTeacherId').val('');
                $('#searchTeacherRow' + teacher_id).removeClass('tableRowActive');
            } else {
                $('#searchTeacherId').val(teacher_id);
                $('.searchTeacherRow').removeClass('tableRowActive');
                $('#searchTeacherRow' + teacher_id).addClass('tableRowActive');
            }
        }

        $(document).on('click', '#schoolTeacherAddBtn', function() {
            var searchTeacherId = $('#searchTeacherId').val();
            if (searchTeacherId) {
                $('#schoolTeacherAddForm').submit()
            } else {
                swal("", "Please select one teacher.");
            }
        });

        function editTeacherRowSelect(schoolTeacherList_id) {
            if ($('#editTeacherRow' + schoolTeacherList_id).hasClass('tableRowActive')) {
                $('#editTeacherId').val('');
                $('#editTeacherRow' + schoolTeacherList_id).removeClass('tableRowActive');
                $('#editSchoolTeacherBttn').addClass('disabled-link');
                $('#deleteSchoolTeacherBttn').addClass('disabled-link');
            } else {
                $('#editTeacherId').val(schoolTeacherList_id);
                $('.editTeacherRow').removeClass('tableRowActive');
                $('#editTeacherRow' + schoolTeacherList_id).addClass('tableRowActive');
                $('#editSchoolTeacherBttn').removeClass('disabled-link');
                $('#deleteSchoolTeacherBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editSchoolTeacherBttn', function() {
            var editTeacherId = $('#editTeacherId').val();
            var editSchoolId = $('#editSchoolId').val();
            if (editTeacherId) {
                $('#editSchoolTeacherId').val(editTeacherId);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('schoolTeacherEdit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        editTeacherId: editTeacherId,
                        editSchoolId: editSchoolId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#schoolteacherAjax').html(data.html);
                    }
                });
                $('#schoolTeacherEditModal').modal("show");
            } else {
                swal("", "Please select one teacher.");
            }
        });

        $(document).on('click', '#schoolTeacherEditBtn', function() {
            var editSearchTeacherId = $('#editSearchTeacherId').val();
            if (editSearchTeacherId) {
                $('#schoolTeacherEditForm').submit()
            } else {
                swal("", "Please select one teacher.");
            }
        });

        $(document).on('click', '#deleteSchoolTeacherBttn', function() {
            var editTeacherId = $('#editTeacherId').val();
            if (editTeacherId) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to remove this teacher?",
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
                                    url: '{{ url('schoolTeacherDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        editTeacherId: editTeacherId
                                    },
                                    success: function(data) {
                                        location.reload();
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
