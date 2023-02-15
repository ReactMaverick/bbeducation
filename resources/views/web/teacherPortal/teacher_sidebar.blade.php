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
                    <img src="{{ asset('web/images/user-img.png') }}" alt="">
                    <div class="sidebar-user-edit-sec">
                       <a href="#"> <i class="fa-solid fa-pen"></i></a>
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