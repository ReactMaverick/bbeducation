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
            <div class="school-finance-right-sec">


                <div class="assignment-candidate-section">

                    <div class="assignment-candidate-sec">
                        <div class="assignment-candidate-heading-text">
                            <h2>Candidates</h2>
                            <a href="#"><i class="fa-solid fa-arrows-rotate"></i></a>
                        </div>
                        <div class="form-check assignment-candidate-paid-check">
                            <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat"><br>
                            <label for="vehicle3">Include paid</label>

                        </div>

                        <div class="form-group assignment-candidate-payment-method-type">
                            <label for="inputState">Payment Method</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                    </div>


                    <div class="assignment-candidate-table-section">
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Distance</th>
                                    <th>Availability</th>
                                    <th>Specialism</th>
                                    <th>Days Here</th>
                                    <th>Age Range</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data">
                                    <td>Joanna Mathew</td>
                                    <td>Available</td>
                                    <td>0.3</td>
                                    <td>100</td>
                                    <td>Unknown</td>
                                    <td>0</td>
                                    <td>Primary</td>
                                </tr>

                                <tr class="school-detail-table-data">
                                    <td>Joanna Mathew</td>
                                    <td>Available</td>
                                    <td>0.3</td>
                                    <td>100</td>
                                    <td>Unknown</td>
                                    <td>0</td>
                                    <td>Primary</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="assignment-candidate-billing-details-section">
                    <div class="assignment-candidate-billing-section">
                        <div class="assignment-candidate-billing-details-heading">
                            <span>Continiuty List</span>
                            <a href="#"><i class="fa-solid fa-arrows-rotate"></i></a>
                        </div>
                        <div class="assignment-candidate-second-icon-section">
                            <a href="#"><i class="fa-solid fa-square-check check-icon"></i></a>
                            <a href="#"><i class="fa-solid fa-xmark cancel-icon"></i></a>
                        </div>
                    </div>

                    <div class="assignment-candidate-table-section">
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Days Worked</th>
                                    <th>Preferred</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data">
                                    <td>Lola Aggio</td>
                                    <td>Available</td>
                                    <td>2.5</td>
                                    <td></td>
                                </tr>

                                <tr class="school-detail-table-data">
                                    <td>Lola Aggio</td>
                                    <td>Available</td>
                                    <td>2.5</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="assignment-candidate-billing-section">
                        <div class="assignment-candidate-billing-details-heading">
                            <span>Preferred List</span>
                        </div>
                    </div>

                    <div class="assignment-candidate-table-section">
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Days Worked</th>
                                    <th>Preferred</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data">
                                    <td>Lola Aggio</td>
                                    <td>Available</td>
                                    <td>2.5</td>
                                    <td></td>
                                </tr>

                                <tr class="school-detail-table-data">
                                    <td>Lola Aggio</td>
                                    <td>Available</td>
                                    <td>2.5</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="assignment-candidate-check-icon">
                    <a href="#"><i class="fa-solid fa-square-check"></i></a>
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