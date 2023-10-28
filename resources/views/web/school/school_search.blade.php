{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
@section('content')
    <style>
        .row.srj_row .dataTables_wrapper.dt-bootstrap4.no-footer {
            padding: 15px 0px;
        }
    </style>
    <div class="tab-content assignment-tab-content" id="myTabContent">
        <div class="container-fluid my_container-fluid">

            <div class="col-md-12 topbar-sec pt-4">
                <div class="total-sec">

                    <div class="assignment-section-col sec_box_edit">
                        <div class="assignment-page-sec details-heading">
                            <h2>School Search</h2>
                        </div>

                        <div class="sec_body dataTables_wrapper">
                            <div class="row srj_row">
                                <div class="col-md-12 col-sm-12 col-lg-9 col-xl-9 pr-3">

                                    <div class="school-search-section">
                                        <div class="school-search-field">
                                            <input type="text" class="form-control" id="searchKey" name="searchKey"
                                                value="{{ app('request')->input('search_input') }}">
                                            <button type="submit" class="btn btn-success school-search-btn"
                                                id="normalSearchBtn">Search</button>
                                            <a href="{{ URL::to('/school-search') }}"><i class="fas fa-sync-alt"></i></a>
                                        </div>
                                    </div>
                                    <div class="assignment-candidate-table-section">
                                        <table class="table table-bordered table-striped p-0" id="myTable">
                                            <thead>
                                                <tr class="table-heading">
                                                    <th>Name</th>
                                                    <th>Age Range</th>
                                                    <th>Type</th>
                                                    <th>LA/Borough</th>
                                                    <th>Days</th>
                                                    <th>Last Contact</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body-sec">
                                                @foreach ($schoolList as $key => $school)
                                                    <tr class="table-data">
                                                        <td onclick="schoolDetail({{ $school->school_id }})">
                                                            {{ $school->name_txt }}</td>
                                                        <td onclick="schoolDetail({{ $school->school_id }})">
                                                            {{ $school->ageRange_txt }}
                                                        </td>
                                                        <td onclick="schoolDetail({{ $school->school_id }})">
                                                            {{ $school->type_txt }}</td>
                                                        <td onclick="schoolDetail({{ $school->school_id }})">
                                                            {{ $school->laName_txt }}</td>
                                                        <td onclick="schoolDetail({{ $school->school_id }})">
                                                            {{ $school->days_dec }}</td>
                                                        <td onclick="schoolDetail({{ $school->school_id }})">
                                                            @if ($school->lastContact_dte != 0)
                                                                {{ date('d-m-Y', strtotime($school->lastContact_dte)) }}
                                                            @endif
                                                        </td>
                                                        <td onclick="addAssignment({{ $school->school_id }})"
                                                            title="Add New Assignment">
                                                            <a style="cursor: pointer" class="icon_all"><i
                                                                    class="fas fa-plus-circle"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-3 col-sm-12 col-xl-3 advance-search-col">
                                    <div class="search-form-button">
                                        <button class="btn btn-outline-cool" id="advanceSearch">Advance Search</button>
                                    </div>
                                    <form action="{{ url('/school-search') }}" method="get" id="advanceSearchForm">
                                        @csrf
                                        <input type="hidden" name="search" value="true">
                                        <input type="hidden" name="advance_search" id="advance_search"
                                            value="{{ app('request')->input('advance_search') }}">
                                        <input type="hidden" name="search_input" id="search_input">
                                        <div class="advance-search-filter-section rounded" id="advanceSearchDiv"
                                            style="<?php if (app('request')->input('advance_search') == 'true') {
                                                echo 'display: block;';
                                            } else {
                                                echo 'display: none;';
                                            } ?>">

                                            <div class="form-group filter-form-group">
                                                <label for="ageRangeId">Age Range</label>
                                                <select class="form-control select2" name="ageRangeId" id="ageRangeId"
                                                    style="width: 100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($ageRangeList as $key1 => $ageRange)
                                                        <option value="{{ $ageRange->description_int }}"
                                                            @if (app('request')->input('ageRangeId') == $ageRange->description_int) selected @endif>
                                                            {{ $ageRange->description_txt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group filter-form-group">
                                                <label for="schoolTypeId">School Type</label>
                                                <select class="form-control select2" name="schoolTypeId" id="schoolTypeId"
                                                    style="width: 100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($schoolTypeList as $key2 => $schoolType)
                                                        <option value="{{ $schoolType->description_int }}"
                                                            @if (app('request')->input('schoolTypeId') == $schoolType->description_int) selected @endif>
                                                            {{ $schoolType->description_txt }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group filter-form-group">
                                                <label for="laId">Local Authority/Borough</label>
                                                <select class="form-control select2" name="laId" id="laId"
                                                    style="width: 100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($laBoroughList as $key3 => $laBorough)
                                                        <option value="{{ $laBorough->la_id }}"
                                                            @if (app('request')->input('laId') == $laBorough->la_id) selected @endif>
                                                            {{ $laBorough->laName_txt }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="last-contact-text">
                                                <span>Last Contact</span>
                                            </div>
                                            <div class="row filter-row">
                                                <div class="col-md-6">
                                                    <div class="form-check filter-radio-field">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="lastContactRadio" value="Before"
                                                                @if (app('request')->input('lastContactRadio') == 'Before') checked @endif>
                                                            <span class="radio-text">Before</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-check filter-radio-field">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="lastContactRadio" value="After"
                                                                @if (app('request')->input('lastContactRadio') == 'After') checked @endif>
                                                            <span class="radio-text">After</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="field-input-field">
                                                <input type="date" class="form-control" name="lasContactDate"
                                                    id="lasContactDate"
                                                    value="{{ app('request')->input('lasContactDate') }}">
                                            </div>


                                            <div class="last-contact-text">
                                                <span>Days Booked</span>
                                            </div>

                                            <div class="row filter-row">
                                                <div class="col-md-6">
                                                    <div class="form-check filter-radio-field">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="dayBookedRadio" value="More"
                                                                @if (app('request')->input('dayBookedRadio') == 'More') checked @endif>
                                                            <span class="radio-text">More than</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-check filter-radio-field">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="dayBookedRadio" value="Less"
                                                                @if (app('request')->input('dayBookedRadio') == 'Less') checked @endif>
                                                            <span class="radio-text">Less than</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="field-input-field">
                                                <input type="number" class="form-control" name="booked_day"
                                                    id="booked_day" value="{{ app('request')->input('booked_day') }}">
                                            </div>

                                            <div class="school-search-btn-section">
                                                <button type="button"
                                                    class="btn btn-info save-result-btn schoolSearchBtn"
                                                    id="advanceSearchBtn">Search</button>

                                                {{-- <button type="button" class="btn btn-primary save-result-btn">Save
                                                    Results as
                                                    Mailshot
                                                    List</button> --}}
                                            </div>


                                        </div>
                                    </form>

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
            $('#myTable').DataTable({
                // paging: false,
                // ordering: false,
                info: false,
                searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });

            // $('#advanceSearchDiv').css('display', 'none');
            $("#searchKey").focus();
        });

        function schoolDetail(school_id) {
            window.location.href = "{{ URL::to('/school-detail') }}" + '/' + school_id;
        }

        $(document).on('click', '#advanceSearch', function() {
            $('#search_input').val('');
            $('#ageRangeId').val('');
            $('#schoolTypeId').val('');
            $('#laId').val('');
            $('#lasContactDate').val('');
            $('#booked_day').val('');
            $('input[type=radio][name=lastContactRadio]').prop('checked', false);
            $('input[type=radio][name=dayBookedRadio]').prop('checked', false);

            if ($("#advanceSearchDiv").is(":visible")) {
                $('#advanceSearchDiv').css('display', 'none');
            } else {
                $('#advanceSearchDiv').css('display', 'block');
            }
        });

        $(document).on('click', '#normalSearchBtn', function() {
            var searchKey = $('#searchKey').val();
            $('#search_input').val(searchKey);
            $("#advanceSearchForm").submit();
        });
        $(document).on('click', '#advanceSearchBtn', function() {
            var searchKey = $('#searchKey').val();
            $('#search_input').val(searchKey);
            $('#advance_search').val('true');
            $("#advanceSearchForm").submit();
        });

        $(document).on('keypress', '#searchKey', function(e) {
            var key = e.which;
            if (key == 13) {
                var searchKey = $('#searchKey').val();
                $('#search_input').val(searchKey);
                $("#advanceSearchForm").submit();
            }
        });

        function addAssignment(school_id) {
            if (school_id) {
                swal({
                        title: "",
                        text: "This will create an assignment tied to the select school.",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('createNewAssignment') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        school_id: school_id
                                    },
                                    success: function(data) {
                                        if (data) {
                                            if (data.login == 'yes') {
                                                if (data.asn_id) {
                                                    window.location.href =
                                                        "{{ URL::to('/assignment-details') }}" + '/' + data
                                                        .asn_id;
                                                }
                                            } else {
                                                window.location.href = "{{ URL::to('/') }}";
                                            }
                                        }
                                    }
                                });
                        }
                    });
            }
        }
    </script>
@endsection
