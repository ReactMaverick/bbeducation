{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">

                        <div class="school-assignment-sec">
                            <div class="school-assignment-section sec_box_edit">
                                {{-- <div class="contact-history-heading-section">
                                    <h2>Contact History</h2>
                                    <a data-toggle="modal" data-target="#ContactHistoryAddModal" style="cursor: pointer;">
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div> --}}
                                <div class="teacher-list-section details-heading">
                                    <div class="school-teacher-heading-text">
                                        <h2>All User</h2>
                                    </div>
                                    <div class="school-teacher-list-heading">
                                        <div class="school-assignment-contact-icon-sec contact-icon-sec">
                                            {{-- <a style="cursor: pointer" class="disabled-link icon_all"
                                                id="deleteContactHistoryBttn">
                                                <i class="fas fa-trash-alt trash-icon"></i>
                                            </a> --}}
                                            <a data-toggle="modal" data-target="#userAddModal" style="cursor: pointer;"
                                                class="icon_all">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                            <a style="cursor: pointer;" class="disabled-link icon_all" id="passwordReset"
                                                title="Send to school">
                                                <i class="fas fa-paper-plane"></i>
                                            </a>
                                            <a style="cursor: pointer;" class="disabled-link icon_all"
                                                id="editContactHistoryBttn">
                                                <i class="fas fa-edit school-edit-icon"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="assignment-finance-table-section p-5">
                                    <table class="table table-bordered table-striped" id="myTable">
                                        <thead>
                                            <tr class="school-detail-table-heading">
                                                <th style="width: 40%">First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                {{-- <th>Email</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="table-body-sec">
                                            <?php $dueCallCount = 0; ?>
                                            @foreach ($userAdmins as $key => $userAdmin)
                                                <tr class="school-detail-table-data editContactHistoryRow"
                                                    id="editContactHistoryRow{{ $userAdmin->user_id }}"
                                                    onclick="contactHistoryRowSelect({{ $userAdmin->user_id }})"
                                                    data-id={{ $userAdmin->user_id }}>
                                                    <td style="width: 40%">
                                                        {{ $userAdmin->firstName_txt }}</td>
                                                    <td>{{ $userAdmin->surname_txt }}</td>
                                                    <td>{{ $userAdmin->user_name }}</td>
                                                    <td><select class="form-control status"
                                                            onchange="changeStatus({{ $userAdmin->user_id }}, this.value)">
                                                            <option value='1'
                                                                {{ $userAdmin->isActive == 1 ? 'selected' : '' }}>Active
                                                            </option>
                                                            <option value='0'
                                                                {{ $userAdmin->isActive == 0 ? 'selected' : '' }}>In Active
                                                            </option>
                                                        </select></td>
                                                    {{-- <td>{{ $userAdmin->workEmail_txt }}</td> --}}
                                                    {{-- <td>{{ $userAdmin->DOB_dte }}</td> --}}
                                                    {{-- <td><img src="{{$userAdmin->profileImageLocation_txt . '/' . $userAdmin->profileImage }}"></td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" name="adminId" id="adminId" value="">

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- User Add Modal -->
    <div class="modal fade" id="userAddModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add User Admin</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add User Admin</h2>
                    </div>

                    <div class="modal-input-field-section">
                        <div class="col-md-12 col-lg-12 col-xl-12 col-12 col-sm-12">
                            <form action="{{ url('/insertAdminUsers') }}" method="post" class="form-validate"
                                id="adminUserAddForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="modal-input-field form-group">
                                            <label class="form-check-label">First Name</label>
                                            <input type="text" class="form-control field-validate" name="admin_firstName"
                                                id="admin_firstName" value="">
                                        </div>

                                        <div class="modal-input-field form-group">
                                            <label class="form-check-label">Last Name</label>
                                            <input type="text" class="form-control field-validate" name="admin_surName"
                                                id="admin_surName" value="">
                                        </div>

                                        <div class="modal-input-field form-group">
                                            <label class="form-check-label">Email</label>
                                            <input type="text" class="form-control field-validate email-validate"
                                                name="admin_username" id="admin_username" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                            <span class="file_upload"><i class="fas fa-upload"></i>
                                                Choose File to upload
                                            </span>
                                            <input type="file" class="form-control file_up_load field-validate"
                                                name="profileImage" id="admin_image" value="">
                                        </div>
                                        <p style="color: red; font-size: small;">Jpg,Jpeg,png type allowed. Max size 5mb
                                        </p>
                                        <div id="uploadedImage"></div>
                                        {{-- <div class="modal-input-field form-group">
                                            <label class="form-check-label">Password</label>
                                            <input type="password" class="form-control field-validate" name="admin_password"
                                                id="admin_password" value="">
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="modal-footer calendar-modal-footer">
                                    <button type="button" class="btn btn-secondary" id="adminAddBtn">Add</button>
                                    <button type="button" class="btn btn-danger cancel-btn"
                                        id="dismiss-modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- User Add Modal -->

    <!-- User edit Modal -->
    <div class="modal fade" id="userEditModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit User Admin</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit User Admin</h2>
                    </div>

                    <div class="modal-input-field-section">
                        <div class="col-md-12 col-lg-12 col-xl-12 col-12 col-sm-12">
                            <form action="{{ url('/updateAdminUsers') }}" method="post" class="form-validate-2"
                                id="adminUserUpdateForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="adminUserId" id="adminUserId">
                                        <div class="modal-input-field form-group">
                                            <label class="form-check-label">First Name</label>
                                            <input type="text" class="form-control form-validate-2"
                                                name="edit_admin_firstName" id="edit_admin_firstName" value="">
                                        </div>

                                        <div class="modal-input-field form-group">
                                            <label class="form-check-label">Last Name</label>
                                            <input type="text" class="form-control form-validate-2"
                                                name="edit_admin_surName" id="edit_admin_surName" value="">
                                        </div>

                                        <div class="modal-input-field form-group">
                                            <label class="form-check-label">Email</label>
                                            <input type="text" class="form-control form-validate-2 email-validate2"
                                                name="edit_admin_username" id="edit_admin_username" value="">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="modal-input-field form-group">
                                            <label class="form-check-label">Status</label>
                                            <select class="form-control" id="edit-status" name="edit_status">
                                                <option value='1' selected>
                                                    Active
                                                </option>
                                                <option value='0'>In Active
                                                </option>
                                            </select>
                                        </div>

                                        <div class="modal-input-field form-group new_file">
                                            <label class="form-check-label">Profile Image</label>
                                            <span class="file_upload"><i class="fas fa-upload"></i>
                                                Choose File to upload
                                            </span>
                                            <input type="file" class="form-control file_up_load"
                                                name="edit_profileImage" id="edit_admin_image" value="">
                                        </div>
                                        <p style="color: red; font-size: small;">Jpg,Jpeg,png type allowed. Max size 5mb
                                        </p>
                                        <div id="old_user_image"></div>
                                        <img id="edituploadedImage" style="display: none; width: 70px; height: 70px;"
                                            class="img-fluid">
                                        <input type="hidden" name="old_image" id="old_image">
                                        {{-- <div class="modal-input-field form-group">
                                            <label class="form-check-label">Password</label>
                                            <input type="password" class="form-control form-validate-2"
                                                name="edit_admin_password" id="edit_admin_password" value="">
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="modal-footer calendar-modal-footer">
                                    <button type="button" class="btn btn-secondary" id="adminUpdateBtn">Update</button>
                                    <button type="button" class="btn btn-danger cancel-btn"
                                        data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- User edit Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        $("#dismiss-modal").click(function() {
            $('#uploadedImage').empty();
            $("#userAddModal").modal("hide");
        });

        // User add profile image validation
        $('#admin_image').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                var file = input.files[0];
                var fileType = file.type; // Retrieve the file type
                var fileSize = file.size; // Retrieve the file size in bytes

                // Allowed file types (you can adjust this array with the types you want to allow)
                var allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

                // Max file size in bytes (adjust as needed)
                var maxSize = 5 * 1024 * 1024; // 5 MB

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

                        $('#uploadedImage').append(image);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $('#edit_admin_image').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                var file = input.files[0];
                var fileType = file.type; // Retrieve the file type
                var fileSize = file.size; // Retrieve the file size in bytes

                // Allowed file types (you can adjust this array with the types you want to allow)
                var allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

                // Max file size in bytes (adjust as needed)
                var maxSize = 5 * 1024 * 1024; // 5 MB

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
                        $("#old_user_image").empty();

                        var image = $('<img>', {
                            id: 'edituploadedImage',
                            src: e.target.result,
                            style: 'width: 70px; height: 70px; display: block;',
                            class: 'img-fluid'
                        });

                        $('#old_user_image').append(image);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $(document).on('click', '#adminAddBtn', function() {
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
                            $('#adminUserAddForm').submit();
                        }
                    }
                });
            }
            // if (error == "has error") {
            //     return false;
            // } else {
            //     var form = $("#adminUserAddForm");
            //     console.log(form.serialize());
            //     var actionUrl = form.attr('action');
            //     $.ajax({
            //         type: "POST",
            //         url: actionUrl,
            //         data: form.serialize(),

            //         dataType: "json",
            //         success: function(data) {
            //             console.log(data);
            //             // $("#firstName_txt").val('');
            //             // $("#surname_txt").val('');
            //             // $("#studentTbody").html('');
            //             // $("#studentTbody").html(data.html);
            //             // swal("", "Student added successfully.");

            //             if (data.status === 'success') {
            //                 window.location.reload();
            //             }
            //         }
            //     });
            // }
        });

        $(document).on('click', '#adminUpdateBtn', function() {
            var error = "";
            // $(".form-validate-2").each(function() {
            //     if (this.value == '') {
            //         $(this).closest(".form-group").addClass('has-error');
            //         error = "has error";
            //     } else {
            //         $(this).closest(".form-group").removeClass('has-error');
            //     }
            // });
            $(".email-validate2").each(function() {
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
                var loginMailId = $('#edit_admin_username').val();
                var adminUserId = $('#adminUserId').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ url('checkAdminUserMailExist') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        loginMail: loginMailId,
                        adminUserId: adminUserId
                    },
                    async: false,
                    success: function(data) {
                        if (data == 'Yes') {
                            swal(
                                'Failed!',
                                'Email-id already exist.'
                            );
                        } else {
                            $('#adminUserUpdateForm').submit();
                        }
                    }
                });
            }
        });

        function contactHistoryRowSelect(adminUser_id) {
            if ($('#editContactHistoryRow' + adminUser_id).hasClass('tableRowActive')) {
                $('#adminId').val('');
                $('#editContactHistoryRow' + adminUser_id).removeClass('tableRowActive');
                $('#deleteContactHistoryBttn').addClass('disabled-link');
                $('#editContactHistoryBttn').addClass('disabled-link');
                $('#passwordReset').addClass('disabled-link');
            } else {
                $('#adminId').val(adminUser_id);
                $('.editContactHistoryRow').removeClass('tableRowActive');
                $('#editContactHistoryRow' + adminUser_id).addClass('tableRowActive');
                $('#deleteContactHistoryBttn').removeClass('disabled-link');
                $('#editContactHistoryBttn').removeClass('disabled-link');
                $('#passwordReset').removeClass('disabled-link');
            }
        }

        function changeStatus(id, value) {
            var loginUserId = {{ Session::get('webUserLoginData')->user_id }};
            if (id == loginUserId) {
                swal({
                    title: "Alert",
                    text: "You can't change this status !",
                    icon: "warning",
                    buttons: {
                        cancel: "Discard"
                    },
                })
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else if (id && value) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/adminuser/changeStatus') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        adminId: id,
                        statusValue: value
                    },
                    success: function(data) {
                        if (data == true) {
                            location.reload();
                        } else {
                            swal({
                                title: "Alert",
                                text: "Something went wrong !",
                                icon: "warning",
                                buttons: {
                                    cancel: "Discard"
                                },
                            })
                        }
                    }
                });
            }
        }

        $(document).on('click', '#editContactHistoryBttn', function() {
            var adminId = $('#adminId').val();
            if (adminId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/getAdminUser') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        adminId: adminId
                    },
                    success: function(data) {
                        console.log(data);
                        $("#adminUserId").val(data.userAdmin.user_id);
                        $("#edit_admin_firstName").val(data.userAdmin.firstName_txt);
                        $("#edit_admin_surName").val(data.userAdmin.surname_txt);
                        $("#edit_admin_username").val(data.userAdmin.user_name);
                        // $("#edit_admin_password").val(data.userAdmin.password_txt);
                        $("#old_image").val(data.userAdmin.profileImage);
                        $("#edit-status").val(data.userAdmin.isActive);
                        $("#old_user_image").empty();
                        if (data.image != '') {
                            var html =
                                `<img style="width: 70px; height: 70px;" class="img-fluid" src="${data.image}">`;
                            $("#old_user_image").append(html);
                        }
                    }
                });
                $('#userEditModal').modal("show");
            } else {
                swal("", "Please select one contact.");
            }
        });

        $(document).on('click', '#passwordReset', function() {
            var adminId = $('#adminId').val();
            if (adminId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/adminUserPasswordreset') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        adminId: adminId
                    },
                    success: function(data) {
                        swal({
                            title: "Alert",
                            text: "Mail sent successfully !",
                            icon: "success",
                            buttons: {
                                cancel: "Discard"
                            },
                        })
                    }
                });
            } else {
                swal("", "Please select one contact.");
            }
        });

        // $(document).on('click', '#deleteContactHistoryBttn', function() {
        //     var adminId = $('#adminId').val();
        //     var loginUserId = {{ Session::get('webUserLoginData')->user_id }};

        //     if (adminId == loginUserId) {
        //         swal({
        //             title: "Alert",
        //             text: "You can't delete this user !",
        //             icon: "warning",
        //             buttons: {
        //                 cancel: "Discard"
        //             },
        //         })
        //     } else if (adminId) {
        //         swal({
        //                 title: "Alert",
        //                 text: "Are you sure you wish to remove this user ?",
        //                 buttons: {
        //                     cancel: "No",
        //                     Yes: "Yes"
        //                 },
        //             })
        //             .then((value) => {
        //                 switch (value) {
        //                     case "Yes":
        //                         $.ajax({
        //                             type: 'POST',
        //                             url: '{{ url('/deleteAdminUsers') }}',
        //                             data: {
        //                                 "_token": "{{ csrf_token() }}",
        //                                 adminId: adminId
        //                             },
        //                             success: function(data) {
        //                                 location.reload();
        //                             }
        //                         });
        //                 }
        //             });
        //     } else {
        //         swal("", "Please select one user.");
        //     }
        // });
    </script>
@endsection
