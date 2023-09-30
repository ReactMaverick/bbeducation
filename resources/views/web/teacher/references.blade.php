@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.teacher.teacher_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.teacher.teacher_header')

                <div class="school-assignment-sec">
                    <div class="teacher-reference-section">
                        <div class="assignment-finance-heading-section">
                            <h2>References</h2>
                            <div class="assignment-finance-icon-section">
                                <a style="cursor: pointer;" class="disabled-link" id="deleteReferenceBttn"
                                    title="Delete reference">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                                {{-- <a style="cursor: pointer;" class="disabled-link" id="receiveReferenceBttn"
                                    title="Receive reference">
                                    <i class="fa-solid fa-square-check"></i>
                                </a> --}}
                                <a style="cursor: pointer;" class="disabled-link" id="saveReferenceBttn"
                                    title="Save received reference">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </a>
                                <a style="cursor: pointer;" class="disabled-link" id="previewReferenceBttn"
                                    title="Preview received reference">
                                    <img src="{{ asset('web/company_logo/search-file.png') }}" alt="">
                                </a>
                                <a style="cursor: pointer;" class="disabled-link" id="sendReferenceBttn"
                                    title="Resend reference request">
                                    {{-- <i class="fa-solid fa-envelope"></i> --}}
                                    <i class="fa-solid fa-bell"></i>
                                </a>
                                <a data-toggle="modal" data-target="#addTeacherReferenceModal" style="cursor: pointer;"
                                    title="Add new reference">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <a style="cursor: pointer;" class="disabled-link" id="editReferenceBttn"
                                    title="Edit reference">
                                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                                </a>
                            </div>

                        </div>
                        <div class="assignment-finance-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Employed At</th>
                                        <th>Date From</th>
                                        <th>Date Until</th>
                                        <th>Ref. Sent</th>
                                        <th>No.</th>
                                        <th>Reference Recieved</th>
                                        {{-- <th>Recieved</th>
                                        <th>Valid?</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    <?php $pendingReference = 0; ?>
                                    @foreach ($referenceList as $key => $reference)
                                        <tr class="school-detail-table-data editReferenceRow"
                                            id="editReferenceRow{{ $reference->teacherReference_id }}"
                                            onclick="editReferenceRowSelect({{ $reference->teacherReference_id }}, '<?php echo $reference->receivedOn_dtm; ?>')">
                                            <td>{{ $reference->employer_txt }}</td>
                                            <td>{{ $reference->employedFrom_dte != null ? date('d-m-Y', strtotime($reference->employedFrom_dte)) : '' }}
                                            </td>
                                            <td>{{ $reference->employedUntil_dte != null ? date('d-m-Y', strtotime($reference->employedUntil_dte)) : '' }}
                                            </td>
                                            <td>{{ $reference->lastSent_dte != null ? date('d-m-Y', strtotime($reference->lastSent_dte)) : '' }}
                                            </td>
                                            <td>{{ $reference->totalSent_int }}</td>
                                            <td>
                                                @if ($reference->req_reference_receive == 1)
                                                    Yes
                                                    @if ($reference->req_reference_receive_dte)
                                                        {{ ' ( ' . date('d-m-Y', strtotime($reference->req_reference_receive_dte)) . ' )' }}
                                                    @endif
                                                @else
                                                    No
                                                @endif
                                            </td>
                                            {{-- <td>{{ $reference->receivedOn_dtm != null ? date('d-m-Y', strtotime($reference->receivedOn_dtm)) : '' }}
                                            </td>
                                            <td>
                                                @if ($reference->receivedOn_dtm != null)
                                                    <?php //$pendingReference += 1;
                                                    ?>
                                                    @if ($reference->isValid_status == 0)
                                                        {{ 'N' }}
                                                    @else
                                                        {{ 'Y' }}
                                                    @endif
                                                @endif
                                            </td> --}}
                                            <?php
                                            if ($reference->receivedOn_dtm != null) {
                                                $pendingReference += 1;
                                            }
                                            ?>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <input type="hidden" name="teacherReferenceId" id="teacherReferenceId" value="">
                    <input type="hidden" name="referenceReceiveDate" id="referenceReceiveDate" value="">

                    <div class="assignment-first-sec">
                        <div class="assignment-left-sidebar-section">
                            <div class="references-bottom-sec">
                                <div class="assignment-sidebar-data">
                                    <h2>{{ count($referenceList) }}</h2>
                                </div>
                                <div class="sidebar-sec-text">
                                    <span>Total References</span>
                                </div>
                            </div>
                            <div class="references-bottom-sec">
                                <div class="assignment-sidebar-data2">
                                    <h2>{{ count($referenceList) - $pendingReference }}</h2>
                                </div>
                                <div class="sidebar-sec-text">
                                    <span>Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teacher Reference Add Modal -->
    <div class="modal fade" id="addTeacherReferenceModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width:100%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Teacher Reference</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Add Teacher Reference</h2>
                </div>

                <form action="{{ url('/newTeacherReferenceInsert') }}" method="post" class="form-validate">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>
                            @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                            @else
                                {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                            @endif
                        </h6>
                        {{-- <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p> --}}
                        <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                        <div class="row">
                            <div class="col-md-6 modal-col">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Reference Type</label><span style="color: red;">*</span>
                                    <select class="form-control field-validate" name="referenceType_id" style="width:100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($referenceTypeList as $key1 => $referenceType)
                                            <option value="{{ $referenceType->referenceType_id }}">
                                                {{ $referenceType->title_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">School/Establishment/Employer Name</label><span
                                        style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate" name="employer_txt"
                                        id="" value="">
                                </div>

                                <div class="modal-input-field">
                                    <label class="form-check-label">Address</label>
                                    <input type="text" class="form-control mb-1" name="address1_txt" id=""
                                        value="">
                                    <input type="text" class="form-control mb-1" name="address2_txt" id=""
                                        value="">
                                    <input type="text" class="form-control mb-1" name="address3_txt" id=""
                                        value="">
                                    <input type="text" class="form-control" name="addrress4_txt" id=""
                                        value="">
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Postcode</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate" name="postcode_txt"
                                        id="" value="">
                                </div>
                            </div>
                            <div class="col-md-6 modal-col">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Referee Name</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate" name="refereeName_txt"
                                        id="" value="">
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Referee Email</label><span
                                        style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate" name="refereeEmail_txt"
                                        id="" value="">
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Employed From</label><span
                                        style="color: red;">*</span>
                                    <input type="text" class="form-control datePickerPaste datepaste-validate"
                                        name="employedFrom_dte" id="" value="">
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Employed Until</label><span
                                        style="color: red;">*</span>
                                    <input type="text" class="form-control datePickerPaste datepaste-validate"
                                        name="employedUntil_dte" id="" value="">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="submit" class="btn btn-secondary" id="referenceAddBtn">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Teacher Reference Add Modal -->

    <!-- Teacher Reference Edit Modal -->
    <div class="modal fade" id="editTeacherReferenceModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width:100%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Reference</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Teacher Reference</h2>
                </div>

                <form action="{{ url('/newTeacherReferenceUpdate') }}" method="post" class="form-validate-2">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>
                            @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                            @else
                                {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                            @endif
                        </h6>
                        {{-- <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p> --}}
                        <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">
                        <input type="hidden" name="teacherReference_id" id="editTeacherReferenceId" value="">

                        <div class="row" id="editReferenceAjax"></div>

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
    <!-- Teacher Reference Edit Modal -->

    <!-- Teacher Receive Reference Modal -->
    <div class="modal fade" id="receiveTeacherReferenceModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section" style="max-width:90%;">
            <div class="modal-content calendar-modal-content" style="width:100%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Receive Teacher Reference</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Receive Teacher Reference</h2>
                </div>

                <form action="{{ url('/receiveReferenceUpdate') }}" method="post" class="form-validate-3">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>
                            @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                            @else
                                {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                            @endif
                        </h6>
                        {{-- <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p> --}}
                        <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">
                        <input type="hidden" name="teacherReference_id" id="receiveTeacherReferenceId" value="">

                        <div class="row" id="receiveReferenceAjax"></div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="submit" class="btn btn-secondary">Complete</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Teacher Receive Reference Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: false
            });
        });

        function editReferenceRowSelect(teacherReference_id, receivedOn_dtm) {
            if ($('#editReferenceRow' + teacherReference_id).hasClass('tableRowActive')) {
                $('#teacherReferenceId').val('');
                $('#referenceReceiveDate').val('');
                $('#editReferenceRow' + teacherReference_id).removeClass('tableRowActive');
                $('#receiveReferenceBttn').addClass('disabled-link');
                $('#previewReferenceBttn').addClass('disabled-link');
                $('#sendReferenceBttn').addClass('disabled-link');
                $('#editReferenceBttn').addClass('disabled-link');
                $('#saveReferenceBttn').addClass('disabled-link');
                $('#deleteReferenceBttn').addClass('disabled-link');
            } else {
                $('#teacherReferenceId').val(teacherReference_id);
                $('#referenceReceiveDate').val(receivedOn_dtm);
                $('.editReferenceRow').removeClass('tableRowActive');
                $('#editReferenceRow' + teacherReference_id).addClass('tableRowActive');
                $('#receiveReferenceBttn').removeClass('disabled-link');
                $('#previewReferenceBttn').removeClass('disabled-link');
                $('#sendReferenceBttn').removeClass('disabled-link');
                $('#editReferenceBttn').removeClass('disabled-link');
                $('#saveReferenceBttn').removeClass('disabled-link');
                $('#deleteReferenceBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editReferenceBttn', function() {
            var teacherReferenceId = $('#teacherReferenceId').val();
            var referenceReceiveDate = $('#referenceReceiveDate').val();
            if (teacherReferenceId) {
                // if (referenceReceiveDate) {
                //     swal("",
                //         "You cannot edit the core details for this reference as it has been received and logged."
                //     );
                // } else {
                $('#editTeacherReferenceId').val(teacherReferenceId);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('teacherReferenceEdit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacherReferenceId: teacherReferenceId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#editReferenceAjax').html(data.html);
                    }
                });
                $('#editTeacherReferenceModal').modal("show");

                // }
            } else {
                swal("", "Please select one reference.");
            }
        });

        $(document).on('click', '#receiveReferenceBttn', function() {
            var teacherReferenceId = $('#teacherReferenceId').val();
            var referenceReceiveDate = $('#referenceReceiveDate').val();
            if (teacherReferenceId) {
                if (referenceReceiveDate) {
                    swal({
                            title: "Alert",
                            text: "This reference has already been logged as received. Are you sure you wish to go in and change any details?",
                            buttons: {
                                cancel: "No",
                                Yes: "Yes"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "Yes":
                                    $('#receiveTeacherReferenceId').val(teacherReferenceId);
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('getTeacherReceiveReference') }}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            teacherReferenceId: teacherReferenceId
                                        },
                                        success: function(data) {
                                            //console.log(data);
                                            $('#receiveReferenceAjax').html(data.html);
                                        }
                                    });
                                    $('#receiveTeacherReferenceModal').modal("show");
                            }
                        });
                } else {
                    $('#receiveTeacherReferenceId').val(teacherReferenceId);
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('getTeacherReceiveReference') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            teacherReferenceId: teacherReferenceId
                        },
                        success: function(data) {
                            //console.log(data);
                            $('#receiveReferenceAjax').html(data.html);
                        }
                    });
                    $('#receiveTeacherReferenceModal').modal("show");
                }
            } else {
                swal("", "Please select one reference.");
            }
        });

        $(document).on('click', '#referenceAddBtn', function() {
            $('#fullLoader').show();
        });

        $(document).on('click', '#sendReferenceBttn', function() {
            var teacherReferenceId = $('#teacherReferenceId').val();
            if (teacherReferenceId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to send reference request?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: "{{ url('teacherReferenceResend') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        teacherReferenceId: teacherReferenceId
                                    },
                                    success: function(data) {
                                        //console.log(data);
                                        if (data.add == 'Yes') {
                                            swal("",
                                                "Reference request mail has been send successfully."
                                            );
                                        } else {
                                            swal("",
                                                "Somthing went wrong.");
                                        }
                                        $('#fullLoader').hide();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one reference.");
            }
        });

        $(document).on('click', '#previewReferenceBttn', function() {
            var teacherReferenceId = $('#teacherReferenceId').val();
            if (teacherReferenceId) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('teacherReferencePreview') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacherReferenceId: teacherReferenceId
                    },
                    success: function(data) {
                        if (data.exist == 'Yes' && data.receive == 'Yes' && data.pdf_path) {
                            window.open(data.pdf_path, '_blank');
                        } else {
                            swal("", "Reference feedback not yet recevied.");
                        }
                    }
                });
            } else {
                swal("", "Please select one reference.");
            }
        });

        $(document).on('click', '#saveReferenceBttn', function() {
            var teacherReferenceId = $('#teacherReferenceId').val();
            if (teacherReferenceId) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('teacherReferencePreview') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacherReferenceId: teacherReferenceId
                    },
                    success: function(data) {
                        if (data.exist == 'Yes' && data.receive == 'Yes' && data.pdf_path) {
                            const link = document.createElement('a');
                            link.href = data.pdf_path;
                            link.download = (data.pdf_path).split("/").pop();
                            link.target = '_blank';
                            link.click();
                        } else {
                            swal("", "Reference feedback not yet recevied.");
                        }
                    }
                });
            } else {
                swal("", "Please select one reference.");
            }
        });

        $(document).on('click', '#deleteReferenceBttn', function() {
            var teacherReferenceId = $('#teacherReferenceId').val();
            if (teacherReferenceId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to remove the selected reference?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                $.ajax({
                                    type: 'POST',
                                    url: "{{ url('teacherReferenceDelete') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        teacherReferenceId: teacherReferenceId
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one reference.");
            }
        });
    </script>
@endsection
