<div class="col-md-2 sidebar-col">
    <div class="assignment-detail-sidebar-sec">
        <div class="sidebar-top-text">
            <h2>Alberto Alonso</h2>
            <div class="teacher-detail-user-img-sec">
                <div class="user-img-sec">
                    <img src="{{ asset('web/images/user-img.png') }}" alt="">
                </div>
            </div>
            <div class="sidebar-top-text">
                <span>ID: 10280</span>
                <p>Age: 30</p>
            </div>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Teacher Detail') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-detail/1') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                <i class="fa-solid fa-address-book"></i>                    
                </div>
                <div class="page-name-sec">
                    <span>Details</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Teacher Profession') sidebar-active @endif">
            <a href="{{ URL::to('/profession-qualification') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="page-name-sec">
                    <span>Profession / Qualifications</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Teacher Health') sidebar-active @endif">
            <a href="{{ URL::to('/preference-health') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                <i class="fa-solid fa-desktop"></i>
                </div>
                <div class="page-name-sec">
                    <span>Preferences / Health</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Teacher Reference') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-references') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="page-name-sec">
                    <span>References</span>
                </div>
            </a>
        </div>
        <div class="sidebar-pages-section @if ($title['pageTitle']=='Teacher Documents') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-documents') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="page-name-sec">
                    <span>Documents</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Teacher Contact Log') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-contact-log') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-comment"></i>
                </div>
                <div class="page-name-sec">
                    <span>Contact Logs</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section ">
            <a href="#" class="sidebar-pages">
                <div class="page-icon-sec">
                <i class="fa-solid fa-person-chalkboard"></i>
                </div>
                <div class="page-name-sec">
                    <span>Work</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Teacher Payroll') sidebar-active @endif">
            <a href="{{ URL::to('/teacher-payroll') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="page-name-sec">
                    <span>Payroll</span>
                </div>
            </a>
        </div>
    </div>
</div>