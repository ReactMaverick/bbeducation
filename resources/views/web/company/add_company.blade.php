{{-- @extends('web.layout') --}}
@extends('web.superAdmin.layout')
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
                                                        <h6>Add New Company</h6>
                                                    </div>
                                                    <form action="{{ url('/storeCompany') }}" method="post"
                                                        class="form-validate" id="companyUpdateForm"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-input-field form-group">
                                                            <label class="form-check-label">Company Name</label>
                                                            <input type="text" class="form-control field-validate"
                                                                name="company_name" id="company_name" value="">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Contact Number</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="company_phone" id="company_phone"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Vat Registration</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="vat_registration" id="vat_registration"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Finance Query
                                                                        Email</label>
                                                                    <input type="text"
                                                                        class="form-control email-validate field-validate"
                                                                        name="finance_query_mail" id="finance_query_mail"
                                                                        value="">
                                                                </div>

                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Website</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate" name="website"
                                                                        id="website" value="">
                                                                </div>

                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Compliance Mail</label>
                                                                    <input type="text"
                                                                        class="form-control email-validate field-validate"
                                                                        name="compliance_mail" id="compliance_mail"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Address</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="address1_txt" id="address1_txt"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="address2_txt" id="address2_txt"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="address3_txt" id="address3_txt"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="address4_txt" id="address4_txt"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Postcode</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="postcode_txt" id="postcode_txt"
                                                                        value="">
                                                                </div>
                                                                <p><Strong>Payee Details :</Strong></p>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Account Name</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="account_name" id="account_name"
                                                                        value="">
                                                                </div>

                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Account Number</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="account_number" id="account_number"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Sort Code</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="sort_code" id="sort_code" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">

                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Terms &
                                                                        Condition</label>
                                                                    <textarea class="form-control field-validate" name="terms_and_condition" id="terms_and_condition"></textarea>
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Payment Terms</label>
                                                                    <textarea class="form-control field-validate" name="payment_terms" id="payment_terms"></textarea>
                                                                </div>


                                                                {{-- <div class="modal-input-field form-group">
                                                                <label class="form-check-label">Valid From</label>
                                                                <input type="date" class="form-control" name="valid_from" id="valid_from" value="{{ $company->valid_from }}">
                                                            </div>
                                                            <div class="modal-input-field form-group">
                                                                <label class="form-check-label">Valid To</label>
                                                                <input type="date" class="form-control" name="valid_to" id="valid_to" value="{{ $company->valid_to }}">
                                                            </div> --}}
                                                                <div class="modal-input-field form-group new_file">
                                                                    <label class="form-check-label">Company Logo</label>
                                                                    <span class="file_upload"><i
                                                                            class="fas fa-upload"></i>
                                                                        Choose File to upload
                                                                    </span>
                                                                    <input type="file"
                                                                        class="form-control file_up_load field-validate"
                                                                        name="company_logo" id="company-logo"
                                                                        value="">
                                                                </div>
                                                                <p style="color: red; font-size: small;">Jpg,Jpeg,png type
                                                                    allowed. Max size 1mb
                                                                </p>

                                                                <div id="uploadedImage"></div>
                                                                <div class="modal-input-field form-group new_file">
                                                                    <label class="form-check-label">Invoice Footer
                                                                        Logo</label>
                                                                    <span class="file_upload"><i
                                                                            class="fas fa-upload"></i>
                                                                        Choose Files to upload
                                                                    </span>
                                                                    <input type="file"
                                                                        class="form-control file_up_load field-validate"
                                                                        name="invoice_logo[]" id="invoice-logo"
                                                                        value="" multiple>
                                                                </div>
                                                                <p style="color: red; font-size: small;">Jpg,Jpeg,png type
                                                                    allowed. Max size 1mb
                                                                </p>
                                                                <div class="modal-input-field form-group modal_logo">

                                                                </div>
                                                                <div id="uploadedlogo"
                                                                    style="display: flex; flex-wrap: wrap;"></div>
                                                                    <p><Strong>Add user for this company :</Strong></p>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">First Name</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="admin_firstName" id="admin_firstName"
                                                                        value="">
                                                                </div>

                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Last Name</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate"
                                                                        name="admin_surName" id="admin_surName"
                                                                        value="">
                                                                </div>

                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Email</label>
                                                                    <input type="text"
                                                                        class="form-control field-validate email-validate"
                                                                        name="admin_username" id="admin_username"
                                                                        value="">
                                                                </div>
                                                                <div class="modal-input-field form-group">
                                                                    <label class="form-check-label">Status</label>
                                                                    <select class="form-control" name="status">
                                                                        <option value='1' selected>
                                                                            Active
                                                                        </option>
                                                                        <option value='0'>In Active
                                                                        </option>
                                                                    </select>
                                                                </div>

                                                                <div class="modal-input-field form-group new_file">
                                                                    <label class="form-check-label">Profile Image</label>
                                                                    <span class="file_upload"><i
                                                                            class="fas fa-upload"></i>
                                                                        Choose File to upload
                                                                    </span>
                                                                    <input type="file"
                                                                        class="form-control file_up_load field-validate"
                                                                        name="profileImage" id="admin_image"
                                                                        value="">
                                                                </div>
                                                                <p style="color: red; font-size: small;">Jpg,Jpeg,png type
                                                                    allowed. Max size 1mb
                                                                </p>
                                                                <div id="uploadedImageuser"></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer calendar-modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                id="companyUpdateBtn">Add</button>
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
    <script>
        $('#company-logo').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                var file = input.files[0];
                var fileType = file.type; // Retrieve the file type
                var fileSize = file.size; // Retrieve the file size in bytes

                // Allowed file types (you can adjust this array with the types you want to allow)
                var allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

                // Max file size in bytes (adjust as needed)
                var maxSize = 1 * 1024 * 1024; // 5 MB

                if (!allowedTypes.includes(fileType)) {
                    swal({
                        title: "Alert",
                        text: "File Type not matched!",
                        icon: "warning",
                        buttons: {
                            cancel: "Discard"
                        },
                    });
                } else if (!(fileSize <= maxSize)) {
                    swal({
                        title: "Alert",
                        text: "File size not matched!",
                        icon: "warning",
                        buttons: {
                            cancel: "Discard"
                        },
                    });
                } else {
                    var reader = new FileReader();
                    reader.onload = function(e) {

                        var image = $('<img>', {
                            // id: 'edituploadedImage',
                            src: e.target.result,
                            style: 'width: 70px; height: 70px; display: block;',
                            class: 'img-fluid'
                        });
                        if ($('#oldImage').length > 0) {
                            $('#oldImage').attr('src', e.target.result);
                        } else {
                            $('#uploadedImage').append(image);
                        }

                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $(document).on('click', '#companyUpdateBtn', function() {
            var error = "";
            $(".field-validate").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".email-validate").each(function() {
                var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                if (this.value != '' && validEmail.test(this.value)) {
                    $(this).closest(".form-group").removeClass('has-error');

                } else {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                }
            });
            if (error == "has error") {
                return false;
            } else {
                var loginMailId = $('#admin_username').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ url('checkAdminUserMailExist') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        loginMail: loginMailId
                    },
                    async: false,
                    success: function(data) {
                        if (data == 'Yes') {
                            swal(
                                'Failed!',
                                'Email-id already exist.'
                            );
                        } else {
                            $('#companyUpdateForm').submit();
                        }
                    }
                });
                
            }
        });

        $('#invoice-logo').change(function() {
            var input = this;

            if (input.files && input.files.length > 0) {
                var files = input.files;

                // Iterate through each selected file
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var fileType = file.type; // Retrieve the file type
                    var fileSize = file.size; // Retrieve the file size in bytes

                    // Allowed file types (you can adjust this array with the types you want to allow)
                    var allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

                    // Max file size in bytes (adjust as needed)
                    var maxSize = 1 * 1024 * 1024; // 1 MB

                    if (!allowedTypes.includes(fileType)) {
                        showWarningAlert("File Type not matched!");
                    } else if (!(fileSize <= maxSize)) {
                        showWarningAlert("File size exceeds the limit!");
                    } else {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var imageSrc = e.target.result;
                            displayImage(imageSrc);
                        };

                        reader.readAsDataURL(file);
                    }
                }
            }
        });

        $('#admin_image').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                var file = input.files[0];
                var fileType = file.type; // Retrieve the file type
                var fileSize = file.size; // Retrieve the file size in bytes

                // Allowed file types (you can adjust this array with the types you want to allow)
                var allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

                // Max file size in bytes (adjust as needed)
                var maxSize = 1 * 1024 * 1024; // 5 MB

                if (!allowedTypes.includes(fileType)) {
                    swal({
                        title: "Alert",
                        text: "File Type not matched!",
                        icon: "warning",
                        buttons: {
                            cancel: "Discard"
                        },
                    });
                } else if (!(fileSize <= maxSize)) {
                    swal({
                        title: "Alert",
                        text: "File size not matched!",
                        icon: "warning",
                        buttons: {
                            cancel: "Discard"
                        },
                    });
                } else {
                    var reader = new FileReader();
                    reader.onload = function(e) {

                        var image = $('<img>', {
                            // id: 'edituploadedImage',
                            src: e.target.result,
                            style: 'width: 70px; height: 70px; display: block;',
                            class: 'img-fluid'
                        });

                        $('#uploadedImageuser').append(image);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        function showWarningAlert(message) {
            swal({
                title: "Alert",
                text: message,
                icon: "warning",
                buttons: {
                    cancel: "Discard"
                },
            });
        }

        function displayImage(imageSrc) {
            var image = $('<img>', {
                src: imageSrc,
                style: 'width: 70px; height: 70px; display: block;',
                class: 'img-fluid'
            });
            $('#uploadedlogo').append(image);
            // if ($('#oldImage').length > 0) {
            //     // $('#oldImage').attr('src', imageSrc);
            // } else {

            // }
        }

        function imagedelete(id) {
            var imageId = id;
            if (imageId) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to remove this image ?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('/deletecCompanyImage') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        imageId: imageId
                                    },
                                    success: function(data) {
                                        // console.log(data);
                                        if (data === true) {
                                            location.reload();
                                        }
                                    }
                                });
                        }
                    });

            }
        }
    </script>
@endsection
