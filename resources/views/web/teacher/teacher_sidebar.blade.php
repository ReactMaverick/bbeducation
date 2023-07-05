<div class="col-md-2 sidebar-col">
    <div class="assignment-detail-sidebar-sec">
        <div class="sidebar-top-text">
            <h2>
                @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                    {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                @else
                    {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                @endif
            </h2>
            <div class="teacher-detail-user-img-sec">
                <div class="user-img-sec">
                    @if ($teacherDetail->file_location != null || $teacherDetail->file_location != '')
                        <img src="{{ asset($teacherDetail->file_location) }}" alt="">
                    @else
                        <img src="{{ asset('web/images/user-img.png') }}" alt="">
                    @endif
                </div>
            </div>
            <div class="sidebar-top-text">
                <span>ID: {{ $teacherDetail->teacher_id }}</span>
                <?php
                $tDy = date('Y-m-d');
                $dob = $teacherDetail->DOB_dte;
                $dobDiff = abs(strtotime($tDy) - strtotime($dob));
                $dobYears = floor($dobDiff / (365 * 60 * 60 * 24));
                ?>
                <p>Age:
                    @if ($teacherDetail->DOB_dte == null || $teacherDetail->DOB_dte == '')
                        {{ 'Missing DOB' }}
                    @else
                        {{ $dobYears }}
                    @endif
                </p>
            </div>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Detail') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-detail/' . $teacherDetail->teacher_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-address-book"></i>
                </div>
                <div class="page-name-sec">
                    <span>Details</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Profession') sidebar-active @endif">
            <a href="{{ URL::to('/profession-qualification/' . $teacherDetail->teacher_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="page-name-sec">
                    <span>Profession / Qualifications</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Health') sidebar-active @endif">
            <a href="{{ URL::to('/preference-health/' . $teacherDetail->teacher_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-desktop"></i>
                </div>
                <div class="page-name-sec">
                    <span>Preferences / Health</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Reference') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-references/' . $teacherDetail->teacher_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="page-name-sec">
                    <span>References</span>
                </div>
            </a>
        </div>
        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Documents') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-documents/' . $teacherDetail->teacher_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="page-name-sec">
                    <span>Documents</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Contact Log') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-contact-log/' . $teacherDetail->teacher_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-comment"></i>
                </div>
                <div class="page-name-sec">
                    <span>Contact Logs</span>
                </div>
            </a>
        </div>

        {{-- <div class="sidebar-pages-section ">
            <a href="#" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-person-chalkboard"></i>
                </div>
                <div class="page-name-sec">
                    <span>Work</span>
                </div>
            </a>
        </div> --}}

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Payroll') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-payroll/' . $teacherDetail->teacher_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="page-name-sec">
                    <span>Payroll</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section">
            <a style="cursor: pointer;" class="sidebar-pages"
                onclick="teacherPasswordSendLink('{{ $teacherDetail->teacher_id }}')">
                <div class="page-icon-sec">
                    <i class="fa-sharp fa-solid fa-paper-plane"></i>
                </div>
                <div class="page-name-sec">
                    <span>Send Reset Password Link</span>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
    function teacherPasswordSendLink(teacher_id) {
        if (teacher_id) {
            swal({
                    title: "",
                    text: "Are you sure you wish to send password reset link to the user?",
                    buttons: {
                        cancel: "No",
                        Yes: "Yes"
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "Yes":
                            $('#fullLoader').show();
                            $.ajax({
                                type: 'POST',
                                url: '{{ url('resendTeacherPasswordLink') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    teacher_id: teacher_id
                                },
                                success: function(data) {
                                    $('#fullLoader').hide();
                                    if (data) {
                                        swal("",
                                            "Password reset link has been send successfully to teacher's login email."
                                        );
                                    } else {
                                        swal("",
                                            "Something went wrong.");
                                    }
                                }
                            });
                    }
                });
        }
    }
</script>
