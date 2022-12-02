@extends('web.layout')
@section('content')

<div class="assignment-detail-page-section">
    <div class="row assignment-detail-row">
        <div class="col-md-12 topbar-sec">

            <div class="finance-topbar-Section">
                <div class="topbar-finance-list-page">
                    <a href="#">
                        <i class="fa-solid fa-address-book topbar-active">
                            <span class="finance-topbar-text">Timesheets</span>
                        </i>
                    </a>
                    <a href="#">
                        <i class="fa-solid fa-money-bills">
                            <span class="finance-topbar-text">Invoices</span>
                        </i>
                    </a>
                    <a href="#">
                        <i class="fa-solid fa-user">
                            <span class="finance-topbar-text">Payroll</span>
                        </i>
                    </a>
                    <a href="#">
                        <i class="fa-solid fa-piggy-bank">
                            <span class="finance-topbar-text">Remittance</span>
                        </i>
                    </a>
                </div>

                <div class="bills-icon-section">
                    <a href="#">
                        <i class="fa-solid fa-money-bills bills-icon"></i>
                    </a>
                </div>

            </div>
            <div class="finance-invoice-right-sec">

                <div class="finance-invoice-contact-first-sec">
                    <div class="invoice-top-section">
                        <div class="form-group invoice-top-input-sec">
                            <label for="staticEmail" class="col-form-label">Timesheet-Until:</label>
                            <input type="date" id="staticEmail" placeholder="25-11-2022" value="">
                        </div>
                        <div class="invoice-top-btn-sec">
                            <button>Select None</button>
                        </div>

                        <div class="invoice-top-btn-sec">
                            <button>Select All</button>
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
                                    <th>School</th>
                                    <th>Teacher</th>
                                    <th>Date</th>
                                    <th>Charge</th>
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


                <div class="finance-invoice-contact-second-sec">

                    <div class="invoice-top-second-section">
                        <div class="form-group invoice-top-first-input-sec">
                            <label for="staticEmail" class="col-form-label">Invoice From</label>
                            <input type="date" id="staticEmail" placeholder="25-11-2022" value="">
                        </div>
                        <div class="form-group invoice-top-second-input-sec">
                            <label for="staticEmail" class="col-form-label">to</label>
                            <input type="date" id="staticEmail" placeholder="25-11-2022" value="">
                        </div>
                        <div class="finance-invoice-icon-sec">
                            <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-arrows-rotate"></i>
                            </a>
                        </div>
                        <div class="invoice-checkbox-top-section">
                            <div class="invoice-checkbox-sec">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            </div>
                            <div class="invoice-checkbox-sec">
                                <label for="vehicle1">Show Sent</label>
                            </div>
                        </div>

                        <div class="finance-invoice-icon-sec">
                            <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-file-lines"></i>
                            </a>
                        </div>

                        <div class="finance-invoice-icon-sec">
                            <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                            </a>
                        </div>

                        <div class="finance-invoice-icon-sec">
                            <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                        </div>

                        <div class="finance-invoice-icon-sec">
                            <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-envelope"></i>
                                <div class="finance-invoice-second-icon-sec">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </a>
                        </div>

                        <div class="finance-invoice-icon-sec">
                            <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        </div>
                        <div class="invoice-second-edit-icon">
                            <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                        </div>
                    </div>
                    <div class="finance-invoice-table-section">
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
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data editContactRow">
                                    <td>Acland Burghley School</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                </tr>
                                <tr class="school-detail-table-data editContactRow">
                                    <td>Acland Burghley School</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
                                    <td>432</td>
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