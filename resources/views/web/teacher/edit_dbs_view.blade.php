<div class="col-md-6">
    <div class="form-group modal-input-field">
        <label class="form-check-label">Certificate Number</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-2" name="certificateNumber_txt" id=""
            value="{{ $detail->certificateNumber_txt }}">
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Certificate Date</label><span style="color: red;">*</span>
        <input type="text" class="form-control datePickerPaste datepaste-validate-2" name="DBSDate_dte"
            id=""
            value="{{ $detail->DBSDate_dte != null ? date('d/m/Y', strtotime($detail->DBSDate_dte)) : '' }}">
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Position Applied For</label>
        <input type="text" class="form-control" name="positionAppliedFor_txt" id=""
            value="{{ $detail->positionAppliedFor_txt }}">
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Employer Name</label>
        <input type="text" class="form-control" name="employerName_txt" id=""
            value="{{ $detail->employerName_txt }}">
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Registered Body</label>
        <input type="text" class="form-control" name="registeredBody_txt" id=""
            value="{{ $detail->registeredBody_txt }}">
    </div>
</div>
<div class="col-md-6">
    <div class="modal-side-field mb-2">
        <input type="checkbox" class="" name="dbsWarning_status" id="dbsWarning_status_edit" value="1"
            {{ $detail->dbsWarning_status == '-1' ? 'checked' : '' }}>
        <label class="form-check-label" for="dbsWarning_status_edit">Flag Warning</label>
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Warning Message</label>
        <textarea name="dbsWarning_txt" id="dbsWarning_txt_edit" cols="30" rows="3" class="form-control"
            {{ $detail->dbsWarning_status == '-1' ? '' : 'disabled' }}>{{ $detail->dbsWarning_txt }}</textarea>
    </div>

    <div class="modal-side-field mb-2">
        <input type="checkbox" class="" name="lastCheckedOn" id="lastCheckedOnEdit" value="1">
        <label class="form-check-label" for="lastCheckedOnEdit">Update 'Last Checked On' date
            to today's date</label>
    </div>
    <input type="hidden" name="lastCheckedOn_dte" id=""
        value="{{ $detail->lastCheckedOn_dte != null ? date('Y-m-d', strtotime($detail->lastCheckedOn_dte)) : '' }}">
</div>

<script>
    $(document).ready(function() {
        $('.datePickerPaste').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });
    });

    $("#dbsWarning_status_edit").change(function() {
        if ($(this).is(":checked")) {
            $('#dbsWarning_txt_edit').attr('disabled', false);
        } else {
            $('#dbsWarning_txt_edit').attr('disabled', true);
            $('#dbsWarning_txt_edit').val('');
        }
    });
</script>
