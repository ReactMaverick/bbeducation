@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.school.school_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.school.school_header')

                <div class="school-assignment-sec">


                    <div class="school-assignment-section">
                        <div class="school-assignment-contact-heading-text">
                            <h2>Assignments</h2>
                        </div>
                        <div class="school-assignment-contact-heading">

                            {{-- <div class="school-assignment-contact-icon-sec">
                            <a href="#"><i class="fa-solid fa-xmark"></i></a>
                            <a href="#"><i class="fa-solid fa-plus"></i></a>
                            <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                        </div> --}}
                        </div>



                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Year Group</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Days</th>
                                    <th>Teacher</th>
                                    <th>Date</th>
                                    <th>Weekday</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <?php $completeCount = 0; ?>
                                @foreach ($assignmentList as $key => $Assignment)
                                    @if ($Assignment->assignmentStatus == 'Completed')
                                        <?php $completeCount += 1; ?>
                                    @endif
                                    <tr class="table-data" onclick="assignmentDetail()">
                                        <td>{{ $Assignment->yearGroup }}</td>
                                        <td>{{ $Assignment->assignmentStatus }}</td>
                                        <td>{{ $Assignment->assignmentType }}</td>
                                        <td>{{ $Assignment->dayPercent_dec }} {{ $Assignment->type_txt }}</td>
                                        <td>
                                            @if ($Assignment->techerFirstname || $Assignment->techerSurname)
                                                {{ $Assignment->techerFirstname }} {{ $Assignment->techerSurname }}
                                            @else
                                                No teacher
                                            @endif
                                        </td>
                                        <td>
                                            @if ($Assignment->createdOn_dtm)
                                                {{ date('d-m-Y', strtotime($Assignment->createdOn_dtm)) }}
                                            @else
                                                {{ date('d-m-Y', strtotime($Assignment->timestamp_ts)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($Assignment->createdOn_dtm)
                                                {{ date('l', strtotime($Assignment->createdOn_dtm)) }}
                                            @else
                                                {{ date('l', strtotime($Assignment->timestamp_ts)) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                    <div class="assignment-first-sec">
                        <div class="assignment-left-sidebar-section">
                            <div class="school-assignment-sidebar-sec">
                                <div class="assignment-sidebar-data">
                                    <h2>{{ $completeCount }}</h2>
                                </div>
                                <div class="school-assignment-sidebar-sec-text">
                                    <span>Completed Assignments</span>
                                </div>
                            </div>
                            <div class="school-assignment-sidebar-sec">
                                <div class="assignment-sidebar-data2">
                                    <h2>4</h2>
                                </div>
                                <div class="school-assignment-sidebar-sec-text">
                                    <span>Total Days</span>
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

        function assignmentDetail() {
            window.location.href = "{{ URL::to('/assignment-details') }}";
        }
    </script>
@endsection
