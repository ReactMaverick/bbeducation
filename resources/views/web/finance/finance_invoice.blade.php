@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">
            <div class="col-md-12 topbar-sec">

                @include('web.finance.finance_header')

                <div class="finance-invoice-right-sec">

                    <div class="finance-invoice-contact-first-sec">
                        <div class="invoice-top-section">
                            <div class="form-group timesheet-top-input-sec">
                                <form action="{{ url('/finance-invoices') }}" method="get" style="margin-bottom: 0;">
                                    <label for="" class="col-form-label">Timesheets Until</label>
                                    <input type="hidden" name="invoiceNumberMin"
                                        value="{{ app('request')->input('invoiceNumberMin') }}">
                                    <input type="hidden" name="invoiceNumberMax"
                                        value="{{ app('request')->input('invoiceNumberMax') }}">
                                    <input type="date" name="date"
                                        value="{{ app('request')->input('date') ? app('request')->input('date') : $p_maxDate }}">
                                    <input type="hidden" name="showSent"
                                        value="{{ app('request')->input('showSent') ? app('request')->input('showSent') : 'false' }}">
                                    <button type="submit" class="timesheet-search-btn">Search</button>
                                </form>
                            </div>
                            <div class="invoice-top-btn-sec">
                                <button id="selectNoneBtn">Select None</button>
                            </div>

                            <div class="invoice-top-btn-sec">
                                <button id="selectAllBtn">Select All</button>
                            </div>
                            <div class="invoice-edit-icon">
                                <a style="cursor: pointer" class="disabled-link" id="timesheetEditBtn"
                                    title="Edit timesheet">
                                    <i class="fa-solid fa-pencil"></i>
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

                        <div class="finance-invoice-table-section finance-invoice-page-table">
                            <table class="table finance-timesheet-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>School</th>
                                        <th>Teacher</th>
                                        <th>Date</th>
                                        <th>Charge</th>
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
                                            <td>{{ date('d-m-Y', strtotime($timesheet->asnDate_dte)) }}</td>
                                            <td>{{ $timesheet->charge_dec }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="invoice-process-btn">
                            <button id="processInvoiceBtn">Process Selected</button>
                        </div>
                    </div>

                    <input type="hidden" name="" id="initialAsnItemIds" value="{{ $asnItemIds }}">

                    <form action="{{ url('/financeProcessInvoice') }}" method="post" id="processInvoiceForm">
                        @csrf
                        <input type="hidden" name="timesheetAsnItemIds" id="timesheetAsnItemIds" value="">
                        <input type="hidden" name="p_maxDate" id=""
                            value="{{ app('request')->input('date') ? app('request')->input('date') : $p_maxDate }}">
                    </form>

                    <div class="finance-invoice-contact-second-sec">

                        <div class="invoice-top-second-section">
                            <form action="{{ url('/finance-invoices') }}" method="get"
                                style="margin-bottom: 0;display: flex; align-items: center; width: 56%;"
                                id="invoiceFromToForm">
                                <div class="form-group invoice-top-first-input-sec">
                                    <label for="invoiceFrom" class="col-form-label">Invoice From</label>
                                    <input type="text" id="invoiceFrom" class="onlynumber" name="invoiceNumberMin"
                                        value="{{ app('request')->input('invoiceNumberMin') }}">
                                </div>
                                <div class="form-group invoice-top-second-input-sec">
                                    <label for="invoiceTo" class="col-form-label">to</label>
                                    <input type="text" id="invoiceTo" class="onlynumber" name="invoiceNumberMax"
                                        value="{{ app('request')->input('invoiceNumberMax') }}">
                                </div>
                                <input type="hidden" name="date"
                                    value="{{ app('request')->input('date') ? app('request')->input('date') : $p_maxDate }}">
                                <input type="hidden" name="showSent" id="showSentId"
                                    value="{{ app('request')->input('showSent') ? app('request')->input('showSent') : 'false' }}">
                                <div class="finance-invoice-icon-sec">
                                    <button type="submit" class="timesheet-search-btn"
                                        style="border: none; background-color: transparent"><i
                                            class="fa-solid fa-arrows-rotate"></i></button>
                                </div>
                            </form>
                            <div class="invoice-checkbox-top-section">
                                <div class="invoice-checkbox-sec">
                                    <input type="checkbox" id="show_sent" name="show_sent" value="1"
                                        {{ app('request')->input('showSent') == 'true' ? 'checked' : '' }}>
                                </div>
                                <div class="invoice-checkbox-sec">
                                    <label for="show_sent">Show Sent</label>
                                </div>
                            </div>

                            <div class="finance-invoice-icon-sec">
                                <a style="cursor: pointer" class="disabled-link" id="saveInvoiceBtn"
                                    title="Save Invoice">
                                    <i class="fa-solid fa-file-lines"></i>
                                </a>
                            </div>

                            <div class="finance-invoice-icon-sec">
                                <a style="cursor: pointer" class="disabled-link" id="splitInvoiceBtn"
                                    title="Split Invoice">
                                    <img src="{{ asset('web/company_logo/diverge.png') }}" alt="">
                                </a>
                            </div>

                            <div class="finance-invoice-icon-sec">
                                <a style="cursor: pointer" class="disabled-link" id="viewInvoiceBtn"
                                    title="View Invoice">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </a>
                            </div>

                            <div class="finance-invoice-icon-sec">
                                <a style="cursor: pointer" id="sendAllInvoiceBtn" title="Send All Listed Invoice">
                                    <i class="fa-solid fa-envelope"></i>
                                    <div class="finance-invoice-second-icon-sec">
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="finance-invoice-icon-sec">
                                <a style="cursor: pointer" class="disabled-link" id="sendSelectedInvoiceBtn"
                                    title="Send Selected Invoice">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            </div>
                            <div class="invoice-second-edit-icon">
                                <a style="cursor: pointer" class="disabled-link" id="editInvoiceBtn"
                                    title="Edit Invoice">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            </div>
                        </div>
                        <div class="finance-invoice-table-section finance-invoice-page-table">
                            <table class="table finance-timesheet-page-table" id="myTable">
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
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($invoiceList as $key2 => $invoice)
                                        <tr class="school-detail-table-data editInvoiceRow"
                                            id="editInvoiceRow{{ $invoice->invoice_id }}"
                                            onclick="selectInvoiceRow('{{ $invoice->invoice_id }}')">
                                            <td>{{ $invoice->invoice_id }}</td>
                                            <td>{{ date('d-m-Y', strtotime($invoice->invoiceDate_dte)) }}</td>
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

    <!-- Event Edit Modal -->
    <div class="modal fade" id="eventEditModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Working Day</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
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
    <!-- Event Edit Modal -->

    <!-- Split Invoice Modal -->
    <div class="modal fade" id="splitInvoiceModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width:100%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Split Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
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
    <!-- Split Invoice Modal -->

    <!-- Edit Invoice Modal -->
    <div class="modal fade" id="editInvoiceModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width:100%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
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
    <!-- Edit Invoice Modal -->

    <script>
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

        $(document).on('click', '#sendSelectedInvoiceBtn', function(e) {
            // e.preventDefault();
            var editInvoiceId = $('#editInvoiceId').val();
            if (editInvoiceId) {
                swal({
                        title: "",
                        text: "This will send the selected invoice. Continue?",
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
                                    url: '{{ url('financeInvoiceMail') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        editInvoiceId: editInvoiceId
                                    },
                                    dataType: "json",
                                    // async: false,
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                                // $('#fullLoader').hide();
                        }
                    });
            } else {
                swal("", "Please select one invoice.");
            }
        });

        $(document).on('click', '#sendAllInvoiceBtn', function() {
            var invoiceNumberMin = "{{ app('request')->input('invoiceNumberMin') }}";
            var invoiceNumberMax = "{{ app('request')->input('invoiceNumberMax') }}";
            if (invoiceNumberMin && invoiceNumberMax) {
                swal({
                        title: "",
                        text: "This will send all the listed invoices. Continue?",
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
                                    url: '{{ url('financeInvoiceAllMail') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        invoiceNumberMin: invoiceNumberMin,
                                        invoiceNumberMax: invoiceNumberMax
                                    },
                                    dataType: "json",
                                    // async: false,
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                                // $('#fullLoader').hide();
                        }
                    });
            }
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
