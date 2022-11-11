@extends('web.layout')
@section('content')
    <div class="tab-content assignment-tab-content" id="myTabContent">
        <div>

            <div class="assignment-section-col">
                <div class="assignment-page-sec">
                    <h2>School Search</h2>
                    <!-- <div class="checkbox-field">
                                                                    <label for="vehicle1">Include All</label><input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                                                </div> -->
                </div>

                <div class="row">
                    <div class="col-md-9">

                        <div class="school-search-section">
                            <div class="school-search-field">
                                <form action="{{ url('/schoolSearchPost') }}" method="post" id="SearchForm">
                                    @csrf
                                    <input type="text" class="form-control" id="searchKey" name="searchKey">
                                </form>
                                <button type="submit" class="btn btn-primary school-search-btn"
                                    id="normalSearchBtn">Search</button>
                                <a href="#"><i class="fa-solid fa-arrows-rotate"></i></a>
                                <a href="#"><i class="fa-solid fa-plus"></i></a>
                            </div>

                        </div>
                        <table class="table assignment-page-table" id="myTable">
                            <thead>
                                <tr class="table-heading">
                                    <th>Name</th>
                                    <th>Age Range</th>
                                    <th>Type</th>
                                    <th>LA/Borough</th>
                                    <th>Days</th>
                                    <th>Last Contact</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                @foreach ($schoolList as $key => $school)
                                    <tr class="table-data">
                                        <td>hkhkh</td>
                                        <td>hkhkh</td>
                                        <td>kjhkhh</td>
                                        <td>khkhkh</td>
                                        <td>hkhkh</td>
                                        <td>gsgsgs</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3 advance-search-col">
                        <div class="search-form-button">
                            <button id="advanceSearch">Advance Search</button>
                        </div>
                        <form action="{{ url('/schoolSearchPost') }}" method="post" id="advanceSearchForm">
                            @csrf
                            <div class="advance-search-filter-section" id="advanceSearchDiv">

                                <div class="form-group filter-form-group">
                                    <label for="ageRangeId">Age Range</label>
                                    <select class="form-control select2" name="ageRangeId" id="ageRangeId" style="width: 100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($ageRangeList as $key1 => $ageRange)
                                            <option value="{{ $ageRange->description_int }}">
                                                {{ $ageRange->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group filter-form-group">
                                    <label for="schoolTypeId">School Type</label>
                                    <select class="form-control select2" name="schoolTypeId" id="schoolTypeId" style="width: 100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($schoolTypeList as $key2 => $schoolType)
                                            <option value="{{ $schoolType->description_int }}">
                                                {{ $schoolType->description_txt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group filter-form-group">
                                    <label for="laId">Local Authority/Borough</label>
                                    <select class="form-control select2" name="laId" id="laId" style="width: 100%;">
                                        <option value="">Choose one</option>
                                        @foreach ($laBoroughList as $key3 => $laBorough)
                                            <option value="{{ $laBorough->la_id }}">{{ $laBorough->laName_txt }}</option>
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
                                                <input type="radio" class="form-check-input" name="lastContactRadio"
                                                    value="Before">
                                                <span class="radio-text">Before</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check filter-radio-field">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="lastContactRadio"
                                                    value="After">
                                                <span class="radio-text">After</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="field-input-field">
                                    <input type="date" class="form-control" id="">
                                </div>


                                <div class="last-contact-text">
                                    <span>Days Booked</span>
                                </div>

                                <div class="row filter-row">
                                    <div class="col-md-6">
                                        <div class="form-check filter-radio-field">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="dayBookedRadio"
                                                    value="More">
                                                <span class="radio-text">More than</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check filter-radio-field">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="dayBookedRadio"
                                                    value="Less">
                                                <span class="radio-text">Less than</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="field-input-field">
                                    <input type="number" class="form-control" id="">
                                </div>

                                <div class="school-search-btn-section">
                                    <button type="button" class="btn btn-primary save-result-btn schoolSearchBtn"
                                        id="advanceSearchBtn">Search</button>

                                    <button type="button" class="btn btn-primary save-result-btn">Save Results as
                                        Mailshot
                                        List</button>
                                </div>


                            </div>
                        </form>

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

            $('#advanceSearchDiv').css('display', 'none');
        });

        $(document).on('click', '#advanceSearch', function() {
            if ($("#advanceSearchDiv").is(":visible")) {
                $('#advanceSearchDiv').css('display', 'none');
            } else {
                $('#advanceSearchDiv').css('display', 'block');
            }
        });

        $(document).on('click', '#advanceSearchBtn', function() {
            $("#SearchForm").submit();
            $("#advanceSearchForm").submit();
        });
    </script>
@endsection
