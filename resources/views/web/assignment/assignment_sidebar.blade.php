<style>
    .disabled-link {
        pointer-events: none;
    }
</style>
<div class="col-md-2 sidebar-col">
    <div class="assignment-detail-sidebar-sec">
        <div class="sidebar-top-text">
            <a href="{{ URL::to('/school-detail/' . $assignmentDetail->school_id) }}" class="" target="_blank">
                <h2>{{ $assignmentDetail->schooleName }}</h2>
                <span>{{ $assignmentDetail->school_id }}</span>
            </a>
            @if ($assignmentDetail->status_int < 3)
                <a style="cursor: pointer;" id="statusAnchId"
                    onclick="changeStatusToComplete({{ $asn_id }}, '{{ $assignmentDetail->teacher_id }}', '{{ $assignmentDetail->techerFirstname . ' ' . $assignmentDetail->techerSurname }}')">
                    <i class="fa-solid fa-square-check {{ $assignmentDetail->status_int == 3 ? 'assignmentComplete' : 'assignmentInComplete' }}"
                        id="statusIconId"></i>
                </a>
            @else
                <a style="cursor: pointer;">
                    <i
                        class="fa-solid fa-square-check {{ $assignmentDetail->status_int == 3 ? 'assignmentComplete' : 'assignmentInComplete' }}"></i>
                </a>
            @endif
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Assignments Detail') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-details/' . $assignmentDetail->asn_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-person-chalkboard"></i>
                </div>
                <div class="page-name-sec">
                    <span>Assignment</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Assignments Contact') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-contact/' . $assignmentDetail->asn_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-comment"></i>
                </div>
                <div class="page-name-sec">
                    <span>Contact</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Assignments Candidate') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-candidate/' . $assignmentDetail->asn_id . '?showall=') }}"
                class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div class="page-name-sec">
                    <span>Candidates</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Assignments School Detail') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-school/' . $assignmentDetail->asn_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-school"></i>
                </div>
                <div class="page-name-sec">
                    <span>School Details</span>
                </div>
            </a>
        </div>
        {{-- <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Assignments Finance') sidebar-active @endif">
            <a href="{{ URL::to('/assignment-finance/' . $assignmentDetail->asn_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="page-name-sec">
                    <span>Finance</span>
                </div>
            </a>
        </div> --}}

        <div class="teacher-name">
            @if ($assignmentDetail->teacher_id)
                <a href="{{ URL::to('/teacher-detail/' . $assignmentDetail->teacher_id) }}" class=""
                    target="_blank">
                    <span>{{ $assignmentDetail->techerFirstname . ' ' . $assignmentDetail->techerSurname }}</span>
                </a>
            @endif
        </div>

        <div class="assignment-detail-user-img-sec">
            <div class="user-img-sec">
                @if ($assignmentDetail->file_location != null || $assignmentDetail->file_location != '')
                    <img src="{{ asset($assignmentDetail->file_location) }}" alt="">
                @else
                    <img src="{{ asset('web/images/user-img.png') }}" alt="">
                @endif
            </div>
        </div>


        <div class="sidebar-user-number">
            <span>{{ $assignmentDetail->teacher_id }}</span>
        </div>

        <div class="sidebar-check-icon">
            <i
                class="fa-solid fa-square-check {{ $assignmentDetail->teacher_id ? 'assignmentComplete' : 'assignmentInComplete' }}"></i>
        </div>
        <div class="assignment-id-text-sec">
            <span>Assignment ID :</span>
            <span>{{ $assignmentDetail->asn_id }}</span>
        </div>

    </div>
</div>

<!-- Candidate Vetting Modal -->
<div class="modal fade" id="candidateVettingModalSidebar">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section cand-vetting-modal-section">
        <div class="modal-content calendar-modal-content">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Candidate Vetting</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div id="candidateVetAjaxSidebar"></div>

        </div>
    </div>
</div>
<!-- Candidate Vetting Modal -->

<script>
    function changeStatusToComplete(asn_id, teacher_id, candidateName) {
        var count = 0;
        $.ajax({
            type: 'POST',
            url: '{{ url('assignmentStatusEdit') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                asn_id: asn_id,
                status: '3'
            },
            dataType: "json",
            async: false,
            success: function(data) {
                if (data) {
                    count = 1;
                    $('#statusIconId').removeClass('assignmentInComplete');
                    $('#statusIconId').addClass('assignmentComplete');
                    $('#statusAnchId').addClass('disabled-link');
                }
            }
        });
        if (count == 1 && teacher_id) {
            $.ajax({
                type: 'POST',
                url: '{{ url('createCandidateVetting') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    asn_id: asn_id,
                    vetting_id: '',
                    newVetting: "Yes",
                    sidebar: "Yes"
                },
                success: function(data) {
                    if (data) {
                        $('#candidateVetAjaxSidebar').html(data.html);
                        $('#candidateVettingModalSidebar').modal("show");
                    }
                }
            });
        }
    }

    $(document).on('click', '#candVettingEditBtnSidebar', function() {
        // var error = "";
        // $(".vetting-field-validate").each(function() {
        //     if (this.value == '') {
        //         $(this).closest(".form-group").addClass('has-error');
        //         error = "has error";
        //     } else {
        //         $(this).closest(".form-group").removeClass('has-error');
        //     }
        // });
        // if (error == "has error") {
        //     return false;
        // } else {
        var form = $("#candVettingEditForm");
        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            dataType: "json",
            async: false,
            success: function(data) {
                if (data) {
                    $('#candidateVetAjaxSidebar').html(data.html);
                }
            }
        });
        // }
    });
</script>
