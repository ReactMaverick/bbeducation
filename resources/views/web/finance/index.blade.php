@extends('web.layout')
@section('content')
    <!-- <div class="tab-content finance-tab-content" id="myTabContent"> -->
    <div class="assignment-section-col">

        <div class="teacher-all-section">
            <div class="finance-section">
                <div class="teacher-page-sec">
                    <h2>Finance</h2>
                </div>
                <div class="teacher-left-sec">
                    <div class="about-finance">
                        <a href="{{ URL::to('/finance-timesheets') }}"> <i class="fa-solid fa-file-lines"></i>
                            <p>Timesheets</p>
                        </a>
                    </div>

                    <div class="about-finance">
                        <a href="{{ URL::to('/finance-invoices') }}"> <i class="fa-solid fa-money-bills"></i>
                            <p>Invoicing</p>
                        </a>
                    </div>

                    <div class="about-finance">
                        <a href="{{ URL::to('/finance-payroll') }}"> <i class="fa-solid fa-piggy-bank"></i>
                            <p>Payroll</p>
                        </a>
                    </div>

                    <div class="about-finance">
                        <a href="{{ URL::to('/finance-remittance?include=&method=') }}"> <i
                                class="fa-regular fa-file-lines"></i>
                            <p>Remit Invoice</p>
                        </a>
                    </div>

                    <div class="about-finance">
                        <a data-toggle="modal" data-target="#exportInvoiesModal" style="cursor: pointer;">
                            <i class="fa-solid fa-envelope"></i>
                            <p>Export</p>
                            <p>Invoices</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->

    <!-- Export Invoice Modal -->
    <div class="modal fade" id="exportInvoiesModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section" style="max-width: 700px;">
            <div class="modal-content calendar-modal-content" style="width: 55%">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Export Invoices</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-envelope school-edit-icon"></i>
                    <h2>Export Invoices</h2>
                </div>

                <form action="{{ url('/exportInvoiceByDate') }}" method="post" class="form-validate" id="exportInvsForm">
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
