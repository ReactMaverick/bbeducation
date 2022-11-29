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
                <div class="school-details-first-sec">
                    <div class="details-heading">
                        <h2>Profession</h2>
                        <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                class="fa-solid fa-pencil"></i></a>
                    </div>

                    <div class="about-school-section">
                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>Candidate Type</h2>
                            </div>
                            <div class="teacher-profession-name-text">
                                <p>Teacher</p>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>SubType</h2>
                            </div>
                            <!-- <div class="teacher-profession-name-text">
                                <p>Mr</p>
                            </div> -->
                        </div>
                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>Age Range</h2>
                            </div>
                            <div class="grid-refs-sec">
                                <div class="grid-refs-text1">
                                    <p>Secondary</p>
                                </div>

                                <!-- <div class="grid-refs-text1">
                                    <p>Alonso</p>
                                </div> -->

                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <label for="vehicle1">NQT Required</label>
                            </div>
                            <div class="teacher-profession-heading-text">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>NQT Completed</h2>
                            </div>
                            <!-- <div class="teacher-profession-name-text">
                                <p>abc</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>TRN</h2>
                            </div>
                            <!-- <div class="teacher-profession-name-text">
                                <p>12-04-1992</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>Imported Title</h2>
                            </div>
                            <!-- <div class="teacher-profession-name-text">
                                <p>Spanish</p>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div class="school-details-second-sec">
                    <div>
                        <div class="details-heading">
                            <h2>Interview</h2>
                            <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </div>

                        <!-- <div class="about-school-section"> -->
                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>Notes</h2>
                            </div>
                            <!-- <div class="teacher-profession-headnameing-text">
                                <p>Flat 3, 14 Cholmeley Park</p>
                                <p>N6 5EU</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>Interview Quality</h2>
                            </div>
                            <!-- <div class="teacher-profession-name-text">
                                <p>51.5742105</p>
                                <p>-0.1434667</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>Language Skills</h2>
                            </div>
                            <!-- <div class="teacher-profession-name-text">
                                <p>51.5742105</p>
                                <p>-0.1434667</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-profession-heading-text">
                                <h2>interview Details</h2>
                            </div>
                            <div class="teacher-profession-name-text">
                                <p>Interviewed by Georgia Symeou on 24-05-2016</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="school-detail-right-sec">

                <div class="school-details-contact-second-sec">
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


                <div class="school-details-contact-second-sec">
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
</div>
@endsection