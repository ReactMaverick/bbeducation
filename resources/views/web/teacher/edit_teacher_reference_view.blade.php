<div class="col-md-6">
    <div class="form-group calendar-form-filter">
        <label for="">Reference Type</label><span style="color: red;">*</span>
        <select class="form-control field-validate-2" name="referenceType_id"  style="width:100%;">
            <option value="">Choose one</option>
            @foreach ($referenceTypeList as $key1 => $referenceType)
                <option value="{{ $referenceType->referenceType_id }}" {{ $Detail->referenceType_id==$referenceType->referenceType_id?'selected':'' }} >
                    {{ $referenceType->title_txt }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">School/Establishment/Employer Name</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-2" name="employer_txt" id=""
            value="{{ $Detail->employer_txt }}">
    </div>

    <div class="modal-input-field">
        <label class="form-check-label">Address</label>
        <input type="text" class="form-control mb-1" name="address1_txt" id=""
            value="{{ $Detail->address1_txt }}">
        <input type="text" class="form-control mb-1" name="address2_txt" id=""
            value="{{ $Detail->address2_txt }}">
        <input type="text" class="form-control mb-1" name="address3_txt" id=""
            value="{{ $Detail->address3_txt }}">
        <input type="text" class="form-control" name="addrress4_txt" id=""
            value="{{ $Detail->addrress4_txt }}">
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Postcode</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-2" name="postcode_txt"
            id="" value="{{ $Detail->postcode_txt }}">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group modal-input-field">
        <label class="form-check-label">Referee Name</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-2" name="refereeName_txt" id=""
            value="{{ $Detail->refereeName_txt }}">
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Referee Email</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-2" name="refereeEmail_txt" id=""
            value="{{ $Detail->refereeEmail_txt }}">
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Employed Fromm</label><span style="color: red;">*</span>
        <input type="date" class="form-control field-validate-2" name="employedFrom_dte"
            id="" value="{{ $Detail->employedFrom_dte }}">
    </div>

    <div class="form-group modal-input-field">
        <label class="form-check-label">Employed Until</label><span style="color: red;">*</span>
        <input type="date" class="form-control field-validate-2" name="employedUntil_dte"
            id="" value="{{ $Detail->employedUntil_dte }}">
    </div>
</div>