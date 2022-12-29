@extends('web.layout')
@section('content')
    <div class="tab-content assignment-tab-content" id="myTabContent">
        <div>

            <div class="assignment-section-col">
                <div class="assignment-page-sec">
                    <h2>Assignment</h2>
                    <div class="checkbox-field">
                        <label for="includeAll">Include All</label>
                        <input type="checkbox" id="includeAll" name="include" value="1" <?php
                        echo app('request')->input('include') == 1 ? 'checked' : ''; ?>>
                    </div>
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
                            <tr class="table-data" onclick="assignmentDetail({{ $Assignment->asn_id }})">
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
                                    @if ($Assignment->asnStartDate_dte)
                                        {{ date('d-m-Y', strtotime($Assignment->asnStartDate_dte)) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($Assignment->asnStartDate_dte)
                                        {{ date('l', strtotime($Assignment->asnStartDate_dte)) }}
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
                <div class="assignment-sidebar-sec">
                    <div class="assignment-sidebar-data">
                        <h2>{{ count($openAssignmentList) }}</h2>
                    </div>
                    <div class="assignment-sidebar-sec-text">
                        <span>Open Assignments</span>
                    </div>
                </div>

                <div class="assignment-sidebar-sec">
                    <div class="assignment-sidebar-data3">
                        <h2>{{ count($closeAssignmentList) }}</h2>
                    </div>
                    <div class="assignment-sidebar-sec-text">
                        <span>Closed Assignments</span>
                    </div>
                </div>

                <div class="assignment-sidebar-sec">
                    <div class="assignment-sidebar-data2">
                        <h2>{{ count($pendingAssignmentList) }}</h2>
                    </div>
                    <div class="assignment-sidebar-sec-text">
                        <span>Pending Assignments</span>
                    </div>
                </div>

                <div class="assignment-sidebar-sec">
                    <div class="assignment-sidebar-data4">
                        <h2>{{ count($completeAssignmentList) }}</h2>
                    </div>
                    <div class="assignment-sidebar-sec-text">
                        <span>Completed Assignments</span>
                    </div>
                </div>

                <div class="assignment-sidebar-sec">
                    <div class="assignment-sidebar-data3">
                        <h2>{{ count($allAssignmentList) }}</h2>
                    </div>
                    <div class="assignment-sidebar-sec-text">
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
