<div class="col-md-12">
    <div class="form-group modal-input-field">
        <label class="form-check-label">Date Register On Update</label><span style="color: red;">*</span>
        <input type="text" class="form-control datePickerPaste datepaste-validate" name="check_date" id=""
            value="{{ date('d/m/Y', strtotime($Detail->check_date)) }}">
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
