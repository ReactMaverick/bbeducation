{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
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
                    @include('web.finance.finance_header')
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">
                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">

                        <div class="finance-invoice-right-sec">
                            <div class="row my_row_gap">
                                <div class="col-md-5 col-lg-5 col-xl-5 col-12 col-sm-12">
                                    <div class="finance-invoice-contact-first-sec sec_box_edit">
                                        <div class="invoice-top-section details-heading new_invoice_details">
                                            <div class="form-group timesheet-top-input-sec top-input">
                                                <form class="finance_timesheets_form top-input_form"
                                                    action="{{ url('/finance-invoices') }}" method="get"
                                                    style="margin-bottom: 0;">
                                                    <label for=""
                                                        class="col-form-label finance_timesheets_label">Timesheets
                                                        Until</label>
                                                    <input type="hidden" name="invoiceNumberMin"
                                                        value="{{ app('request')->input('invoiceNumberMin') }}">
                                                    <input type="hidden" name="invoiceNumberMax"
                                                        value="{{ app('request')->input('invoiceNumberMax') }}">
                                                    <input type="text" class="datePickerPaste" name="date"
                                                        value="{{ app('request')->input('date') ? app('request')->input('date') : date('d/m/Y', strtotime($p_maxDate)) }}">
                                                    <input type="hidden" class="datePickerPaste" name="invoiceFromDate"
                                                        value="{{ app('request')->input('invoiceFromDate') ? app('request')->input('invoiceFromDate') : '' }}">
                                                    <input type="hidden" class="datePickerPaste" name="invoiceToDate"
                                                        value="{{ app('request')->input('invoiceToDate') ? app('request')->input('invoiceToDate') : '' }}">
                                                    <input type="hidden" id="" class="onlynumber"
                                                        name="invoiceNumberMin"
                                                        value="{{ app('request')->input('invoiceNumberMin') }}">
                                                    <input type="hidden" id="" class="onlynumber"
                                                        name="invoiceNumberMax"
                                                        value="{{ app('request')->input('invoiceNumberMax') }}">
                                                    <input type="hidden" name="showSent"
                                                        value="{{ app('request')->input('showSent') ? app('request')->input('showSent') : 'false' }}">
                                                    <button
                                                        type="submit"class="btn btn-secondary timesheet-search-btn">Search</button>
                                                </form>
                                            </div>
                                            <div class="invoice-top-btn-sec">
                                                <button class="btn btn-warning btn_nw" id="selectNoneBtn">Select
                                                    None</button>
                                            </div>

                                            <div class="invoice-top-btn-sec">
                                                <button class="btn btn-info btn_nw" id="selectAllBtn">Select All</button>
                                            </div>
                                            <div class="invoice-edit-icon">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="timesheetEditBtn" title="Edit timesheet">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <?php
                                        $asnItemIdsArr = [];
                                        foreach ($timesheetList as $key => $time) {
                                            array_push($asnItemIdsArr, $time->asnItem_id);
                                        }
                                        $asnItemIds = implode(',', $asnItemIdsArr);
                                        ?>

                                        <div
                                            class="finance-invoice-table-section finance-invoice-page-table financeInvoiceTableNew">
                                            <table class="table table-bordered table-striped" id="myTable1">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>School</th>
                                                        <th>Teacher</th>
                                                        <th>Date</th>
                                                        <th>Part</th>
                                                        <th>Charge</th>
                                                        <th>Pay</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec" id="timesheetTbody">
                                                    @foreach ($timesheetList as $key1 => $timesheet)
                                                        <tr class="school-detail-table-data editTimesheetRow"
                                                            id="editTimesheetRow{{ $timesheet->asnItem_id }}"
                                                            onclick="timesheetRow('{{ $timesheet->asnItem_id }}')">
                                                            <td>{{ $timesheet->name_txt }}</td>
                                                            <td>
                                                                @if ($timesheet->knownAs_txt == null && $timesheet->knownAs_txt == '')
                                                                    {{ $timesheet->firstName_txt . ' ' . $timesheet->surname_txt }}
                                                                @else
                                                                    {{ $timesheet->knownAs_txt . ' ' . $timesheet->surname_txt }}
                                                                @endif
                                                            </td>
                                                            <td>{{ date('d-m-Y', strtotime($timesheet->asnDate_dte)) }}
                                                            </td>
                                                            <td>{{ $timesheet->datePart_txt }}</td>
                                                            <td>{{ $timesheet->charge_dec }}</td>
                                                            <td>{{ $timesheet->cost_dec }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="invoice-process-btn p-2 finance_timesheets_form"
                                            style="text-align: center;">
                                            <button class="btn btn-secondary timesheet-search-btn"
                                                id="processInvoiceBtn">Process Selected</button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="" id="initialAsnItemIds"
                                        value="{{ $asnItemIds }}">

                                    <form class="sd_form" action="{{ url('/financeProcessInvoice') }}" method="post"
                                        id="processInvoiceForm">
                                        @csrf
                                        <input type="hidden" name="timesheetAsnItemIds" id="timesheetAsnItemIds"
                                            value="">
                                        <input type="hidden" name="p_maxDate" id=""
                                            value="{{ app('request')->input('date') ? app('request')->input('date') : $p_maxDate }}">
                                    </form>
                                </div>

                                <div class="col-md-7 col-lg-7 col-xl-7 col-12 col-sm-12">
                                    <div class="finance-invoice-contact-second-sec sec_box_edit">

                                        <div class="invoice-top-second-section new_details-heading">
                                            <div class="sd_input_box">
                                                <form class="sd_form" action="{{ url('/finance-invoices') }}"
                                                    method="get" id="invoiceFromToForm">

                                                    <div class="form-group invoice-top-first-input-sec">
                                                        <label style="width: 145px;" for=""
                                                            class="col-form-label finance_timesheets_label">Invoice No
                                                            From</label>
                                                        <input type="text" id="" class="onlynumber"
                                                            name="invoiceNumberMin"
                                                            value="{{ app('request')->input('invoiceNumberMin') }}">
                                                    </div>
                                                    <div class="form-group invoice-top-second-input-sec">
                                                        <label for=""
                                                            class="col-form-label finance_timesheets_label">to</label>
                                                        <input type="text" id="" class="onlynumber"
                                                            name="invoiceNumberMax"
                                                            value="{{ app('request')->input('invoiceNumberMax') }}">
                                                    </div>

                                                    <input type="hidden" class="datePickerPaste" name="invoiceFromDate"
                                                        value="{{ app('request')->input('invoiceFromDate') ? app('request')->input('invoiceFromDate') : '' }}">
                                                    <input type="hidden" class="datePickerPaste" name="invoiceToDate"
                                                        value="{{ app('request')->input('invoiceToDate') ? app('request')->input('invoiceToDate') : '' }}">

                                                    <input type="hidden" name="date"
                                                        value="{{ app('request')->input('date') ? app('request')->input('date') : $p_maxDate }}">
                                                    <input type="hidden" name="showSent" id="showSentId"
                                                        value="{{ app('request')->input('showSent') ? app('request')->input('showSent') : 'false' }}">
                                                    <div class="finance-invoice-icon-sec">
                                                        <button type="submit" class="timesheet-search-btn"
                                                            style="border: none; background-color: transparent"><i
                                                                class="fas fa-sync"></i></button>
                                                    </div>

                                                </form>

                                                <form action="{{ url('/finance-invoices') }}" method="get"
                                                    class="sd_form" id="invoiceFromToForm">

                                                    <div class="form-group invoice-top-first-input-sec">
                                                        <label style="width: 145px;" for="invoiceFrom"
                                                            class="col-form-label finance_timesheets_label">Invoice Date
                                                            From</label>
                                                        <input type="text" class="datePickerPaste"
                                                            name="invoiceFromDate"
                                                            value="{{ app('request')->input('invoiceFromDate') ? app('request')->input('invoiceFromDate') : '' }}">
                                                    </div>
                                                    <div class="form-group invoice-top-second-input-sec">
                                                        <label for="invoiceTo"
                                                            class="col-form-label finance_timesheets_label">to</label>
                                                        <input type="text" class="datePickerPaste"
                                                            name="invoiceToDate"
                                                            value="{{ app('request')->input('invoiceToDate') ? app('request')->input('invoiceToDate') : '' }}">
                                                    </div>

                                                    <input type="hidden" id="" class="onlynumber"
                                                        name="invoiceNumberMin"
                                                        value="{{ app('request')->input('invoiceNumberMin') }}">
                                                    <input type="hidden" id="" class="onlynumber"
                                                        name="invoiceNumberMax"
                                                        value="{{ app('request')->input('invoiceNumberMax') }}">

                                                    <input type="hidden" name="date"
                                                        value="{{ app('request')->input('date') ? app('request')->input('date') : $p_maxDate }}">
                                                    <input type="hidden" name="showSent" id="showSentId"
                                                        value="{{ app('request')->input('showSent') ? app('request')->input('showSent') : 'false' }}">
                                                    <div class="finance-invoice-icon-sec">
                                                        <button type="submit" class="timesheet-search-btn"
                                                            style="border: none; background-color: transparent"><i
                                                                class="fas fa-sync"></i></button>
                                                    </div>

                                                </form>
                                            </div>
                                            <div class="sd_side_items">
                                                <div class="invoice-checkbox-top-section">
                                                    <div class="invoice-checkbox-sec">
                                                        <input type="checkbox" id="show_sent" name="show_sent"
                                                            value="1"
                                                            {{ app('request')->input('showSent') == 'true' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="invoice-checkbox-sec w_100">
                                                        <label class="col-form-label finance_timesheets_label"
                                                            for="show_sent">Show
                                                            Sent</label>
                                                    </div>
                                                </div>

                                                <div class="finance-invoice-icon-sec">
                                                    <a style="cursor: pointer" class="disabled-link icon_all"
                                                        id="saveInvoiceBtn" title="Save Invoice">
                                                        <i class="fas fa-file-download"></i>
                                                    </a>
                                                </div>

                                                <div class="finance-invoice-icon-sec">
                                                    <a style="cursor: pointer" class="disabled-link icon_all"
                                                        id="splitInvoiceBtn" title="Split Invoice">
                                                        <img src="{{ asset('web/company_logo/diverge.png') }}"
                                                            alt="">
                                                    </a>
                                                </div>

                                                <div class="finance-invoice-icon-sec">
                                                    <a style="cursor: pointer" class="disabled-link icon_all"
                                                        id="viewInvoiceBtn" title="View Invoice">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                </div>

                                                <div class="finance-invoice-icon-sec">
                                                    <a style="cursor: pointer" id="sendAllInvoiceBtn"
                                                        title="Send All Listed Invoice" class="nw_icon icon_all">
                                                        <i class="fas fa-envelope"></i>
                                                        <div class="finance-invoice-second-icon-sec">
                                                            <i class="fas fa-plus"></i>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="finance-invoice-icon-sec">
                                                    <a style="cursor: pointer" class="disabled-link icon_all"
                                                        id="sendSelectedInvoiceBtn" title="Send Selected Invoice">
                                                        <i class="fas fa-envelope"></i>
                                                    </a>
                                                </div>
                                                <div class="invoice-second-edit-icon">
                                                    <a style="cursor: pointer" class="disabled-link icon_all"
                                                        id="editInvoiceBtn" title="Edit Invoice">
                                                        <i class="fas fa-edit school-edit-icon"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                        <div
                                            class="finance-invoice-table-section finance-invoice-page-table financeInvoiceTableNew">
                                            <table class="table table-bordered table-striped" id="myTable2">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Invoice ID</th>
                                                        <th>Date</th>
                                                        <th>School</th>
                                                        <th>Gross</th>
                                                        <th>Net</th>
                                                        <th>Days</th>
                                                        <th>Tch</th>
                                                        <th>Email</th>
                                                        <th>Factor</th>
                                                        <th>Mail Send</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($invoiceList as $key2 => $invoice)
                                                        <tr class="school-detail-table-data editInvoiceRow"
                                                            id="editInvoiceRow{{ $invoice->invoice_id }}"
                                                            onclick="selectInvoiceRow('{{ $invoice->invoice_id }}')">
                                                            <td>{{ $invoice->invoice_id }}</td>
                                                            <td>{{ date('d-m-Y', strtotime($invoice->invoiceDate_dte)) }}
                                                            </td>
                                                            <td>{{ $invoice->name_txt }}</td>
                                                            <td>{{ $invoice->gross_dec }}</td>
                                                            <td>{{ $invoice->net_dec }}</td>
                                                            <td>{{ $invoice->days_dec }}</td>
                                                            <td>{{ $invoice->teachers_int }}</td>
                                                            <td>{{ $invoice->hasEmail_status }}</td>
                                                            <td>{{ $invoice->factored_status }}</td>
                                                            <td>
                                                                @if ($invoice->sentMailDate)
                                                                    Yes
                                                                @else
                                                                    No
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($invoice->paidOn_dte != null)
                                                                    {{ 'Paid' }}
                                                                @elseif (date('Y-m-d', strtotime($invoice->invoiceDate_dte . ' + 30 days')) < date('Y-m-d'))
                                                                    {{ 'Overdue' }}
                                                                @else
                                                                    {{ 'Due' }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <input type="hidden" name="" id="editInvoiceId" value="">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Edit Modal -->
    <div class="modal fade" id="eventEditModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Working Day</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Assignment Day</h2>
                    </div>

                    <form action="{{ url('/timesheetEventUpdateAjax') }}" method="post" class="form-validate"
                        id="ajaxAssignmentEventForm">
                        @csrf

                        <input type="hidden" name="p_maxDate" value="{{ $p_maxDate }}">

                        <div class="modal-input-field-section">
                            <div id="AjaxEventEdit"></div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="ajaxAssignmentEventBtn">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Event Edit Modal -->

    <!-- Split Invoice Modal -->
    <div class="modal fade" id="splitInvoiceModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Split Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Split Invoice Id - <span id="spanInvId"></span></h2>
                    </div>

                    <form action="{{ url('/financeSplitInvoiceCreate') }}" method="post" class=""
                        enctype="multipart/form-data" id="splitInvoiceForm">
                        @csrf

                        <input type="hidden" name="invoiceNumberMin"
                            value="{{ app('request')->input('invoiceNumberMin') }}">
                        <input type="hidden" name="invoiceNumberMax"
                            value="{{ app('request')->input('invoiceNumberMax') }}">
                        <input type="hidden" name="date"
                            value="{{ app('request')->input('date') ? app('request')->input('date') : $p_maxDate }}">
                        <input type="hidden" name="showSent"
                            value="{{ app('request')->input('showSent') ? app('request')->input('showSent') : 'false' }}">

                        <div class="modal-input-field-section" id="invoiceISplitAjax" style="width: 100%;"></div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="splitInvSubmitBtn">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Split Invoice Modal -->

    <!-- Edit Invoice Modal -->
    <div class="modal fade" id="editInvoiceModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Invoice Details</h2>
                    </div>

                    <form action="{{ url('/financeInvoiceUpdate') }}" method="post" class=""
                        enctype="multipart/form-data">
                        @csrf

                        <div class="modal-input-field-section" id="invoiceEditAjax" style="width: 100%;"></div>

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
    <!-- Edit Invoice Modal -->

    <!-- Send Selected Invoice Modal -->
    <div class="modal fade" id="selectedInvModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Send Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="{{ url('/financeInvoiceMail') }}" method="post" class=""
                        enctype="multipart/form-data" id="sendInvFormId">
                        @csrf

                        <input type="hidden" name="editInvoiceId" id="formInvoiceId" value="">

                        <div class="modal-input-field-section mt-3">
                            <div class="modal-input-field">
                                <label class="form-check-label">Mail Body</label>
                                <textarea class="form-control" name="temp_description" id="temp_description" rows="12" cols="50">{!! $templateDet->temp_description !!}</textarea>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="formSendInvBtn">Send</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Send Selected Invoice Modal -->

    <!-- Send Listed Invoice Modal -->
    <div class="modal fade" id="listedInvModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Send Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="{{ url('/financeInvoiceAllMail') }}" method="post" class=""
                        enctype="multipart/form-data" id="sendListedInvFormId">
                        @csrf

                        <input type="hidden" name="invoiceNumberMin"
                            value="{{ app('request')->input('invoiceNumberMin') }}">
                        <input type="hidden" name="invoiceNumberMax"
                            value="{{ app('request')->input('invoiceNumberMax') }}">

                        <div class="modal-input-field-section mt-3">
                            <div class="modal-input-field">
                                <label class="form-check-label">Mail Body</label>
                                <textarea class="form-control" name="temp_description" id="listed_temp_description" rows="12" cols="50">{!! $templateDet->temp_description !!}</textarea>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="formSendListInvBtn">Send</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Send Listed Invoice Modal -->

    <script src="//cdn.ckeditor.com/4.4.7/standard-all/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/4.4.7/standard-all/adapters/jquery.js"></script>

    <script>
        $(document).ready(function() {
            $('#temp_description').ckeditor({
                toolbar: [],
            });
            $('#listed_temp_description').ckeditor({
                toolbar: [],
            });

            $('#myTable1, #myTable2').DataTable({
                scrollY: '600px',
                paging: false,
                footer: false,
                info: false,
                ordering: false,
                searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        function timesheetRow(asnItem_id) {
            if ($('#editTimesheetRow' + asnItem_id).hasClass('tableRowActive')) {
                setIds(asnItem_id, 'rm');
                $('#editTimesheetRow' + asnItem_id).removeClass('tableRowActive');
            } else {
                setIds(asnItem_id, 'add');
                $('#editTimesheetRow' + asnItem_id).addClass('tableRowActive');
            }
        }

        function setIds(asnItem_id, type) {
            var ItemId = parseInt(asnItem_id);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#timesheetAsnItemIds').val();
            if (asnItemIds) {
                idsArr = asnItemIds.split(',');
            }
            if (type == 'add') {
                idsArr.push(ItemId);
            }
            if (type == 'rm') {
                idsArr = jQuery.grep(idsArr, function(value) {
                    return value != ItemId;
                });
            }
            ids = idsArr.toString();
            $('#timesheetAsnItemIds').val(ids);
            if (ids) {
                $('#timesheetEditBtn').removeClass('disabled-link');
            } else {
                $('#timesheetEditBtn').addClass('disabled-link');
            }
        }

        $(document).on('click', '#selectAllBtn', function(event) {
            var initialAsnItemIds = $('#initialAsnItemIds').val();
            if (initialAsnItemIds) {
                var asnIdsArr = initialAsnItemIds.split(",");
                $.each(asnIdsArr, function(index, value) {
                    $('#editTimesheetRow' + value).addClass('tableRowActive');
                });
                $('#timesheetAsnItemIds').val(initialAsnItemIds);
                $('#timesheetEditBtn').removeClass('disabled-link');
            }
        });

        $(document).on('click', '#selectNoneBtn', function(event) {
            $('.editTimesheetRow').removeClass('tableRowActive');
            $('#timesheetAsnItemIds').val('');
            $('#timesheetEditBtn').addClass('disabled-link');
        });

        $(document).on('click', '#timesheetEditBtn', function() {
            var asnItemIds = $('#timesheetAsnItemIds').val();
            if (asnItemIds) {
                var idsArr = [];
                idsArr = asnItemIds.split(',');
                if (idsArr.length == 1) {
                    $('#fullLoader').show();
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('timesheetEventEdit') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            asnItemId: idsArr[0]
                        },
                        success: function(data) {
                            if (data.exist == 'Yes') {
                                $('#AjaxEventEdit').html(data.html);
                                $('#eventEditModal').modal("show");
                            }
                            $('#fullLoader').hide();
                        }
                    });
                } else {
                    swal("", "You cannot edit more then one item at a time.");
                }
            } else {
                swal("", "Please select one item.");
            }
        });

        $(document).on('click', '#ajaxAssignmentEventBtn', function() {
            var error = "";
            $(".field-validate").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".number-validate").each(function() {
                if (this.value == '' || isNaN(this.value)) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (error == "has error") {
                return false;
            } else {
                $('#fullLoader').show();
                var form = $("#ajaxAssignmentEventForm");
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        if (data) {
                            if (data.status == 'success') {
                                var eventId = data.eventId;
                                $('#timesheetTbody').html(data.html);
                                $('#timesheetAsnItemIds').val(eventId);
                                $('#editTimesheetRow' + eventId).addClass('tableRowActive');

                                $('#eventEditModal').modal("hide");
                            }
                        }
                        $('#fullLoader').hide();
                    }
                });
            }
        });

        $(document).on('click', '#processInvoiceBtn', function() {
            var asnItemIds = $('#timesheetAsnItemIds').val();
            if (asnItemIds) {
                $('#fullLoader').show();
                $('#processInvoiceForm').submit()
            } else {
                swal("", "Please select atleast one item.");
            }
        });

        function selectInvoiceRow(invoice_id) {
            if ($('#editInvoiceRow' + invoice_id).hasClass('tableRowActive')) {
                $('#editInvoiceId').val('');
                $('#editInvoiceRow' + invoice_id).removeClass('tableRowActive');
                $('#saveInvoiceBtn').addClass('disabled-link');
                $('#splitInvoiceBtn').addClass('disabled-link');
                $('#viewInvoiceBtn').addClass('disabled-link');
                // $('#sendAllInvoiceBtn').addClass('disabled-link');
                $('#sendSelectedInvoiceBtn').addClass('disabled-link');
                $('#editInvoiceBtn').addClass('disabled-link');
            } else {
                $('#editInvoiceId').val(invoice_id);
                $('.editInvoiceRow').removeClass('tableRowActive');
                $('#editInvoiceRow' + invoice_id).addClass('tableRowActive');
                $('#saveInvoiceBtn').removeClass('disabled-link');
                $('#splitInvoiceBtn').removeClass('disabled-link');
                $('#viewInvoiceBtn').removeClass('disabled-link');
                // $('#sendAllInvoiceBtn').removeClass('disabled-link');
                $('#sendSelectedInvoiceBtn').removeClass('disabled-link');
                $('#editInvoiceBtn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#splitInvoiceBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            if (editInvoiceId) {
                swal({
                        title: "",
                        text: "You currently have an invoice selected. Do you want to split that invoice?",
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
                                    url: '{{ url('financeInvoiceSplit') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        editInvoiceId: editInvoiceId
                                    },
                                    async: false,
                                    success: function(data) {
                                        //console.log(data);
                                        $('#spanInvId').html(editInvoiceId);
                                        $('#invoiceISplitAjax').html(data.html);
                                        $('#fullLoader').hide();
                                    }
                                });
                                // $('#fullLoader').hide();
                                $('#splitInvoiceModal').modal("show");
                        }
                    });
            } else {
                swal("", "Please select one invoice.");
            }
        });

        $(document).on('click', '#splitInvSubmitBtn', function() {
            var splitInvoiceItemCount = $('#splitInvoiceItemCount').val();
            var splitInvoiceSelectedItems = $('#splitInvoiceSelectedItems').val();

            if (splitInvoiceItemCount > 1) {
                if (splitInvoiceSelectedItems != '') {
                    $('#fullLoader').show();
                    $('#splitInvoiceForm').submit()
                } else {
                    swal("", "You haven't selected any items to add to a split invoice.");
                }
            } else {
                swal("", "You can't split a single invoice item there needs to be a minimum of two items.");
            }
        });

        $(document).on('click', '#editInvoiceBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            if (editInvoiceId) {
                $('#fullLoader').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ url('financeInvoiceEdit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        editInvoiceId: editInvoiceId
                    },
                    async: false,
                    success: function(data) {
                        //console.log(data);
                        $('#invoiceEditAjax').html(data.html);
                        $('#fullLoader').hide();
                    }
                });
                // $('#fullLoader').hide();
                $('#editInvoiceModal').modal("show");
            } else {
                swal("", "Please select one invoice.");
            }
        });

        $(document).on('click', '#saveInvoiceBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            if (editInvoiceId) {
                $('#fullLoader').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ url('financeInvoiceSave') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        editInvoiceId: editInvoiceId
                    },
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        // console.log(data);
                        if (data.exist == 'Yes' && data.invoice_path) {
                            // window.location.href = data.invoice_path;
                            // location.replace(data.invoice_path);
                            const link = document.createElement('a');
                            link.href = data.invoice_path;
                            link.download = (data.invoice_path).split("/").pop();
                            link.target = '_blank';
                            link.click();
                        }
                        var subject = 'Finance Invoice';
                        var body = "Hello";
                        window.location = 'mailto:' + data.sendMail + '?subject=' +
                            encodeURIComponent(subject) + '&body=' +
                            encodeURIComponent(body);

                        $('#fullLoader').hide();
                    }
                });
                // $('#fullLoader').hide();
            } else {
                swal("", "Please select one invoice.");
            }
        });

        $(document).on('click', '#viewInvoiceBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            if (editInvoiceId) {
                $('#fullLoader').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ url('financeInvoiceSave') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        editInvoiceId: editInvoiceId
                    },
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        // console.log(data);
                        if (data.exist == 'Yes' && data.invoice_path) {
                            // window.location.href = data.invoice_path;
                            // window.open(
                            //     data.invoice_path,
                            //     '_blank', true
                            // );
                            var newWindow = window.open(data.invoice_path, '_blank');
                            newWindow.location.href = data.invoice_path;
                            newWindow.addEventListener('load', function() {
                                newWindow.location.reload(true);
                            });
                        }
                        $('#fullLoader').hide();
                    }
                });
                // $('#fullLoader').hide();
            } else {
                swal("", "Please select one invoice.");
            }
        });

        $(document).on('click', '#sendSelectedInvoiceBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            if (editInvoiceId) {
                $('#formInvoiceId').val(editInvoiceId);
                $('#selectedInvModal').modal("show");
            } else {
                swal("", "Please select one invoice.");
            }
        });

        $(document).on('click', '#formSendInvBtn', function() {
            $('#fullLoader').show();
            $('#sendInvFormId').submit();
        });

        $(document).on('click', '#sendAllInvoiceBtn', function() {
            var invoiceNumberMin = "{{ app('request')->input('invoiceNumberMin') }}";
            var invoiceNumberMax = "{{ app('request')->input('invoiceNumberMax') }}";
            if (invoiceNumberMin && invoiceNumberMax) {
                $('#listedInvModal').modal("show");
            }
        });

        $(document).on('click', '#formSendListInvBtn', function() {
            $('#fullLoader').show();
            $('#sendListedInvFormId').submit();
        });

        $(document).on('change', '#show_sent', function() {
            if ($(this).is(":checked")) {
                $('#showSentId').val('true');
            } else {
                $('#showSentId').val('false');
            }
            $('#invoiceFromToForm').submit();
        });
    </script>
@endsection
