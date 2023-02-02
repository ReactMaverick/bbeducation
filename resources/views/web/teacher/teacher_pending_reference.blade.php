@extends('web.layout')
@section('content')
    <div class="tab-content assignment-tab-content">

        <div class="school-assignment-sec">
            <div class="teacher-pending-reference-section">
                <div class="assignment-finance-heading-section">
                    <h2>Refernces</h2>
                    <div class="assignment-finance-icon-section">
                        <a href="#"><i class="fa-solid fa-envelope"></i></a>
                        <a style="cursor: pointer" class="disabled-link" id="editContactItemBttn">
                            <i class="fa-solid fa-pencil school-edit-icon"></i>
                        </a>
                    </div>

                </div>
                <div class="assignment-finance-table-section">
                    <table class="table school-detail-page-table" id="myTable">
                        <thead>
                            <tr class="school-detail-table-heading">
                                <th>Teacher</th>
                                <th>Employer</th>
                                <th>Date From</th>
                                <th>Date Until</th>
                                <th>Ref. Sent</th>
                                <th>No.</th>
                                <th>Days Over</th>
                            </tr>
                        </thead>
                        <tbody class="table-body-sec">
                            @foreach ($pendingRefList as $key => $pendingRef)
                                <tr class="school-detail-table-data">
                                    <td>
                                        @if ($pendingRef->knownAs_txt == null || $pendingRef->knownAs_txt == '')
                                            {{ $pendingRef->firstName_txt . ' ' . $pendingRef->surname_txt }}
                                        @else
                                            {{ $pendingRef->firstName_txt . ' (' . $pendingRef->knownAs_txt . ') ' . $pendingRef->surname_txt }}
                                        @endif
                                    </td>
                                    <td>{{ $pendingRef->employer_txt }}</td>
                                    <td>{{ $pendingRef->employedFrom_dte?date('d-m-Y', strtotime($pendingRef->employedFrom_dte)):'' }}</td>
                                    <td>{{ $pendingRef->employedUntil_dte?date('d-m-Y', strtotime($pendingRef->employedUntil_dte)):'' }}</td>
                                    <td>{{ $pendingRef->lastSent_txt }}</td>
                                    <td>{{ $pendingRef->totalSent_int }}</td>
                                    <td>{{ $pendingRef->overDueDays_int }}</td>
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
