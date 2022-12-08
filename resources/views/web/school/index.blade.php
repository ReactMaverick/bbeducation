@extends('web.layout')
@section('content')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
    <div class="tab-content dashboard-tab-content" id="myTabContent">
        <div class="assignment-section-col">

            <div class="teacher-all-section">
                <div class="teacher-section">
                    <div class="teacher-page-sec">
                        <h2>Schools</h2>
                    </div>
                    <div class="teacher-left-sec">
                        <div class="about-teacher">
                            <a href="{{ URL::to('/school-search') }}"> <i class="fa-solid fa-magnifying-glass"></i>
                                <p>Find School</p>
                            </a>
                        </div>

                        <div class="about-teacher">
                            <a data-toggle="modal" data-target="#addNewSchoolModal" style="cursor: pointer;">
                                <i class="fa-solid fa-school-circle-check"></i>
                                <p>Add New</p>
                                <p>School</p>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="teacher-page-table-section">
                    <table class="table teacher-page-table" id="myTable">
                        <thead>
                            <tr class="table-heading">
                                <th><i class="fa-solid fa-star"><span>Favourites</span></i></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-body-sec">
                            @foreach ($fabSchoolList as $key => $fabSchool)
                                <tr class="table-data" onclick="schoolDetail({{ $fabSchool->school_id }})">
                                    <td>{{ $fabSchool->name_txt }}</td>
                                    <td>
                                        @if ($fabSchool->contactSchoolId == null || $fabSchool->contactSchoolId == '')
                                            No Contact
                                        @else
                                            {{ date('d-m-Y', strtotime($fabSchool->lastContact_dte)) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>

    </div>

    <!-- School Add Modal -->
    <div class="modal fade" id="addNewSchoolModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section" style="max-width: 700px;">
            <div class="modal-content calendar-modal-content" style="width: 100%">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add New School</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Add New School</h2>
                </div>

                <form action="{{ url('/newSchoolInsert') }}" method="post" class="form-validate">
                    @csrf
                    <div class="modal-input-field-section">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">School Name</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate" name="name_txt" id=""
                                        value="">
                                </div>

                                <div class="modal-input-field">
                                    <label class="form-check-label">Address</label>
                                    <input type="text" class="form-control mb-1" name="address1_txt" id=""
                                        value="">
                                    <input type="text" class="form-control mb-1" name="address2_txt" id=""
                                        value="">
                                    <input type="text" class="form-control mb-1" name="address3_txt" id=""
                                        value="">
                                    <input type="text" class="form-control" name="address4_txt" id=""
                                        value="">
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Postcode</label><span style="color: red;">*</span>
                                    <input type="text" class="form-control field-validate" name="postcode_txt"
                                        id="" value="">
                                </div>

                                <a href="javascript:void(0)">Get Grid References</a>

                                <div class="modal-input-field">
                                    <label class="form-check-label">Grid References</label>
                                    <input type="hidden" name="lat_txt" id="lat_txt">
                                    <input type="hidden" name="lon_txt" id="lon_txt">
                                    <h6></h6>
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">Local Authority/Borough</label><span style="color: red;">*</span>
                                    <select class="form-control field-validate select2" name="la_id">
                                        <option value="">Choose one</option>
                                        @foreach ($laBoroughList as $key2 => $laBorough)
                                            <option value="{{ $laBorough->la_id }}">
                                                {{ $laBorough->laName_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Age Range</label><span style="color: red;">*</span>
                                    <select class="form-control field-validate select2" name="ageRange_int">
                                        <option value="">Choose one</option>
                                        @foreach ($ageRangeList as $key3 => $ageRange)
                                            <option value="{{ $ageRange->description_int }}">
                                                {{ $ageRange->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">School Type</label><span style="color: red;">*</span>
                                    <select class="form-control field-validate select2" name="type_int">
                                        <option value="">Choose one</option>
                                        @foreach ($schoolTypeList as $key4 => $schoolType)
                                            <option value="{{ $schoolType->description_int }}">
                                                {{ $schoolType->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">Religious Character</label><span style="color: red;">*</span>
                                    <select class="form-control field-validate select2" name="religion_int">
                                        <option value="">Choose one</option>
                                        @foreach ($religiousList as $key5 => $religious)
                                            <option value="{{ $religious->description_int }}">
                                                {{ $religious->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="modal-input-field">
                                    <label class="form-check-label">Website</label>
                                    <input type="text" class="form-control" name="website_txt" id=""
                                        value="">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- School Add Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        function schoolDetail(school_id) {
            window.location.href = "{{ URL::to('/school-detail') }}" + '/' + school_id;
        }
    </script>
@endsection
