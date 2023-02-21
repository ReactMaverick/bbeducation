<input type="hidden" name="teacher_timesheet_id" id="eTeacherTimesheetId"
    value="{{ $eventItemDetail->teacher_timesheet_id }}">

<div class="row">
    <div class="col-md-6">
        <div class="form-group modal-input-field">
            <label class="form-check-label">Date</label>
            <p>{{ $eventItemDetail->asnDate_dte }}</p>
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
    </div>
</div>

<script>
    $(document).on('change', '#dayPart_int_ajx', function() {
        var dayPart_int = this.value;
        if (dayPart_int == 4) {
            $('#hours_dec_ajx').addClass('number-validate');
        } else {
            $('#hours_dec_ajx').removeClass('number-validate');
            $('#hours_dec_ajx').closest(".form-group").removeClass('has-error');
        }
    });
</script>
