{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
@section('content')
    <div class="tab-content dashboard-tab-content" id="myTabContent">
        <div class="container-fluid my_container-fluid">
            <div class="row pt-3 justify-content-center content-header date_sec">
                <div class="col-lg-3 text-center">
                    <div class="date_area">
                        <div class="date-sec">
                            <span>Week Beginning</span>
                        </div>
                        <div class="date-text">
                            <a
                                href="{{ URL::to('/dashboard?date=' . date('Y-m-d', strtotime($weekStartDate . ' -7 days'))) }}"><i
                                    class="fas fa-caret-left"></i></a>
                            <h2>{{ date('D d M Y', strtotime($weekStartDate)) }}</h2>
                            <a
                                href="{{ URL::to('/dashboard?date=' . date('Y-m-d', strtotime($weekStartDate . ' +7 days'))) }}"><i
                                    class="fas fa-caret-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format((float) $asnSubquery->daysThisPeriod_dec, 1, '.', '') }}</h3>
                            <p>Days this Week</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $asnSubquery->teachersWorking_int }}</h3>
                            <p>Teachers Working</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner text-white">
                            <h3>{{ $asnSubquery->schoolsUsing_int }}</h3>
                            <p>Schools Using</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-school"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>&#163 {{ number_format((float) $asnSubquery->predictedGP_dec, 2, '.', ',') }}</h3>
                            <p>Predicted GP (this week)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-check"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>&#163 {{ number_format((float) $billedSubquery->actualBilled_dec, 2, '.', ',') }}</h3>
                            <p>Billed That Week</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-receipt"></i>

                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>&#163 {{ number_format((float) $invoiceSubquery->actualGP_dec, 2, '.', ',') }}</h3>
                            <p>Invoices This Week</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="col-md-12 topbar-sec">
                <div class="total-sec">

                    <div class="second-sec assignment-col sec_box_edit">
                        <div class="assignment-status-sec details-heading">
                            <h2>{{ count($latestAssignment) }} - Latest Assignments</h2>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable dtr-inline collapsed" id="myTable">
                                <thead>
                                    <tr class="table-heading">
                                        <th>School</th>
                                        <th>Status</th>
                                        <th>Profession</th>
                                        <th>Candidate</th>
                                        <th>Days</th>
                                        <th>Pay</th>
                                        <th>Charge</th>
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
                                            <td>{{ $Assignment->cost_dec }}</td>
                                            <td>{{ $Assignment->charge_dec }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: false,
                pageLength: 25
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
