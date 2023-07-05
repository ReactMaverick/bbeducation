<input type="hidden" name="timesheet_item_id" id="eTeacherTimesheetId" value="{{ $eventItemDetail->timesheet_item_id }}">

<div class="row">
    <div class="col-md-6 form-group modal-input-field">
        <label class="form-check-label">Date</label>
        <p>{{ date('d-m-Y', strtotime($eventItemDetail->asnDate_dte)) }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group modal-input-field">
        <label class="form-check-label">From</label>
        <input type="text" class="form-control field-validate" name="start_tm" id="workStartTimeEdit"
            value="{{ $eventItemDetail->start_tm }}">
    </div>

    <div class="col-md-6 form-group modal-input-field">
        <label class="form-check-label">To</label>
        <input type="text" class="form-control field-validate" name="end_tm" id="workEndTimeEdit"
            value="{{ $eventItemDetail->end_tm }}">
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#workStartTimeEdit, #workEndTimeEdit').timepicker({
            timeFormat: 'h:i a',
            'step': 30,
            'forceRoundTime': true
        });
    });
</script>
