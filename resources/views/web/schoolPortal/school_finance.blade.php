@extends('web.schoolPortal.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.schoolPortal.school_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.schoolPortal.school_header')

                <div class="school-finance-right-sec">


                    <div class="school-finance-section">

                        <div class="school-finance-sec" style="justify-content: space-between;">
                            <div class="school-finance-contact-heading-text">
                                <h2>Finance</h2>
                            </div>
                            {{-- <div class="form-check paid-check">
                                <label for="includePaid">Include paid</label>
                                <input type="checkbox" id="includePaid" name="include" value="1"
                                    <?php
                                    //echo app('request')->input('include') == 1 ? 'checked' : '';
                                    ?>><br>
                            </div> --}}

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
                                    <a style="cursor: pointer" class="disabled-link" id="previewInvoiceBtn"
                                        title="Preview Invoice">
                                        <img src="{{ asset('web/company_logo/search-file.png') }}" alt="">
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

                            <div class="finance-timesheet-contact-first-sec" style="width: 100%">
                                <div class="contact-heading">
                                    <div class="contact-heading-text">
                                        <h2>Teacher Timesheet For Approval</h2>
                                    </div>
                                    <div class="contact-icon-sec">
                                        <a style="cursor: pointer;" class="disabled-link" id="approveTimesheetBtn"
                                            title="Approve Timesheet">
                                            <i class="fa-solid fa-square-check"></i>
                                        </a>
                                        <a style="cursor: pointer;" class="disabled-link" id="viewTimesheetBtn"
                                            title="View timesheet">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="finance-list-section">
                                    <div class="finance-list-text-section">
                                        <div class="finance-list-text">
                                            <table class="table finance-timesheet-page-table" id="">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Teacher</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($documentList as $key => $document)
                                                        <tr class="school-detail-table-data selectDocumentRow"
                                                            id="selectDocumentRow{{ $document->teacher_timesheet_id }}"
                                                            onclick="selectDocumentRowSelect({{ $document->teacher_timesheet_id }})">
                                                            <td>
                                                                @if ($document->knownAs_txt == null && $document->knownAs_txt == '')
                                                                    {{ $document->firstName_txt . ' ' . $document->surname_txt }}
                                                                @else
                                                                    {{ $document->knownAs_txt . ' ' . $document->surname_txt }}
                                                                @endif
                                                            </td>
                                                            <td>({{ date('d/m/Y', strtotime($document->start_date)) . '-' . date('d/m/Y', strtotime($document->end_date)) }})
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <input type="hidden" name="teacherTimesheetId" id="teacherTimesheetId"
                                            value="">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>



            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable, #myTable1').DataTable();
        });

        $(document).on('change', '#includePaid', function() {
            var method = "<?php echo app('request')->input('method'); ?>";
            if ($(this).is(":checked")) {
                $('#paymentMethod').val(method);
                filtering(1, method);
            } else {
                $('#paymentMethod').val(method);
                filtering('', method);
            }
        });

        $(document).on('change', '#paymentMethod', function() {
            var paymentMethod = $(this).val();
            var include = "<?php echo app('request')->input('include'); ?>";
            if (paymentMethod != '') {
                // $('#includePaid').prop('checked', false);
                filtering(include, paymentMethod);
            } else {
                // $('#includePaid').prop('checked', true);
                filtering(include, '');
            }
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

        function editInvoiceRowSelect(invoice_id) {
            if ($('#editInvoiceRow' + invoice_id).hasClass('tableRowActive')) {
                $('#editInvoiceId').val('');
                $('#editInvoiceRow' + invoice_id).removeClass('tableRowActive');
                // $('#InvoiceEditBttn').addClass('disabled-link');
                // $('#remitInvoiceBtn').addClass('disabled-link');
                // $('#creditNoteBttn').addClass('disabled-link');
                // $('#splitInvoiceBtn').addClass('disabled-link');
                $('#previewInvoiceBtn').addClass('disabled-link');
                // $('#sendInvoiceBtn').addClass('disabled-link');
                // $('#deleteInvoiceBttn').addClass('disabled-link');
            } else {
                $('#editInvoiceId').val(invoice_id);
                $('.editInvoiceRow').removeClass('tableRowActive');
                $('#editInvoiceRow' + invoice_id).addClass('tableRowActive');
                // $('#InvoiceEditBttn').removeClass('disabled-link');
                // $('#remitInvoiceBtn').removeClass('disabled-link');
                // $('#creditNoteBttn').removeClass('disabled-link');
                // $('#splitInvoiceBtn').removeClass('disabled-link');
                $('#previewInvoiceBtn').removeClass('disabled-link');
                // $('#sendInvoiceBtn').removeClass('disabled-link');
                // $('#deleteInvoiceBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#previewInvoiceBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            var editInvoiceSchoolId = $('#editInvoiceSchoolId').val();
            if (editInvoiceSchoolId && editInvoiceId) {
                var rUrl = '<?php echo url('/school/invoice-pdf/'); ?>' + '/' + editInvoiceSchoolId + '/' + editInvoiceId;
                window.open(rUrl, '_blank');
            } else {
                swal("", "Please select one invoice.");
            }
        });

        function selectDocumentRowSelect(teacher_timesheet_id) {
            // $('#teacherTimesheetTbody').html('');
            // $('#teacherTimesheetDiv').css('display', 'none');
            if ($('#selectDocumentRow' + teacher_timesheet_id).hasClass('tableRowActive')) {
                $('#teacherTimesheetId').val('');
                $('#selectDocumentRow' + teacher_timesheet_id).removeClass('tableRowActive');
                $('#approveTimesheetBtn').addClass('disabled-link');
                // $('#sendTimesheetBtn').addClass('disabled-link');
                $('#viewTimesheetBtn').addClass('disabled-link');
            } else {
                $('#teacherTimesheetId').val(teacher_timesheet_id);
                $('.selectDocumentRow').removeClass('tableRowActive');
                $('#selectDocumentRow' + teacher_timesheet_id).addClass('tableRowActive');
                $('#approveTimesheetBtn').removeClass('disabled-link');
                // $('#sendTimesheetBtn').removeClass('disabled-link');
                $('#viewTimesheetBtn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#viewTimesheetBtn', function() {
            var teacher_timesheet_id = $('#teacherTimesheetId').val();
            if (teacher_timesheet_id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/school/logSchoolTeacherSheet') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacher_timesheet_id: teacher_timesheet_id
                    },
                    success: function(data) {
                        //console.log(data);
                        // $('#teacherTimesheetTbody').html('');
                        // $('#teacherTimesheetTbody').html(data.html);
                        // $('#teacherTimesheetDiv').css('display', 'block');

                        if (data.pdfPath) {
                            var location = data.pdfPath;
                            window.open(location);
                        }
                    }
                });
            } else {
                swal("", "Please select one document.");
            }
        });

        $(document).on('click', '#approveTimesheetBtn', function() {
            var teacher_timesheet_id = $('#teacherTimesheetId').val();
            if (teacher_timesheet_id) {
                swal({
                        title: "",
                        text: "Choose to approve or not approve.",
                        buttons: {
                            Yes: "Approve",
                            No: "Not Approve",
                            cancel: "Cancel"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('/school/approveTeacherSheet') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        teacher_timesheet_id: teacher_timesheet_id,
                                        status: 2
                                    },
                                    success: function(data) {
                                        //console.log(data);
                                        location.reload();
                                    }
                                });
                                break;
                            case "No":
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('/school/approveTeacherSheet') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        teacher_timesheet_id: teacher_timesheet_id,
                                        status: 3
                                    },
                                    success: function(data) {
                                        //console.log(data);
                                        location.reload();
                                    }
                                });
                                break;
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });
    </script>
@endsection
