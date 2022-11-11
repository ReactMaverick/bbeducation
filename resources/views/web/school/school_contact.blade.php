@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.school.school_sidebar')

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
                        <div class="contact-history-heading-section">
                            <h2>Contact History</h2>
                            <a href="#"><i class="fa-solid fa-plus"></i></a>
                        </div>
                        <!-- <div class="school-assignment-contact-heading">

                            <div class="school-assignment-contact-icon-sec">
                                <a href="#"><i class="fa-solid fa-xmark"></i></a>
                                <a href="#"><i class="fa-solid fa-plus"></i></a>
                                <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                            </div>
                        </div> -->



                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Contact Notes</th>
                                    <th>Spoke To</th>
                                    <th>Contact By</th>
                                    <th>Contact On</th>
                                    <th>Method</th>
                                    <th>CB Due</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data">
                                    <td>School Main</td>
                                    <td>School Main</td>
                                    <td>020 8359 7744</td>
                                    <td>020 8359 7744</td>
                                    <td>020 8359 7744</td>
                                    <td>020 8359 7744</td>
                                </tr>

                                <tr class="school-detail-table-data">
                                    <td>School Main</td>
                                    <td>School Main</td>
                                    <td>020 8359 7744</td>
                                    <td>020 8359 7744</td>
                                    <td>020 8359 7744</td>
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
                                    <span>Total Contacts</span>
                                </div>
                            </div>
                            <div class="sidebar-sec">
                                <div class="assignment-sidebar-data2">
                                    <h2>4</h2>
                                </div>
                                <div class="sidebar-sec-text">
                                    <span>Callbacks Due</span>
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
