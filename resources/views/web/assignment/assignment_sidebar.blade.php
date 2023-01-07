<div class="col-md-2 sidebar-col">
    <div class="assignment-detail-sidebar-sec">
        <div class="sidebar-top-text">
            <a href="{{ URL::to('/school-detail/' . $assignmentDetail->school_id) }}" class="" target="_blank">
                <h2>{{ $assignmentDetail->schooleName }}</h2>
                <span>{{ $assignmentDetail->school_id }}</span>
            </a>
            <i class="fa-solid fa-square-check"></i>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Assignments Detail') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-details/'.$assignmentDetail->asn_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-person-chalkboard"></i>
                </div>
                <div class="page-name-sec">
                    <span>Assignment</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Assignments Contact') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-contact/'.$assignmentDetail->asn_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-comment"></i>
                </div>
                <div class="page-name-sec">
                    <span>Contact</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Assignments Candidate') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-candidate/'.$assignmentDetail->asn_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div class="page-name-sec">
                    <span>Candidates</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle']=='Assignments School Detail') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-school/'.$assignmentDetail->asn_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-school"></i>
                </div>
                <div class="page-name-sec">
                    <span>School Details</span>
                </div>
            </a>
        </div>
        <div class="sidebar-pages-section @if ($title['pageTitle']=='Assignments Finance') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-finance/'.$assignmentDetail->asn_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="page-name-sec">
                    <span>Finance</span>
                </div>
            </a>
        </div>

        <div class="teacher-name">
            <span>{{ $assignmentDetail->techerFirstname . ' ' . $assignmentDetail->techerSurname }}</span>
        </div>
        <div class="assignment-detail-user-img-sec">
            <div class="user-img-sec">
                <img src="{{ asset('web/images/user-img.png') }}" alt="">
            </div>
        </div>


        <div class="sidebar-user-number">
            <span>{{ $assignmentDetail->teacher_id }}</span>
        </div>

        <div class="sidebar-check-icon">
            <i class="fa-solid fa-square-check"></i>
        </div>
        <div class="assignment-id-text-sec">
            <span>Assignment ID :</span>
            <span>{{ $assignmentDetail->asn_id }}</span>
        </div>

    </div>
</div>
