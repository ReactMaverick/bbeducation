@extends('web.layout')
@section('content')
    <div class="tab-content assignment-tab-content" id="myTabContent">
        <div>

            <div class="assignment-section-col">
                <div class="assignment-page-sec">
                    <h2>Assignment</h2>
                    <!-- <div class="checkbox-field">
                                        <label for="vehicle1">Include All</label><input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    </div> -->
                </div>

                <table class="table assignment-page-table" id="myTable">
                    <thead>
                        <tr class="table-heading">
                            <th>School For</th>
                            <th>Year Group</th>
                            <th>Status</th>
                            <th>Profession</th>
                            <th>Type</th>
                            <th>Days</th>
                            <th>Teacher</th>
                            <th>Date</th>
                            <th>Weekday</th>
                        </tr>
                    </thead>
                    <tbody class="table-body-sec">
                        @foreach ($assignmentList as $key => $Assignment)
                            <tr class="table-data">
                                <td>{{ $Assignment->schooleName }}</td>
                                <td>{{ $Assignment->yearGroup }}</td>
                                <td>{{ $Assignment->assignmentStatus }}</td>
                                <td>{{ $Assignment->teacherProfession }}</td>
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
        </div>
        <div class="assignment-first-sec">
            <div class="assignment-left-sidebar-section">
                <div class="sidebar-sec">
                    <div class="assignment-sidebar-data">
                        <h2>29</h2>
                    </div>
                    <div class="sidebar-sec-text">
                        <span>Open Assignments</span>
                    </div>
                </div>

                <div class="sidebar-sec">
                    <div class="assignment-sidebar-data3">
                        <h2>218</h2>
                    </div>
                    <div class="sidebar-sec-text">
                        <span>Closed Assignments</span>
                    </div>
                </div>

                <div class="sidebar-sec">
                    <div class="assignment-sidebar-data2">
                        <h2>4</h2>
                    </div>
                    <div class="sidebar-sec-text">
                        <span>Pending Assignments</span>
                    </div>
                </div>

                <div class="sidebar-sec">
                    <div class="assignment-sidebar-data4">
                        <h2>2641</h2>
                    </div>
                    <div class="sidebar-sec-text">
                        <span>Completed Assignments</span>
                    </div>
                </div>

                <div class="sidebar-sec">
                    <div class="assignment-sidebar-data3">
                        <h2>2895</h2>
                    </div>
                    <div class="sidebar-sec-text">
                        <span>All Assignments</span>
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
