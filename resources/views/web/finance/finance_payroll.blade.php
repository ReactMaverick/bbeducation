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

                    <div class="finance-payroll-contact-first-sec">
                        <div class="invoice-top-section">
                            <div class="finance-payroll-top-sec">
                                <div class="finance-payroll-top-btn-sec">
                                    <button id="selectNoneBtn">Select None</button>
                                </div>

                                <div class="finance-payroll-top-btn-sec">
                                    <button id="selectAllBtn">Select All</button>
                                </div>
                            </div>

                            <div class="invoice-edit-icon">
                                <a style="cursor: pointer" class="disabled-link" id="payrollEditBtn" title="Edit timesheet">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            </div>
                        </div>

                        <?php
                        $asnItemIdsArr = [];
                        foreach ($payrollList as $key => $payroll) {
                            array_push($asnItemIdsArr, $payroll->asnItem_id);
                        }
                        $asnItemIds = implode(',', $asnItemIdsArr);
                        ?>

                        <div class="finance-invoice-table-section finance-payroll-page-tbl">
                            <table class="table finance-timesheet-page-table">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Teacher</th>
                                        <th>School</th>
                                        <th>Date</th>
                                        <th>Part</th>
                                        <th>Pay</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec" id="payrollTbody">
                                    @foreach ($payrollList as $key1 => $payroll)
                                        <tr class="school-detail-table-data editPayrollRow"
                                            id="editPayrollRow{{ $payroll->asnItem_id }}"
                                            onclick="payrollRow('{{ $payroll->asnItem_id }}')">
                                            <td>
                                                @if ($payroll->knownAs_txt == null && $payroll->knownAs_txt == '')
                                                    {{ $payroll->firstName_txt . ' ' . $payroll->surname_txt }}
                                                @else
                                                    {{ $payroll->firstName_txt . ' (' . $payroll->knownAs_txt . ') ' . $payroll->surname_txt }}
                                                @endif
                                            </td>
                                            <td>{{ $payroll->name_txt }}</td>
                                            <td>{{ date('d-m-Y', strtotime($payroll->asnDate_dte)) }}</td>
                                            <td>{{ $payroll->dayPart_dec }}</td>
                                            <td>{{ $payroll->pay_dec }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="invoice-process-btn">
                            <button id="processPayrollBtn">Process Selected</button>
                        </div>

                        <input type="hidden" name="" id="initialAsnItemIds" value="{{ $asnItemIds }}">

                        <form action="{{ url('/financeProcessPayroll') }}" method="post" id="processPayrollForm">
                            @csrf
                            <input type="hidden" name="payrollAsnItemIds" id="payrollAsnItemIds" value="">
                        </form>
                    </div>

                    <div class="finance-payroll-contact-first-sec">
                        <div class="invoice-top-section">
                            <div class="finance-payroll-top-second-sec">
                                <div class="finance-payroll-pay-date-sec">
                                    <span>Pay Date</span>
                                </div>

                                <div class="finance-payroll-top-btn-sec">
                                    <a style="cursor: pointer;" onclick="clickDate('prev')">
                                        <i class="fa-solid fa-caret-left"></i>
                                    </a>
                                    <span id="dateSpan">{{ date('d-m-Y', strtotime($friday)) }}</span>
                                    <a style="cursor: pointer;" onclick="clickDate('next')">
                                        <i class="fa-solid fa-caret-right"></i>
                                    </a>
                                </div>
                            </div>

                            <input type="hidden" name="" id="fridayDate" value="{{ $friday }}">

                            <div class="finance-payroll-icon">
                                <a style="cursor: pointer;" id="exportPayrollBtn">
                                    <i class="fa-solid fa-piggy-bank">
                                    </i>
                                </a>
                            </div>
                        </div>

                        <div class="payroll-table-right-sec">
                            <div class="finance-payroll-table-section  finance-payroll-page-tbl mr-3">
                                <table class="table finance-timesheet-page-table">
                                    <thead>
                                        <tr class="school-detail-table-heading">
                                            <th>Teacher</th>
                                            <th>Items</th>
                                            <th>Gross Pay</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body-sec" id="paySummaryTbody">
                                        @foreach ($paySummaryList as $key2 => $paySummary)
                                            <tr class="school-detail-table-data">
                                                <td>
                                                    @if ($paySummary->knownAs_txt == null && $paySummary->knownAs_txt == '')
                                                        {{ $paySummary->firstName_txt . ' ' . $paySummary->surname_txt }}
                                                    @else
                                                        {{ $paySummary->firstName_txt . ' (' . $paySummary->knownAs_txt . ') ' . $paySummary->surname_txt }}
                                                    @endif
                                                </td>
                                                <td>{{ $paySummary->days_dec }}</td>
                                                <td>{{ $paySummary->grossPay_dec }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="finance-payroll-table-section  finance-payroll-page-tbl ml-3">
                                <table class="table finance-timesheet-page-table">
                                    <thead>
                                        <tr class="school-detail-table-heading">
                                            <th>Pay Date</th>
                                            <th>Teachers</th>
                                            <th>Gross Pay</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body-sec">
                                        @foreach ($payrollRunList as $key3 => $payrollRun)
                                            <tr class="school-detail-table-data editPayrollRunRow"
                                                id="editPayrollRunRow{{ $key3 + 1 }}"
                                                onclick="payrollRowRun('{{ $key3 + 1 }}','{{ $payrollRun->payDate_dte }}')">
                                                <td>{{ date('d-m-Y', strtotime($payrollRun->payDate_dte)) }}</td>
                                                <td>{{ $payrollRun->teachers_int }}</td>
                                                <td>{{ $payrollRun->grossPay_dec }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                    <h4 class="modal-title">Edit Rate</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Rate</h2>
                </div>

                <form action="{{ url('/payrollEventUpdate') }}" method="post" class="form-validate"
                    id="ajaxPayrollEventForm">
                    @csrf

                    <input type="hidden" name="asnItem_id" id="payrollAsnItemId" value="">

                    <div class="modal-input-field-section">
                        <div class="modal-input-field form-group">
                            <label class="form-check-label">Please enter the new pay rate for that date</label>
                            <input type="text" class="form-control number-validate onlynumber" name="cost_dec"
                                id="payrollCostDec" value="">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-secondary" id="ajaxPayrollEventBtn">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Event Edit Modal -->

    <script>
        function payrollRow(asnItem_id) {
            if ($('#editPayrollRow' + asnItem_id).hasClass('tableRowActive')) {
                setIds(asnItem_id, 'rm');
                $('#editPayrollRow' + asnItem_id).removeClass('tableRowActive');
            } else {
                setIds(asnItem_id, 'add');
                $('#editPayrollRow' + asnItem_id).addClass('tableRowActive');
            }
        }

        function setIds(asnItem_id, type) {
            var ItemId = parseInt(asnItem_id);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#payrollAsnItemIds').val();
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
            $('#payrollAsnItemIds').val(ids);
            if (ids) {
                $('#payrollEditBtn').removeClass('disabled-link');
            } else {
                $('#payrollEditBtn').addClass('disabled-link');
            }
        }

        $(document).on('click', '#selectAllBtn', function(event) {
            var initialAsnItemIds = $('#initialAsnItemIds').val();
            if (initialAsnItemIds) {
                var asnIdsArr = initialAsnItemIds.split(",");
                $.each(asnIdsArr, function(index, value) {
                    $('#editPayrollRow' + value).addClass('tableRowActive');
                });
                $('#payrollAsnItemIds').val(initialAsnItemIds);
                $('#payrollEditBtn').removeClass('disabled-link');
            }
        });

        $(document).on('click', '#selectNoneBtn', function(event) {
            $('.editPayrollRow').removeClass('tableRowActive');
            $('#payrollAsnItemIds').val('');
            $('#payrollEditBtn').addClass('disabled-link');
        });

        $(document).on('click', '#payrollEditBtn', function() {
            var asnItemIds = $('#payrollAsnItemIds').val();
            if (asnItemIds) {
                var idsArr = [];
                idsArr = asnItemIds.split(',');
                if (idsArr.length == 1) {
                    $('#fullLoader').show();
                    $('#payrollAsnItemId').val(idsArr[0]);
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('payrollEventEdit') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            asnItemId: idsArr[0]
                        },
                        success: function(data) {
                            if (data.exist == 'Yes') {
                                $('#payrollCostDec').val(data.eventItemDetail.cost_dec);
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

        $('#ajaxPayrollEventForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                event_Form_submit();
            }
        });

        $(document).on('click', '#ajaxPayrollEventBtn', function() {
            event_Form_submit();
        });

        function event_Form_submit() {
            var error = "";
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
                var form = $("#ajaxPayrollEventForm");
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
                                $('#payrollTbody').html(data.html);
                                $('#payrollAsnItemIds').val(eventId);
                                $('#editPayrollRow' + eventId).addClass('tableRowActive');

                                $('#eventEditModal').modal("hide");
                            }
                        }
                        $('#fullLoader').hide();
                    }
                });
            }
        }

        $(document).on('click', '#processPayrollBtn', function() {
            var asnItemIds = $('#payrollAsnItemIds').val();
            if (asnItemIds) {
                $('#fullLoader').show();
                $('#processPayrollForm').submit()
            } else {
                swal("", "Please select atleast one item.");
            }
        });

        function clickDate(dateType) {
            $('#fullLoader').show();
            var fridayDate = $('#fridayDate').val();
            fetchPaySummary(dateType, fridayDate);
        }

        function payrollRowRun(keyId, payDate_dte) {
            $('.editPayrollRunRow').removeClass('tableRowActive');
            $('#editPayrollRunRow' + keyId).addClass('tableRowActive');

            fetchPaySummary('', payDate_dte);
        }

        function fetchPaySummary(dateType, fridayDate) {
            $.ajax({
                type: 'POST',
                url: '{{ url('payrollDateChange') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    dateType: dateType,
                    fridayDate: fridayDate
                },
                dataType: "json",
                async: false,
                success: function(data) {
                    // console.log(data);
                    $('#fridayDate').val(data.newFriday);
                    $('#dateSpan').html(data.formattedDate);
                    $('#paySummaryTbody').html(data.html);

                    $('#fullLoader').hide();
                }
            });
        }

        $(document).on('click', '#exportPayrollBtn', function() {
            var fridayDate = $('#fridayDate').val();
            var url = "{{ url('exportPayroll') }}" + '/' + fridayDate;
            window.open(url, '_blank');
        });
    </script>
@endsection
