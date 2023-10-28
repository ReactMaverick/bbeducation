{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
@section('content')
    <div class="tab-content assignment-tab-content" id="myTabContent">
        <div class="container-fluid my_container-fluid">

            <div class="row pt-3">
                <div class="col-lg-1"></div>

                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ count($openAssignmentList) }}</h3>
                            <p>Open Assignments</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ count($closeAssignmentList) }}</h3>
                            <p>Closed Assignments</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner text-white">
                            <h3>{{ count($pendingAssignmentList) }}</h3>
                            <p>Pending Assignments</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ count($completeAssignmentList) }}</h3>
                            <p>Completed Assignments</p>
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
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ count($allAssignmentList) }}</h3>
                            <p>All Assignments</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-receipt"></i>

                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-1"></div>
            </div>

            <div class="col-md-12 topbar-sec pt-0">
                <div class="total-sec">
                    <div class="second-sec assignment-col sec_box_edit">
                        <div class="assignment-status-sec details-heading">
                            <h2>Assignment</h2>
                            <div class="checkbox-field">
                                <label for="includeAll">Include All</label>
                                <input type="checkbox" id="includeAll" name="include" value="1" <?php
                                echo app('request')->input('include') == 1 ? 'checked' : ''; ?>>
                            </div>
                        </div>

                        <div class="assignment-candidate-table-section">
                            <table class="table table-bordered table-striped" id="myTable">
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
                                        <th>Pay</th>
                                        <th>Charge</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($assignmentList as $key => $Assignment)
                                        <tr class="table-data" onclick="assignmentDetail({{ $Assignment->asn_id }})">
                                            <td>{{ $Assignment->schooleName }}</td>
                                            <td>{{ $Assignment->yearGroup }}</td>
                                            <td>{{ $Assignment->assignmentStatus }}</td>
                                            <td>{{ $Assignment->teacherProfession }}</td>
                                            <td>{{ $Assignment->assignmentType }}</td>
                                            <td>{{ $Assignment->daysThisWeek }} Days</td>
                                            <td>
                                                @if ($Assignment->techerFirstname || $Assignment->techerSurname)
                                                    {{ $Assignment->techerFirstname }} {{ $Assignment->techerSurname }}
                                                @else
                                                    No teacher
                                                @endif
                                            </td>
                                            <td>
                                                @if ($Assignment->asnStartDate_dte)
                                                    {{ date('d-m-Y', strtotime($Assignment->asnStartDate_dte)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($Assignment->asnStartDate_dte)
                                                    {{ date('l', strtotime($Assignment->asnStartDate_dte)) }}
                                                @endif
                                            </td>
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
                // ordering: false,
                pageLength: 25,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        function assignmentDetail(asn_id) {
            window.location.href = "{{ URL::to('/assignment-details') }}" + '/' + asn_id;
        }

        $(document).on('change', '#includeAll', function() {
            if ($(this).is(":checked")) {
                filtering(1);
            } else {
                filtering('');
            }
        });

        function filtering(include) {
            //alert(sort_val);
            var qUrl = ""
            var current_url = window.location.href;
            var base_url = current_url.split("?")[0];
            var hashes = current_url.split("?")[1];
            var hash = hashes.split('&');
            for (var i = 0; i < hash.length; i++) {
                params = hash[i].split("=");
                if (params[0] == 'include') {
                    params[1] = include;
                }
                paramJoin = params.join("=");
                qUrl = "" + qUrl + paramJoin + "&";
            }
            if (qUrl != '') {
                qUrl = qUrl.substr(0, qUrl.length - 1);
            }

            var joinUrl = base_url + "?" + qUrl
            //alert("My favourite sports are: " + joinUrl);
            window.location.assign(joinUrl);
        }
    </script>
@endsection
