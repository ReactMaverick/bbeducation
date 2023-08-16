<div class="col-md-2 sidebar-col">
    <div class="assignment-detail-sidebar-sec">
        <div class="school-detail-sec">
            <h2>{{ $schoolDetail->name_txt }}</h2>
            {{-- <i class="fa-solid fa-school"></i> --}}
            <div class="teacher-detail-user-img-sec">
                <div class="user-img-sec">
                    @if ($schoolDetail->profile_pic != null || $schoolDetail->profile_pic != '')
                        <img src="{{ asset($schoolDetail->profile_pic) }}" alt="">
                    @else
                        <img src="{{ asset('web/images/college.png') }}" alt="">
                    @endif
                </div>
            </div>
            <span>{{ $schoolDetail->school_id }}</span>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Detail') sidebar-active @endif">
            <a href="{{ URL::to('/school-detail/' . $school_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-clipboard-list"></i>

                </div>
                <div class="page-name-sec">
                    <span>Details</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Contact') sidebar-active @endif">
            <a href="{{ URL::to('/school-contact/' . $school_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-comment"></i>
                </div>
                <div class="page-name-sec">
                    <span>Contact History</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Assignment') sidebar-active @endif">
            <a href="{{ URL::to('/school-assignment/' . $school_id . '?include=&status=2') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-person-chalkboard"></i>
                </div>
                <div class="page-name-sec">
                    <span>Assignments</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Finance') sidebar-active @endif">
            <a href="{{ URL::to('/school-finance/' . $school_id . '?include=&method=') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="page-name-sec">
                    <span>Finance</span>
                </div>
            </a>
        </div>
        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Document') sidebar-active @endif">
            <a href="{{ URL::to('/school-document/' . $school_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="page-name-sec">
                    <span>Documents</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Teacher') sidebar-active @endif">
            <a href="{{ URL::to('/school-candidate/' . $school_id . '?status=all') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-person"></i>
                </div>
                <div class="page-name-sec">
                    <span>Teacher List</span>
                </div>
            </a>
        </div>

    </div>
</div>
