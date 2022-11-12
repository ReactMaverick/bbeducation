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
                    <div class="teacher-list-section">
                        <div class="school-teacher-heading-text">
                            <h2>Teachers</h2>
                        </div>
                        <div class="school-teacher-list-heading">

                            <div class="school-assignment-contact-icon-sec">
                                <a href="#"><i class="fa-solid fa-xmark"></i></a>
                                <a href="#"><i class="fa-solid fa-plus"></i></a>
                                <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="teacher-list-right-sec">
                        <div class="teacher-list-page-table">
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
                                        <td>School Main</td>
                                        <td>School Main</td>
                                        <td>020 8359 7744</td>
                                    </tr>

                                    <tr class="school-detail-table-data">
                                        <td>School Main</td>
                                        <td>School Main</td>
                                        <td>020 8359 7744</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="preferred-list-sec">
                            <div class="form-check list-form-check">
                                <input type="radio" id="html" name="fav_language" value="HTML">
                                <label for="html">Preferred</label>
                            </div>
                            <div class="form-check list-form-check">
                                <input type="radio" id="html" name="fav_language" value="HTML">
                                <label for="html">Rejected</label>
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