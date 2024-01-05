@extends('web.schoolPortal.layout')
@section('content')
    @php
        $schoolLoginData = Session::get('schoolLoginData');
    @endphp
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.schoolPortal.school_header')
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- /.content-header -->
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 topbar-sec">

                        <div class="row school-finance-right-sec">
                            <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6 col-12">
                                <div class="sec_box_edit">
                                    <div class="contact-heading details-heading">
                                        <div class="contact-heading-text">
                                            <h2>Amount Owed</h2>
                                        </div>
                                    </div>
                                    <div class="about-school-section">
                                        <div class="school-name-section">
                                            <div class="school-heading-text">
                                                <h2>Net</h2>
                                            </div>
                                            <div class="school-name-text">
                                                @if ($invoiceCal->net_dec)
                                                    <p>&#163
                                                        {{ number_format((float) $invoiceCal->net_dec, 2, '.', ',') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="school-name-section">
                                            <div class="school-heading-text">
                                                <h2>Vat</h2>
                                            </div>
                                            <div class="school-name-text">
                                                @if ($invoiceCal->vat_dec)
                                                    <p>&#163
                                                        {{ number_format((float) $invoiceCal->vat_dec, 2, '.', ',') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="school-name-section">
                                            <div class="school-heading-text">
                                                <h2>Gross</h2>
                                            </div>
                                            <div class="school-name-text">
                                                @if ($invoiceCal->gross_dec)
                                                    <p>&#163
                                                        {{ number_format((float) $invoiceCal->gross_dec, 2, '.', ',') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6 col-12">
                                <div class="sec_box_edit">
                                    <div class="contact-heading details-heading">
                                        <div class="contact-heading-text">
                                            <h2>Amount Overdue</h2>
                                        </div>
                                    </div>
                                    <div class="about-school-section">
                                        <div class="school-name-section">
                                            <div class="school-heading-text">
                                                <h2>Net</h2>
                                            </div>
                                            <div class="school-name-text">
                                                @if ($invoiceOverdueCal->net_dec)
                                                    <p>&#163
                                                        {{ number_format((float) $invoiceOverdueCal->net_dec, 2, '.', ',') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="school-name-section">
                                            <div class="school-heading-text">
                                                <h2>Vat</h2>
                                            </div>
                                            <div class="school-name-text">
                                                @if ($invoiceOverdueCal->vat_dec)
                                                    <p>&#163
                                                        {{ number_format((float) $invoiceOverdueCal->vat_dec, 2, '.', ',') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="school-name-section">
                                            <div class="school-heading-text">
                                                <h2>Gross</h2>
                                            </div>
                                            <div class="school-name-text">
                                                @if ($invoiceOverdueCal->gross_dec)
                                                    <p>&#163
                                                        {{ number_format((float) $invoiceOverdueCal->gross_dec, 2, '.', ',') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row school-finance-right-sec mt-3">
                            <div class="col-md-12 col-sm-12 col-lg-6 col-xl-6 col-12">
                                <div class="school-finance-sec heading_finance">
                                    <div class="finance_lft_box">
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
                                            <a style="cursor: pointer;" class="disabled-link" id="addPaymentMethodBtn"
                                                title="Add Payment Method">
                                                <i class="fas fa-check"></i>

                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 col-xl-6 col-12"></div>
                        </div>
                        <div class="row school-finance-right-sec my_row_gap">
                            <div class="col-md-12 col-sm-12 col-lg-6 col-xl-6 col-12">
                                <input type="hidden" name="" id="editInvoiceId" value="">
                                <input type="hidden" name="" id="editInvoiceSchoolId" value="{{ $school_id }}">
                                <input type="hidden" name="" id="editInvoiceIncludeId"
                                    value="{{ app('request')->input('include') }}">
                                <input type="hidden" name="" id="editInvoiceMethodId"
                                    value="{{ app('request')->input('method') }}">
                                <div class="sec_box_edit">
                                    <div class="contact-heading details-heading">
                                        <div class="contact-heading-text">
                                            <h2>Invoices</h2>
                                        </div>
                                    </div>
                                    <div class="school-finance-table-section">
                                        <table class="table table-bordered table-striped" id="myTable">
                                            <thead>
                                                <tr class="school-detail-table-heading">
                                                    <th>Invoice Number</th>
                                                    <th>Date</th>
                                                    <th>Net</th>
                                                    <th>Vat</th>
                                                    <th>Gross</th>
                                                    <th>Paid On</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body-sec">
                                                @foreach ($schoolInvoices as $key => $Invoices)
                                                    <tr class="school-detail-table-data editInvoiceRow"
                                                        onclick="editInvoiceRowSelect('<?php echo $Invoices->invoice_id; ?>')"
                                                        id="editInvoiceRow{{ $Invoices->invoice_id }}">
                                                        <td>{{ $Invoices->invoice_id }}</td>
                                                        <td>{{ date('d M Y', strtotime($Invoices->invoiceDate_dte)) }}</td>
                                                        <td>{{ $Invoices->net_dec }}</td>
                                                        <td>{{ $Invoices->vat_dec }}</td>
                                                        <td>{{ $Invoices->gross_dec }}</td>
                                                        <td>
                                                            @if ($Invoices->paidOn_dte != null)
                                                                {{ date('d M Y', strtotime($Invoices->paidOn_dte)) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($Invoices->paidOn_dte != null)
                                                                Paid
                                                            @else
                                                                @if ($Invoices->school_paid_dte)
                                                                    Paid
                                                                    @if ($Invoices->paymentMethod_txt)
                                                                        (by {{ $Invoices->paymentMethod_txt }})
                                                                    @endif
                                                                @else
                                                                    Due
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 col-xl-6 col-12">
                                <div class="sec_box_edit">
                                    <div class="contact-heading details-heading">
                                        <div class="contact-heading-text">
                                            <h2>Invoices (Paid by school)</h2>
                                        </div>
                                    </div>
                                    <div class="school-finance-table-section">
                                        <table class="table table-bordered table-striped" id="myTable2">
                                            <thead>
                                                <tr class="school-detail-table-heading">
                                                    <th>Invoice Number</th>
                                                    <th>Date</th>
                                                    <th>Net</th>
                                                    <th>Vat</th>
                                                    <th>Gross</th>
                                                    {{-- <th>Paid On</th> --}}
                                                    <th>Status</th>
                                                    <th>Paid On (School)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body-sec">
                                                @foreach ($schoolPaidInvoices as $key => $Invoices)
                                                    <tr class="school-detail-table-data editInvoiceRow"
                                                        onclick="editInvoiceRowSelect('<?php echo $Invoices->invoice_id; ?>')"
                                                        id="editInvoiceRow{{ $Invoices->invoice_id }}">
                                                        <td>{{ $Invoices->invoice_id }}</td>
                                                        <td>{{ date('d M Y', strtotime($Invoices->invoiceDate_dte)) }}</td>
                                                        <td>{{ $Invoices->net_dec }}</td>
                                                        <td>{{ $Invoices->vat_dec }}</td>
                                                        <td>{{ $Invoices->gross_dec }}</td>
                                                        {{-- <td>
                                                @if ($Invoices->paidOn_dte != null)
                                                    {{ date('d-m-Y', strtotime($Invoices->paidOn_dte)) }}
                                                @endif
                                            </td> --}}
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
                                                                {{ date('d M Y', strtotime($Invoices->school_paid_dte)) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="school-finance-right-sec mt-3">
                            <div class="school-finance-section">

                                <div class="finance-timesheet-contact-first-sec sec_box_edit" style="width: 100%">
                                    <div class="contact-heading details-heading">
                                        <div class="contact-heading-text">
                                            <h2>Teacher Timesheets (Sent from
                                                "{{ $schoolLoginData->company_name ? $schoolLoginData->company_name : '' }}")
                                            </h2>
                                        </div>

                                        <div class="contact-icon header_icon">
                                            @if ($canUpTimesheet)
                                                <a style="cursor: pointer" class="disabled-link" id="timesheetRejectBtn"
                                                    title="Reject timesheet">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link" id="logTimesheetBtn"
                                                    title="Log timesheet">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="day_sec about-school-section">
                                        <div class="total-days-slider-sec ">
                                            <div class="total-days-text">
                                                <div class="assignment-date">
                                                    <a
                                                        href="{{ URL::to('school/finance?include=' . app('request')->input('include') . '&method=' . app('request')->input('method') . '&date=' . date('Y-m-d', strtotime($weekStartDate . ' -7 days'))) }}">
                                                        <i class="fas fa-caret-left"></i>
                                                    </a>
                                                </div>
                                                <div class="teacher-calendar-date-text">
                                                    <span>{{ date('D d M Y', strtotime($weekStartDate)) }}</span>
                                                </div>
                                                <div class="assignment-date2">
                                                    <a
                                                        href="{{ URL::to('school/finance?include=' . app('request')->input('include') . '&method=' . app('request')->input('method') . '&date=' . date('Y-m-d', strtotime($weekStartDate . ' +7 days'))) }}">
                                                        <i class="fas fa-caret-right"></i>
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
                                                <p>{{ date('d M Y', strtotime($weekStartDate)) }}</p>
                                                <p>Monday</p>
                                                <p class="teacher-calendar-bottom-text">{{ $day1Amount_total1 }}</p>
                                            </div>
                                            <div class="teacher-calendar-days-text">
                                                <p>{{ date('d M Y', strtotime($weekStartDate . ' +1 days')) }}</p>
                                                <p>Tuesday</p>
                                                <p class="teacher-calendar-bottom-text">{{ $day2Amount_total1 }}</p>
                                            </div>
                                            <div class="teacher-calendar-days-text">
                                                <p>{{ date('d M Y', strtotime($weekStartDate . ' +2 days')) }}</p>
                                                <p>Wednesday</p>
                                                <p class="teacher-calendar-bottom-text">{{ $day3Amount_total1 }}</p>
                                            </div>
                                            <div class="teacher-calendar-days-text">
                                                <p>{{ date('d M Y', strtotime($weekStartDate . ' +3 days')) }}</p>
                                                <p>Thursday</p>
                                                <p class="teacher-calendar-bottom-text">{{ $day4Amount_total1 }}</p>
                                            </div>
                                            <div class="teacher-calendar-days-text">
                                                <p>{{ date('d M Y', strtotime($weekStartDate . ' +4 days')) }}</p>
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
                                                                        <p>
                                                                            {{ $calender->day1Avail_txt }}
                                                                            @if ($calender->start_tm1 && $calender->end_tm1)
                                                                                ({{ date('h:i a', strtotime($calender->start_tm1)) }}
                                                                                -
                                                                                {{ date('h:i a', strtotime($calender->end_tm1)) }})
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                @else
                                                                    <div class="teacher-calendar-days-field3"></div>
                                                                @endif
                                                            </div>
                                                            <div class="date-left-teacher-calendar">
                                                                @if ($calender->day2Avail_txt && $calender->day2asnDate_dte)
                                                                    <div
                                                                        class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                        <p>
                                                                            {{ $calender->day2Avail_txt }}
                                                                            @if ($calender->start_tm2 && $calender->end_tm2)
                                                                                ({{ date('h:i a', strtotime($calender->start_tm2)) }}
                                                                                -
                                                                                {{ date('h:i a', strtotime($calender->end_tm2)) }})
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                @else
                                                                    <div class="teacher-calendar-days-field3"></div>
                                                                @endif
                                                            </div>
                                                            <div class="date-left-teacher-calendar">
                                                                @if ($calender->day3Avail_txt && $calender->day3asnDate_dte)
                                                                    <div
                                                                        class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                        <p>
                                                                            {{ $calender->day3Avail_txt }}
                                                                            @if ($calender->start_tm3 && $calender->end_tm3)
                                                                                ({{ date('h:i a', strtotime($calender->start_tm3)) }}
                                                                                -
                                                                                {{ date('h:i a', strtotime($calender->end_tm3)) }})
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                @else
                                                                    <div class="teacher-calendar-days-field3"></div>
                                                                @endif
                                                            </div>
                                                            <div class="date-left-teacher-calendar">
                                                                @if ($calender->day4Avail_txt && $calender->day4asnDate_dte)
                                                                    <div
                                                                        class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                        <p>
                                                                            {{ $calender->day4Avail_txt }}
                                                                            @if ($calender->start_tm4 && $calender->end_tm4)
                                                                                ({{ date('h:i a', strtotime($calender->start_tm4)) }}
                                                                                -
                                                                                {{ date('h:i a', strtotime($calender->end_tm4)) }})
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                @else
                                                                    <div class="teacher-calendar-days-field3"></div>
                                                                @endif
                                                            </div>
                                                            <div class="date-left-teacher-calendar">
                                                                @if ($calender->day5Avail_txt && $calender->day5asnDate_dte)
                                                                    <div
                                                                        class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}">
                                                                        <p>
                                                                            {{ $calender->day5Avail_txt }}
                                                                            @if ($calender->start_tm5 && $calender->end_tm5)
                                                                                ({{ date('h:i a', strtotime($calender->start_tm5)) }}
                                                                                -
                                                                                {{ date('h:i a', strtotime($calender->end_tm5)) }})
                                                                            @endif
                                                                        </p>
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

                        <div class="school-finance-right-sec mt-3">
                            <div class="school-finance-section">
                                <div class="finance-timesheet-contact-first-sec sec_box_edit" style="width: 100%">
                                    <div class="contact-heading details-heading">
                                        <div class="contact-heading-text">
                                            <h2>Teacher Timesheets (Submitted by teacher)</h2>
                                        </div>

                                        <div class="contact-icon header_icon">
                                            @if ($canUpTimesheet)
                                                <a style="cursor: pointer" class="disabled-link" id="itemSheetRejectBtn"
                                                    title="Reject timesheet">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link"
                                                    id="itemSheetApproveBtn" title="Approve timesheet">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <input type="hidden" name="" id="logTeacherTimeItemIds" value="">
                                    <table class="table table-bordered table-striped" id="myTable3">
                                        <thead>
                                            <tr class="school-detail-table-heading">
                                                <th>Teacher</th>
                                                <th>Date</th>
                                                <th>Part</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body-sec" id="teacherTimesheetTbody">
                                            @foreach ($teacherList as $key => $teacher)
                                                <?php
                                                $name = '';
                                                if ($teacher->knownAs_txt == null && $teacher->knownAs_txt == '') {
                                                    $name = $teacher->firstName_txt . ' ' . $teacher->surname_txt;
                                                } else {
                                                    $name = $teacher->knownAs_txt . ' ' . $teacher->surname_txt;
                                                }
                                                
                                                $startTime = '';
                                                if ($teacher->t_start_tm) {
                                                    $startTime = date('h:i a', strtotime($teacher->t_start_tm));
                                                }
                                                $endTime = '';
                                                if ($teacher->t_end_tm) {
                                                    $endTime = date('h:i a', strtotime($teacher->t_end_tm));
                                                }
                                                $rejectText = '';
                                                if ($teacher->t_rejected_text) {
                                                    $rejectText = '( ' . $teacher->t_rejected_text . ' )';
                                                }
                                                
                                                if ($teacher->t_admin_approve == 2) {
                                                    $tStatus = 'Rejected' . $rejectText;
                                                } elseif ($teacher->t_send_to_school == 1) {
                                                    $tStatus = 'Sent to School';
                                                } else {
                                                    $tStatus = '--';
                                                }
                                                ?>
                                                <tr class="school-detail-table-data selectLogTeacherRow"
                                                    id="selectLogTeacherRow{{ $teacher->timesheet_item_id }}"
                                                    teacher-id="{{ $teacher->t_teacher_id }}"
                                                    asn-id="{{ $teacher->t_asn_id }}"
                                                    timesheet-item-id="{{ $teacher->timesheet_item_id }}"
                                                    school-id="{{ $teacher->t_school_id }}">
                                                    <td>{{ $name }}</td>
                                                    <td>{{ $teacher->asnDate_dte }}</td>
                                                    <td>{{ $teacher->datePart_txt }}</td>
                                                    <td>{{ $startTime }}</td>
                                                    <td>{{ $endTime }}</td>
                                                    <td>{{ $tStatus }}</td>
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
    </section>

    <!-- Invoice Payment method Modal -->
    <div class="modal fade" id="invoicePaymentMethodModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Invoice</h2>
                    </div>

                    <form action="{{ url('/school/logSchoolInvoicePayMethodEdit') }}" method="post"
                        class="form-validate-2" enctype="multipart/form-data">
                        @csrf

                        <div id="invoicePaymentMethodAjax"></div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Invoice Payment method Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                scrollY: '300px',
                paging: false,
                // footer: false,
                info: false,
                "order": [
                    [1, "desc"]
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
            $('#myTable2').DataTable({
                scrollY: '280px',
                paging: false,
                // footer: false,
                info: false,
                "order": [
                    [6, "desc"]
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });

            $('#myTable3').DataTable({
                scrollY: '300px',
                paging: false,
                // footer: false,
                info: false,
                ordering: false,
                searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });

            $('#myTable4').DataTable({
                scrollY: '395px',
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
                $('#addPaymentMethodBtn').addClass('disabled-link');
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
                $('#addPaymentMethodBtn').removeClass('disabled-link');
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

        $(document).on('click', '#addPaymentMethodBtn', function() {
            var editInvoiceId = $('#editInvoiceId').val();
            if (editInvoiceId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/school/logSchoolInvoicePayMethod') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        editInvoiceId: editInvoiceId
                    },
                    success: function(res) {
                        //console.log(res);
                        $('#invoicePaymentMethodAjax').html(res.html);
                    }
                });
                $('#invoicePaymentMethodModal').modal("show");
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
                                $('#fullLoader').show();
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
                                            $('#fullLoader').hide();
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
                        content: {
                            element: 'textarea',
                            attributes: {
                                placeholder: 'Remark',
                                rows: 3
                            }
                        },
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                var remark = $('.swal-content textarea').val();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('/school/logSchoolTimesheetReject') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnId: asnId,
                                        weekStartDate: "{{ $weekStartDate }}",
                                        weekEndDate: "{{ $plusFiveDate }}",
                                        remark: remark
                                    },
                                    success: function(data) {
                                        $('#fullLoader').hide();
                                        swal("", "Timesheet rejected successfully");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '.selectLogTeacherRow', function() {
            var teacherId = $(this).attr('teacher-id');
            var asnId = $(this).attr('asn-id');
            var timesheetItemId = $(this).attr('timesheet-item-id');
            var schoolId = $(this).attr('school-id');

            if ($('#selectLogTeacherRow' + timesheetItemId).hasClass('tableRowActive')) {
                $('#selectLogTeacherRow' + timesheetItemId).removeClass('tableRowActive');
                setLogTeacherTimeIdsNew(timesheetItemId, 'rm');
            } else {
                $('#selectLogTeacherRow' + timesheetItemId).addClass('tableRowActive');
                setLogTeacherTimeIdsNew(timesheetItemId, 'add');
            }
        });

        function setLogTeacherTimeIdsNew(timesheetItemId, type) {
            var ItemId = parseInt(timesheetItemId);
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#logTeacherTimeItemIds').val();
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
            $('#logTeacherTimeItemIds').val(ids);
            if (ids) {
                $('#itemSheetRejectBtn').removeClass('disabled-link');
                $('#itemSheetApproveBtn').removeClass('disabled-link');
            } else {
                $('#itemSheetRejectBtn').addClass('disabled-link');
                $('#itemSheetApproveBtn').addClass('disabled-link');
            }
        }

        function teacherSubmittedSheet() {
            var school_id = "{{ $school_id }}";
            var max_date = "{{ $plusFiveDate }}";
            if (school_id && max_date) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('school/logSchfetchTeacherSheetById') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        school_id: school_id,
                        max_date: max_date
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#teacherTimesheetTbody').html('');
                        $('#teacherTimesheetTbody').html(data.html);
                        $('#teacherTimesheetDiv').css('display', 'block');
                        $('#logteacherTimeApproveBtn').addClass('disabled-link');
                        $('#logteacherSendSchoolBtn').addClass('disabled-link');
                        $('#logTeacherTimeItemIds').val('');
                    }
                });
            }
        }

        $(document).on('click', '#itemSheetRejectBtn', function() {
            var asnItemIds = $('#logTeacherTimeItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "",
                        text: "Are you sure you wish to reject all the selected timesheet(s)?",
                        content: {
                            element: 'textarea',
                            attributes: {
                                placeholder: 'Remark',
                                rows: 3
                            }
                        },
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $('#fullLoader').show();
                                var remark = $('.swal-content textarea').val();
                                $.ajax({
                                    type: 'POST',
                                    url: "{{ url('school/logSchteacherItemSheetReject') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds,
                                        remark: remark
                                    },
                                    success: function(data) {
                                        teacherSubmittedSheet();
                                        $('#fullLoader').hide();
                                        swal("", "Timesheet rejected successfully");
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one timesheet.");
            }
        });

        $(document).on('click', '#itemSheetApproveBtn', function() {
            var asnItemIds = $('#logTeacherTimeItemIds').val();
            if (asnItemIds) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to approve all the selected timesheet(s)?",
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
                                    url: "{{ url('school/logSchTeacherItemSheetApprove') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        asnItemIds: asnItemIds
                                    },
                                    async: false,
                                    dataType: "json",
                                    success: function(data) {
                                        if (data.add == 'Yes') {
                                            var idsArr = [];
                                            if (asnItemIds) {
                                                idsArr = asnItemIds.split(',');
                                            }
                                            for (var i = 0; i < idsArr.length; i++) {
                                                $('#selectLogTeacherRow' + idsArr[i]).remove();
                                            }
                                            $('#logTeacherTimeItemIds').val('');
                                            $('#logteacherTimeApproveBtn').addClass(
                                                'disabled-link');
                                            $('#logteacherSendSchoolBtn').addClass('disabled-link');
                                            var popTxt =
                                                'You have just logged a timesheet for ' + data
                                                .schoolName +
                                                '. Timesheet ID : ' + data.timesheet_id;
                                            swal("", popTxt);
                                        }
                                        $('#fullLoader').hide();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one item.");
            }
        });
    </script>
@endsection
