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
                <div class="assignment-finance-section">
                    <div class="assignment-finance-heading-section">
                        <h2>Finance</h2>
                        <div class="assignment-finance-icon-section">
                            <a href="#"><i class="fa-solid fa-square-check"></i></a>
                            <a href="#"><i class="fa-solid fa-file-lines"></i></a>
                            <a href="#"><i class="fa-solid fa-envelope"></i></a>
                        </div>

                    </div>
                    <div class="assignment-finance-table-section">
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Invoice ID</th>
                                    <th>Invoice Date</th>
                                    <th>Net</th>
                                    <th>Vat</th>
                                    <th>Gross</th>
                                    <th>Date Paid</th>
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