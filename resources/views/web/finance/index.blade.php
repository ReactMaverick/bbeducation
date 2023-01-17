@extends('web.layout')
@section('content')
<!-- <div class="tab-content finance-tab-content" id="myTabContent"> -->
<div class="assignment-section-col">

    <div class="teacher-all-section">
        <div class="finance-section">
            <div class="teacher-page-sec">
                <h2>Finance</h2>
            </div>
            <div class="teacher-left-sec">
                <div class="about-finance">
                    <a href="{{ URL::to('/finance-timesheets') }}"> <i class="fa-solid fa-file-lines"></i>
                        <p>Timesheets</p>
                    </a>
                </div>

                <div class="about-finance">
                    <a href="{{ URL::to('/finance-invoices') }}"> <i class="fa-solid fa-money-bills"></i>
                        <p>Invoicing</p>
                    </a>
                </div>

                <div class="about-finance">
                    <a href="{{ URL::to('/finance-payroll') }}"> <i class="fa-solid fa-piggy-bank"></i>
                        <p>Payroll</p>
                    </a>
                </div>

                <div class="about-finance">
                    <a href="{{ URL::to('/finance-remittance') }}"> <i class="fa-regular fa-file-lines"></i>
                        <p>Remit Invoice</p>
                    </a>
                </div>

                <div class="about-finance">
                    <a href="#" data-toggle="modal" data-target="#ContactHistoryAddModal">
                        <i class="fa-solid fa-envelope"></i>
                        <p>Export</p>
                        <p>Invoices</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- </div> -->

<!-- Contact Add Modal -->
<div class="modal fade" id="ContactHistoryAddModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section cand-vetting-modal-section">
        <div class="modal-content calendar-modal-content">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Log School Contact</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="calendar-heading-sec">
                <i class="fa-solid fa-pencil school-edit-icon"></i>
                <h2>Log School Contact</h2>
            </div>

            <form action="" method="post" class="form-validate">
                @csrf
                <div class="modal-input-field-section">
                    <div class="row cand-vetting-modal-left">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group cand-vetting-modal-input-field">
                                        <label for="email">FAO</label>
                                        <input type="email" class="form-control" placeholder="Head Teacher" id="email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-icon-sec">
                                        <a href="#"><i class="fa-solid fa-school-flag"></i></a>
                                        <a href="#"><i class="fa-solid fa-person"></i></a>
                                        <a href="#"><i class="fa-solid fa-file-signature"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group cand-vetting-modal-input-field">
                                        <label for="email">FAO Email</label>
                                        <select class="form-control" id="sel1">
                                            <option>Saleem@bbe-edu.co.uk</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Candidate</p>
                                        <span>Chavi Mathur</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        afafaf
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Date of Birth</p>
                                        <span>03-11-1984</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Identity</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Date Checked</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Original ID Seen</p>
                                        <span>Seen and Verified</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>23-02-2016</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Proof of Address</p>
                                        <span>Seen and Verified</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>23-02-2016</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Qualification</p>
                                        <span>MA - Teaching Assistant</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-field">

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Reference History</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Date Checked</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Reference Recieved</p>
                                        <span>2</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>23-02-2016</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Employment History</p>
                                        <span>Seen and Verified</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>23-02-2016</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Health Decleration</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Date Checked</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Health Decleration</p>
                                        <span>Signed and Recieved</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>26-08-2015</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Occupational Health</p>
                                        <span>No Assessment Necessary</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Health Issues</p>
                                        <span>No Assessment Needed</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Child Protection</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Date Checked</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>DBS Enhanced Disclosure Number</p>
                                        <span>001500379885</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>26-07-2016</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>DBS Enhanced Disclosure Date</p>
                                        <span>25-08-2015</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <!-- <span>26-07-2016</span> -->
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Candidate on Update Service</p>
                                        <span>Yes</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>02-09-2016</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>List 99 Check Result</p>
                                        <span>Clear</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>26-07-2016</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Disqualification by Association Act</p>
                                        <span>Completed & Clear</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>26-07-2016</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Mandatory Induction info Safeguarding</p>
                                        <span>Completed</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>26-07-2016</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>NCTL Check</p>
                                        <span>Clear</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-input-field">
                                        <span>11-01-2023</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>s128 Management Check</p>
                                    </div>
                                    <div class="cand-vetting-modal-field">
                                        <!-- <span>Clear</span> -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-field">
                                        <!-- <span>Clear</span> -->
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-input-field">
                                        <p>EEA Restriction Check</p>
                                    </div>
                                    <div class="cand-vetting-modal-field">
                                        <!-- <span>Clear</span> -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-field">
                                        <!-- <span>Clear</span> -->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Other</p>
                                    </div>
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Right To Work</p>
                                        <span>Valid Work Permit</span>
                                    </div>
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Face to Face Interview Date</p>
                                        <span>26-08-2015</span>
                                    </div>
                                    <div class="cand-vetting-modal-input-field">
                                        <p>NI Number</p>
                                        <span>SR 35 16 67 D</span>
                                    </div>
                                    <div class="cand-vetting-modal-input-field">
                                        <p>Teacher Reference Number</p>
                                    </div>
                                    <div class="cand-vetting-modal-field">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cand-vetting-modal-heading-sec">
                                        <p>Likeness of Candidate</p>
                                    </div>

                                    <div class="cand-vetting-modal-user-img">
                                        <img src="http://localhost/git/bbeducation/public/web/company_logo/man.png" alt="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer calendar-modal-footer cand-vetting-modal-btn">
                    <button type="submit" class="btn btn-secondary">Update</button>

                    <button type="submit" class="btn btn-warning cand-vetting-approve-disable-btn">Approve and Send</button>
                    
                    <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Contact Add Modal -->
@endsection