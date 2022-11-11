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

                <div class="sidebar-pages-section">
                    <a href="{{ URL::to('/school-detail') }}" class="sidebar-pages">
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

                <div class="sidebar-pages-section sidebar-active">
                    <a href="{{ URL::to('/school-assignment') }}" class="sidebar-pages">
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

            <div class="school-assignment-sec">


                <div class="school-assignment-section">
                    <div class="school-assignment-contact-heading-text">
                        <h2>Assignments</h2>
                    </div>
                    <div class="school-assignment-contact-heading">

                        <div class="school-assignment-contact-icon-sec">
                            <a href="#"><i class="fa-solid fa-xmark"></i></a>
                            <a href="#"><i class="fa-solid fa-plus"></i></a>
                            <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                        </div>
                    </div>



                    <table class="table school-detail-page-table" id="myTable">
                        <thead>
                            <tr class="school-detail-table-heading">
                                <th>Person</th>
                                <th>Type</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody class="table-body-sec">
                            <tr class="school-detail-table-data">
                                <td>School Main</td>
                                <td>School Main</td>
                                <td>020 8359 7744</td>
                            </tr>

                            <tr class="school-detail-table-data">
                                <td>School Main</td>
                                <td>School Main</td>
                                <td>020 8359 7744</td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            <div class="assignment-first-sec">
                <div class="assignment-left-sidebar-section">
                    <div class="sidebar-sec">
                        <div class="assignment-sidebar-data">
                            <h2>29</h2>
                        </div>
                        <div class="sidebar-sec-text">
                            <span>Completed Assignments</span>
                        </div>
                    </div>
                    <div class="sidebar-sec">
                        <div class="assignment-sidebar-data2">
                            <h2>4</h2>
                        </div>
                        <div class="sidebar-sec-text">
                            <span>Total Days</span>
                        </div>
                    </div>

                </div>
            </div>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>
@endsection