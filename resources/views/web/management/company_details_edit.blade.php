{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
@section('content')
    <div class="tab-content dashboard-tab-content" id="myTabContent">
        <div class="assignment-section-col">
            <div class="teacher-all-section pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-xl m-auto">
                                <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section mx_w_100">
                                    <div class="modal-content calendar-modal-content">
                                        <div class="modal-body">
                                            <div class="modal-input-field-section p-0">
                                                <div class="col-md-12 col-lg-12 col-xl-12 col-12 col-sm-12">
                                                    <div class="modal-input-field-section nwp">
                                                        <h6>{{ $company->company_name }}</h6>
                                                    </div>
                                                    <form action="{{ url('/updateCompanyDetails') }}" method="post"
                                                        class="form-validate" id="adminUserAddForm"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <!-- <div class="modal-input-field form-group">
                                        <label class="form-check-label">Company Name</label>
                                        <input type="text" class="form-control field-validate" name="company_name" id="company_name" value="{{ $company->company_name }}" readonly>
                                    </div> -->
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Contact Number</label>
                                                                    <input type="text" class="form-control"
                                                                        name="company_phone" id="company_phone"
                                                                        value="{{ $company->company_phone }}">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Vat Registration</label>
                                                                    <input type="text" class="form-control"
                                                                        name="vat_registration" id="vat_registration"
                                                                        value="{{ $company->vat_registration }}">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Address</label>
                                                                    <input type="text" class="form-control"
                                                                        name="address1_txt" id="address1_txt"
                                                                        value="{{ $company->address1_txt }}">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="address2_txt" id="address2_txt"
                                                                        value="{{ $company->address2_txt }}">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="address3_txt" id="address3_txt"
                                                                        value="{{ $company->address3_txt }}">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="address4_txt" id="address4_txt"
                                                                        value="{{ $company->address4_txt }}">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Postcode</label>
                                                                    <input type="text" class="form-control"
                                                                        name="postcode_txt" id="postcode_txt"
                                                                        value="{{ $company->postcode_txt }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">


                                                                {{-- <div class="modal-input-field form-group">
                                                                <label class="form-check-label">Valid From</label>
                                                                <input type="date" class="form-control" name="valid_from" id="valid_from" value="{{ $company->valid_from }}">
                                                            </div>
                                                            <div class="modal-input-field form-group">
                                                                <label class="form-check-label">Valid To</label>
                                                                <input type="date" class="form-control" name="valid_to" id="valid_to" value="{{ $company->valid_to }}">
                                                            </div> --}}
                                                                <div class="modal-input-field form-group new_file">
                                                                    <label class="form-check-label">Image</label>
                                                                    <span class="file_upload"><i class="fas fa-upload"></i>
                                                                        Choose File to upload
                                                                    </span>
                                                                    <input type="file" class="form-control file_up_load"
                                                                        name="company_logo" id="company_logo"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group modal_logo">
                                                                    <img class="img-fluid"
                                                                        src="{{ asset($company->company_logo) }}">
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="modal-footer calendar-modal-footer">
                                                            <button type="submit" class="btn btn-secondary"
                                                                id="adminAddBtn">Update</button>
                                                            <button type="button" class="btn btn-danger cancel-btn"
                                                                data-dismiss="modal"
                                                                onclick="window.location.href='{{ url()->previous() }}'">Back</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
