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
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                            <button type="submit" class="btn btn-primary school-search-btn">Search</button>
                            <a href="#"><i class="fa-solid fa-arrows-rotate"></i></a>
                            <a href="#"><i class="fa-solid fa-plus"></i></a>
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
                            </tr>
                        </thead>
                        <tbody class="table-body-sec">
                            <tr class="table-data">
                                <td>hkhkh</td>
                                <td>hkhkh</td>
                                <td>kjhkhh</td>
                                <td>khkhkh</td>
                                <td>hkhkh</td>
                                <td>gsgsgs</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3 advance-search-col">
                    <div class="search-form-button">
                        <button>Advance Search</button>
                    </div>

                    <div class="advance-search-filter-section">
                        <div class="form-group filter-form-group">
                            <label for="sel1">Age Range</label>
                            <select class="form-control" id="sel1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </div>

                        <div class="form-group filter-form-group">
                            <label for="sel1">Second Type</label>
                            <select class="form-control" id="sel1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </div>

                        <div class="form-group filter-form-group">
                            <label for="sel1">Local Authority/Borough</label>
                            <select class="form-control" id="sel1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </div>

                        <div class="last-contact-text">
                            <span>Last Contact</span>
                        </div>
                        <div class="row filter-row">
                            <div class="col-md-6">
                                <div class="form-check filter-radio-field">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" disabled>Before
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check filter-radio-field">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" disabled>After
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="field-input-field">
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>


                        <div class="last-contact-text">
                            <span>Last Contact</span>
                        </div>

                        <div class="row filter-row">
                            <div class="col-md-6">
                                <div class="form-check filter-radio-field">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" disabled>Before
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check filter-radio-field">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" disabled>After
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="field-input-field">
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>

                        <button type="submit" class="btn btn-primary save-result-btn">Save Results as Mailshot List</button>

                    </div>

                </div>
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