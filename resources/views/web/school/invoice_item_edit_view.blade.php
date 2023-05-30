<div class="col-md-12">
    <div class="form-group modal-input-field">
        <label class="form-check-label">Item Description</label><span style="color: red;">*</span>
        <textarea name="description_txt" id="" cols="30" rows="4" class="form-control field-validate-2">{{ $itemDetail->description_txt }}</textarea>
    </div>

    <div class="modal-input-field form-group">
        <label class="form-check-label">Number of Items</label><span style="color: red;">*</span>
        <input type="text" class="form-control number-validate-2" name="numItems_dec" id=""
            value="{{ $itemDetail->numItems_dec }}">
    </div>

    <div class="modal-input-field form-group">
        <label class="form-check-label">Linked Date</label><span style="color: red;">*</span>
        <input type="text" class="form-control datePickerPaste datepaste-validate-2" name="dateFor_dte"
            id="" value="{{ date('d/m/Y', strtotime($itemDetail->dateFor_dte)) }}">
    </div>

    <div class="modal-input-field form-group">
        <label class="form-check-label">Charge</label><span style="color: red;">*</span>
        <input type="text" class="form-control number-validate-2" name="charge_dec" id=""
            value="{{ $itemDetail->charge_dec }}">
    </div>

    <div class="modal-input-field form-group">
        <label class="form-check-label">Cost</label><span style="color: red;">*</span>
        <input type="text" class="form-control number-validate-2" name="cost_dec" id=""
            value="{{ $itemDetail->cost_dec }}">
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.datePickerPaste').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            weekStart: 1
        });
    });
</script>
