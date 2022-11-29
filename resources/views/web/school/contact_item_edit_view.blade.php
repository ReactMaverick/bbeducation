<div class="row">
    <div class="col-md-6">
        <div class="form-group calendar-form-filter">
            <label for="">Contact Method</label>
            <select class="form-control field-validate-2" name="type_int" id="editContactMethodId">
                <option value="">Choose one</option>
                @foreach ($contactMethodList as $key1 => $contactMethod)
                    <option value="{{ $contactMethod->description_int }}"
                        {{ $contactItemDetail->type_int == $contactMethod->description_int ? 'selected' : '' }}>
                        {{ $contactMethod->description_txt }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="modal-side-field">
            <input type="checkbox" class="" name="receiveInvoices_status" id="editInvoiceContact" value="1"
                {{ $contactItemDetail->receiveInvoices_status == '-1' ? 'checked' : '' }}
                {{ $contactItemDetail->type_int == 1 ? '' : 'disabled' }}>
            <label class="form-check-label" for="editInvoiceContact">Invoice Contact</label>
        </div>

        <div class="form-group modal-input-field">
            <label class="form-check-label">Details (number/email etc.)</label>
            <input type="text" class="form-control field-validate-2" name="contactItem_txt" id=""
                value="{{ $contactItemDetail->contactItem_txt }}">
        </div>
    </div>
    <div class="col-md-6 modal-form-right-sec">
        <div class="modal-side-field">
            <label class="form-check-label" for="editSchoolMainId">School Main (not specific
                person)</label>
            <input type="checkbox" class="" name="schoolMainId" id="editSchoolMainId" value="1"
                {{ $contactItemDetail->schoolContact_id == null ? 'checked' : '' }}>
        </div>

        <div class="form-group calendar-form-filter">
            <label for="">Contact Person</label>
            <select class="form-control" name="schoolContact_id" id="editSchoolContactId">
                <option value="">Choose one</option>
                @foreach ($schoolContacts as $key2 => $Contacts)
                    <?php
                    $cName = '';
                    if ($Contacts->firstName_txt != '' && $Contacts->surname_txt != '') {
                        $cName = $Contacts->firstName_txt . ' ' . $Contacts->surname_txt;
                    } elseif ($Contacts->firstName_txt != '' && $Contacts->surname_txt == '') {
                        $cName = $Contacts->firstName_txt;
                    } elseif ($Contacts->title_int != '' && $Contacts->surname_txt != '') {
                        $cName = $Contacts->title_txt . ' ' . $Contacts->surname_txt;
                    } elseif ($Contacts->jobRole_int != '') {
                        $cName = $Contacts->jobRole_txt . ' (name unknown)';
                    } else {
                        $cName = 'Name unknown';
                    }
                    ?>

                    <option value="{{ $Contacts->contact_id }}"
                        {{ $contactItemDetail->schoolContact_id == $Contacts->contact_id ? 'selected' : '' }}>
                        {{ $cName }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
