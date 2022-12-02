@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.school.school_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.school.school_header')

                <div class="school-assignment-sec">
                    <div class="school-assignment-section">
                        <div class="teacher-list-section">
                            <div class="school-teacher-heading-text">
                                <h2>Teachers</h2>
                            </div>
                            <div class="school-teacher-list-heading">

                                <div class="school-assignment-contact-icon-sec">
                                    <a href="#"><i class="fa-solid fa-xmark"></i></a>
                                    <a href="#"><i class="fa-solid fa-plus"></i></a>
                                    <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-list-right-sec">
                            <div class="teacher-list-page-table">
                                <table class="table school-detail-page-table" id="myTable">
                                    <thead>
                                        <tr class="school-detail-table-heading">
                                            <th>Teacher ID</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Days Worked</th>
                                            <th>Pref/Reject</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body-sec">
                                        @foreach ($teacherList as $key => $teacher)
                                            <tr class="school-detail-table-data">
                                                <td>{{ $teacher->teacher_id }}</td>
                                                <td>
                                                    @if ($teacher->knownAs_txt == null || $teacher->knownAs_txt == '')
                                                        {{ $teacher->firstName_txt . ' ' . $teacher->surname_txt }}
                                                    @else
                                                        {{ $teacher->firstName_txt . ' (' . $teacher->knownAs_txt . ') ' . $teacher->surname_txt }}
                                                    @endif
                                                </td>
                                                <td>{{ $teacher->status_txt }}</td>
                                                <td>{{ $teacher->daysWorked_dec }}</td>
                                                <td>
                                                    @if ($teacher->rejectOrPreferred_int == 1)
                                                        {{ 'Preferred' }}
                                                    @elseif ($teacher->rejectOrPreferred_int == 2)
                                                        {{ 'Rejected' }}
                                                    @else
                                                        {{ '' }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="preferred-list-sec">
                                <div class="form-check list-form-check">
                                    <input type="radio" id="AllId" name="rejectOrPreferred" value="all" <?php
                                    echo app('request')->input('status') == 'all' ? 'checked' : ''; ?> >
                                    <label for="AllId">All</label>
                                </div>
                                <div class="form-check list-form-check">
                                    <input type="radio" id="PreferredId" name="rejectOrPreferred" value="preferred" <?php
                                    echo app('request')->input('status') == 'preferred' ? 'checked' : ''; ?> >
                                    <label for="PreferredId">Preferred</label>
                                </div>
                                <div class="form-check list-form-check">
                                    <input type="radio" id="RejectedId" name="rejectOrPreferred" value="rejected" <?php
                                    echo app('request')->input('status') == 'rejected' ? 'checked' : ''; ?> >
                                    <label for="RejectedId">Rejected</label>
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

            $('input[type=radio][name=rejectOrPreferred]').change(function() {
                var status = this.value;
                var qUrl = ""
                var current_url = window.location.href;
                var base_url = current_url.split("?")[0];
                var hashes = current_url.split("?")[1];
                var hash = hashes.split('&');
                for (var i = 0; i < hash.length; i++) {
                    params = hash[i].split("=");
                    if (params[0] == 'status') {
                        params[1] = status;
                    }
                    paramJoin = params.join("=");
                    qUrl = "" + qUrl + paramJoin + "&";
                }
                if (qUrl != '') {
                    qUrl = qUrl.substr(0, qUrl.length - 1);
                }
                var joinUrl = base_url + "?" + qUrl;
                window.location.assign(joinUrl);
            });
        });
    </script>
@endsection
