@extends('web.layout')
@section('content')
    <div class="tab-content dashboard-tab-content" id="myTabContent">
        <div class="assignment-section-col">

            <div class="teacher-all-section">
                <div class="teacher-section">
                    <div class="teacher-page-sec">
                        <h2>Teachers</h2>
                    </div>
                    <div class="teacher-left-sec">
                        <div class="about-teacher">
                            <a href="#"> <i class="fa-solid fa-magnifying-glass"></i>
                                <p>Find Teacher</p>
                            </a>
                        </div>

                        <div class="about-teacher">
                            <a href="#"> <i class="fa-regular fa-calendar-days"></i>
                                <p>Teacher</p>
                                <p>Calendar</p>
                            </a>
                        </div>

                        <div class="about-teacher">
                            <a href="#"> <i class="fa-solid fa-user"></i>
                                <p>New Teacher</p>
                            </a>
                        </div>

                        <div class="about-teacher">
                            <a href="#"> <i class="fa-solid fa-file-lines"></i>
                                <p>Pending</p>
                                <p>Documents</p>
                            </a>
                        </div>

                        <div class="about-teacher">
                            <a href="#"> <i class="fa-regular fa-file-lines"></i>
                                <p>Pending</p>
                                <p>References</p>
                            </a>
                        </div>
                    </div>



                </div>

                <div class="teacher-page-table-section">
                    <table class="table teacher-page-table" id="myTable">
                        <thead>
                            <tr class="table-heading">

                                <th><i class="fa-solid fa-star">Favourites</i></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-body-sec">
                            @foreach ($fabTeacherList as $key => $fabTeacher)
                                <tr class="table-data">
                                    <td>
                                        @if ($fabTeacher->knownAs_txt == '' || $fabTeacher->knownAs_txt == null)
                                            {{ $fabTeacher->firstName_txt }} {{ $fabTeacher->surname_txt }}
                                        @else
                                            {{ $fabTeacher->knownAs_txt }} {{ $fabTeacher->surname_txt }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($fabTeacher->contactTeacherId == null || $fabTeacher->contactTeacherId == '')
                                            No Contact
                                        @else
                                            {{ date('d-m-Y', strtotime($fabTeacher->lastContact_dte)) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
