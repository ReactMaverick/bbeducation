@extends('web.layout')
@section('content')
    <div class="tab-content assignment-tab-content">

    <div class="school-assignment-sec">
                <div class="teacher-pending-reference-section">
                    <div class="assignment-finance-heading-section">
                        <h2>Refernces</h2>
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
                                <th>Teacher</th>
                                <th>Employer</th>
                                <th>Date From</th>
                                <th>Date Until</th>
                                <th>Ref. Sent</th>
                                <th>No.</th>
                                <th>Days Over</th>
                            </tr>
                        </thead>
                        <tbody class="table-body-sec">
                            <tr class="school-detail-table-data">
                                <td>Alberto Garrido</td>
                                <td>School Main</td>
                                <td></td>
                                <td></td>
                                <td>Not Sent</td>
                                <td>0</td>
                                <td></td>
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
@endsection
