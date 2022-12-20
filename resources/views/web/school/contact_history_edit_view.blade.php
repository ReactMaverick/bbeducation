<div class="col-md-6">
    <div class="form-group calendar-form-filter">
        <label for="">Spoke to (specific contact)</label>
        <select class="form-control field-validate editSpokeToId" name="spokeTo_id" id="editSpokeToId"
            onchange="selectSpokeToEdit(this.value, this.options[this.selectedIndex].getAttribute('sName'))">
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
                <option sName="{{ $name }}" value="{{ $Contacts->contact_id }}"
                    {{ $contactDetail->spokeTo_id == $Contacts->contact_id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="modal-input-field">
        <label class="form-check-label">Spoke to</label>
        <input type="text" class="form-control" name="spokeTo_txt" id="sopkeToTextEdit"
            value="{{ $contactDetail->spokeTo_txt }}">
    </div>

    <div class="form-group calendar-form-filter">
        <label for="">Contact Method</label>
        <select class="form-control field-validate" name="method_int">
            <option value="">Choose one</option>
            @foreach ($methodList as $key2 => $method)
                <option value="{{ $method->description_int }}"
                    {{ $contactDetail->method_int == $method->description_int ? 'selected' : '' }}>
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
                <option value="{{ $reason->description_int }}"
                    {{ $contactDetail->contactAbout_int == $reason->description_int ? 'selected' : '' }}>
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
                <option value="{{ $outcome->description_int }}"
                    {{ $contactDetail->outcome_int == $outcome->description_int ? 'selected' : '' }}>
                    {{ $outcome->description_txt }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-6 modal-form-right-sec">
    <div class="form-group modal-input-field">
        <label class="form-check-label">Notes</label>
        <textarea name="notes_txt" id="" cols="30" rows="5" class="form-control field-validate">{{ $contactDetail->notes_txt }}</textarea>
    </div>

    <div class="modal-side-field">
        <label class="form-check-label" for="callBackIdEdit">Callback</label>
        <input type="checkbox" class="" name="callBackCheck" id="callBackIdEdit" value="1"
            {{ $contactDetail->callbackOn_dtm != null ? 'checked' : '' }}>
    </div>

    <div class="row" id="quickSettingDivEdit"
        style="display: {{ $contactDetail->callbackOn_dtm != null ? '' : 'none' }};">
        <div class="form-group calendar-form-filter col-md-12">
            <label for="">Quick Setting</label>
            <select class="form-control" name="quick_setting"
                onchange="editQuickSettingChange(this.value, this.options[this.selectedIndex].getAttribute('settingTxt'))" id="editquickSettingId">
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
            <input type="date" class="form-control" name="quick_setting_date" id="editDateId"
                value="{{ $contactDetail->callbackOn_dtm != null ? date('Y-m-d', strtotime($contactDetail->callbackOn_dtm)) : '' }}">
        </div>

        <div class="modal-input-field col-md-6">
            <label class="form-check-label">Time</label>
            <input type="time" class="form-control" name="quick_setting_time" id="editTimeId"
                value="{{ $contactDetail->callbackOn_dtm != null ? date('H:i', strtotime($contactDetail->callbackOn_dtm)) : '' }}">
        </div>
    </div>
</div>

<script>
    function selectSpokeToEdit(contact_id, contact_name) {
        if (contact_id) {
            $('#sopkeToTextEdit').val(contact_name);
        } else {
            $('#sopkeToTextEdit').val('');
        }
    }

    $(document).on('change', '#callBackIdEdit', function() {
        $('#editquickSettingId').val('');
        $('#editDateId').val('');
        $('#editTimeId').val('');
        if ($(this).is(":checked")) {
            $('#quickSettingDivEdit').show();
        } else {
            $('#quickSettingDivEdit').hide();
        }
    });

    function editQuickSettingChange(setting_id, setting_text) {
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
            $('#editDateId').val(DateValue);
            $('#editTimeId').val(TimeValue);
        } else {
            $('#editDateId').val('');
            $('#editTimeId').val('');
        }
    }
</script>
