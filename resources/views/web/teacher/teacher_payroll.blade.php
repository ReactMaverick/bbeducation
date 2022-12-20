@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.teacher.teacher_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.teacher.teacher_header')

                <div class="school-detail-right-sec">
                    <div class="school-details-first-sec">
                        <div class="details-heading">
                            <h2>Payroll</h2>
                            <a data-toggle="modal" data-target="#editPayrollModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </div>

                        <div class="about-school-section">
                            <div class="school-name-section">
                                <div class="teacher-profession-heading-text">
                                    <h2>NI Number</h2>
                                </div>
                                <div class="teacher-profession-name-text">
                                    <p>{{ $teacherDetail->NINumber_txt }}</p>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-profession-heading-text">
                                    <h2>Bank</h2>
                                </div>
                                <div class="teacher-profession-name-text">
                                    <p>{{ $teacherDetail->bank_txt }}</p>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-profession-heading-text">
                                    <h2>Sort Code</h2>
                                </div>
                                <div class="teacher-profession-name-text">
                                    <p>{{ $teacherDetail->sortCode_int }}</p>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-profession-heading-text">
                                    <h2>Account No.</h2>
                                </div>
                                <div class="teacher-profession-name-text">
                                    <p>{{ $teacherDetail->accountNumber_txt }}</p>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-profession-heading-text">
                                    <h2>Base Pay</h2>
                                </div>
                                <div class="teacher-profession-name-text">
                                    <p>{{ $teacherDetail->basePayRate_dec }}</p>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-profession-heading-text">
                                    <h2>RACS Number</h2>
                                </div>
                                <div class="teacher-profession-name-text">
                                    <p>{{ $teacherDetail->RACSnumber_txt }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payroll-bottom-text">
                    <p>Details of payments will be released once the invoicing and payroll elements are complete.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Edit Modal -->
    <div class="modal fade" id="editPayrollModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Bank</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Bank/Payroll</h2>
                </div>

                <form action="{{ url('/teacherPayrollUpdate') }}" method="post" class="">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>
                            @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                            @else
                                {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                            @endif
                        </h6>
                        <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p>
                        <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">NI Number</label>
                                    <input type="text" class="form-control" name="NINumber_txt"
                                        id="" value="{{ $teacherDetail->NINumber_txt }}">
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">Bank</label>
                                    <select class="form-control" name="bank_int" style="width:100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($bankList as $key1 => $bank)
                                            <option value="{{ $bank->description_int }}"
                                                {{ $teacherDetail->bank_int == $bank->description_int ? 'selected' : '' }}>
                                                {{ $bank->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Sort Code (6 digits, no separators)</label>
                                    <input type="text" class="form-control numberField" name="sortCode_int"
                                        id="" value="{{ $teacherDetail->sortCode_int }}" maxlength="6" >
                                </div>
                            </div>
                            <div class="col-md-6 modal-form-right-sec">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Account Number</label>
                                    <input type="text" class="form-control" name="accountNumber_txt" id=""
                                        value="{{ $teacherDetail->accountNumber_txt }}">
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Base Pay Rate</label>
                                    <input type="text" class="form-control numberField" name="basePayRate_dec" id=""
                                        value="{{ $teacherDetail->basePayRate_dec }}">
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">RACS Number</label>
                                    <input type="text" class="form-control" name="RACSnumber_txt" id=""
                                        value="{{ $teacherDetail->RACSnumber_txt }}">
                                </div>
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
    <!-- Detail Edit Modal -->

    <script>
        $(document).ready(function() {
            $('.numberField').keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });
        });
    </script>

@endsection
