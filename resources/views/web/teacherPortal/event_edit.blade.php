<div class="modal-input-field-section">
    <input type="hidden" name="timesheet_item_id" id="eTeacherTimesheetId" value="{{ $timesheet_item_id }}">
    <input type="hidden" name="asnItem_id" id="eTeacherAsnItemId" value="{{ $asnItem_id }}">

    <div class="row">
        <div class="col-md-6 form-group modal-input-field">
            <label class="form-check-label">Date</label>
            <p>{{ date('d-m-Y', strtotime($eventItemDetail->asnDate_dte)) }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group modal-input-field">
            <label class="form-check-label">Start Time</label>
            <input type="text" class="form-control field-validate" name="start_tm" id="workStartTimeEdit"
                value="{{ $eventItemDetail->start_tm }}">
        </div>

        <div class="col-md-6 form-group modal-input-field">
            <label class="form-check-label">Finish Time</label>
            <input type="text" class="form-control field-validate" name="end_tm" id="workEndTimeEdit"
                value="{{ $eventItemDetail->end_tm }}">
        </div>

        <div class="col-md-6 form-group modal-input-field" hidden>
            <label class="form-check-label">Hours</label>
            <input type="text" class="form-control onlynumber" name="hours_dec" id="hours_dec_ajx_edit"
                value="{{ $eventItemDetail->hours_dec }}">
        </div>

        <div class="col-md-12 form-group modal-input-field">
            <label class="form-check-label">Mins taken for lunch</label>
            <input type="text" class="form-control" name="lunch_time" id=""
                value="{{ $eventItemDetail->lunch_time }}">
        </div>
    </div>
</div>

<!-- Modal footer -->
<div class="modal-footer calendar-modal-footer">
    <button type="button" class="btn btn-secondary" id="eventEditBtn">Submit</button>

    @if ($timesheet_item_id)
        <button type="button" class="btn btn-danger cancel-btn" id="teacherTimesheetDelBtn">Delete</button>
    @else
        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
    @endif
</div>


<script>
    // $(document).ready(function() {
    //     $('#workStartTimeEdit, #workEndTimeEdit').timepicker({
    //         // timeFormat: 'h:i a',
    //         // 'step': 30,
    //         // 'forceRoundTime': true,
    //         autocomplete: true
    //     });
    // });

    // $(document).on('change', '#workStartTimeEdit, #workEndTimeEdit', function() {
    //     var startTime = $('#workStartTimeEdit').val();
    //     var endTime = $('#workEndTimeEdit').val();
    //     $('#hours_dec_ajx_edit').val('');
    //     if (startTime, endTime) {
    //         var start = parseTime1(startTime);
    //         var end = parseTime1(endTime);
    //         // Calculate the time difference in hours
    //         var hoursDiff = (end - start) / 1000 / 60 / 60;
    //         $('#hours_dec_ajx_edit').val(hoursDiff);
    //     }
    // });

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
