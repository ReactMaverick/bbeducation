<input type="hidden" name="file_location" value="{{ $docDetail->file_location }}">
<div class="col-md-12">
    <div class="modal-input-field form-group" hidden>
        <label class="form-check-label">Document Name</label>
        <input type="text" class="form-control" name="file_name" id="fileNameEdit" value="{{ $docDetail->file_name }}">
        <input type="hidden" class="form-control" name="file_name_hidden" id="docNameHiddenEdit" value="">
    </div>

    <div class="form-group calendar-form-filter">
        <label for="">Document Type</label><span style="color: red;">*</span>
        <select class="form-control field-validate-4 select2" name="type_int" id="type_intEdit" style="width: 100%;"
            onchange="docTypeChangeEdit(this.value, this.options[this.selectedIndex].getAttribute('descTxt'))">
            <option value="">Choose one</option>
            @foreach ($typeList as $key5 => $type)
                <option value="{{ $type->description_int }}"
                    {{ $docDetail->type_int == $type->description_int ? 'selected' : '' }}
                    descTxt="{{ $type->description_txt }}">
                    {{ $type->description_txt }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="modal-input-field form-group">
        <label class="form-check-label">Upload Document</label>
        <input type="file" class="form-control" name="file" id="" value=""><span>
            *Only file type 'jpg', 'png', 'jpeg',
            'pdf', 'doc',
            'docx', 'txt'</span>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#type_intEdit').select2();
    });

    function docTypeChangeEdit(desc_int, description_txt) {
        var txt = $('#fileNameEdit').val()
        $('#docNameHiddenEdit').val(description_txt)
        if (txt == null || txt == '') {
            $('#fileNameEdit').val(description_txt)
        }
    }
</script>
