@extends('web.layout')
@section('content')
<div class="assignment-detail-page-section">
    <div class="row assignment-detail-row">

        <div class="col-md-12 topbar-sec">

            <div class="finance-topbar-Section">
                <div class="finance-topbar">
                    <div class="topbar-finance-list-page topbar-active">
                        <a href="#">
                            <i class="fa-solid fa-address-book">
                                <span class="finance-topbar-text">Timesheets</span>
                            </i>
                        </a>
                    </div>

                    <div class="topbar-finance-list-page">

                        <a href="#">
                            <i class="fa-solid fa-money-bills">
                                <span class="finance-topbar-text">Invoices</span>
                            </i>
                        </a>
                    </div>

                    <div class="topbar-finance-list-page">
                        <a href="#">
                            <i class="fa-solid fa-user">
                                <span class="finance-topbar-text">Payroll</span>
                            </i>
                        </a>

                    </div>

                    <div class="topbar-finance-list-page">
                        <a href="#">
                            <i class="fa-solid fa-piggy-bank">
                                <span class="finance-topbar-text">Remittance</span>
                            </i>
                        </a>
                    </div>
                </div>

                <div class="bills-icon-section">
                    <a href="#">
                        <i class="fa-solid fa-money-bills bills-icon"></i>
                    </a>
                </div>

            </div>

            <div class="finance-timesheet-top-total-section">
                <div class="finance-timesheet-total-section">
                    <div class="timesheet-top-section">
                        <div class="form-group timesheet-top-input-sec">
                            <label for="staticEmail" class="col-form-label">Timesheet-Until</label>
                            <input type="date" id="staticEmail" placeholder="25-11-2022" value="">
                        </div>

                        <div class="timesheet-process-btn">
                            <button>S:\Timesheet To Process</button>
                        </div>
                    </div>
                    <div class="finance-timesheet-section">
                        <div class="finance-timesheet-left-sec">

                            <div class="finance-timesheet-contact-first-sec">
                                <div class="contact-heading">
                                    <div class="contact-heading-text">
                                        <h2>Select a file</h2>
                                    </div>
                                    <div class="contact-icon-sec">
                                        <a data-toggle="modal" data-target="#ContactItemAddModal"
                                            style="cursor: pointer;">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                        </a>
                                        <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                            <i class="fa-solid fa-folder-open"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="finance-list-section">

                                    <div class="finance-list-text-section">
                                        <div class="finance-list-text">
                                            <ul>
                                                <li class="timesheet-list-active">New Text Document.txt</li>
                                            </ul>

                                            <ul>
                                                <li>New Text Document.txt</li>
                                            </ul>

                                            <ul>
                                                <li>New Text Document.txt</li>
                                            </ul>

                                            <ul>
                                                <li>New Text Document.txt</li>
                                            </ul>

                                            <ul>
                                                <li>New Text Document.txt</li>
                                            </ul>

                                            <ul>
                                                <li>New Text Document.txt</li>
                                            </ul>

                                            <ul>
                                                <li>New Text Document.txt</li>
                                            </ul>

                                            <ul>
                                                <li>New Text Document.txt</li>
                                            </ul>

                                            <ul>
                                                <li>New Text Document.txt</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="finance-timesheet-contact-second-sec">
                                <div class="finance-timesheet-table-section">
                                    <table class="table finance-timesheet-page-table" id="myTable">
                                        <thead>
                                            <tr class="school-detail-table-heading">
                                                <th>School</th>
                                                <th>Days</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body-sec">
                                            <tr class="school-detail-table-data editContactRow">
                                                <td>Acland Burghley School</td>
                                                <td>432</td>
                                            </tr>
                                            <tr class="school-detail-table-data editContactRow">
                                                <td>Acland Burghley School</td>
                                                <td>432</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="table-bottom-text">
                                        <span>Double-click to open the school</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="finance-timesheet-second-table-section">
                            <table class="table finance-timesheet-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>School</th>
                                        <th>Days</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>Acland Burghley School</td>
                                        <td>432</td>
                                    </tr>
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>Acland Burghley School</td>
                                        <td>432</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="table-assignment-bottom-text-sec">
                                <div class="table-bottom-text">
                                    <span>Double-click to open the assignment</span>
                                </div>


                                <div class="finance-contact-icon-sec">
                                    <a style="cursor: pointer" class="disabled-link" id="deleteContactBttn">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                    <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="finance-timesheet-right-sec">
                    <div class="finance-timesheet-right-inner-section">
                    <iframe src="https://www.wikipedia.org/" title="W3Schools Free Online Web Tutorials"></iframe>
                    </div>
                </div>
            </div>






        </div>
    </div>
</div>
@endsection