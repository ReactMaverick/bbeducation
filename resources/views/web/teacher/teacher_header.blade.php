<div class="topbar-Section">
    <a data-toggle="modal" data-target="#editHeaderStatusModal" style="cursor: pointer;">
        <i class="fa-solid fa-address-book">
            <span class="topbar-text">{{ $teacherDetail->appStatus_txt }}</span>
        </i>
    </a>
    <i class="fa-solid fa-users">
        <span class="topbar-text">{{ $teacherDetail->ageRangeSpecialism_txt }}</span>
    </i>
    <i class="fa-brands fa-black-tie">
        <span class="topbar-text">{{ $teacherDetail->professionalType_txt }}</span>
    </i>
    <a style="cursor: pointer;" onclick="addteacherFab('{{ $teacherDetail->teacher_id }}')">
        <i class="fa-solid fa-star {{ $teacherDetail->favourite_id ? 'topbar-star-icon' : '' }}"></i>
    </a>

    <a href="{{ URL::to('/teacher-calendar-list/' . $teacherDetail->teacher_id) }}">
        <i class="fa-regular fa-calendar-days">
            <span class="topbar-text">Calendar</span>
        </i>
    </a>

    {{-- <a href="#">
        <i class="fa-solid fa-trash trash-icon"></i>
    </a> --}}
</div>

<!-- Detail Edit Modal -->
<div class="modal fade" id="editHeaderStatusModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section">
        <div class="modal-content calendar-modal-content" style="width: 65%">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Edit Teacher Status</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="calendar-heading-sec">
                <i class="fa-solid fa-pencil school-edit-icon"></i>
                <h2>Edit Details</h2>
            </div>

            <form action="{{ url('/teacherHeaderStatusUpdate') }}" method="post" class="">
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
<!-- Detail Edit Modal -->

<script>
    function addteacherFab(teacher_id) {
        $.ajax({
            type: 'POST',
            url: '{{ url('teacherFabAdd') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                teacher_id: teacher_id
            },
            async: false,
            success: function(data) {
                location.reload();
            }
        });
    }
</script>
