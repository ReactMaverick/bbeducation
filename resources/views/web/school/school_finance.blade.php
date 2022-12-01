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
                                    <a href="#"><i class="fa-solid fa-square-check"></i></a>
                                    <a href="#"><i class="fa-solid fa-money-bills"></i></a>
                                    <a href="#"><i class="fa-solid fa-arrow-up"></i></a>
                                    <a href="#"><i class="fa-solid fa-id-card"></i></a>
                                    <a href="#"><i class="fa-solid fa-envelope"></i></a>
                                    <a href="#"><i class="fa-solid fa-plus"></i></a>
                                    <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                                </div>
                            </div>
                        </div>


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
                                        <tr class="school-detail-table-data">
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
                            <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
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
            } else {
                $('#includePaid').prop('checked', true);
                filtering(1, '');
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
    </script>
@endsection
