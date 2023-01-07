@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.assignment.assignment_sidebar')

            <div class="col-md-10 topbar-sec">
                <div class="topbar-Section">
                    <i class="fa-solid fa-crown"></i>
                    <a href="#"> <i class="fa-solid fa-trash trash-icon"></i></a>
                </div>



                <div class="school-assignment-sec">
                    <div class="school-assignment-section">
                        <div class="assignment-contact-history-heading-section">
                            <div class="assignment-contact-history-heading">
                                <h2>Contact History</h2>
                            </div>
                            <div class="assignment-contact-history-icon">
                                <a data-toggle="modal" data-target="#ContactHistoryAddModal" style="cursor: pointer;">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                            </div>
                        </div>


                        <div class="assignment-contact-page-table">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Contact On</th>
                                        <th>Contact Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($ContactHistory as $key => $History)
                                        <tr class="school-detail-table-data">
                                            <td>
                                                Contact On : {{ date('d-m-Y H:i', strtotime($History->contactOn_dtm)) }} <br>
                                                Contact With : {{ $History->contactWith_txt }}
                                            </td>
                                            <td>{{ $History->notes_txt }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="assignment-first-sec">
                        <div class="assignment-contact-sidebar-sec">
                            <div class="assignment-sidebar-data">
                                <h2>{{ count($ContactHistory) }}</h2>
                            </div>
                            <div class="assignment-sidebar-text">
                                <span>Total contacts for this specific assignment</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Add Modal -->
    <div class="modal fade" id="ContactHistoryAddModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Log School Contact</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Log School Contact</h2>
                </div>

                <form action="{{ url('/assignmentContactLogInsert') }}" method="post" class="form-validate">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>{{ $assignmentDetail->schooleName }}</h6>
                        {{-- <h6>ID</h6>
                        <h6>{{ $schoolDetail->school_id }}</h6> --}}
                        <input type="hidden" name="school_id" value="{{ $assignmentDetail->school_id }}">
                        <input type="hidden" name="asn_id" value="{{ $asn_id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Spoke to (specific contact)</label><span style="color: red;">*</span>
                                    <select class="form-control field-validate SpokeToId" name="spokeTo_id" id="SpokeToId"
                                        onchange="selectSpokeTo(this.value, this.options[this.selectedIndex].getAttribute('sName'))">
                                        <option value="">Choose one</option>
                                        @foreach ($schoolContacts as $key1 => $Contacts)
                                            {{ $name = '' }}
                                            @if ($Contacts->firstName_txt != '' && $Contacts->surname_txt != '')
                                                {{ $name = $Contacts->firstName_txt . ' ' . $Contacts->surname_txt }}
                                            @elseif ($Contacts->firstName_txt != '' && $Contacts->surname_txt == '')
                                                {{ $name = $Contacts->firstName_txt }}
                                            @elseif ($Contacts->title_int != '' && $Contacts->surname_txt != '')
                                                {{ $name = $Contacts->title_txt . ' ' . $Contacts->surname_txt }}
                                            @elseif ($Contacts->jobRole_int != '')
                                                {{ $name = $Contacts->jobRole_txt . ' (name unknown)' }}
                                            @else
                                                {{ $name = 'Name unknown' }}
                                            @endif
                                            <option sName="{{ $name }}" value="{{ $Contacts->contact_id }}">
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="modal-input-field">
                                    <label class="form-check-label">Spoke to</label>
                                    <input type="text" class="form-control" name="spokeTo_txt" id="sopkeToText"
                                        value="">
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">Contact Method</label><span style="color: red;">*</span>
                                    <select class="form-control field-validate" name="method_int">
                                        <option value="">Choose one</option>
                                        @foreach ($methodList as $key2 => $method)
                                            <option value="{{ $method->description_int }}">
                                                {{ $method->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">Contact Reason</label>
                                    <select class="form-control" name="contactAbout_int">
                                        <option value="">Choose one</option>
                                        @foreach ($reasonList as $key4 => $reason)
                                            <option value="{{ $reason->description_int }}" {{ $reason->description_int==2?'selected':'' }}>
                                                {{ $reason->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">Call Outcome</label>
                                    <select class="form-control" name="outcome_int">
                                        <option value="">Choose one</option>
                                        @foreach ($outcomeList as $key5 => $outcome)
                                            <option value="{{ $outcome->description_int }}">
                                                {{ $outcome->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 modal-form-right-sec">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Notes</label><span style="color: red;">*</span>
                                    <textarea name="notes_txt" id="" cols="30" rows="5" class="form-control field-validate"></textarea>
                                </div>

                                <div class="modal-side-field">
                                    <label class="form-check-label" for="callBackId">Callback</label>
                                    <input type="checkbox" class="" name="callBackCheck" id="callBackId"
                                        value="1">
                                </div>

                                <div class="row" id="quickSettingDiv" style="display: none;">
                                    <div class="form-group calendar-form-filter col-md-12">
                                        <label for="">Quick Setting</label>
                                        <select class="form-control" name="quick_setting"
                                            onchange="quickSettingChange(this.value, this.options[this.selectedIndex].getAttribute('settingTxt'))" id="quickSettingId">
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
                                        <input type="date" class="form-control" name="quick_setting_date"
                                            id="DateId" value="">
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

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        function selectSpokeTo(contact_id, contact_name) {
            if (contact_id) {
                $('#sopkeToText').val(contact_name);
            } else {
                $('#sopkeToText').val('');
            }
        }

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

    </script>
@endsection
