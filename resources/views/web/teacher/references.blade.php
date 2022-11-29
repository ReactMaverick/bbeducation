@extends('web.layout')
@section('content')
<style>
.disabled-link {
    pointer-events: none;
}
</style>
<div class="assignment-detail-page-section">
    <div class="row assignment-detail-row">

        @include('web.teacher.teacher_sidebar')

        <div class="col-md-10 topbar-sec">

            @include('web.teacher.teacher_header')

            <div class="school-assignment-sec">
                <div class="teacher-reference-section">
                    <div class="assignment-finance-heading-section">
                        <h2>References</h2>
                        <div class="assignment-finance-icon-section">
                            <a href="#"><i class="fa-solid fa-square-check"></i></a>
                            <a href="#"><i class="fa-solid fa-file-lines"></i></a>
                            <a href="#"><i class="fa-solid fa-envelope"></i></a>
                            <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                <i class="fa-solid fa-pencil school-edit-icon"></i>
                            </a>
                        </div>

                    </div>
                    <div class="assignment-finance-table-section">
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Employed At</th>
                                    <th>Date From</th>
                                    <th>Date Until</th>
                                    <th>Ref. Sent</th>
                                    <th>No.</th>
                                    <th>Recieved</th>
                                    <th>Valid?</th>
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
                                    <td>020 8359 7744</td>
                                </tr>

                                <tr class="school-detail-table-data">
                                    <td>School Main</td>
                                    <td>School Main</td>
                                    <td>020 8359 7744</td>
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
                    <div class="assignment-left-sidebar-section">
                        <div class="references-bottom-sec">
                            <div class="assignment-sidebar-data">
                                <h2>0</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Total References</span>
                            </div>
                        </div>
                        <div class="references-bottom-sec">
                            <div class="assignment-sidebar-data2">
                                <h2>0</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Pending</span>
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