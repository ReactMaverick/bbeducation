{{-- @extends('web.layout') --}}
@extends('web.teacher.teacher_layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.teacher.teacher_header')
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">

                        <div class="school-detail-right-sec">
                            <div class="row my_row_gap">
                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="teacher-health-first-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Preferences</h2>
                                            <a data-toggle="modal" data-target="#preferenceEditModal"
                                                style="cursor: pointer;" class="icon_all"><i
                                                    class="fas fa-edit school-edit-icon"></i></a>
                                        </div>

                                        <div class="about-school-section">
                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <label for="vehicle1">Can Drive</label>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <input type="checkbox" id="" name="" value="1"
                                                        disabled
                                                        {{ $teacherDetail->prefDrive_status == '-1' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <label for="vehicle1">Daily Supply</label>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <input type="checkbox" id="" name="" value="1"
                                                        disabled
                                                        {{ $teacherDetail->prefDailySupply_status == '-1' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <label for="vehicle1">Long Term</label>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <input type="checkbox" id="" name="" value="1"
                                                        disabled
                                                        {{ $teacherDetail->prefLongTerm_status == '-1' ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <label for="vehicle1">Early Morning Calls</label>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <input type="checkbox" id="" name="" value="1"
                                                        disabled
                                                        {{ $teacherDetail->prefEarlyMorningCall_status == '-1' ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <label for="vehicle1">SEN Interested</label>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <input type="checkbox" id="" name="" value="1"
                                                        disabled
                                                        {{ $teacherDetail->prefSEN_status == '-1' ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <label for="vehicle1">SEN Experience</label>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <input type="checkbox" id="" name="" value="1"
                                                        disabled
                                                        {{ $teacherDetail->prefSENExperience_status == '-1' ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <h2>Max. Distance</h2>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <p>{{ $teacherDetail->prefDistance_int }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <h2>Pref. Year Group</h2>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <p>{{ $teacherDetail->prefYearGroup_int }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <h2>Ideal job</h2>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <p>{{ $teacherDetail->prefIdealJob_txt }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <h2>Other Agencies</h2>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <p>{{ $teacherDetail->otherAgencies_txt }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <h2>Current Rate</h2>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <p>{{ $teacherDetail->currentRate_dec }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <h2>Previous Schools</h2>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <p>{{ $teacherDetail->previousSchools_txt }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="teacher-health-second-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Health</h2>
                                            <a data-toggle="modal" data-target="#healthEditModal" style="cursor: pointer;"
                                                class="icon_all"><i class="fas fa-edit school-edit-icon"></i></a>
                                        </div>

                                        <div class="about-school-section">
                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <h2>Occupational Health</h2>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <p>{{ $teacherDetail->occupationalHealth_txt }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <h2>Health Issues</h2>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <p>{{ $teacherDetail->healthIssues_txt }}</p>
                                                </div>
                                            </div>

                                            <div class="school-name-section">
                                                <div class="teacher-prefernce-heading-text">
                                                    <h2>Health Decoration Date</h2>
                                                </div>
                                                <div class="teacher-prefernce-name-text">
                                                    <p>{{ $teacherDetail->healthDeclaration_dte != null ? date('d-m-Y', strtotime($teacherDetail->healthDeclaration_dte)) : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Preference Edit Modal -->
    <div class="modal fade" id="preferenceEditModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Preferences</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Preferences</h2>
                    </div>

                    <form action="{{ url('/teacherPreferenceUpdate') }}" method="post" class="">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                    <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="prefDrive_status">Can Drive</label>
                                        <input type="checkbox" class="" name="prefDrive_status"
                                            id="prefDrive_status" value="1"
                                            {{ $teacherDetail->prefDrive_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="prefDailySupply_status">Daily Supply</label>
                                        <input type="checkbox" class="" name="prefDailySupply_status"
                                            id="prefDailySupply_status" value="1"
                                            {{ $teacherDetail->prefDailySupply_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="prefLongTerm_status">Long Term</label>
                                        <input type="checkbox" class="" name="prefLongTerm_status"
                                            id="prefLongTerm_status" value="1"
                                            {{ $teacherDetail->prefLongTerm_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Max. Distance</label>
                                        <input type="text" class="form-control numberField" name="prefDistance_int"
                                            id="" value="{{ $teacherDetail->prefDistance_int }}">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Ideal job</label>
                                        <textarea name="prefIdealJob_txt" id="" cols="30" rows="3" class="form-control">{{ $teacherDetail->prefIdealJob_txt }}</textarea>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Current Rate</label>
                                        <input type="text" class="form-control numberField" name="currentRate_dec"
                                            id="" value="{{ $teacherDetail->currentRate_dec }}">
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="prefEarlyMorningCall_status">Early Morning
                                            Calls</label>
                                        <input type="checkbox" class="" name="prefEarlyMorningCall_status"
                                            id="prefEarlyMorningCall_status" value="1"
                                            {{ $teacherDetail->prefEarlyMorningCall_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="prefSEN_status">SEN Interested</label>
                                        <input type="checkbox" class="" name="prefSEN_status" id="prefSEN_status"
                                            value="1" {{ $teacherDetail->prefSEN_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="modal-side-field mb-2">
                                        <label class="form-check-label" for="prefSENExperience_status">SEN
                                            Experience</label>
                                        <input type="checkbox" class="" name="prefSENExperience_status"
                                            id="prefSENExperience_status" value="1"
                                            {{ $teacherDetail->prefSENExperience_status == '-1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Pref. Year Group</label>
                                        <input type="text" class="form-control numberField" name="prefYearGroup_int"
                                            id="" value="{{ $teacherDetail->prefYearGroup_int }}">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Other Agencies</label>
                                        <textarea name="otherAgencies_txt" id="" cols="30" rows="3" class="form-control">{{ $teacherDetail->otherAgencies_txt }}</textarea>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Previous Schools</label>
                                        <textarea name="previousSchools_txt" id="" cols="30" rows="3" class="form-control">{{ $teacherDetail->previousSchools_txt }}</textarea>
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
    </div>
    <!-- Preference Edit Modal -->

    <!-- Teacher Health Edit Modal -->
    <div class="modal fade" id="healthEditModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Health</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec" style="align-items: baseline;">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Health</h2>
                    </div>

                    <form action="{{ url('/teacherHealthUpdate') }}" method="post" class="">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            {{-- <span>ID</span>
                    <p>{{ $teacherDetail->teacher_id }}</p> --}}
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Occupational Health</label>
                                        <textarea name="occupationalHealth_txt" id="" cols="30" rows="5" class="form-control">{{ $teacherDetail->occupationalHealth_txt }}</textarea>
                                    </div>

                                    <div class="modal-input-field">
                                        <label class="form-check-label">Health Decoration Date</label>
                                        <input type="text" class="form-control datePickerPaste"
                                            name="healthDeclaration_dte" id=""
                                            value="{{ $teacherDetail->healthDeclaration_dte != null ? date('d/m/Y', strtotime($teacherDetail->healthDeclaration_dte)) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Health Issues</label>
                                        <textarea name="healthIssues_txt" id="" cols="30" rows="5" class="form-control">{{ $teacherDetail->healthIssues_txt }}</textarea>
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
    </div>
    <!-- Teacher Health Edit Modal -->

    <script>
        $(document).ready(function() {
            $('.numberField').keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });
        });
    </script>
@endsection
