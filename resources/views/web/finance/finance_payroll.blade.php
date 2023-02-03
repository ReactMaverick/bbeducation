@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">
            <div class="col-md-12 topbar-sec">

                @include('web.finance.finance_header')

                <div class="finance-invoice-right-sec">

                    <div class="finance-payroll-contact-first-sec">
                        <div class="invoice-top-section">
                            <div class="finance-payroll-top-sec">
                                <div class="finance-payroll-top-btn-sec">
                                    <button>Select None</button>
                                </div>

                                <div class="finance-payroll-top-btn-sec">
                                    <button>Select All</button>
                                </div>
                            </div>

                            <div class="invoice-edit-icon">
                                <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            </div>
                        </div>
                        <div class="finance-invoice-table-section">
                            <table class="table finance-timesheet-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Teacher</th>
                                        <th>School</th>
                                        <th>Date</th>
                                        <th>Part</th>
                                        <th>Pay</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>Acland Burghley School</td>
                                        <td>Vivian Amoako</td>
                                        <td>19-09-2022</td>
                                        <td>117</td>
                                        <td>74.52</td>
                                    </tr>
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>Acland Burghley School</td>
                                        <td>Vivian Amoako</td>
                                        <td>19-09-2022</td>
                                        <td>117</td>
                                        <td>74.52</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="invoice-process-btn">
                            <button>Process Selected</button>
                        </div>
                    </div>

                    <div class="finance-payroll-contact-first-sec">
                        <div class="invoice-top-section">
                            <div class="finance-payroll-top-second-sec">
                                <div class="finance-payroll-pay-date-sec">
                                    <span>Pay Date</span>
                                </div>

                                <div class="finance-payroll-top-btn-sec">
                                    <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;">
                                        <i class="fa-solid fa-caret-left"></i>
                                    </a><span>02-12-2022</span><a data-toggle="modal" data-target="#DetailModal"
                                        style="cursor: pointer;">
                                        <i class="fa-solid fa-caret-right"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="finance-payroll-icon">
                                <a href="#">
                                    <i class="fa-solid fa-piggy-bank">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <div class="finance-payroll-table-section">
                            <table class="table finance-payroll-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Teacher</th>
                                        <th>Item</th>
                                        <th>Gross Pay</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>Acland Burghley School</td>
                                        <td>Vivian Amoako</td>
                                        <td>19-09-2022</td>
                                    </tr>
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>Acland Burghley School</td>
                                        <td>Vivian Amoako</td>
                                        <td>19-09-2022</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table finance-payroll-page-second-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Pay Date</th>
                                        <th>Teacher</th>
                                        <th>Gross Pay</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>Acland Burghley School</td>
                                        <td>Vivian Amoako</td>
                                        <td>19-09-2022</td>
                                    </tr>
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>Acland Burghley School</td>
                                        <td>Vivian Amoako</td>
                                        <td>19-09-2022</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
