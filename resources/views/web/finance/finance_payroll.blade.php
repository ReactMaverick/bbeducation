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
                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="finance-payroll-contact-first-sec sec_box_edit">
                                        <div class="invoice-top-section details-heading">
                                            <div class="finance-payroll-top-sec">
                                                <div class="finance-payroll-top-btn-sec">
                                                    <button class="btn btn-secondary btn_nw" id="selectNoneBtn">Select
                                                        None</button>
                                                </div>

                                                <div class="finance-payroll-top-btn-sec">
                                                    <button class="btn btn-info btn_nw" id="selectAllBtn">Select
                                                        All</button>
                                                </div>
                                            </div>

                                            <div class="invoice-edit-icon">
                                                <a style="cursor: pointer" class="disabled-link icon_all"
                                                    id="payrollEditBtn" title="Edit timesheet">
                                                    <i class="fas fa-edit school-edit-icon"></i>
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
                                            <table class="table table-bordered table-striped" id="myTable1">
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
                                        <div class="invoice-process-btn p-2 finance_timesheets_form"
                                            style="text-align: center;">
                                            <button class="btn btn-secondary timesheet-search-btn"
                                                id="processPayrollBtn">Process Selected</button>
                                        </div>

                                        <input type="hidden" name="" id="initialAsnItemIds"
                                            value="{{ $asnItemIds }}">

                                        <form action="{{ url('/financeProcessPayroll') }}" method="post"
                                            id="processPayrollForm">
                                            @csrf
                                            <input type="hidden" name="payrollAsnItemIds" id="payrollAsnItemIds"
                                                value="">
                                        </form>
                                    </div>
                                </div>

                                <div class="col-md-3 col-lg-3 col-xl-3 col-12 col-sm-12">
                                    <div class="invoice-top-section sec_box_edit">
                                        <div class="finance-payroll-top-second-sec details-heading">
                                            <div class="finance-payroll-pay-date-sec">
                                                <span>Pay Date</span>
                                            </div>

                                            <div class="finance-payroll-top-btn-sec date-text contact-icon-sec">
                                                <a style="cursor: pointer;" onclick="clickDate('prev')" class="icon_all">
                                                    <i class="fas fa-caret-left"></i>
                                                </a>
                                                <span id="dateSpan">{{ date('d-m-Y', strtotime($friday)) }}</span>
                                                <a style="cursor: pointer;" onclick="clickDate('next')" class="icon_all">
                                                    <i class="fas fa-caret-right"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <input type="hidden" name="" id="fridayDate" value="{{ $friday }}">

                                        <div class="finance-payroll-table-section  finance-payroll-page-tbl">
                                            <table class="table table-bordered table-striped" id="myTable2">
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
                                    </div>
                                </div>

                                <div class="col-md-3 col-lg-3 col-xl-3 col-12 col-sm-12">
                                    <div class="payroll-table-right-sec sec_box_edit">
                                        <div class="finance-payroll-icon details-heading">
                                            <div class="contact-heading-text">

                                            </div>
                                            <div class="contact-icon-sec">
                                                <a style="cursor: pointer;" id="exportPayrollBtn" class="icon_all">
                                                    <i class="fas fa-piggy-bank">
                                                    </i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="finance-payroll-table-section finance-payroll-page-tbl">
                                            <table class="table table-bordered table-striped" id="myTable3">
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
                                                            <td>{{ date('d-m-Y', strtotime($payrollRun->payDate_dte)) }}
                                                            </td>
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
            </div>
        </div>
    </section>

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
        $(document).ready(function() {
            $('#myTable1').DataTable({
                scrollY: '466px',
                paging: false,
                footer: false,
                info: false,
                ordering: false,
                searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
            $('#myTable2').DataTable({
                scrollY: '516px',
                paging: false,
                footer: false,
                info: false,
                ordering: false,
                searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
            $('#myTable3').DataTable({
                scrollY: '520px',
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
