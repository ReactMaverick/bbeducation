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
            <div class="assignment-school-detail-right-sec">
                <div class="assignment-school-details-first-sec">
                    <div class="details-heading">
                        <h2>School Details</h2>
                        <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                class="fa-solid fa-pencil"></i></a>
                    </div>

                    <div class="about-school-section">
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>School</h2>
                            </div>
                            <div class="school-name-text">
                                <p>Test School</p>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Address</h2>
                            </div>
                            <div class="school-name-text">
                                <p>123</p>
                                <p>123</p>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Grid Refs</h2>
                            </div>
                            <div class="grid-refs-sec">
                                <div class="grid-refs-text1">
                                    <p>51.617450</p>
                                </div>

                                <div class="grid-refs-text1">
                                    <p>-0.179875</p>
                                </div>

                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Website</h2>
                            </div>
                            <div class="school-name-text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="assignment-school-detail-right-sec">

                <div class="assignment-school-details-contact-second-sec">
                    <div class="contact-heading">
                        <div class="contact-heading-text">
                            <h2>Contacts</h2>
                        </div>
                    </div>

                    <table class="table school-detail-page-table" id="myTable">
                        <thead>
                            <tr class="school-detail-table-heading">
                                <th>Job Role</th>
                                <th>Name</th>
                                <th>Vet.</th>
                                <th>T/S </th>
                            </tr>
                        </thead>
                        <tbody class="table-body-sec">
                            <tr class="school-detail-table-data">
                                <td>HR Manager</td>
                                <td>Karen.Walsh-Saunders@Barnet.gov.uk Walsh-Saunders</td>
                                <td>Y</td>
                                <td>N</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="assignment-school-details-first-sec">
                    <div class="details-table">
                        <div class="contact-heading">
                            <div class="contact-heading-text">
                                <h2>Contact Items</h2>
                            </div>
                            <div class="contact-icon-sec">
                                <a href="#"><i class="fa-solid fa-mobile-screen"></i></a>
                                <a href="#"><i class="fa-solid fa-envelope"></i></a>
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
                                    <td>Karen.Walsh-Saunders@Barnet.gov.uk Walsh-Saunders </td>
                                    <td>Email</td>
                                    <td>Karen.Walsh-Saunders@Barnet.gov.uk</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection