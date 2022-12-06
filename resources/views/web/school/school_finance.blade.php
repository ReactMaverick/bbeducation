@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.school.school_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.school.school_header')

                <div class="school-finance-right-sec">


                    <div class="school-finance-section">

                        <div class="school-finance-sec">
                            <div class="school-finance-contact-heading-text">
                                <h2>Finance</h2>
                            </div>
                            <div class="form-check paid-check">
                                <label for="includePaid">Include paid</label>
                                <input type="checkbox" id="includePaid" name="include" value="1"
                                    <?php
                                    echo app('request')->input('include') == 1 ? 'checked' : ''; ?>><br>
                            </div>

                            <div class="form-group payment-method-type">
                                <label>Payment Method</label>
                                <select id="paymentMethod" name="method" class="form-control">
                                    <option value="">Choose One</option>
                                    @foreach ($paymentMethodList as $key1 => $paymentMethod)
                                        <option value="{{ $paymentMethod->description_int }}" <?php echo app('request')->input('method') == $paymentMethod->description_int ? 'selected' : ''; ?>>
                                            {{ $paymentMethod->description_txt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="school-finance-contact-heading">
                                <div class="school-finance-contact-icon-sec">
                                    <a style="cursor: pointer" class="disabled-link" id="remitInvoiceBtn"
                                        title="Remit Invoice">
                                        <i class="fa-solid fa-square-check"></i>
                                    </a>
                                    <a style="cursor: pointer" class="disabled-link" id="creditNoteBttn"
                                        title="Create Credit Note">
                                        <i class="fa-solid fa-money-bills"></i>
                                    </a>
                                    <a style="cursor: pointer" class="disabled-link" id="splitInvoiceBtn"
                                        title="Split Invoice">
                                        <i class="fa-solid fa-arrow-up"></i>
                                    </a>
                                    <a style="cursor: pointer" class="disabled-link" id="previewInvoiceBtn"
                                        title="Preview Invoice">
                                        <i class="fa-solid fa-id-card"></i>
                                    </a>
                                    <a style="cursor: pointer" class="disabled-link" id="sendInvoiceBtn"
                                        title="Send Invoice">
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>
                                    <a style="cursor: pointer" id="invoiceAddBttn"
                                        onclick="invoiceAdd('<?php echo $school_id; ?>', '<?php echo app('request')->input('include'); ?>', '<?php echo app('request')->input('method'); ?>')"
                                        title="Create Invoice">
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                    <a style="cursor: pointer" class="disabled-link" id="InvoiceEditBttn"
                                        title="Edit invoice">
                                        <i class="fa-solid fa-pencil school-edit-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="" id="editInvoiceId" value="">
                        <input type="hidden" name="" id="editInvoiceSchoolId" value="{{ $school_id }}">
                        <input type="hidden" name="" id="editInvoiceIncludeId"
                            value="{{ app('request')->input('include') }}">
                        <input type="hidden" name="" id="editInvoiceMethodId"
                            value="{{ app('request')->input('method') }}">

                        <div class="school-finance-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Invoice Number</th>
                                        <th>Date</th>
                                        <th>Net</th>
                                        <th>Vat</th>
                                        <th>Gross</th>
                                        <th>Paid On</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($schoolInvoices as $key => $Invoices)
                                        <tr class="school-detail-table-data editInvoiceRow"
                                            onclick="editInvoiceRowSelect('<?php echo $Invoices->invoice_id; ?>')"
                                            id="editInvoiceRow{{ $Invoices->invoice_id }}">
                                            <td>{{ $Invoices->invoice_id }}</td>
                                            <td>{{ date('d-m-Y', strtotime($Invoices->invoiceDate_dte)) }}</td>
                                            <td>{{ $Invoices->net_dec }}</td>
                                            <td>{{ $Invoices->vat_dec }}</td>
                                            <td>{{ $Invoices->gross_dec }}</td>
                                            <td>
                                                @if ($Invoices->paidOn_dte != null)
                                                    {{ date('d-m-Y', strtotime($Invoices->paidOn_dte)) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <hr>

                            <table class="table school-detail-page-table" id="myTable1">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Teacher</th>
                                        <th>Days</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($schoolTimesheet as $key => $Timesheet)
                                        <tr class="school-detail-table-data">
                                            <td>
                                                @if ($Timesheet->knownAs_txt == null || $Timesheet->knownAs_txt == '')
                                                    {{ $Timesheet->firstName_txt . ' ' . $Timesheet->surname_txt }}
                                                @else
                                                    {{ $Timesheet->knownAs_txt . ' ' . $Timesheet->surname_txt }}
                                                @endif
                                            </td>
                                            <td>{{ $Timesheet->items_int }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="billing-details-section">
                        <div class="billing-details-heading">
                            <span>Billing Details</span>
                            <a data-toggle="modal" data-target="#editBillingAddressModal" style="cursor: pointer;"
                                title="Edit billing address"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                        </div>
                        <div class="invoice-timesheet-checkbox">
                            <input type="checkbox" id="includeTimesheetId" name="" value="1"
                                @if ($schoolDetail->timesheetWithInvoice_status == -1) checked @endif class="disabled-link">
                            <label for="includeTimesheetId" class="disabled-link">Include Timesheet with Invoice</label>
                        </div>
                        <div class="billing-address-section">
                            <h2>Billing Address</h2>
                            @if ($schoolDetail->billingAddress1_txt)
                                <p>{{ $schoolDetail->billingAddress1_txt }}</p>
                            @endif
                            @if ($schoolDetail->billingAddress2_txt)
                                <p>{{ $schoolDetail->billingAddress2_txt }}</p>
                            @endif
                            @if ($schoolDetail->billingAddress3_txt)
                                <p>{{ $schoolDetail->billingAddress3_txt }}</p>
                            @endif
                            @if ($schoolDetail->billingAddress4_txt)
                                <p>{{ $schoolDetail->billingAddress4_txt }}</p>
                            @endif
                            @if ($schoolDetail->billingAddress5_txt)
                                <p>{{ $schoolDetail->billingAddress5_txt }}</p>
                            @endif
                            @if ($schoolDetail->billingPostcode_txt)
                                <p>{{ $schoolDetail->billingPostcode_txt }}</p>
                            @endif
                        </div>

                        <div class="billing-button">
                            <button>Candidate Rates</button>
                        </div>

                    </div>
                </div>



            </div>
        </div>
    </div>

    <!-- Billing Address Edit Modal -->
    <div class="modal fade" id="editBillingAddressModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit School Billing Information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Billing Detail</h2>
                </div>

                <form action="{{ url('/schoolBillingAddressUpdate') }}" method="post">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>{{ $schoolDetail->name_txt }}</h6>
                        <span>ID</span>
                        <p>{{ $schoolDetail->school_id }}</p>
                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">
                        <input type="hidden" name="include" value="{{ app('request')->input('include') }}">
                        <input type="hidden" name="method" value="{{ app('request')->input('method') }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="modal-input-field">
                                    <label class="form-check-label">Address</label>
                                    <input type="text" class="form-control mb-1" name="billingAddress1_txt"
                                        id="" value="{{ $schoolDetail->billingAddress1_txt }}">
                                    <input type="text" class="form-control mb-1" name="billingAddress2_txt"
                                        id="" value="{{ $schoolDetail->billingAddress2_txt }}">
                                    <input type="text" class="form-control mb-1" name="billingAddress3_txt"
                                        id="" value="{{ $schoolDetail->billingAddress3_txt }}">
                                    <input type="text" class="form-control mb-1" name="billingAddress4_txt"
                                        id="" value="{{ $schoolDetail->billingAddress4_txt }}">
                                    <input type="text" class="form-control" name="billingAddress5_txt" id=""
                                        value="{{ $schoolDetail->billingAddress5_txt }}">
                                </div>

                                <div class="modal-input-field">
                                    <label class="form-check-label">Postcode</label>
                                    <input type="text" class="form-control" name="billingPostcode_txt" id=""
                                        value="{{ $schoolDetail->billingPostcode_txt }}">
                                </div>
                            </div>
                            <div class="col-md-6 modal-form-right-sec">
                                <div class="modal-side-field">
                                    <input type="checkbox" class="" name="timesheetWithInvoice_status"
                                        id="timesheetWithInvoice_status" value="1"
                                        @if ($schoolDetail->timesheetWithInvoice_status == -1) checked @endif>
                                    <label class="form-check-label" for="timesheetWithInvoice_status">Include timesheet
                                        with invoice</label>
                                </div>

                                <div class="modal-side-field">
                                    <input type="checkbox" class="" name="isFactored_status"
                                        id="isFactored_status" value="1"
                                        @if ($schoolDetail->isFactored_status == -1) checked @endif>
                                    <label class="form-check-label" for="isFactored_status">Factored</label>
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
    <!-- Billing Address Edit Modal -->

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

                <form action="{{ url('/schoolSplitInvoiceCreate') }}" method="post" class=""
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="splitInvoiceId" id="splitInvoiceId" value="">
                    <input type="hidden" name="splitInvoiceSchoolId" id="splitInvoiceSchoolId" value="">
                    <div class="modal-input-field-section">
                        <span>School</span>
                        <p>{{ $schoolDetail->name_txt }}</p>

                        <div class="row" id="invoiceISplitAjax" style="width: 100%;"></div>
                    </div>

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

    <script>
        $(document).ready(function() {
            $('#myTable, #myTable1').DataTable();
        });

        $(document).on('change', '#includePaid', function() {
            if ($(this).is(":checked")) {
                $('#paymentMethod').val('');
                filtering(1, '');
            } else {
                $('#paymentMethod').val(1);
                filtering('', 1);
            }
        });

        $(document).on('change', '#paymentMethod', function() {
            var paymentMethod = $(this).val();
            if (paymentMethod != '') {
                $('#includePaid').prop('checked', false);
                filtering('', paymentMethod);
            }
            // else {
            //     $('#includePaid').prop('checked', true);
            //     filtering(1, '');
            // }
        });

        function filtering(include, method) {
            //alert(sort_val);
            var qUrl = ""
            var current_url = window.location.href;
            var base_url = current_url.split("?")[0];
            var hashes = current_url.split("?")[1];
            var hash = hashes.split('&');
            for (var i = 0; i < hash.length; i++) {
                params = hash[i].split("=");
                if (params[0] == 'include') {
                    params[1] = include;
                }
                if (params[0] == 'method') {
                    params[1] = method;
                }
                paramJoin = params.join("=");
                qUrl = "" + qUrl + paramJoin + "&";
            }
            if (qUrl != '') {
                qUrl = qUrl.substr(0, qUrl.length - 1);
            }

            var joinUrl = base_url + "?" + qUrl
            //alert("My favourite sports are: " + joinUrl);
            window.location.assign(joinUrl);
        }

        function invoiceAdd(school_id, include, method) {
            swal({
                    title: "",
                    text: "Are you sure you wish to add new invoice?",
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
                                url: '{{ url('schoolFinanceInvoiceInsert') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    school_id: school_id,
                                    include: include,
                                    method: method
                                },
                                success: function(data) {
                                    // console.log(data);
                                    var include1 = '';
                                    if (data.include != null) {
                                        include1 = data.include;
                                    }
                                    var method1 = '';
                                    if (data.method != null) {
                                        method1 = data.method;
                                    }
                                    var rUrl = '<?php echo url('/school-finance-invoice-edit/'); ?>' + '/' + data.school_id + '/' + data
                                        .invoice_id + '?include=' + include1 + '&method=' + method1;
                                    window.location.assign(rUrl);
                                }
                            });
                    }
                });
        }

        function editInvoiceRowSelect(invoice_id) {
            if ($('#editInvoiceRow' + invoice_id).hasClass('tableRowActive')) {
                $('#editInvoiceId').val('');
                $('#editInvoiceRow' + invoice_id).removeClass('tableRowActive');
                $('#InvoiceEditBttn').addClass('disabled-link');
                $('#remitInvoiceBtn').addClass('disabled-link');
                $('#creditNoteBttn').addClass('disabled-link');
                $('#splitInvoiceBtn').addClass('disabled-link');
                $('#previewInvoiceBtn').addClass('disabled-link');
                $('#sendInvoiceBtn').addClass('disabled-link');
            } else {
                $('#editInvoiceId').val(invoice_id);
                $('.editInvoiceRow').removeClass('tableRowActive');
                $('#editInvoiceRow' + invoice_id).addClass('tableRowActive');
                $('#InvoiceEditBttn').removeClass('disabled-link');
                $('#remitInvoiceBtn').removeClass('disabled-link');
                $('#creditNoteBttn').removeClass('disabled-link');
                $('#splitInvoiceBtn').removeClass('disabled-link');
                $('#previewInvoiceBtn').removeClass('disabled-link');
                $('#sendInvoiceBtn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#InvoiceEditBttn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            var editInvoiceSchoolId = $('#editInvoiceSchoolId').val();
            var editInvoiceIncludeId = $('#editInvoiceIncludeId').val();
            var editInvoiceMethodId = $('#editInvoiceMethodId').val();
            if (editInvoiceId) {
                var rUrl = '<?php echo url('/school-finance-invoice-edit/'); ?>' + '/' + editInvoiceSchoolId + '/' + editInvoiceId + '?include=' +
                    editInvoiceIncludeId + '&method=' + editInvoiceMethodId;
                window.location.assign(rUrl);
            } else {
                swal("", "Please select one invoice.");
            }
        });

        $(document).on('click', '#creditNoteBttn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            var editInvoiceSchoolId = $('#editInvoiceSchoolId').val();
            var editInvoiceIncludeId = $('#editInvoiceIncludeId').val();
            var editInvoiceMethodId = $('#editInvoiceMethodId').val();
            if (editInvoiceId) {
                swal({
                        title: "",
                        text: "You currently have an invoice selected. Do you want to create a credit copy of that invoice?",
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
                                    url: '{{ url('schoolCreditInvoiceInsert') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        editInvoiceId: editInvoiceId,
                                        school_id: editInvoiceSchoolId
                                    },
                                    success: function(data) {
                                        // console.log(data);
                                        var rUrl = '<?php echo url('/school-finance-invoice-edit/'); ?>' + '/' +
                                            editInvoiceSchoolId + '/' + data.invoice_id +
                                            '?include=' +
                                            editInvoiceIncludeId + '&method=' + editInvoiceMethodId;
                                        window.location.assign(rUrl);
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one invoice.");
            }
        });

        $(document).on('click', '#splitInvoiceBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            var editInvoiceSchoolId = $('#editInvoiceSchoolId').val();
            if (editInvoiceId) {
                $('#splitInvoiceId').val(editInvoiceId);
                $('#splitInvoiceSchoolId').val(editInvoiceSchoolId);
                $('#spanInvId').html(editInvoiceId);
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
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('invoiceDetailForSplit') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        editInvoiceId: editInvoiceId
                                    },
                                    success: function(data) {
                                        //console.log(data);
                                        $('#invoiceISplitAjax').html(data.html);
                                    }
                                });
                                $('#splitInvoiceModal').modal("show");
                        }
                    });
            } else {
                swal("", "Please select one invoice.");
            }
        });
    </script>
@endsection
