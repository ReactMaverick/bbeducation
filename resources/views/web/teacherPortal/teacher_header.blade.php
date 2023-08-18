<div class="topbar-Section">
    <div class="menu_item">
        <a data-toggle="modal" data-target="#editHeaderStatusModal" style="cursor: pointer;">
            <i class="fas fa-address-book">
            </i>
            <span class="topbar-text">{{ $teacherDetail->appStatus_txt }}</span>
        </a>
    </div>
    <div class="menu_item">
        <i class="fas fa-users">
        </i>
        <span class="topbar-text">{{ $teacherDetail->ageRangeSpecialism_txt }}</span>
    </div>
    <div class="menu_item">
        <i class="fab fa-black-tie">
        </i>
        <span class="topbar-text">{{ $teacherDetail->professionalType_txt }}</span>
    </div>
</div>

<!-- Detail Edit Modal -->
<div class="modal fade" id="editHeaderStatusModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section">
        <div class="modal-content calendar-modal-content">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Edit Teacher Status</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="calendar-heading-sec">
                    <i class="fas fa-edit school-edit-icon"></i>
                    <h2>Edit Details</h2>
                </div>

                <form action="{{ url('/candidate/LogTeacherStatusUpdateHead') }}" method="post" class="">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>
                            @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                            @else
                                {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                            @endif
                        </h6>
                        <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Status</label>
                                    <select class="form-control" name="applicationStatus_int" style="width:100%;">
                                        @foreach ($headerStatusList as $key1 => $headerStatus)
                                            <option value="{{ $headerStatus->description_int }}"
                                                {{ $teacherDetail->applicationStatus_int == $headerStatus->description_int ? 'selected' : '' }}>
                                                {{ $headerStatus->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
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
<!-- Detail Edit Modal -->
