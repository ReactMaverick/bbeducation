<input type="hidden" name="file_location" value="{{ $docDetail->file_location }}">
<div class="row">
    <div class="col-md-12">
        <div class="modal-input-field form-group">
            <label class="form-check-label">Document Name</label>
            <input type="text" class="form-control" name="file_name" id="fileNameEdit"
                value="{{ $docDetail->file_name }}">
        </div>

        <input type="hidden" class="form-control" name="file_name_hidden" id="file_name_hidden_edit" value="">

        <div class="form-group calendar-form-filter">
            <label for="">Document Type</label><span style="color: red;">*</span>
            <select class="form-control field-validate-2" name="documentType" id="editDocumentType"
                onchange="docTypeChangeEdit(this.value, this.options[this.selectedIndex].getAttribute('descTxt'))">
                <option value="">Choose one</option>
                @foreach ($typeList as $key5 => $type)
                    <option value="{{ $type->document_type_id }}"
                        {{ $docDetail->documentType == $type->document_type_id ? 'selected' : '' }}
                        descTxt="{{ $type->document_type_text }}">
                        {{ $type->document_type_text }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="modal-input-field form-group" id="editOthersTextDiv"
            style="display: {{ $docDetail->documentType != 1 ? 'none' : '' }}">
            <label class="form-check-label">Others</label><span style="color: red;">*</span>
            <input type="text" class="form-control" name="othersText" id="editOthersText"
                value="{{ $docDetail->othersText }}">
        </div>

        <div class="modal-input-field form-group">
            <label class="form-check-label">Upload Document</label>
            <input type="file" class="form-control file-validate-2" name="file" id=""
                value=""><span> *Only file type 'jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'txt'</span>
        </div>
    </div>
</div>

<script>
    $(document).on('change', '#editDocumentType', function() {
        var editDocumentType = $(this).val();
        if (editDocumentType != '' && editDocumentType == 1) {
            $('#editOthersTextDiv').show();
            $('#editOthersText').addClass('field-validate-2');
        } else {
            $('#editOthersTextDiv').hide();
            $('#editOthersText').val('');
            $('#editOthersText').removeClass('field-validate-2');
            $('#editOthersText').closest(".form-group").removeClass('has-error');
        }
    });

    function docTypeChangeEdit(desc_int, description_txt) {
        var txt = $('#fileNameEdit').val()
        $('#file_name_hidden_edit').val(description_txt)
        if (txt == null || txt == '') {
            $('#fileNameEdit').val(description_txt)
        }
    }
</script>
