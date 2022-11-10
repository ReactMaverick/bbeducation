@extends('web.layout')
@section('content')
    <div class="tab-content dashboard-tab-content" id="myTabContent">
        <div class="assignment-section-col">

            <div class="teacher-all-section">
                <div class="teacher-section">
                    <div class="teacher-page-sec">
                        <h2>Schools</h2>
                    </div>
                    <div class="teacher-left-sec">
                        <div class="about-teacher">
                            <a href="{{ URL::to('/school-search') }}"> <i class="fa-solid fa-magnifying-glass"></i>
                                <p>Find School</p>
                            </a>
                        </div>

                        <div class="about-teacher">
                            <a href="#"> <i class="fa-solid fa-school-circle-check"></i>
                                <p>Add New</p>
                                <p>School</p>
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
                            @foreach ($fabSchoolList as $key => $fabSchool)
                                <tr class="table-data" onclick="schoolDetail()">
                                    <td>{{ $fabSchool->name_txt }}</td>
                                    <td>
                                        @if ($fabSchool->contactSchoolId == null || $fabSchool->contactSchoolId == '')
                                            No Contact
                                        @else
                                            {{ date('d-m-Y', strtotime($fabSchool->lastContact_dte)) }}
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

        function schoolDetail(){
            window.location.href = "{{ URL::to('/school-detail') }}";
        }
    </script>
@endsection
