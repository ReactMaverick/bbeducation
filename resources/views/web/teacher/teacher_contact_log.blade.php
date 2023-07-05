@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.teacher.teacher_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.teacher.teacher_header')

                <div class="school-assignment-sec">
                    <div class="teacher-reference-section">
                        <div class="assignment-finance-heading-section">
                            <h2>Contact</h2>
                            <div class="assignment-finance-icon-section">
                                <a style="cursor: pointer" class="disabled-link" id="deleteContactLogBttn">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                                <a data-toggle="modal" data-target="#ContactLogAddModal" style="cursor: pointer;">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <a style="cursor: pointer;" class="disabled-link" id="editContactLogBttn">
                                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                                </a>
                            </div>

                        </div>
                        <div class="assignment-finance-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th style="width: 40%">Contact Notes</th>
                                        <th>Contact By</th>
                                        <th>Contact On</th>
                                        <th>Method</th>
                                        <th>CB Due</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    <?php $dueCallCount = 0; ?>
                                    @foreach ($teacherContactLogs as $key => $teacherContact)
                                        <tr class="school-detail-table-data editContactLogRow"
                                            id="editContactLogRow{{ $teacherContact->teacherContactLog_id }}"
                                            onclick="editContactLogRowSelect({{ $teacherContact->teacherContactLog_id }})">
                                            <td style="width: 40%">{{ $teacherContact->notes_txt }}</td>
                                            <td>{{ $teacherContact->firstName_txt . ' ' . $teacherContact->surname_txt }}
                                            </td>
                                            <td>{{ date('d-m-Y H:i', strtotime($teacherContact->contactOn_dtm)) }}</td>
                                            <td>{{ $teacherContact->method_txt }}</td>
                                            <td>
                                                @if ($teacherContact->callbackOn_dtm == null)
                                                    {{ 'N' }}
                                                @elseif ($teacherContact->callbackOn_dtm >= date('Y-m-d H:i:s'))
                                                    {{ 'Y' }}
                                                    <?php $dueCallCount += 1; ?>
                                                @else
                                                    {{ 'N' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <input type="hidden" name="contactLogId" id="contactLogId" value="">

                    <div class="assignment-first-sec">
                        <div class="assignment-left-sidebar-section">
                            <div class="references-bottom-sec">
                                <div class="assignment-sidebar-data">
                                    <h2>{{ count($teacherContactLogs) }}</h2>
                                </div>
                                <div class="sidebar-sec-text">
                                    <span>Total References</span>
                                </div>
                            </div>
                            <div class="references-bottom-sec">
                                <div class="assignment-sidebar-data2">
                                    <h2>{{ $dueCallCount }}</h2>
                                </div>
                                <div class="sidebar-sec-text">
                                    <span>Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Add Modal -->
    <div class="modal fade" id="ContactLogAddModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Log Teacher Contact</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Log Teacher Contact</h2>
                </div>

                <form action="{{ url('/teacherContactLogInsert') }}" method="post" class="form-validate">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>
                            @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                            @else
                                {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                            @endif
                        </h6>
                        {{-- <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p> --}}
                        <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Contact Method</label>
                                    <select class="form-control field-validate" name="method_int">
                                        <option value="">Choose one</option>
                                        @foreach ($methodList as $key2 => $method)
                                            <option value="{{ $method->description_int }}">
                                                {{ $method->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Notes</label>
                                    <textarea name="notes_txt" id="" cols="30" rows="5" class="form-control field-validate"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 modal-form-right-sec">
                                <div class="modal-side-field">
                                    <label class="form-check-label" for="callBackId">Callback</label>
                                    <input type="checkbox" class="" name="callBackCheck" id="callBackId"
                                        value="1">
                                </div>

                                <div class="row" id="quickSettingDiv" style="display: none;">
                                    <div class="form-group calendar-form-filter col-md-12">
                                        <label for="">Quick Setting</label>
                                        <select class="form-control" name="quick_setting"
                                            onchange="quickSettingChange(this.value, this.options[this.selectedIndex].getAttribute('settingTxt'))"
                                            id="quickSettingId">
                                            <option value="">Choose one</option>
                                            @foreach ($quickSettingList as $key3 => $quickSetting)
                                                <option settingTxt="{{ $quickSetting->description_txt }}"
                                                    value="{{ $quickSetting->description_int }}">
                                                    {{ $quickSetting->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-input-field col-md-6">
                                        <label class="form-check-label">Date</label>
                                        <input type="date" class="form-control" name="quick_setting_date" id="DateId"
                                            value="">
                                    </div>

                                    <div class="modal-input-field col-md-6">
                                        <label class="form-check-label">Time</label>
                                        <input type="time" class="form-control" name="quick_setting_time"
                                            id="timeId" value="">
                                    </div>
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
    <!-- Contact Add Modal -->

    <!-- Contact Edit Modal -->
    <div class="modal fade" id="ContactLogEditModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Contact</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Teacher Contact</h2>
                </div>

                <form action="{{ url('/teacherContactLogUpdate') }}" method="post" class="form-validate-2">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>
                            @if ($teacherDetail->knownAs_txt == null && $teacherDetail->knownAs_txt == '')
                                {{ $teacherDetail->firstName_txt . ' ' . $teacherDetail->surname_txt }}
                            @else
                                {{ $teacherDetail->firstName_txt . ' (' . $teacherDetail->knownAs_txt . ') ' . $teacherDetail->surname_txt }}
                            @endif
                        </h6>
                        {{-- <span>ID</span>
                        <p>{{ $teacherDetail->teacher_id }}</p> --}}
                        <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">
                        <input type="hidden" name="editContactLogId" id="editContactLogId" value="">

                        <div class="row" id="editContactLogAjax"></div>

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
    <!-- Contact Edit Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: false
            });
        });

        $(document).on('change', '#callBackId', function() {
            $('#quickSettingId').val('');
            $('#DateId').val('');
            $('#timeId').val('');
            if ($(this).is(":checked")) {
                $('#quickSettingDiv').show();
            } else {
                $('#quickSettingDiv').hide();
            }
        });

        function quickSettingChange(setting_id, setting_text) {
            if (setting_id && setting_text) {
                var arr = setting_text.split(" ");
                var today = new Date();
                var newdate = new Date(today);
                if (arr.length > 0 && arr[1] == 'Minutes') {
                    newdate.setMinutes(newdate.getMinutes() + parseInt(arr[0]));
                }
                if (arr.length > 0 && arr[1] == 'Hour') {
                    newdate.setHours(newdate.getHours() + parseInt(arr[0]));
                }
                if (arr.length > 0 && arr[1] == 'Day') {
                    newdate.setDate(newdate.getDate() + parseInt(arr[0]));
                }
                if (arr.length > 0 && arr[1] == 'Week') {
                    newdate.setDate(newdate.getDate() + 7);
                }
                if (arr.length > 0 && arr[1] == 'Month') {
                    newdate.setMonth(newdate.getMonth() + parseInt(arr[0]));
                }
                if (arr.length > 0 && arr[1] == 'Year') {
                    newdate.setFullYear(newdate.getFullYear() + parseInt(arr[0]));
                }
                var fdate = new Date(newdate);

                if ((fdate.getMonth() + 1).toString().length < 2) {
                    var monthString = '0' + (fdate.getMonth() + 1);
                } else {
                    var monthString = (fdate.getMonth() + 1);
                }
                if ((fdate.getDate()).toString().length < 2) {
                    var dateString = '0' + fdate.getDate();
                } else {
                    var dateString = fdate.getDate();
                }
                if ((fdate.getHours()).toString().length < 2) {
                    var hourString = '0' + fdate.getHours();
                } else {
                    var hourString = fdate.getHours();
                }
                if ((fdate.getMinutes()).toString().length < 2) {
                    var minuteString = '0' + fdate.getMinutes();
                } else {
                    var minuteString = fdate.getMinutes();
                }
                var DateValue = fdate.getFullYear() + '-' + monthString + '-' + dateString;
                var TimeValue = hourString + ':' + minuteString;
                $('#DateId').val(DateValue);
                $('#timeId').val(TimeValue);
            } else {
                $('#DateId').val('');
                $('#timeId').val('');
            }
        }

        function editContactLogRowSelect(teacherContactLog_id) {
            if ($('#editContactLogRow' + teacherContactLog_id).hasClass('tableRowActive')) {
                $('#contactLogId').val('');
                $('#editContactLogRow' + teacherContactLog_id).removeClass('tableRowActive');
                $('#deleteContactLogBttn').addClass('disabled-link');
                $('#editContactLogBttn').addClass('disabled-link');
            } else {
                $('#contactLogId').val(teacherContactLog_id);
                $('.editContactLogRow').removeClass('tableRowActive');
                $('#editContactLogRow' + teacherContactLog_id).addClass('tableRowActive');
                $('#deleteContactLogBttn').removeClass('disabled-link');
                $('#editContactLogBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editContactLogBttn', function() {
            var contactLogId = $('#contactLogId').val();
            if (contactLogId) {
                $('#editContactLogId').val(contactLogId);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('teacherContactLogEdit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        contactLogId: contactLogId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#editContactLogAjax').html(data.html);
                    }
                });
                $('#ContactLogEditModal').modal("show");
            } else {
                swal("", "Please select one contact.");
            }
        });

        $(document).on('click', '#deleteContactLogBttn', function() {
            var contactLogId = $('#contactLogId').val();
            if (contactLogId) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to remove this contact?",
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
                                    url: '{{ url('teacherContactLogDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        contactLogId: contactLogId
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one contact.");
            }
        });
    </script>
@endsection
