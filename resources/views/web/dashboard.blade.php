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
                                <a
                                    href="{{ URL::to('/dashboard?date=' . date('Y-m-d', strtotime($weekStartDate . ' -7 days'))) }}"><i
                                        class="fa-solid fa-caret-left"></i></a>
                                <h2>{{ date('D d M Y', strtotime($weekStartDate)) }}</h2>
                                <a
                                    href="{{ URL::to('/dashboard?date=' . date('Y-m-d', strtotime($weekStartDate . ' +7 days'))) }}"><i
                                        class="fa-solid fa-caret-right"></i></a>
                            </div>
                        </div>
                        <div class="sidebar-sec">
                            <div class="sidebar-data">
                                {{-- <h2>{{ number_format((float)$sideBarData[0]->daysThisWeek, 1, '.', '') }}</h2> --}}
                                <h2>{{ number_format((float) $asnSubquery->daysThisPeriod_dec, 1, '.', '') }}</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Days this Week</span>
                            </div>
                        </div>

                        <div class="sidebar-sec">
                            <div class="sidebar-data2">
                                {{-- <h2>{{ $sideBarData[0]->teachersWorking }}</h2> --}}
                                <h2>{{ $asnSubquery->teachersWorking_int }}</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Teachers Working</span>
                            </div>
                        </div>

                        <div class="sidebar-sec">
                            <div class="sidebar-data3">
                                {{-- <h2>{{ $sideBarData[0]->schoolsUsing }}</h2> --}}
                                <h2>{{ $asnSubquery->schoolsUsing_int }}</h2>
                            </div>
                            <div class="sidebar-sec-text">
                                <span>Schools Using</span>
                            </div>
                        </div>
                        <div class="price-sec">
                            <span>Predicted GP (this week)</span>
                            {{-- <h2>&#163 {{ number_format((float)$sideBarData[0]->predictedGP, 1, '.', '') }}</h2> --}}
                            <h2>&#163 {{ number_format((float) $asnSubquery->predictedGP_dec, 1, '.', '') }}</h2>
                            <span>Billed That Week</span>
                            <h2>&#163 {{ $billedSubquery->actualBilled_dec }}</h2>
                            <span>Invoices This Week</span>
                            <h2>&#163 {{ $invoiceSubquery->actualGP_dec }}</h2>
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
                                <tr class="table-data" onclick="assignmentDetail({{ $Assignment->asn_id }})">
                                    <td>{{ $Assignment->schooleName }}</td>
                                    <td>
                                        {{ $Assignment->assignmentStatus }}
                                    </td>
                                    <td>{{ $Assignment->teacherProfession }}</td>
                                    <td>{{ $Assignment->techerFirstname }} {{ $Assignment->techerSurname }}</td>
                                    <td>{{ $Assignment->daysThisWeek }} Days</td>
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
            $('#myTable').DataTable({
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy',
                //     'excel',
                //     'csv',
                //     'pdf',
                //     'print'
                // ],
            });
        });

        function assignmentDetail(asn_id) {
            window.location.href = "{{ URL::to('/assignment-details') }}" + '/' + asn_id;
        }
    </script>
@endsection
