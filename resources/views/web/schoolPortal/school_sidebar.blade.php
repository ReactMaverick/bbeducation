<div class="col-md-2 sidebar-col">
    <div class="assignment-detail-sidebar-sec">
        <div class="school-detail-sec">
            <h2>{{ $schoolDetail->name_txt }}</h2>
            {{-- <i class="fa-solid fa-school"></i> --}}
            <div class="teacher-detail-user-img-sec">
                <div class="user-img-sec">
                    @if ($schoolDetail->profile_pic != null || $schoolDetail->profile_pic != '')
                        <img src="{{ asset($schoolDetail->profile_pic) }}" alt="">
                    @else
                        <img src="{{ asset('web/images/college.png') }}" alt="">
                    @endif

                    <div class="sidebar-user-delete-sec">
                        <a id="profilePicDeleteBtn" style="cursor: pointer;">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                    <div class="sidebar-user-edit-sec">
                        <a data-toggle="modal" data-target="#profilePicAddModal" style="cursor: pointer;">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </div>
                </div>
            </div>

            <span>{{ $schoolDetail->school_id }}</span>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Detail') sidebar-active @endif">
            <a href="{{ URL::to('/school/detail') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-clipboard-list"></i>

                </div>
                <div class="page-name-sec">
                    <span>Details</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Finance') sidebar-active @endif">
            <a href="{{ URL::to('/school/finance?include=&method=') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="page-name-sec">
                    <span>Finance</span>
                </div>
            </a>
        </div>

        {{-- <div class="sidebar-pages-section">
            <a href="{{ URL::to('/school/logout') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </div>
                <div class="page-name-sec">
                    <span>Logout</span>
                </div>
            </a>
        </div> --}}

    </div>
</div>

<!-- Profile Pic Add Modal -->
<div class="modal fade" id="profilePicAddModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section">
        <div class="modal-content calendar-modal-content" style="width:65%;">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Add Profile Image</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="calendar-heading-sec">
                <i class="fa-solid fa-pencil school-edit-icon"></i>
                <h2>Add Profile Image</h2>
            </div>

            <form action="{{ url('/school/logSchoolProfilePicAdd') }}" method="post" class="form-validate-6"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-input-field-section">
                    <h6>
                        {{ $schoolDetail->name_txt }}
                    </h6>
                    {{-- <span>ID</span>
                            <p>{{ $schoolDetail->school_id }}</p> --}}
                    <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-input-field form-group">
                                <label class="form-check-label">Upload Profile Image</label><span
                                    style="color: red;">*</span>
                                <input type="file" class="form-control file-validate-6" name="file" id=""
                                    value=""><span> *Only file type 'jpg', 'png', 'jpeg'</span>
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
<!-- Profile Pic Add Modal -->

<script>
    $(document).on('click', '#profilePicDeleteBtn', function() {
        var school_id = "{{ $schoolDetail->school_id }}";
        if (school_id) {
            swal({
                    title: "Alert",
                    text: "Are you sure you wish to remove this profile image?",
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
                                url: '{{ url('/school/logSchoolProfilePicDelete') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    school_id: school_id
                                },
                                success: function(data) {
                                    location.reload();
                                }
                            });
                    }
                });
        }
    });
</script>
