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

                    <div class="school-finance-sec">
                        <div class="school-finance-contact-heading-text">
                            <h2>Finance</h2>
                        </div>
                        <div class="form-check paid-check">
                            <label for="vehicle3">Include paid</label>
                            <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat"><br>
                        </div>

                        <div class="form-group payment-method-type">
                            <label for="inputState">Payment Method</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="school-finance-contact-heading">
                            <div class="school-finance-contact-icon-sec">
                                <a href="#"><i class="fa-solid fa-square-check"></i></a>
                                <a href="#"><i class="fa-solid fa-money-bills"></i></a>
                                <a href="#"><i class="fa-solid fa-arrow-up"></i></a>
                                <a href="#"><i class="fa-solid fa-id-card"></i></a>
                                <a href="#"><i class="fa-solid fa-envelope"></i></a>
                                <a href="#"><i class="fa-solid fa-plus"></i></a>
                                <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                            </div>
                        </div>
                    </div>


                    <div class="school-finance-table-section">
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th>Net</th>
                                    <th>Vat</th>
                                    <th>Gross</th>
                                    <th>Paid On</th>
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

                        <hr>

                        <table class="table school-detail-page-table" id="myTable1">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Teacher</th>
                                    <th>Days</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data">
                                    <td>School Main</td>
                                    <td>School Main</td>
                                </tr>

                                <tr class="school-detail-table-data">
                                    <td>School Main</td>
                                    <td>School Main</td>
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
    $('#myTable, #myTable1').DataTable();
});
</script>
@endsection