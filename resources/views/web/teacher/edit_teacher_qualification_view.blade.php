<div class="col-md-6">
    <div class="form-group calendar-form-filter">
        <label for="">Qualification Type</label><span style="color: red;">*</span>
        <select class="form-control field-validate-5" name="type_int" style="width:100%;">
            <option value="">Choose one</option>
            @foreach ($typeList as $key1 => $type)
                <option value="{{ $type->description_int }}"
                    {{ $Detail->type_int == $type->description_int ? 'selected' : '' }}>
                    {{ $type->description_txt }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group calendar-form-filter">
        <label for="">subtype</label><span style="color: red;">*</span>
        <select class="form-control field-validate-5" name="subType_int" style="width:100%;">
            <option value="">Choose one</option>
            @foreach ($subTypeList as $key1 => $subType)
                <option value="{{ $subType->description_int }}"
                    {{ $Detail->subType_int == $subType->description_int ? 'selected' : '' }}>
                    {{ $subType->description_txt }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Title</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-5" name="title_txt" id=""
            value="{{ $Detail->title_txt }}">
    </div>

    <div class="modal-side-field mb-2">
        <label class="form-check-label" for="givesQTS_status_edit">Gives QTS</label>
        <input type="checkbox" class="" name="givesQTS_status" id="givesQTS_status_edit" value="1"
            {{ $Detail->givesQTS_status == '-1' ? 'checked' : '' }}>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group modal-input-field">
        <label class="form-check-label">Awarding Body</label>
        <input type="text" class="form-control" name="awardingBody_txt" id=""
            value="{{ $Detail->awardingBody_txt }}">
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Qualification Date</label>
        <input type="text" class="form-control datePickerPaste" name="qualified_dte" id=""
            value="{{ $Detail->qualified_dte != null ? date('d/m/Y', strtotime($Detail->qualified_dte)) : '' }}">
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
