<div class="col-md-2 sidebar-col">
    <div class="assignment-detail-sidebar-sec">
        <div class="school-detail-sec">
            <h2>{{ $schoolDetail->name_txt }}</h2>
            <i class="fa-solid fa-school"></i>
            <span>{{ $schoolDetail->school_id }}</span>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Detail') sidebar-active @endif">
            <a href="{{ URL::to('/school/detail') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-clipboard-list"></i>

                </div>
                <div class="page-name-sec">
                    <span>Details</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Finance') sidebar-active @endif">
            <a href="{{ URL::to('/school/finance?include=&method=') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="page-name-sec">
                    <span>Finance</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section">
            <a href="{{ URL::to('/school/logout') }}" class="sidebar-pages">
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
