@php
    $teacherLoginData = Session::get('teacherLoginData');
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ URL::to('/candidate/detail') }}" class="brand-link">
        <img src="{{ asset($teacherLoginData->company_logo) }}" alt="" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">
            @if ($teacherLoginData && isset($teacherLoginData->company_name))
                {{ $teacherLoginData->company_name }}
            @endif
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ URL::to('/candidate/detail') }}"
                        class="nav-link @if ($pagetitle['pageTitle'] == 'Teacher Detail') active @endif">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>
                            Details
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::to('/candidate/timesheet') }}"
                        class="nav-link @if ($pagetitle['pageTitle'] == 'Teacher Timesheet') active @endif">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Timesheet
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::to('/candidate/profession-qualification') }}"
                        class="nav-link @if ($pagetitle['pageTitle'] == 'Teacher Profession') active @endif">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Profession / Qualifications
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::to('/candidate/preference-health/') }}"
                        class="nav-link @if ($pagetitle['pageTitle'] == 'Teacher Health') active @endif">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>
                            Preferences / Health
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::to('/candidate/all-documents') }}"
                        class="nav-link @if ($pagetitle['pageTitle'] == 'Teacher Documents') active @endif">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Documents
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::to('/candidate/payroll') }}"
                        class="nav-link @if ($pagetitle['pageTitle'] == 'Teacher Payroll') active @endif">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Payroll
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @if ($teacherDetail->file_location != null || $teacherDetail->file_location != '')
                <img src="{{ asset($teacherDetail->file_location) }}" class="img-circle elevation-2" alt="">
            @else
                <img src="{{ asset('web/images/user-img.png') }}" class="img-circle elevation-2" alt="">
            @endif
        </div>
        <div class="info">
            <a href="javascript:void(0)" class="d-block">
                @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                    {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                @else
                    {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                @endif
            </a>
        </div>
    </div>
</aside>

<!-- Profile Pic Add Modal -->
<div class="modal fade" id="profilePicAddModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section">
        <div class="modal-content calendar-modal-content" style="width:65%;">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Add Profile Image</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="calendar-heading-sec">
                <i class="fa-solid fa-pencil school-edit-icon"></i>
                <h2>Add Profile Image</h2>
            </div>

            <form action="{{ url('/candidate/logTeacherProfilePicAdd') }}" method="post" class="form-validate-6"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-input-field-section">
                    <h6>
                        @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                            {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                        @else
                            {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                        @endif
                    </h6>
                    {{-- <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p> --}}
                    <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">
                    <input type="hidden" name="teacherDocument_id" value="{{ $teacherDetail->teacherDocument_id }}">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-input-field form-group">
                                <label class="form-check-label">Upload Profile Image</label><span
                                    style="color: red;">*</span>
                                <input type="file" class="form-control file-validate-6" name="file" id=""
                                    value=""><span> *Only file type 'jpg', 'png', 'jpeg'</span>
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
<!-- Profile Pic Add Modal -->

<script>
    $(document).on('click', '#profilePicDeleteBtn', function() {
        var teacherDocument_id = "{{ $teacherDetail->teacherDocument_id }}";
        if (teacherDocument_id) {
            swal({
                    title: "Alert",
                    text: "Are you sure you wish to remove this profile image?",
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
                                url: '{{ url('/candidate/logTeacherProfilePicDelete') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    teacherDocument_id: teacherDocument_id
                                },
                                success: function(data) {
                                    location.reload();
                                }
                            });
                    }
                });
        }
    });
</script>
