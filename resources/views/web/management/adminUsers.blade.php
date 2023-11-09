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
                                        <a style="cursor: pointer" class="disabled-link icon_all" id="deleteContactHistoryBttn">
                                            <i class="fas fa-trash-alt trash-icon"></i>
                                        </a>
                                        <a data-toggle="modal" data-target="#userAddModal" style="cursor: pointer;" class="icon_all">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                        <a style="cursor: pointer;" class="disabled-link icon_all" id="editContactHistoryBttn">
                                            <i class="fas fa-edit school-edit-icon"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="assignment-finance-table-section">
                                <table class="table table-bordered table-striped" id="myTable">
                                    <thead>
                                        <tr class="school-detail-table-heading">
                                            <th style="width: 40%">Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>DOB</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body-sec">
                                        <?php $dueCallCount = 0; ?>
                                        @foreach ($userAdmins as $key => $userAdmin)
                                        <tr class="school-detail-table-data editContactHistoryRow" id="editContactHistoryRow{{ $userAdmin->user_id }}" onclick="contactHistoryRowSelect({{ $userAdmin->user_id }})">
                                            <td style="width: 40%">{{ $userAdmin->firstName_txt ." " . $userAdmin->	surname_txt  }}</td>
                                            <td>{{ $userAdmin->	user_name }}</td>
                                            <td>{{ $userAdmin->	workEmail_txt }}</td>
                                            <td>{{ $userAdmin->	DOB_dte }}</td>
                                            <!-- <td><img src="{{ $userAdmin->	profileImageLocation_txt .'/'.$userAdmin->	profileImage  }}"></td> -->
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
                        <form action="{{ url('/insertAdminUsers') }}" method="post" class="form-validate" id="adminUserAddForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">First Name</label>
                                        <input type="text" class="form-control field-validate" name="admin_firstName" id="admin_firstName" value="">
                                    </div>

                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Surname</label>
                                        <input type="text" class="form-control field-validate" name="admin_surName" id="admin_surName" value="">
                                    </div>
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">DOB</label>
                                        <input type="date" class="form-control field-validate" name="admin_dob" id="admin_dob" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Email</label>
                                        <input type="text" class="form-control field-validate" name="admin_email" id="admin_email" value="">
                                    </div>
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Password</label>
                                        <input type="text" class="form-control field-validate" name="admin_password" id="admin_password" value="">
                                    </div>
                                    <div class="modal-input-field form-group new_file">
                                        <label class="form-check-label">Photo</label>
                                        <span class="file_upload"><i class="fas fa-upload"></i>
                                            Choose File to upload
                                        </span>
                                        <input type="file" class="form-control file_up_load field-validate" name="profileImage" id="admin_image" value="">
                                    </div>
                                    <div class="modal-footer calendar-modal-footer">
                                        <button type="submit" class="btn btn-secondary" id="adminAddBtn">Add</button>
                                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
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
                        <form action="{{ url('/updateAdminUsers') }}" method="post" class="form-validate-2" id="adminUserAddForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="adminUserId" id="adminUserId">
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">First Name</label>
                                        <input type="text" class="form-control form-validate-2" name="edit_admin_firstName" id="edit_admin_firstName" value="">
                                    </div>

                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Surname</label>
                                        <input type="text" class="form-control form-validate-2" name="edit_admin_surName" id="edit_admin_surName" value="">
                                    </div>
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">DOB</label>
                                        <input type="date" class="form-control form-validate-2" name="edit_admin_dob" id="edit_admin_dob" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Email</label>
                                        <input type="text" class="form-control form-validate-2" name="edit_admin_email" id="edit_admin_email" value="">
                                    </div>
                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Password</label>
                                        <input type="text" class="form-control form-validate-2" name="edit_admin_password" id="edit_admin_password" value="">
                                    </div>
                                    <div class="modal-input-field form-group new_file">
                                        <label class="form-check-label">Photo</label>
                                        <span class="file_upload"><i class="fas fa-upload"></i>
                                            Choose File to upload
                                        </span>
                                        <input type="file" class="form-control file_up_load" name="edit_profileImage" id="edit_admin_image" value="">
                                    </div>
                                    <div id="old_user_image"></div>
                                    <input type="hidden" name="old_image" id="old_image">
                                    <div class="modal-footer calendar-modal-footer">
                                    <button type="submit" class="btn btn-secondary">Update</button>
                                    <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                                </div>
                                </div>
                               
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

    // $(document).on('click', '#adminAddBtn', function() {

    //     var error = "";
    //     $(".field-validate").each(function() {
    //         if (this.value == '') {
    //             $(this).closest(".form-group").addClass('has-error');
    //             error = "has error";
    //         } else {
    //             $(this).closest(".form-group").removeClass('has-error');
    //         }
    //     });

    //     if (error == "has error") {
    //         return false;
    //     } else {
    //         var form = $("#adminUserAddForm");
    //         console.log(form.serialize());
    //         var actionUrl = form.attr('action');
    //         $.ajax({
    //             type: "POST",
    //             url: actionUrl,
    //             data: form.serialize(),

    //             dataType: "json",
    //             success: function(data) {
    //                 console.log(data);
    //                 // $("#firstName_txt").val('');
    //                 // $("#surname_txt").val('');
    //                 // $("#studentTbody").html('');
    //                 // $("#studentTbody").html(data.html);
    //                 // swal("", "Student added successfully.");

    //                 if (data.status === 'success') {
    //                     window.location.reload();
    //                 }
    //             }
    //         });
    //     }
    // });

    function contactHistoryRowSelect(adminUser_id) {
        if ($('#editContactHistoryRow' + adminUser_id).hasClass('tableRowActive')) {
            $('#adminId').val('');
            $('#editContactHistoryRow' + adminUser_id).removeClass('tableRowActive');
            $('#deleteContactHistoryBttn').addClass('disabled-link');
            $('#editContactHistoryBttn').addClass('disabled-link');
        } else {
            $('#adminId').val(adminUser_id);
            $('.editContactHistoryRow').removeClass('tableRowActive');
            $('#editContactHistoryRow' + adminUser_id).addClass('tableRowActive');
            $('#deleteContactHistoryBttn').removeClass('disabled-link');
            $('#editContactHistoryBttn').removeClass('disabled-link');
        }
    }

    $(document).on('click', '#editContactHistoryBttn', function() {
        var adminId = $('#adminId').val();
        // alert(adminId);
        if (adminId) {
            // $('#editContactHistoryId').val(ContactHistoryId);
            $.ajax({
                type: 'POST',
                url: '{{ url(' / getAdminUser ')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    adminId: adminId
                },
                success: function(data) {
                    $("#adminUserId").val(data.userAdmin.user_id);
                    $("#edit_admin_firstName").val(data.userAdmin.firstName_txt);
                    $("#edit_admin_surName").val(data.userAdmin.surname_txt);
                    $("#edit_admin_dob").val(data.userAdmin.DOB_dte);
                    $("#edit_admin_email").val(data.userAdmin.workEmail_txt);
                    $("#edit_admin_password").val(data.userAdmin.password_txt);
                    $("#old_image").val(data.userAdmin.profileImage);
                    $("#old_user_image").empty();
                    var html = `<img style="width: 70px; height: 70px;" class="img-fluid" src="${data.userAdmin.profileImageLocation_txt}/${data.userAdmin.profileImage}">`;
                    $("#old_user_image").append(html);
                }
            });
            $('#userEditModal').modal("show");
        } else {
            swal("", "Please select one contact.");
        }
    });

    $(document).on('click', '#deleteContactHistoryBttn', function() {
        var adminId = $('#adminId').val();
        if (adminId) {
            swal({
                    title: "Alert",
                    text: "Are you sure you wish to remove this user?",
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
                                url: '{{ url('/deleteAdminUsers') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    adminId: adminId
                                },
                                success: function(data) {
                                    location.reload();
                                }
                            });
                    }
                });
        } else {
            swal("", "Please select one user.");
        }
    });
</script>
@endsection