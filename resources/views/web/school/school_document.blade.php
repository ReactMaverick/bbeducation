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
                            <div class="row my_row_gap">
                                <div class="col-md-10 col-lg-10 col-xl-10 col-12 col-sm-12">
                                    <div class="school-assignment-section sec_box_edit">
                                        <div class="teacher-list-section details-heading">
                                            <div class="school-teacher-heading-text">
                                                <h2>Document</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteDocumentBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#documentAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editDocumentBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="teacher-list-right-sec">
                                            <div class="teacher-list-page-table">
                                                <table class="table table-bordered table-striped" id="myTable">
                                                    <thead>
                                                        <tr class="school-detail-table-heading">
                                                            <th>#</th>
                                                            <th>File Name</th>
                                                            <th>File Type</th>
                                                            <th>Document Type</th>
                                                            <th>Other</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-body-sec">
                                                        @foreach ($documentList as $key => $document)
                                                            <tr class="school-detail-table-data editDocumentRow"
                                                                id="editDocumentRow{{ $document->schoolDocument_id }}"
                                                                onclick="documentRowSelect({{ $document->schoolDocument_id }})">
                                                                <td>{{ $key + 1 }}</td>
                                                                <td><a href="{{ asset($document->file_location) }}"
                                                                        target="_blank">{{ $document->file_name }}</a></td>
                                                                <td>{{ $document->file_type }}</td>
                                                                <td>{{ $document->document_type_text }}</td>
                                                                <td>
                                                                    @if ($document->documentType == 1)
                                                                        {{ $document->othersText }}
                                                                    @else
                                                                        {{ 'N/A' }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ date('d M Y', strtotime($document->uploadOn_dtm)) }}
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
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Document Add Modal -->
    <div class="modal fade" id="documentAddModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add School Document</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Document</h2>
                    </div>

                    <form action="{{ url('/schoolDocumentInsert') }}" method="post" class="form-validate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>{{ $schoolDetail->name_txt }}</h6>
                            <span>ID</span>
                            <p>{{ $schoolDetail->school_id }}</p>
                            <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Document Name</label>
                                        <input type="text" class="form-control" name="file_name" id="fileName"
                                            value="">
                                    </div>
                                    <input type="hidden" class="form-control" name="file_name_hidden" id="file_name_hidden"
                                        value="">

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Document Type</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate" name="documentType" id="documentType"
                                            onchange="docTypeChange(this.value, this.options[this.selectedIndex].getAttribute('descTxt'))">
                                            <option value="">Choose one</option>
                                            @foreach ($typeList as $key5 => $type)
                                                <option value="{{ $type->document_type_id }}"
                                                    descTxt="{{ $type->document_type_text }}">
                                                    {{ $type->document_type_text }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-input-field form-group" id="othersTextDiv" style="display: none;">
                                        <label class="form-check-label">Others</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control" name="othersText" id="othersText"
                                            value="">
                                    </div>

                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Upload Document</label><span
                                            style="color: red;">*</span>
                                        <input type="file" class="form-control file-validate" name="file"
                                            id="" value=""><span> *Only file type 'jpg', 'png', 'jpeg',
                                            'pdf', 'doc',
                                            'docx', 'txt'</span>
                                    </div>
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
    <!-- Document Add Modal -->

    <!-- Document Edit Modal -->
    <div class="modal fade" id="DocumentEditModal" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit School Document</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Document</h2>
                    </div>

                    <form action="{{ url('/schoolDocumentUpdate') }}" method="post" class="form-validate-2"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="editDocumentId" id="editDocumentId" value="">
                        <div class="modal-input-field-section">
                            <h6>{{ $schoolDetail->name_txt }}</h6>
                            <span>ID</span>
                            <p>{{ $schoolDetail->school_id }}</p>
                            <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

                            <div id="docEditAjax"></div>
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
    <!-- Document Edit Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        function documentRowSelect(schoolDocument_id) {
            if ($('#editDocumentRow' + schoolDocument_id).hasClass('tableRowActive')) {
                $('#editDocumentId').val('');
                $('#editDocumentRow' + schoolDocument_id).removeClass('tableRowActive');
                $('#deleteDocumentBttn').addClass('disabled-link');
                $('#editDocumentBttn').addClass('disabled-link');
            } else {
                $('#editDocumentId').val(schoolDocument_id);
                $('.editDocumentRow').removeClass('tableRowActive');
                $('#editDocumentRow' + schoolDocument_id).addClass('tableRowActive');
                $('#deleteDocumentBttn').removeClass('disabled-link');
                $('#editDocumentBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editDocumentBttn', function() {
            var editDocumentId = $('#editDocumentId').val();
            if (editDocumentId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('getSchoolDocDetail') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        editDocumentId: editDocumentId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#docEditAjax').html(data.html);
                    }
                });
                $('#DocumentEditModal').modal("show");
            } else {
                swal("", "Please select one document.");
            }
        });

        $(document).on('click', '#deleteDocumentBttn', function() {
            var editDocumentId = $('#editDocumentId').val();
            if (editDocumentId) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to remove this document?",
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
                                    url: '{{ url('schoolDocumentDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        editDocumentId: editDocumentId
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one document.");
            }
        });

        $(document).on('change', '#documentType', function() {
            var documentType = $(this).val();
            if (documentType != '' && documentType == 1) {
                $('#othersTextDiv').show();
                $('#othersText').addClass('field-validate');
            } else {
                $('#othersTextDiv').hide();
                $('#othersText').val('');
                $('#othersText').removeClass('field-validate');
                $('#othersText').closest(".form-group").removeClass('has-error');
            }
        });

        function docTypeChange(desc_int, description_txt) {
            var txt = $('#fileName').val()
            $('#file_name_hidden').val(description_txt)
            if (txt == null || txt == '') {
                $('#fileName').val(description_txt)
            }
        }
    </script>
@endsection
