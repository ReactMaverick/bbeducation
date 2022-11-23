@extends('web.layout')
@section('content')

<div class="assignment-detail-page-section">
    <div class="row assignment-detail-row">

        @include('web.assignment.assignment_sidebar')

        <div class="col-md-10 topbar-sec">
            <div class="topbar-Section">
                <i class="fa-solid fa-crown"></i>
                <a href="#"> <i class="fa-solid fa-trash trash-icon"></i></a>
            </div>



            <div class="school-assignment-sec">
                <div class="school-assignment-section">
                    <div class="assignment-contact-history-heading-section">
                        <div class="assignment-contact-history-heading">
                            <h2>Contact History</h2>
                        </div>
                        <div class="assignment-contact-history-icon">
                            <a href="#"><i class="fa-solid fa-plus"></i></a>
                        </div>
                    </div>


                    <div class="assignment-contact-page-table">
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

                </div>
                <div class="assignment-first-sec">
                    <div class="assignment-contact-sidebar-sec">
                        <div class="assignment-sidebar-data">
                            <h2>0</h2>
                        </div>
                        <div class="assignment-sidebar-text">
                            <span>Total contacts for this specific assignment</span>
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