<div class="topbar-Section">
    <div class="menu_item">
        <a data-toggle="modal" data-target="#editHeaderStatusModal" style="cursor: pointer;">
            <i class="far fa-address-book"></i>
            <span class="topbar-text">{{ $teacherDetail->appStatus_txt }}</span>
        </a>
    </div>

    <div class="menu_item">
        <i class="fas fa-users"></i>
        <span class="topbar-text">{{ $teacherDetail->ageRangeSpecialism_txt }}</span>
    </div>

    <div class="menu_item">
        <i class="fab fa-black-tie"></i>
        <span class="topbar-text">{{ $teacherDetail->professionalType_txt }}</span>
    </div>

    <div class="menu_item">
        <a style="cursor: pointer;" onclick="addteacherFab('{{ $teacherDetail->teacher_id }}')">
            <i class="fas fa-star {{ $teacherDetail->favourite_id ? 'topbar-star-icon' : '' }}"></i>
        </a>
    </div>

    <div class="menu_item">
        <a href="{{ URL::to('/candidate-calendar-list/' . $teacherDetail->teacher_id) }}">
            <i class="fas fa-calendar-alt"></i>
            <span class="topbar-text">Calendar</span>
        </a>
    </div>

    <div class="menu_item">
        <a style="cursor: pointer;" onclick="teacherDeleteHeader('{{ $teacherDetail->teacher_id }}')">
            <i class="fas fa-trash-alt trash-icon"></i>
        </a>
    </div>
</div>

<!-- Detail Edit Modal -->
<div class="modal fade" id="editHeaderStatusModal">
    <div class="modal-dialog modal-sm modal-dialog-centered calendar-modal-section">
        <div class="modal-content calendar-modal-content">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Edit Teacher Status</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
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

    function teacherDeleteHeader(teacher_id) {
        $.ajax({
            type: 'POST',
            url: '{{ url('checkTeacherUsed') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                teacher_id: teacher_id
            },
            dataType: "json",
            success: function(data) {
                if (data.exist == 'Yes') {
                    swal("",
                        "You cannot delete this teacher because he/she is assigned for some assignment.",
                        "warning"
                    );
                } else {
                    teacherDeleteAjax(teacher_id)
                }
            }
        });
    }

    function teacherDeleteAjax(teacher_id) {
        swal({
                title: "",
                text: "Are you sure you want to completely delete this teacher?",
                buttons: {
                    Yes: "Yes",
                    cancel: "No"
                },
            })
            .then((value) => {
                switch (value) {
                    case "Yes":
                        $('#fullLoader').show();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('delete_teacher') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                teacher_id: teacher_id
                            },
                            dataType: "json",
                            success: function(data) {
                                window.location.href = "{{ URL::to('/candidates') }}";
                            }
                        });
                }
            });
    }
</script>
