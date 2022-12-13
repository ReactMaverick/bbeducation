<div class="col-md-12">
    <div class="form-group calendar-form-filter">
        <label for="">Subject</label><span style="color: red;">*</span>
        <select class="form-control field-validate-3 select2" name="subject_id" id="" style="width: 100%;">
            <option value="">Choose one</option>
            @foreach ($subjectList as $key1 => $subjects)
                <option value="{{ $subjects->description_int }}" {{ $Detail->subject_id == $subjects->description_int ? 'selected' : '' }} >
                    {{ $subjects->description_txt }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="modal-side-field mb-2">
        <label class="form-check-label" for="isMain_status_edit">Main Subject</label>
        <input type="checkbox" class="" name="isMain_status"
            id="isMain_status_edit" value="1" {{ $Detail->isMain_status == '-1' ? 'checked' : '' }} >
    </div>
</div>