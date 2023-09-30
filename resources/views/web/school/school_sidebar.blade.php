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
                </div>
            </div>
            <span>{{ $schoolDetail->school_id }}</span>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Detail') sidebar-active @endif">
            <a href="{{ URL::to('/school-detail/' . $school_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-clipboard-list"></i>

                </div>
                <div class="page-name-sec">
                    <span>Details</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Contact') sidebar-active @endif">
            <a href="{{ URL::to('/school-contact/' . $school_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-comment"></i>
                </div>
                <div class="page-name-sec">
                    <span>Contact History</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Assignment') sidebar-active @endif">
            <a href="{{ URL::to('/school-assignment/' . $school_id . '?include=&status=3') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-person-chalkboard"></i>
                </div>
                <div class="page-name-sec">
                    <span>Assignments</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Finance') sidebar-active @endif">
            <a href="{{ URL::to('/school-finance/' . $school_id . '?include=&method=') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="page-name-sec">
                    <span>Finance</span>
                </div>
            </a>
        </div>
        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Document') sidebar-active @endif">
            <a href="{{ URL::to('/school-document/' . $school_id) }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="page-name-sec">
                    <span>Documents</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section @if ($title['pageTitle'] == 'School Teacher') sidebar-active @endif">
            <a href="{{ URL::to('/school-candidate/' . $school_id . '?status=all') }}" class="sidebar-pages">
                <div class="page-icon-sec">
                    <i class="fa-solid fa-person"></i>
                </div>
                <div class="page-name-sec">
                    <span>Teacher List</span>
                </div>
            </a>
        </div>

        <div class="sidebar-pages-section">
            <a style="cursor: pointer;" class="sidebar-pages" onclick="schoolPasswordSendLink('{{ $school_id }}')">
                <div class="page-icon-sec">
                    <i class="fa-sharp fa-solid fa-paper-plane"></i>
                </div>
                <div class="page-name-sec">
                    <span>Send Reset Password Link</span>
                </div>
            </a>
        </div>

    </div>
</div>

<script>
    function schoolPasswordSendLink(school_id) {
        if (school_id) {
            swal({
                    title: "",
                    text: "Are you sure you wish to send password reset link to the user?",
                    buttons: {
                        cancel: "No",
                        Yes: "Yes"
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "Yes":
                            $('#fullLoader').show();
                            $.ajax({
                                type: 'POST',
                                url: '{{ url('checkSchoolLogMail') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    school_id: school_id
                                },
                                success: function(data) {
                                    // console.log(data.rData.contactMail.length);
                                    // if (data.rData.lMailExist == "Yes") {
                                    //     var log_mail = data.rData.loginMail;
                                    //     sendSchoolPassLink(school_id, log_mail)
                                    // } else {
                                    if (data.rData.contactMail.length > 0) {
                                        // if (data.rData.contactMail.length == 1) {
                                        //     var log_mail = data.rData.contactMail[0]
                                        //         .contactItem_txt;
                                        //     sendSchoolPassLink(school_id, log_mail)
                                        // } else {
                                        $('#fullLoader').hide();
                                        var dropdownHtml =
                                            '<select id="logmailDropdown" class="form-control">';
                                        $.each(data.rData.contactMail, function(index,
                                            element) {
                                            dropdownHtml += '<option value="' + element
                                                .contactItemSch_id + '">' + element
                                                .contactItem_txt + '</option>';
                                        });
                                        dropdownHtml += '</select>';

                                        swal({
                                                title: "",
                                                text: "Need to choose one contact mail to send reset password link. This mail will be use as login mail for this school.",
                                                content: {
                                                    element: 'div',
                                                    attributes: {
                                                        innerHTML: dropdownHtml,
                                                    }
                                                },
                                                buttons: {
                                                    cancel: "No",
                                                    Yes: "Yes"
                                                },
                                            })
                                            .then((value) => {
                                                switch (value) {
                                                    case "Yes":
                                                        var log_mail = $(
                                                            '#logmailDropdown').val();
                                                        sendSchoolPassLink(school_id,
                                                            log_mail)
                                                }
                                            });
                                        // }
                                    } else {
                                        $('#fullLoader').hide();
                                        swal("",
                                            "Please add atleast one candidate contact mail first."
                                        );
                                    }
                                    // }
                                }
                            });
                    }
                });
        }
    }

    function sendSchoolPassLink(school_id, log_mail) {
        $('#fullLoader').show();
        $.ajax({
            type: 'POST',
            url: '{{ url('resendSchoolPasswordLink') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                school_id: school_id,
                log_mail: log_mail
            },
            success: function(data) {
                $('#fullLoader').hide();
                if (data == "notEdit") {
                    swal("",
                        "This mail is already use as other school's login mail."
                    );
                } else {
                    if (data) {
                        swal("",
                            "Password reset link has been send successfully to school's mail."
                        );
                    } else {
                        swal("",
                            "Something went wrong.");
                    }
                }
            }
        });
    }
</script>
