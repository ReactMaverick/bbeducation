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

            <div class="school-detail-right-sec">
                <div class="teacher-health-first-sec">
                    <div class="details-heading">
                        <h2>Documents</h2>
                        <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                class="fa-solid fa-pencil"></i></a>
                    </div>


                    <div class="teacher-document-first-sec">
                        <div class="teacher-document-section">
                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">Passport</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">Driver's Licence</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">Bank Statement</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">DBS</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">Disqual. Form</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">Health Dec.</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>
                        </div>

                        <div class="teacher-document-section">
                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">EU Card</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">Utility Bill</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">Telephone Bill</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">Benefit Statement</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">Credit Card Bill</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label for="vehicle1">P45/P60</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-heading-text">
                                    <label>Counsil Tax Bill</label>
                                </div>
                                <div class="teacher-document-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="teacher-health-second-sec">
                    <div class="details-heading">
                        <h2>Vetting Details</h2>
                        <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                class="fa-solid fa-pencil"></i></a>
                    </div>

                    <div class="teacher-document-first-sec">
                        <div class="teacher-document-section">
                            <div class="school-name-section">
                                <div class="teacher-document-second-heading-text">
                                    <label for="vehicle1">Vetting Update Service</label>
                                </div>
                                <div class="teacher-document-second-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-document-second-heading-text">
                                    <label for="vehicle1">List 99</label>
                                </div>
                                <div class="teacher-document-second-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                                <div class="teacher-document-third-name-text">
                                    <p>Expires on 22-06-2017</p>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="teacher-document-second-heading-text">
                                    <label for="vehicle1">Nctl Check</label>
                                </div>
                                <div class="teacher-document-second-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                                <div class="teacher-document-third-name-text">
                                    <p>Expires on 13-06-2017</p>
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-second-heading-text">
                                    <label for="vehicle1">Disqualification Check</label>
                                </div>
                                <div class="teacher-document-second-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                                <div class="teacher-document-third-name-text">
                                    <p>Expires on 02-09-2016</p>
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-second-heading-text">
                                    <label for="vehicle1">Safeguarding Induction</label>
                                </div>
                                <div class="teacher-document-second-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                                <div class="teacher-document-third-name-text">
                                    <p>Expires on 05-09-2016</p>
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-second-heading-text">
                                    <label for="vehicle1">s128 Management Check</label>
                                </div>
                                <div class="teacher-document-second-name-text">
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                                
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-second-heading-text">
                                    <h2>EEA Restriction Check</h2>
                                </div>
                                <div class="teacher-document-second-name-text">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="teacher-document-second-heading-text">
                                    <h2>Right to Work</h2>
                                </div>
                                <div class="teacher-document-second-name-text">
                                    <p>EU Citizen</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="school-detail-right-sec">

                <div class="teacher-document-table-sec">
                    <div class="contact-heading">
                        <div class="contact-heading-text">
                            <h2>Teaching Subjects</h2>
                        </div>
                        <div class="contact-icon-sec">
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
                                    <th>Subject</th>
                                    <th>Main</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data editContactRow">
                                    <td></td>
                                    <td>Y</td>
                                </tr>
                                <tr class="school-detail-table-data editContactRow">
                                    <td></td>
                                    <td>N</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="teacher-document-table-sec">
                    <div class="contact-heading">
                        <div class="contact-heading-text">
                            <h2>Qualifications</h2>
                        </div>
                        <div class="contact-icon-sec">
                        <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-minus"></i>
                            </a>
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
                                    <th>Type</th>
                                    <th>Qualification</th>
                                    <th>QTS</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data editContactRow">
                                    <td>BA</td>
                                    <td>Primary Education</td>
                                    <td>N</td>
                                </tr>
                                <tr class="school-detail-table-data editContactRow">
                                    <td>MA</td>
                                    <td>Physical Activity, Health & Sports Training</td>
                                    <td>Y</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endsection