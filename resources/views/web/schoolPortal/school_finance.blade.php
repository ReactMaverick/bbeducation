@extends('web.schoolPortal.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }

        .date-left-teacher-calendar {
            width: 13%;
        }

        .teacher-calendar-days-text {
            width: 13%;
        }

        .teacher-calendar-days-field3 p {
            text-align: center;
        }

        .teacher-calendar-days-text p {
            /* border-bottom: 1px solid #A0C5E7; */
            padding-bottom: 3px;
        }

        .teacher-calendar-days-sec {
            border: 1px solid #afabab;
            padding-right: 21px;
        }

        .teacher-calendar-table-section {
            padding: 0 5px;
        }

        .calendar-outer-sec:hover {
            cursor: pointer;
        }

        .calendar-section {
            padding: 0 5px;
        }

        .invoice-top-section {
            justify-content: flex-end;
        }

        .finance-contact-icon-sec i {
            font-size: 25px;
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
                            <div class="form-check paid-check">
                                <label for="includePaid">Include paid</label>
                                <input type="checkbox" id="includePaid" name="include" value="1"
                                    <?php
                                    echo app('request')->input('include') == 1 ? 'checked' : '';
                                    ?>><br>
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
                        </div>

                        <div class="finance-timesheet-contact-first-sec" style="width: 100%">
                            <div class="contact-heading mb-2">
                                <div class="contact-heading-text">
                                    <h2>Teacher Timesheets</h2>
                                </div>

                                <div class="contact-icon-sec">
                                    <a style="cursor: pointer" class="disabled-link" id="timesheetRejectBtn"
                                        title="Reject timesheet">
                                        <i class="fa-sharp fa-solid fa-circle-xmark"></i>
                                    </a>
                                    <a style="cursor: pointer;" class="disabled-link" id="logTimesheetBtn"
                                        title="Log timesheet">
                                        <i class="fa-solid fa-square-check"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="total-days-slider-sec">
                                <div class="total-days-text">
                                    <div class="assignment-date">
                                        <a
                                            href="{{ URL::to('school/finance?include=' . app('request')->input('include') . '&method=' . app('request')->input('method') . '&date=' . date('Y-m-d', strtotime($weekStartDate . ' -7 days'))) }}">
                                            <i class="fa-solid fa-caret-left"></i>
                                        </a>
                                    </div>
                                    <div class="teacher-calendar-date-text">
                                        <span>{{ date('D d M Y', strtotime($weekStartDate)) }}</span>
                                    </div>
                                    <div class="assignment-date2">
                                        <a
                                            href="{{ URL::to('school/finance?include=' . app('request')->input('include') . '&method=' . app('request')->input('method') . '&date=' . date('Y-m-d', strtotime($weekStartDate . ' +7 days'))) }}">
                                            <i class="fa-solid fa-caret-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <?php
                            $day1Amount_total1 = 0;
                            $day2Amount_total1 = 0;
                            $day3Amount_total1 = 0;
                            $day4Amount_total1 = 0;
                            $day5Amount_total1 = 0;
                            foreach ($calenderList as $key => $cal) {
                                $day1Amount_total1 += $cal->day1Amount_dec;
                                $day2Amount_total1 += $cal->day2Amount_dec;
                                $day3Amount_total1 += $cal->day3Amount_dec;
                                $day4Amount_total1 += $cal->day4Amount_dec;
                                $day5Amount_total1 += $cal->day5Amount_dec;
                            }
                            ?>

                            <div class="teacher-calendar-days-sec">
                                <div class="teacher-calendar-days-text">
                                    <p>School</p>
                                </div>
                                <div class="teacher-calendar-days-text">
                                    <p>Teacher</p>
                                </div>
                                <div class="teacher-calendar-days-text">
                                    <p>Monday</p>
                                    <p class="teacher-calendar-bottom-text">{{ $day1Amount_total1 }}</p>
                                </div>
                                <div class="teacher-calendar-days-text">
                                    <p>Tuesday</p>
                                    <p class="teacher-calendar-bottom-text">{{ $day2Amount_total1 }}</p>
                                </div>
                                <div class="teacher-calendar-days-text">
                                    <p>Wednesday</p>
                                    <p class="teacher-calendar-bottom-text">{{ $day3Amount_total1 }}</p>
                                </div>
                                <div class="teacher-calendar-days-text">
                                    <p>Thursday</p>
                                    <p class="teacher-calendar-bottom-text">{{ $day4Amount_total1 }}</p>
                                </div>
                                <div class="teacher-calendar-days-text">
                                    <p>Friday</p>
                                    <p class="teacher-calendar-bottom-text">{{ $day5Amount_total1 }}</p>
                                </div>
                            </div>

                            <div class="finance-list-text-section">
                                <div class="teacher-calendar-table-section">

                                    @foreach ($calenderList as $key1 => $calender)
                                        <div class="calendar-outer-sec editApprovTimesheetDiv"
                                            id="editApprovTimesheetDiv{{ $calender->asn_id }}"
                                            onclick="timesheetApprovRow('{{ $calender->asn_id }}')">
                                            <div class="calendar-section">
                                                <div class="date-left-teacher-calendar">
                                                    <div class="teacher-calendar-days-field3">
                                                        <p>
                                                            {{ $calender->name_txt }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    <div class="teacher-calendar-days-field3">
                                                        <p>
                                                            @if ($calender->knownAs_txt == null && $calender->knownAs_txt == '')
                                                                {{ $calender->firstName_txt . ' ' . $calender->surname_txt }}
                                                            @else
                                                                {{ $calender->knownAs_txt . ' ' . $calender->surname_txt }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if ($calender->day1Avail_txt && $calender->day1asnDate_dte)
                                                        <div
                                                            class="{{ $calender->day1LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                            <p>{{ $calender->day1Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3"></div>
                                                    @endif
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if ($calender->day2Avail_txt && $calender->day2asnDate_dte)
                                                        <div
                                                            class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                            <p>{{ $calender->day2Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3"></div>
                                                    @endif
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if ($calender->day3Avail_txt && $calender->day3asnDate_dte)
                                                        <div
                                                            class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                            <p>{{ $calender->day3Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3"></div>
                                                    @endif
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if ($calender->day4Avail_txt && $calender->day4asnDate_dte)
                                                        <div
                                                            class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                            <p>{{ $calender->day4Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3"></div>
                                                    @endif
                                                </div>
                                                <div class="date-left-teacher-calendar">
                                                    @if ($calender->day5Avail_txt && $calender->day5asnDate_dte)
                                                        <div
                                                            class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                            <p>{{ $calender->day5Avail_txt }}</p>
                                                        </div>
                                                    @else
                                                        <div class="teacher-calendar-days-field3"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                <input type="hidden" name="" id="approveAsnId" value="">
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

        function timesheetApprovRow(asn_id) {
            if ($('#editApprovTimesheetDiv' + asn_id).hasClass('timesheetActive')) {
                $('#approveAsnId').val('');
                $('#editApprovTimesheetDiv' + asn_id).removeClass('timesheetActive');
                $('#logTimesheetBtn').addClass('disabled-link');
                $('#timesheetRejectBtn').addClass('disabled-link');
            } else {
                $('#approveAsnId').val(asn_id);
                $('.editApprovTimesheetDiv').removeClass('timesheetActive');
                $('#editApprovTimesheetDiv' + asn_id).addClass('timesheetActive');
                $('#logTimesheetBtn').removeClass('disabled-link');
                $('#timesheetRejectBtn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#logTimesheetBtn', function() {
            var approveAsnId = $('#approveAsnId').val();
            if (approveAsnId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to log this timesheet?",
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
                                    url: '{{ url('/school/logSchoolTimesheetLog') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        approveAsnId: approveAsnId,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}"
                                    },
                                    success: function(data) {
                                        if (data.add == 'Yes') {
                                            $('#sendToSchoolBttn').addClass('disabled-link');
                                            $('#logTimesheetBtn').addClass('disabled-link');
                                            $('#editApprovTimesheetDiv' + approveAsnId)
                                                .remove();
                                            var popTxt =
                                                'You have just logged a timesheet for ' + data
                                                .schoolName +
                                                '. Timesheet ID : ' + data.timesheet_id;
                                            swal("", popTxt);
                                        } else {
                                            location.reload();
                                        }
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#timesheetRejectBtn', function() {
            var asnId = $('#approveAsnId').val();
            if (asnId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to reject the selected timesheet?",
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
                                    url: '{{ url('/school/logSchoolTimesheetReject') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnId: asnId,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}"
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });
    </script>
@endsection
