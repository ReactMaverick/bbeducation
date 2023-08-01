<div class="row">
    <div class="col-md-6">
        <div class="form-group modal-input-field">
            <label class="form-check-label">Date</label>
            <input type="date" class="form-control field-validate" name="asnDate_dte" id=""
                value="{{ $eventItemDetail->asnDate_dte }}">
        </div>

        <div class="form-group calendar-form-filter">
            <label for="">Part Of Day</label>
            <select class="form-control field-validate" name="dayPart_int" id="dayPart_int_ajx">
                <option value="">Choose one</option>
                @foreach ($dayPartList as $key1 => $dayPart)
                    <option value="{{ $dayPart->description_int }}"
                        {{ $eventItemDetail->dayPart_int == $dayPart->description_int ? 'selected' : '' }}>
                        {{ $dayPart->description_txt }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group modal-input-field" id="workStartTimeEditAjaxDiv" hidden>
            <label class="form-check-label">Start Time</label>
            <input type="text" class="form-control" name="start_tm" id="workStartTimeEditAjax"
                value="{{ $eventItemDetail->dayPart_int == 4 && $eventItemDetail->start_tm ? $eventItemDetail->start_tm : '' }}">
        </div>
    </div>

    <div class="col-md-6 modal-form-right-sec">
        <div class="form-group modal-input-field">
            <label class="form-check-label">Percentage of a day</label>
            <input type="text" class="form-control number-validate" name="dayPercent_dec" id=""
                value="{{ $eventItemDetail->dayPercent_dec }}">
        </div>

        <div class="form-group modal-input-field">
            <label class="form-check-label">Hours</label>
            <input type="text" class="form-control onlynumber" name="hours_dec" id="hours_dec_ajx"
                value="{{ $eventItemDetail->hours_dec }}">
        </div>

        <div class="form-group modal-input-field" id="workEndTimeEditAjaxDiv" hidden>
            <label class="form-check-label">Finish Time</label>
            <input type="text" class="form-control" name="end_tm" id="workEndTimeEditAjax"
                value="{{ $eventItemDetail->dayPart_int == 4 && $eventItemDetail->end_tm ? $eventItemDetail->end_tm : '' }}">
        </div>
    </div>

    <div class="col-md-12 modal-form-right-sec">
        <div class="form-group modal-input-field">
            <label class="form-check-label">Mins taken for lunch</label>
            <input type="text" class="form-control" name="lunch_time" id=""
                value="{{ $eventItemDetail->lunch_time }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group modal-input-field">
            <label class="form-check-label">Charge</label>
            <input type="text" class="form-control number-validate" name="charge_dec" id=""
                value="{{ $eventItemDetail->charge_dec }}">
        </div>
    </div>
    <div class="col-md-6 modal-form-right-sec">
        <div class="form-group modal-input-field">
            <label class="form-check-label">Pay</label>
            <input type="text" class="form-control number-validate" name="cost_dec" id=""
                value="{{ $eventItemDetail->cost_dec }}">
        </div>
    </div>

    <div class="col-md-12 modal-form-right-sec">
        <div class="form-group modal-input-field">
            <label class="form-check-label">Note</label>
            <textarea class="form-control" rows="2" id="" name="event_note">{{ $eventItemDetail->event_note }}</textarea>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#workStartTimeEditAjax, #workEndTimeEditAjax').timepicker({
            // timeFormat: 'h:i a',
            // 'step': 30,
            // 'forceRoundTime': true,
            autocomplete: true
        });
    });

    $(document).on('change', '#dayPart_int_ajx', function() {
        var dayPart_int = this.value;
        $('#workStartTimeEditAjax').val('');
        $('#workEndTimeEditAjax').val('');
        if (dayPart_int == 4) {
            $('#hours_dec_ajx').addClass('number-validate');

            // $('#workStartTimeEditAjaxDiv').css('display', 'block');
            // $('#workEndTimeEditAjaxDiv').css('display', 'block');
            // $('#workStartTimeEditAjax').addClass('field-validate');
            // $('#workEndTimeEditAjax').addClass('field-validate');
        } else {
            $('#hours_dec_ajx').removeClass('number-validate');
            $('#hours_dec_ajx').val('');
            $('#hours_dec_ajx').closest(".form-group").removeClass('has-error');

            // $('#workStartTimeEditAjaxDiv').css('display', 'none');
            // $('#workEndTimeEditAjaxDiv').css('display', 'none');
            // $('#workStartTimeEditAjax').removeClass('field-validate');
            // $('#workEndTimeEditAjax').removeClass('field-validate');
        }
    });

    $(document).on('change', '#workStartTimeEditAjax, #workEndTimeEditAjax', function() {
        var startTime = $('#workStartTimeEditAjax').val();
        var endTime = $('#workEndTimeEditAjax').val();
        $('#hours_dec_ajx').val('');
        if (startTime, endTime) {
            // var currentDate = new Date();
            // var startDate = new Date(currentDate.toDateString() + ' ' + startTime);
            // var endDate = new Date(currentDate.toDateString() + ' ' + endTime);
            // var timeDiff = endDate - startDate;
            // var hoursDiff = timeDiff / (1000 * 60 * 60);
            var start = parseTime1(startTime);
            var end = parseTime1(endTime);
            // Calculate the time difference in hours
            var hoursDiff = (end - start) / 1000 / 60 / 60;
            $('#hours_dec_ajx').val(hoursDiff);
        }
    });

    function parseTime1(time) {
        var parts = time.match(/(\d+):(\d+)(am|pm)/);
        var hours = parseInt(parts[1]);
        var minutes = parseInt(parts[2]);

        if (parts[3] === "pm" && hours !== 12) {
            hours += 12;
        } else if (parts[3] === "am" && hours === 12) {
            hours = 0;
        }
        return new Date(0, 0, 0, hours, minutes);
    }
</script>
