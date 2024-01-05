{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
@section('content')
    <div class="tab-content assignment-tab-content">
        <div class="container-fluid my_container-fluid">
            <div class="col-md-12 topbar-sec pt-3">
                <div class="total-sec">
                    <div class="school-assignment-sec sec_box_edit">
                        <div class="teacher-pending-reference-section">
                            <div class="assignment-finance-heading-section header_icon details-heading">
                                <h2>References</h2>
                                <div class="assignment-finance-icon-section">
                                    <a style="cursor: pointer;" class="disabled-link icon_all" id="sendReferenceBttn"
                                        title="Resend reference request">
                                        {{-- <i class="fa-solid fa-envelope"></i> --}}
                                        <i class="fas fa-bell"></i>
                                    </a>
                                    <a style="cursor: pointer;" class="disabled-link icon_all" id="editReferenceBttn"
                                        title="Edit reference">
                                        <i class="fas fa-edit school-edit-icon"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="assignment-candidate-table-section">
                                <table class="table table-bordered table-striped" id="myTable">
                                    <thead>
                                        <tr class="school-detail-table-heading">
                                            <th>Teacher</th>
                                            <th>Employer</th>
                                            <th>Date From</th>
                                            <th>Date Until</th>
                                            <th>Ref. Sent</th>
                                            <th>No.</th>
                                            <th>Days Over</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body-sec">
                                        @foreach ($pendingRefList as $key => $pendingRef)
                                            <tr class="school-detail-table-data editReferenceRow"
                                                id="editReferenceRow{{ $pendingRef->teacherReference_id }}"
                                                onclick="editReferenceRowSelect({{ $pendingRef->teacherReference_id }}, '<?php echo $pendingRef->receivedOn_dtm; ?>')">
                                                <td>
                                                    @if ($pendingRef->knownAs_txt == null || $pendingRef->knownAs_txt == '')
                                                        {{ $pendingRef->firstName_txt . ' ' . $pendingRef->surname_txt }}
                                                    @else
                                                        {{ $pendingRef->firstName_txt . ' (' . $pendingRef->knownAs_txt . ') ' . $pendingRef->surname_txt }}
                                                    @endif
                                                </td>
                                                <td>{{ $pendingRef->employer_txt }}</td>
                                                <td>{{ $pendingRef->employedFrom_dte ? date('d M Y', strtotime($pendingRef->employedFrom_dte)) : '' }}
                                                </td>
                                                <td>{{ $pendingRef->employedUntil_dte ? date('d M Y', strtotime($pendingRef->employedUntil_dte)) : '' }}
                                                </td>
                                                <td>{{ $pendingRef->lastSent_txt }}</td>
                                                <td>{{ $pendingRef->totalSent_int }}</td>
                                                <td>{{ $pendingRef->overDueDays_int }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <input type="hidden" name="teacherReferenceId" id="teacherReferenceId" value="">
                            <input type="hidden" name="referenceReceiveDate" id="referenceReceiveDate" value="">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teacher Reference Edit Modal -->
    <div class="modal fade" id="editTeacherReferenceModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Reference</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Teacher Reference</h2>
                    </div>

                    <form action="{{ url('/newTeacherReferenceUpdate') }}" method="post" class="form-validate-2">
                        @csrf
                        <div class="modal-input-field-section">

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
    </div>
    <!-- Teacher Reference Edit Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: false,
                pageLength: 25,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        function editReferenceRowSelect(teacherReference_id, receivedOn_dtm) {
            if ($('#editReferenceRow' + teacherReference_id).hasClass('tableRowActive')) {
                $('#teacherReferenceId').val('');
                $('#referenceReceiveDate').val('');
                $('#editReferenceRow' + teacherReference_id).removeClass('tableRowActive');
                $('#sendReferenceBttn').addClass('disabled-link');
                $('#editReferenceBttn').addClass('disabled-link');
            } else {
                $('#teacherReferenceId').val(teacherReference_id);
                $('#referenceReceiveDate').val(receivedOn_dtm);
                $('.editReferenceRow').removeClass('tableRowActive');
                $('#editReferenceRow' + teacherReference_id).addClass('tableRowActive');
                $('#sendReferenceBttn').removeClass('disabled-link');
                $('#editReferenceBttn').removeClass('disabled-link');
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
    </script>
@endsection
