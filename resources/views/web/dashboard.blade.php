@extends('web.layout')
@section('content')
    <div class="tab-content dashboard-tab-content" id="myTabContent">
        <div>
            <h2>Home</h2>
            <div class="total-sec">
                <div class="first-sec">
                    <div class="left-sidebar-section">
                        <div class="date-sec">
                            <span>Week Beginning</span>
                            <div class="date-text">
                                <i class="fa-solid fa-caret-left"></i>
                                <h2>Mon 31 Oct 2022</h2><i class="fa-solid fa-caret-right"></i>
                            </div>
                        </div>
                        <div class="sidebar-sec">
                            <div class="sidebar-data">
                                <h2>211</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Days this Week</span>
                            </div>
                        </div>

                        <div class="sidebar-sec">
                            <div class="sidebar-data2">
                                <h2>43</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Teachers Working</span>
                            </div>
                        </div>

                        <div class="sidebar-sec">
                            <div class="sidebar-data3">
                                <h2>19</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Schools Using</span>
                            </div>
                        </div>
                        <div class="price-sec">
                            <span>Predicted GP (this week)</span>
                            <h2>&#163 8,708.94</h2>
                            <span>Billed That Week</span>
                            <h2>&#163 0.00</h2>
                            <span>Invoices This Week</span>
                            <h2>&#163 0.00</h2>
                        </div>
                    </div>
                </div>
                <div class="second-sec assignment-col">
                    <div class="assignment-status-sec">
                        <h2>{{ count($latestAssignment) }} - Latest Assignments</h2>
                        {{-- <span>Double click to open the assignment</span> --}}
                    </div>

                    <table class="table assignment-status-table" id="myTable">
                        <thead>
                            <tr class="table-heading">
                                <th>School</th>
                                <th>Status</th>
                                <th>Profession</th>
                                <th>Candidate</th>
                                <th>Days</th>
                            </tr>
                        </thead>
                        <tbody class="table-body-sec">
                            @foreach ($latestAssignment as $key => $Assignment)
                                <tr class="table-data">
                                    <td>{{ $Assignment->schooleName }}</td>
                                    <td>
                                        @if ($Assignment->status_int == 3)
                                            Complete
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>{{ $Assignment->positionAppliedFor_txt }}</td>
                                    <td>{{ $Assignment->techerFirstname }} {{ $Assignment->techerSurname }}</td>
                                    <td>{{ $Assignment->totalDay }} Days</td>
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
