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

                    <div class="finance-remittance-contact-first-sec">
                        <div class="invoice-top-section">
                            <div class="form-group finance-remittance-payment-method">
                                <label>Payment Method</label>
                                <select id="paymentMethod" name="method" class="form-control">
                                    <option value="">Choose One</option>
                                    @foreach ($paymentMethodList as $key1 => $paymentMethod)
                                        <option value="{{ $paymentMethod->description_int }}"
                                            {{ app('request')->input('method') == $paymentMethod->description_int ? 'selected' : '' }}>
                                            {{ $paymentMethod->description_txt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="finance-remittance-top-sec">
                                <div class="invoice-checkbox-top-section">
                                    <div class="invoice-checkbox-sec">
                                        <input type="checkbox" id="includePaid" name="include" value="1"
                                            {{ app('request')->input('include') == 1 ? 'checked' : '' }}>
                                    </div>
                                    <div class="invoice-checkbox-sec">
                                        <label for="includePaid">Include Paid</label>
                                    </div>
                                </div>
                                <div class="remittance-top-icon">
                                    <a style="cursor: pointer" class="disabled-link" id="remitInvoiceBtn"
                                        title="Remit Invoice">
                                        <i class="fa-solid fa-square-check"></i>
                                    </a>
                                    <a style="cursor: pointer" class="disabled-link" id="previewInvoiceBtn"
                                        title="Preview Invoice">
                                        <img src="{{ asset('web/company_logo/search-file.png') }}" alt="">
                                    </a>
                                </div>
                            </div>

                        </div>

                        <input type="hidden" name="" id="editInvoiceId" value="">
                        <input type="hidden" name="" id="editInvoiceIncludeId"
                            value="{{ app('request')->input('include') }}">
                        <input type="hidden" name="" id="editInvoiceMethodId"
                            value="{{ app('request')->input('method') }}">

                        <div class="finance-invoice-table-section">
                            <table class="table finance-timesheet-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Invoice ID</th>
                                        <th>Invoice Date</th>
                                        <th>School</th>
                                        <th>Paid On</th>
                                        <th>Remitted By</th>
                                        <th>Sent On</th>
                                        <th>Sent By</th>
                                        <th>Net</th>
                                        <th>VAT</th>
                                        <th>Gross</th>
                                        <th>Status By School</th>
                                        <th>Paid On (School)</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($remitInvoices as $key => $Invoices)
                                        <tr class="school-detail-table-data editInvoiceRow"
                                            onclick="editInvoiceRowSelect('<?php echo $Invoices->invoice_id; ?>')"
                                            id="editInvoiceRow{{ $Invoices->invoice_id }}">
                                            <td>{{ $Invoices->invoice_id }}</td>
                                            <td>{{ $Invoices->invoice_dte ? date('d-m-Y', strtotime($Invoices->invoice_dte)) : '' }}
                                            </td>
                                            <td>{{ $Invoices->school_txt }}</td>
                                            <td>{{ $Invoices->paid_dte ? date('d-m-Y', strtotime($Invoices->paid_dte)) : '' }}
                                            </td>
                                            <td>{{ $Invoices->remittee_txt }}</td>
                                            <td>{{ $Invoices->sent_dte ? date('d-m-Y', strtotime($Invoices->sent_dte)) : '' }}
                                            </td>
                                            <td>{{ $Invoices->sender_txt }}</td>
                                            <td>{{ $Invoices->net_dec }}</td>
                                            <td>{{ $Invoices->vat_dec }}</td>
                                            <td>{{ $Invoices->gross_dec }}</td>
                                            <td>
                                                @if ($Invoices->school_paid_dte)
                                                    Paid
                                                    @if ($Invoices->paymentMethod_txt)
                                                        (by {{ $Invoices->paymentMethod_txt }})
                                                    @endif
                                                @else
                                                    Due
                                                @endif
                                            </td>
                                            <td>
                                                @if ($Invoices->school_paid_dte != null)
                                                    {{ date('d-m-Y', strtotime($Invoices->school_paid_dte)) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="finance-remittance-contact-second-sec">

                        <div class="amount-owed-heading-sec">
                            <h2>Amount Owed</h2>
                            <div class="amount-owed-price-sec">
                                <span>Net</span>
                                @if ($invoiceCal->net_dec)
                                    <p>&#163 {{ $invoiceCal->net_dec }}</p>
                                @endif
                            </div>
                            <div class="amount-owed-price-sec">
                                <span>Vat</span>
                                @if ($invoiceCal->vat_dec)
                                    <p>&#163 {{ $invoiceCal->vat_dec }}</p>
                                @endif
                            </div>
                            <div class="amount-owed-price-sec">
                                <span>Gross</span>
                                @if ($invoiceCal->gross_dec)
                                    <p>&#163 {{ $invoiceCal->gross_dec }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="amount-owed-heading-sec">
                            <h2>Amount Overdue</h2>
                            <div class="amount-owed-price-sec">
                                <span>Net</span>
                                @if ($invoiceCal->net_dec)
                                    <p>&#163 {{ $invoiceCal->net_dec }}</p>
                                @endif
                            </div>
                            <div class="amount-owed-price-sec">
                                <span>Vat</span>
                                @if ($invoiceCal->vat_dec)
                                    <p>&#163 {{ $invoiceCal->vat_dec }}</p>
                                @endif
                            </div>
                            <div class="amount-owed-price-sec">
                                <span>Gross</span>
                                @if ($invoiceCal->gross_dec)
                                    <p>&#163 {{ $invoiceCal->gross_dec }}</p>
                                @endif
                            </div>

                            {{-- <div class="Amount-owed-icon-sec">
                                <a href="#"><i class="fa-solid fa-arrows-rotate"></i></a>
                            </div> --}}

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "order": [
                    [11, "desc"]
                ]
            });
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
                $('#remitInvoiceBtn').addClass('disabled-link');
                $('#previewInvoiceBtn').addClass('disabled-link');
            } else {
                $('#editInvoiceId').val(invoice_id);
                $('.editInvoiceRow').removeClass('tableRowActive');
                $('#editInvoiceRow' + invoice_id).addClass('tableRowActive');
                $('#remitInvoiceBtn').removeClass('disabled-link');
                $('#previewInvoiceBtn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#remitInvoiceBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            if (editInvoiceId) {
                swal({
                        title: "",
                        text: "You currently have an invoice selected. Do you want to remit that invoice?",
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
                                    url: '{{ url('schoolInvoiceRemit') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        editInvoiceId: editInvoiceId
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one invoice.");
            }
        });

        $(document).on('click', '#previewInvoiceBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            if (editInvoiceId) {
                var rUrl = '<?php echo url('/finance-invoice-pdf/'); ?>' + '/' + editInvoiceId;
                window.open(rUrl, '_blank');
            } else {
                swal("", "Please select one invoice.");
            }
        });
    </script>
@endsection
