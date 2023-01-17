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
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
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
                        <h6></h6>

                        <div class="row">
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Contact Add Modal -->
@endsection
