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
                        <h2>Profession</h2>
                        <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                class="fa-solid fa-pencil"></i></a>
                    </div>

                    <div class="about-school-section">
                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">Can Drive</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">Daily Supply</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">Long Term</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">Early Morning Calls</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">SEN Interested</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <label for="vehicle1">SEN Experience</label>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Max. Distance</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>10</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Pref. Year Group</h2>
                            </div>
                            <!-- <div class="teacher-prefernce-name-text">
                                <p>10</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Ideal job</h2>
                            </div>
                            <!-- <div class="teacher-prefernce-name-text">
                                <p>10</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Other Agencies</h2>
                            </div>
                            <!-- <div class="teacher-prefernce-name-text">
                                <p>10</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Current rate</h2>
                            </div>
                            <!-- <div class="teacher-prefernce-name-text">
                                <p>10</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Previous Schools</h2>
                            </div>
                            <!-- <div class="teacher-prefernce-name-text">
                                <p>10</p>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div class="teacher-health-second-sec">
                    <div>
                        <div class="details-heading">
                            <h2>Health</h2>
                            <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </div>

                        <!-- <div class="about-school-section"> -->
                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Occupational Health</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>No assessment necessary</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Health Issues</h2>
                            </div>
                            <!-- <div class="teacher-prefernce-name-text">
                                <p>51.5742105</p>
                                <p>-0.1434667</p>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="teacher-prefernce-heading-text">
                                <h2>Health Decoration Date</h2>
                            </div>
                            <div class="teacher-prefernce-name-text">
                                <p>24-05-2016</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection