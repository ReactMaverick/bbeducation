@extends('web.layout')
@section('content')
<div class="assignment-detail-page-section">
    <div class="row assignment-detail-row">
        <div class="col-md-2 sidebar-col">
            <div class="assignment-detail-sidebar-sec">
                <div class="school-detail-sec">
                    <h2>Barnet Virtual School</h2>
                    <i class="fa-solid fa-school"></i>
                    <span>100960</span>

                </div>

                <div class="sidebar-pages-section sidebar-active">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-clipboard-list"></i>

                        </div>
                        <div class="page-name-sec">
                            <span>Details</span>
                        </div>
                    </a>
                </div>

                <div class="sidebar-pages-section">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-comment"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Contact History</span>
                        </div>
                    </a>
                </div>

                <div class="sidebar-pages-section">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-person-chalkboard"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Assignments</span>
                        </div>
                    </a>
                </div>

                <div class="sidebar-pages-section">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-money-bills"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Finance</span>
                        </div>
                    </a>
                </div>
                <div class="sidebar-pages-section">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Documents</span>
                        </div>
                    </a>
                </div>

                <div class="sidebar-pages-section">
                    <a href="#" class="sidebar-pages">
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

        <div class="col-md-10 topbar-sec">
            <div class="topbar-Section">
                <i class="fa-solid fa-crown">
                    <span class="topbar-text">All Through</span>
                </i>
                <i class="fa-solid fa-school">
                    <span class="topbar-text">Other</span>
                </i>
                <i class="fa-solid fa-list-ul">
                    <span class="topbar-text">Barnet</span>
                </i>
                <i class="fa-solid fa-flag">
                    <span class="topbar-text">Other</span>
                </i>
                <i class="fa-solid fa-star topbar-star-icon"></i>
                <i class="fa-regular fa-calendar-days">
                    <span class="topbar-text">calendar</span>
                </i>
            </div>

            <div class="school-detail-right-sec">
                <div class="school-details-first-sec">
                    <div class="details-heading">
                        <h2>Details</h2>
                        <a href="#"><i class="fa-solid fa-pencil"></i></a>
                    </div>
                </div>

                <div class="school-details-second-sec">

                </div>
            </div>

        </div>
    </div>
</div>
@endsection