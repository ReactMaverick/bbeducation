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
                                    <h2>Finance</h2>
                                </div>
                                <div class="teacher-left-sec skd_row dataTables_wrapper">
                                    <div class="about-teacher skd_icon_box small-box bg-info">
                                        <a class="" href="{{ URL::to('/finance-timesheets') }}">
                                            <div class="inner text-white">
                                                <p>Timesheets</p>
                                            </div>
                                            <div class="icon"><i class="far fa-file-alt"></i></div>
                                        </a>
                                    </div>

                                    <div class="about-teacher skd_icon_box small-box bg-success">
                                        <a class="" href="{{ URL::to('/finance-invoices') }}">
                                            <div class="inner text-white">
                                                <p>Invoicing</p>
                                            </div>
                                            <div class="icon"><i class="fas fa-file-invoice"></i></div>
                                        </a>
                                    </div>

                                    <div class="about-teacher skd_icon_box small-box bg-warning">
                                        <a class="" href="{{ URL::to('/finance-payroll') }}">
                                            <div class="inner text-white">
                                                <p>Payroll</p>
                                            </div>
                                            <div class="icon"><i class="fas fa-piggy-bank"></i></div>
                                        </a>
                                    </div>

                                    <div class="about-teacher skd_icon_box small-box bg-primary">
                                        <a class="" href="{{ URL::to('/finance-remittance?include=&method=') }}">
                                            <div class="inner text-white">
                                                <p>Remit Invoice</p>
                                            </div>
                                            <div class="icon"><i class="fas fa-file-alt"></i></div>
                                        </a>
                                    </div>

                                    <div class="about-teacher skd_icon_box small-box bg-dark">
                                        <a data-toggle="modal" data-target="#exportInvoiesModal" style="cursor: pointer;">
                                            <div class="inner text-white">
                                                <p>Export</p>
                                                <p>Invoices</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-file-export"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Export Invoice Modal -->
    <div class="modal fade" id="exportInvoiesModal">
        <div class="modal-dialog modal-sm modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Export Invoices</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Export Invoices</h2>
                    </div>

                    <form action="{{ url('/exportInvoiceByDate') }}" method="post" class="form-validate"
                        id="exportInvsForm">
                        @csrf
                        <div class="modal-input-field-section">

                            <div class="form-group modal-input-field">
                                <label class="form-check-label">From</label><span style="color: red;">*</span>
                                <input type="date" class="form-control field-validate" name="date_from" id="date_from"
                                    value="">
                            </div>

                            <div class="form-group modal-input-field">
                                <label class="form-check-label">To</label><span style="color: red;">*</span>
                                <input type="date" class="form-control field-validate" name="date_to" id="date_to"
                                    value="">
                            </div>

                            <div class="form-group calendar-form-filter">
                                <label for="">Download Type</label><span style="color: red;">*</span>
                                <select class="form-control field-validate" name="download_type" id="download_type">
                                    <option value="">Choose one</option>
                                    <option value="Excel">Excel</option>
                                    <option value="CSV">CSV</option>
                                    <option value="Pdf">Pdf</option>
                                </select>
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="exportInvsBtn">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Export Invoice Modal -->

    <script>
        $(document).on('click', '#exportInvsBtn', function() {
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
                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();
                var download_type = $('#download_type').val();
                var url = "{{ url('exportInvoiceByDate') }}" + '/' + date_from + '/' + date_to + '/' +
                    download_type;
                window.open(url, '_blank');

                $('#date_from').val('');
                $('#date_to').val('');
                $('#download_type').val('');
                $('#exportInvoiesModal').modal("hide");
            }
        });
    </script>
@endsection
