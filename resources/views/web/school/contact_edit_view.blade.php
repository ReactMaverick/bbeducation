<div class="row">
    <div class="col-md-6">
        <div class="form-group calendar-form-filter">
            <label for="">Title</label>
            <select class="form-control" name="title_int">
                <option value="">Choose one</option>
                @foreach ($titleList as $key1 => $title)
                    <option value="{{ $title->description_int }}"
                        {{ $contactDetail->title_int == $title->description_int ? 'selected' : '' }}>
                        {{ $title->description_txt }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="modal-input-field">
            <label class="form-check-label">First Name</label>
            <input type="text" class="form-control" name="firstName_txt" id=""
                value="{{ $contactDetail->firstName_txt }}">
        </div>

        <div class="modal-input-field">
            <label class="form-check-label">Surname</label>
            <input type="text" class="form-control" name="surname_txt" id=""
                value="{{ $contactDetail->surname_txt }}">
        </div>
    </div>
    <div class="col-md-6 modal-form-right-sec">
        <div class="form-group calendar-form-filter">
            <label for="">Job Role</label>
            <select class="form-control" name="jobRole_int">
                <option value="">Choose one</option>
                @foreach ($jobRoleList as $key2 => $jobRole)
                    <option value="{{ $jobRole->description_int }}"
                        {{ $contactDetail->jobRole_int == $jobRole->description_int ? 'selected' : '' }}>
                        {{ $jobRole->description_txt }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="modal-side-field">
            <label class="form-check-label" for="receiveVetting_statusEdit">Receive Vetting
                Confirmations</label>
            <input type="checkbox" class="" name="receiveVetting_status" id="receiveVetting_statusEdit"
                value="1" {{ $contactDetail->receiveVetting_status == '-1' ? 'checked' : '' }}>
        </div>

        <div class="modal-side-field">
            <label class="form-check-label" for="receiveTimesheets_statusEdit">Receive
                Timesheets</label>
            <input type="checkbox" class="" name="receiveTimesheets_status" id="receiveTimesheets_statusEdit"
                value="1" {{ $contactDetail->receiveTimesheets_status == '-1' ? 'checked' : '' }}
                {{ $sheetContactExit == 1 ? 'disabled' : '' }}>
        </div>

        <div class="modal-side-field">
            <label class="form-check-label" for="receiveInvoice_statusEdit">Receive
                Invoices</label>
            <input type="checkbox" class="" name="receiveInvoice_status" id="receiveInvoice_statusEdit"
                value="1" {{ $contactDetail->receiveInvoice_status == '-1' ? 'checked' : '' }}>
        </div>
    </div>
</div>
