<div class="col-md-6">
    <div class="form-group calendar-form-filter">
        <label for="">Contact Method</label>
        <select class="form-control field-validate-3" name="method_int">
            <option value="">Choose one</option>
            @foreach ($methodList as $key2 => $method)
                <option value="{{ $method->description_int }}"
                    {{ $contactDetail->method_int == $method->description_int ? 'selected' : '' }}>
                    {{ $method->description_txt }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Notes</label>
        <textarea name="notes_txt" id="" cols="30" rows="5" class="form-control field-validate-3">{{ $contactDetail->notes_txt }}</textarea>
    </div>
</div>
<div class="col-md-6 modal-form-right-sec">
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
                onchange="editQuickSettingChange(this.value, this.options[this.selectedIndex].getAttribute('settingTxt'))"
                id="quickSettingIdEdit">
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
            <input type="date" class="form-control" name="quick_setting_date" id="DateIdEdit"
                value="{{ $contactDetail->callbackOn_dtm != null ? date('Y-m-d', strtotime($contactDetail->callbackOn_dtm)) : '' }}">
        </div>

        <div class="modal-input-field col-md-6">
            <label class="form-check-label">Time</label>
            <input type="time" class="form-control" name="quick_setting_time" id="timeIdEdit"
                value="{{ $contactDetail->callbackOn_dtm != null ? date('H:i', strtotime($contactDetail->callbackOn_dtm)) : '' }}">
        </div>
    </div>
</div>

<script>
    $(document).on('change', '#callBackIdEdit', function() {
        $('#quickSettingIdEdit').val('');
        $('#DateIdEdit').val('');
        $('#timeIdEdit').val('');
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
            $('#DateIdEdit').val(DateValue);
            $('#timeIdEdit').val(TimeValue);
        } else {
            $('#DateIdEdit').val('');
            $('#timeIdEdit').val('');
        }
    }
</script>
