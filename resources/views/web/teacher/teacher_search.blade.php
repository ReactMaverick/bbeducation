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
                            <h2>Teacher Search</h2>
                        </div>
                        <div class="sec_body dataTables_wrapper">
                            <div class="row srj_row">
                                <div class="col-md-12 col-sm-12 col-lg-9 col-xl-9 pr-3">

                                    <div class="school-search-section">
                                        <div class="school-search-field">
                                            <input type="text" class="form-control srj_formInput" id="searchKey"
                                                name="searchKey" value="{{ app('request')->input('search_input') }}">
                                            <button type="submit" class="btn btn-success school-search-btn"
                                                id="normalSearchBtn">Search</button>
                                            <a href="{{ URL::to('/candidate-search') }}"><i class="fas fa-sync-alt"></i></a>
                                        </div>

                                    </div>
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped table-hover dataTable dtr-inline collapsed p-0"
                                            id="myTable">
                                            <thead>
                                                <tr class="table-heading">
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>App Status</th>
                                                    <th>Days</th>
                                                    <th>Last Contact</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body-sec">
                                                @foreach ($teacherList as $key => $teacher)
                                                    <tr class="table-data"
                                                        onclick="teacherDetail({{ $teacher->teacher_id }})">
                                                        <td>
                                                            @if ($teacher->knownAs_txt == null && $teacher->knownAs_txt == '')
                                                                {{ $teacher->firstName_txt . ' ' . $teacher->surname_txt }}
                                                            @else
                                                                {{ $teacher->firstName_txt . ' (' . $teacher->knownAs_txt . ') ' . $teacher->surname_txt }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $teacher->professionalType_txt . ' - ' . $teacher->ageRangeSpecialism_txt }}
                                                        </td>
                                                        <td>{{ $teacher->appStatus_txt }}</td>
                                                        <td>{{ $teacher->daysWorked_dec }}</td>
                                                        <td>
                                                            @if ($teacher->lastContact_dte != 0)
                                                                {{ date('d-m-Y', strtotime($teacher->lastContact_dte)) }}
                                                            @endif
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
                                    <form action="{{ url('/candidate-search') }}" method="get" id="advanceSearchForm">
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
                                                <label for="genderId">Gender</label>
                                                <select class="form-control select2" name="gender" id="genderId"
                                                    style="width: 100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($genderList as $key5 => $gender)
                                                        <option value="{{ $gender->description_int }}"
                                                            @if (app('request')->input('gender') == $gender->description_int) selected @endif>
                                                            {{ $gender->description_txt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group filter-form-group">
                                                <label for="professionalId">Professional Type</label>
                                                <select class="form-control select2" name="profession" id="professionalId"
                                                    style="width: 100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($professionList as $key2 => $profession)
                                                        <option value="{{ $profession->description_int }}"
                                                            @if (app('request')->input('profession') == $profession->description_int) selected @endif>
                                                            {{ $profession->description_txt }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group filter-form-group">
                                                <label for="applicationlId">Application Status</label>
                                                <select class="form-control select2" name="application" id="applicationlId"
                                                    style="width: 100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($applicationList as $key4 => $application)
                                                        <option value="{{ $application->description_int }}"
                                                            @if (app('request')->input('application') == $application->description_int) selected @endif>
                                                            {{ $application->description_txt }}</option>
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
                                                <span>Days Worked</span>
                                            </div>

                                            <div class="row filter-row">
                                                <div class="col-md-6">
                                                    <div class="form-check filter-radio-field">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="daysWorked" value="More"
                                                                @if (app('request')->input('daysWorked') == 'More') checked @endif>
                                                            <span class="radio-text">More than</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-check filter-radio-field">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="daysWorked" value="Less"
                                                                @if (app('request')->input('daysWorked') == 'Less') checked @endif>
                                                            <span class="radio-text">Less than</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="field-input-field">
                                                <input type="number" class="form-control" name="worked_day"
                                                    id="worked_day" value="{{ app('request')->input('worked_day') }}">
                                            </div>

                                            <div class="row filter-row">
                                                <div class="col-md-6">
                                                    <div class="field-input-field">
                                                        <input type="date" class="form-control" name="date_from"
                                                            id="date_from"
                                                            value="{{ app('request')->input('date_from') }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="field-input-field">
                                                        <input type="date" class="form-control" name="date_to"
                                                            id="date_to"
                                                            value="{{ app('request')->input('date_to') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="school-search-btn-section">
                                                <button type="button"
                                                    class="btn btn-info save-result-btn schoolSearchBtn"
                                                    id="advanceSearchBtn">Search</button>

                                                {{-- <button type="button" class="btn btn-primary save-result-btn">Save Results as
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
                searching: false
            });

            // $('#advanceSearchDiv').css('display', 'none');
            $("#searchKey").focus();
        });

        function teacherDetail(teacher_id) {
            window.location.href = "{{ URL::to('/candidate-detail') }}" + '/' + teacher_id;
        }

        $(document).on('click', '#advanceSearch', function() {
            $('#search_input').val('');
            $('#ageRangeId').val('');
            $('#genderId').val('');
            $('#professionalId').val('');
            $('#applicationlId').val('');
            $('#lasContactDate').val('');
            $('#worked_day').val('');
            $('#date_from').val('');
            $('#date_to').val('');
            $('input[type=radio][name=lastContactRadio]').prop('checked', false);
            $('input[type=radio][name=daysWorked]').prop('checked', false);

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
    </script>
@endsection
