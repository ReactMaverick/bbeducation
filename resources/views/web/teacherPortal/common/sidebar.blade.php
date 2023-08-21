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

    {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
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
    </div> --}}
</aside>

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
