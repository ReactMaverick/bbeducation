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
            </div>
            <div class="payroll-bottom-text">
                <p>Details of payments will be recieved once the invoicing and payroll elements are complete.</p>
            </div>
        </div>
    </div>
</div>
@endsection