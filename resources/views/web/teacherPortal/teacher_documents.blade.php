@extends('web.teacherPortal.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.teacherPortal.teacher_header')
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

                    <div class="col-md-12 topbar-sec">

                        <div class="school-detail-right-sec ">

                            <div class="teacher-document-table-sec sec_box_edit">
                                <div class="contact-heading  details-heading">
                                    <div class="contact-heading-text">
                                        <h2>Filed Documents</h2>
                                    </div>
                                    <div class="contact-icon-sec">

                                        <a data-toggle="modal" data-target="#documentAddModal" style="cursor: pointer;">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>

                                    </div>
                                </div>
                                <div class="assignment-finance-table-section about-school-section table-responsive">
                                    <table class="table table-bordered table-striped" id="myTable">
                                        <thead>
                                            <tr class="school-detail-table-heading">
                                                <th>#</th>
                                                <th>File Name</th>
                                                <th>File Type</th>
                                                <th>Document Type</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body-sec">
                                            @if (count($documentList) > 0)
                                                @foreach ($documentList as $key => $document)
                                                    <tr class="school-detail-table-data editDocumentRow"
                                                        id="editDocumentRow{{ $document->teacherDocument_id }}"
                                                        onclick="documentRowSelect({{ $document->teacherDocument_id }})">
                                                        <td>{{ $key + 1 }}</td>
                                                        <td><a class="file_name"
                                                                href="{{ asset($document->file_location) }}"
                                                                target="_blank">{{ $document->file_name }}</a></td>
                                                        <td>{{ $document->file_type }}</td>
                                                        <td>{{ $document->doc_type_txt }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($document->uploadOn_dtm)) }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr colspan="5">
                                                    <td>No document found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <input type="hidden" name="DocumentId" id="DocumentId" value="">

                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Document Add Modal -->
    <div class="modal fade" id="documentAddModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Teacher Document</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-pencil school-edit-icon"></i>
                        <h2>Add Document</h2>
                    </div>

                    <form action="{{ url('/candidate/logTeacherDocInsert') }}" method="post" class="form-validate-3"
                        enctype="multipart/form-data">
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
                                <div class="col-md-12">
                                    <div class="modal-input-field form-group" hidden>
                                        <label class="form-check-label">Document Name</label>
                                        <input type="text" class="form-control" name="file_name" id="docNameHidden"
                                            value="">
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Document Type</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate-3 select2" name="type_int" id="type_int"
                                            style="width: 100%;"
                                            onchange="docTypeChange(this.value, this.options[this.selectedIndex].getAttribute('descTxt'))">
                                            <option value="">Choose one</option>
                                            @foreach ($typeList as $key5 => $type)
                                                <option value="{{ $type->description_int }}"
                                                    descTxt="{{ $type->description_txt }}">
                                                    {{ $type->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Upload Document</label><span
                                            style="color: red;">*</span>
                                        <input type="file" class="form-control file-validate-3" name="file"
                                            id="" value=""><span> *Only file type 'jpg', 'png', 'jpeg',
                                            'pdf', 'doc',
                                            'docx'</span>
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
    <div class="modal fade" id="DocumentEditModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Document</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-pencil school-edit-icon"></i>
                        <h2>Edit Document</h2>
                    </div>

                    <form action="{{ url('/candidate/logTeacherDocUpdate') }}" method="post" class="form-validate-4"
                        enctype="multipart/form-data">
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
                            <input type="hidden" name="editDocumentId" id="editDocumentId" value="">

                            <div class="row" id="docEditAjax"></div>
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
                scrollY: '300px',
                paging: false,
                // footer: false,
                info: false,
                ordering: false
            });
        });

        function documentRowSelect(teacherDocument_id) {
            if ($('#editDocumentRow' + teacherDocument_id).hasClass('tableRowActive')) {
                $('#DocumentId').val('');
                $('#editDocumentRow' + teacherDocument_id).removeClass('tableRowActive');
                $('#deleteDocumentBttn').addClass('disabled-link');
                $('#editDocumentBttn').addClass('disabled-link');
                $('#documentMailBttn').addClass('disabled-link');
            } else {
                $('#DocumentId').val(teacherDocument_id);
                $('.editDocumentRow').removeClass('tableRowActive');
                $('#editDocumentRow' + teacherDocument_id).addClass('tableRowActive');
                $('#deleteDocumentBttn').removeClass('disabled-link');
                $('#editDocumentBttn').removeClass('disabled-link');
                $('#documentMailBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editDocumentBttn', function() {
            var DocumentId = $('#DocumentId').val();
            if (DocumentId) {
                $('#editDocumentId').val(DocumentId);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('getTeacherDocDetail') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        DocumentId: DocumentId
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
            var DocumentId = $('#DocumentId').val();
            if (DocumentId) {
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
                                    url: '{{ url('/candidate/logTeacherDocDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        DocumentId: DocumentId
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

        function docTypeChange(desc_int, description_txt) {
            $('#docNameHidden').val(description_txt)
        }
    </script>
@endsection
