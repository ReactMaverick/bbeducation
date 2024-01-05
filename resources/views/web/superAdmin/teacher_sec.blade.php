@extends('web.superAdmin.layout')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">
                        <h4 style="text-align: center;border: 2px solid #ddd;">Teacher Section</h4>
                        <div class="school-detail-right-sec">
                            <div class="row my_row_gap">
                                <div class="col-md-4 col-lg-4 col-xl-4 col-12 col-sm-12">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>All Bank</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteBankBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#bankAddModal" style="cursor: pointer;"
                                                    class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editBankBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="myTable1">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>#</th>
                                                        <th>Bank Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($bankList as $key1 => $bank)
                                                        <tr class="school-detail-table-data editBankRow"
                                                            onclick="bankRowSelect('{{ $bank->description_int }}','{{ $bank->description_txt }}')"
                                                            id="editBankRow{{ $bank->description_int }}">
                                                            <td>{{ $key1 + 1 }}</td>
                                                            <td>{{ $bank->description_txt }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-4 col-lg-4 col-xl-4 col-12 col-sm-12">
                                    <div class="school-details-second-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Last Contact</h2>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-4 col-xl-4 col-12 col-sm-12">
                                    <div class="school-details-second-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Last Contact</h2>
                                        </div>


                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        {{-- <div class="school-detail-right-sec mt-3">
                            <div class="row my_row_gap">
                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="school-details-contact-second-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Contacts</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="deleteContactBttn">
                                                    <i class="fas fa-trash-alt trash-icon"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#ContactAddModal"
                                                    style="cursor: pointer;" class="icon_all">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link icon_all"
                                                    id="editContactBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="details-table">
                                            <div class="contact-heading details-heading">
                                                <div class="contact-heading-text">
                                                    <h2>Contact Items</h2>
                                                </div>
                                                <div class="contact-icon-sec">
                                                    <a style="cursor: pointer" class="disabled-link icon_all"
                                                        id="phoneContactItemBttn">
                                                        <i class="fas fa-mobile-alt"></i>
                                                    </a>
                                                    <a style="cursor: pointer" class="disabled-link icon_all"
                                                        id="mailContactItemBttn">
                                                        <i class="fas fa-envelope-open-text"></i>
                                                    </a>
                                                    <a style="cursor: pointer" class="disabled-link icon_all"
                                                        id="deleteContactItemBttn">
                                                        <i class="fas fa-trash-alt trash-icon"></i>
                                                    </a>
                                                    <a data-toggle="modal" data-target="#ContactItemAddModal"
                                                        style="cursor: pointer;" class="icon_all">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </a>
                                                    <a style="cursor: pointer" class="disabled-link icon_all"
                                                        id="editContactItemBttn">
                                                        <i class="fas fa-edit school-edit-icon"></i>
                                                    </a>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Bank Add Modal -->
    <div class="modal fade" id="bankAddModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Bank</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Bank</h2>
                    </div>

                    <form action="{{ url('/sysAddBank') }}" method="post" class="form-validate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Bank Name</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate" name="bankName" id=""
                                        value="">
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
    <!-- Bank Add Modal -->

    <!-- Bank Edit Modal -->
    <div class="modal fade" id="bankEditModal">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Bank</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Bank</h2>
                    </div>

                    <form action="{{ url('/sysEditBank') }}" method="post" class="form-validate-2"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="bankId" id="editBankDescInt" value="">

                        <div class="modal-input-field-section">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Bank Name</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate-2" name="bankName"
                                        id="editBankName" value="">
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
    <!-- Bank Edit Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable1, #myTable2').DataTable({
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

        // For bank
        function bankRowSelect(desc_int, b_name) {
            if ($('#editBankRow' + desc_int).hasClass('tableRowActive')) {
                $('#editBankDescInt').val('');
                $('#editBankName').val('');
                $('#editBankRow' + desc_int).removeClass('tableRowActive');
                $('#deleteBankBttn').addClass('disabled-link');
                $('#editBankBttn').addClass('disabled-link');
            } else {
                $('#editBankDescInt').val(desc_int);
                $('#editBankName').val(b_name);
                $('.editBankRow').removeClass('tableRowActive');
                $('#editBankRow' + desc_int).addClass('tableRowActive');
                $('#deleteBankBttn').removeClass('disabled-link');
                $('#editBankBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editBankBttn', function() {
            var bank_id = $('#editBankDescInt').val();
            if (bank_id) {
                $('#bankEditModal').modal("show");
            } else {
                swal("", "Please select one bank.");
            }
        });

        $(document).on('click', '#deleteBankBttn', function() {
            var bank_id = $('#editBankDescInt').val();
            if (bank_id) {
                swal({
                        title: "",
                        text: "Are you sure you wish to remove this bank?",
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
                                    url: "{{ url('sysDeleteBank') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        bank_id: bank_id
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
                swal("", "Please select one contact.");
            }
        });
        // For bank
    </script>
@endsection
