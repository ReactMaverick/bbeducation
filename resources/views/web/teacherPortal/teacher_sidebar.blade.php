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
                    <div class="sidebar-user-edit-sec">
                        <a data-toggle="modal" data-target="#profilePicAddModal" style="cursor: pointer;">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </div>
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
            <a href="{{ URL::to('/teacher/detail') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-address-book"></i>
                </div>
                <div class="page-name-sec">
                    <span>Details</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Timesheet') sidebar-active @endif">
            <a href="{{ URL::to('/teacher/timesheet') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-address-book"></i>
                </div>
                <div class="page-name-sec">
                    <span>Timesheet</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Profession') sidebar-active @endif">
            <a href="{{ URL::to('/teacher/profession-qualification') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="page-name-sec">
                    <span>Profession / Qualifications</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Health') sidebar-active @endif">
            <a href="{{ URL::to('/teacher/preference-health/') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-desktop"></i>
                </div>
                <div class="page-name-sec">
                    <span>Preferences / Health</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Documents') sidebar-active @endif">
            <a href="{{ URL::to('/teacher/all-documents') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="page-name-sec">
                    <span>Documents</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Teacher Payroll') sidebar-active @endif">
            <a href="{{ URL::to('/teacher/payroll') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="page-name-sec">
                    <span>Payroll</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section">
            <a href="{{ URL::to('/teacher/logout') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </div>
                <div class="page-name-sec">
                    <span>Logout</span>
                </div>
            </a>
        </div>
    </div>
</div>

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

            <form action="{{ url('/teacher/logTeacherProfilePicAdd') }}" method="post" class="form-validate-6"
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
