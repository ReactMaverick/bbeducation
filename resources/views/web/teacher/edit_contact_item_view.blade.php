<div class="col-md-12">
    <div class="form-group calendar-form-filter">
        <label for="">Contact Type</label><span style="color: red;">*</span>
        <select class="form-control field-validate-4 select2" name="type_int" id="" style="width: 100%;">
            <option value="">Choose one</option>
            @foreach ($contactTypeList as $key1 => $contactType)
                <option value="{{ $contactType->description_int }}" {{ $Detail->type_int == $contactType->description_int ? 'selected' : '' }} >
                    {{ $contactType->description_txt }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="modal-input-field form-group">
        <label class="form-check-label">Details</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-4" name="contactItem_txt" id=""
            value="{{ $Detail->contactItem_txt }}">
    </div>
</div>
